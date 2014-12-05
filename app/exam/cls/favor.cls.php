<?php
/*
 * Created on 2011-11-21
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 * 对地区进行操作
 */
class favor_exam
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
	}

	public function _init()
	{
		$this->sql = $this->G->make('sql');
		$this->db = $this->G->make('db');
		$this->pg = $this->G->make('pg');
		$this->ev = $this->G->make('ev');
		$this->session = $this->G->make('session');
		$this->basic = $this->G->make('basic','exam');
		$this->exam = $this->G->make('exam','exam');
		$this->section = $this->G->make('section','exam');
	}

	public function getBestStudentsToday()
	{
		$t = TIME - 24*3600*7;
		$data = array("count(*) AS number,ehusername,max(ehscore) as ehscore",'examhistory',array("ehstarttime >= '{$t}'"),"ehuserid","number DESC",10);
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetchAll($sql);
	}

	public function getBestStudentsThisMonth()
	{
		$t = TIME - 24*3600*30;
		$data = array("count(*) AS number,ehusername,max(ehscore) as ehscore",'examhistory',array("ehstarttime >= '{$t}'"),"ehuserid","number DESC",10);
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetchAll($sql);
	}

	//通过用户ID获取收藏试题列表
	//参数：当前页码，单页显示数量，查询参数（数组或字符串）
	//返回值：试题列表数组
	public function getFavorListByUserid($page,$number = 20,$args = array(),$type = 0)
	{
		$page = $page > 0?$page:1;
		$r = array();
		if($type)
		{
			$args[] = "favor.favorquestionid = questions.questionid";
			$args[] = "questions.questionparent = questionrows.qrid";
			$args[] = "questionrows.qrid = quest2knows.qkquestionid";
			$args[] = "quest2knows.qktype = 1";
			$data = array("DISTINCT questions.*, favor.favorid, questionrows.*",array('favor','questionrows','questions','quest2knows'),$args,false,"favortime DESC,questionparent DESC,questionsequence ASC",array(intval($page-1)*$number,$number));
			$sql = $this->sql->makeSelect($data);
			$r['data'] = $this->db->fetchAll($sql,false,array('questionknowsid','qrknowsid'));
			$data = array('count(DISTINCT questions.questionid) AS number',array('favor','questionrows','questions','quest2knows'),$args);
			$sql = $this->sql->makeSelect($data);
			$t = $this->db->fetch($sql);
			$pages = $this->pg->outPage($this->pg->getPagesNumber($t['number'],$number),$page);
			$r['pages'] = $pages;
			$r['number'] = $t['number'];
		}
		else
		{
			$args[] = "favor.favorquestionid = questions.questionid";
			$args[] = "questions.questionid = quest2knows.qkquestionid";
			$args[] = "quest2knows.qktype = 0";
			$data = array("DISTINCT questions.*, favor.*",array('favor','questions','quest2knows'),$args,false,"favorid DESC",array(intval($page-1)*$number,$number));
			$sql = $this->sql->makeSelect($data);
			$r['data'] = $this->db->fetchAll($sql,false,'questionknowsid');
			$data = array('count(DISTINCT questions.questionid) AS number',array('favor','questions','quest2knows'),$args);
			$sql = $this->sql->makeSelect($data);
			$t = $this->db->fetch($sql);
			$pages = $this->pg->outPage($this->pg->getPagesNumber($t['number'],$number),$page);
			$r['pages'] = $pages;
			$r['number'] = $t['number'];
		}
		return $r;
	}

	//收藏试题
	//参数：试题ID，用户ID，考试ID
	//返回值：试题收藏后的插入ID
	public function favorQuestion($questionid,$userid,$subjectid)
	{
		$args = array("favorsubjectid"=>$subjectid,"favorquestionid" => $questionid,"favoruserid" => $userid,"favortime" => TIME );
		$data = array("favor",$args);
		$sql = $this->sql->makeInsert($data);
		$this->db->exec($sql);
		return $this->db->lastInsertId();
	}

	//根据ID获取试题是否收藏
	//本函数暂不用
	public function getFavorById($id)
	{
		$data = array(false,'favor',"favorid = '{$id}'");
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql,'favorquestion');
	}

	//根据用户ID和试题ID获取试题是否收藏
	//参数：试题ID，用户ID
	//返回值：试题信息数组（无则为FALSE）
	public function getFavorByQuestionAndUserId($id,$userid)
	{
		$data = array(false,'favor',array("favorquestionid = '{$id}'","favoruserid = '{$userid}'"));
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql,'favorquestion');
	}

	//根据ID删除试题
	public function delFavorById($id)
	{
		$data = array("favor","favorid = '{$id}'");
		$sql = $this->sql->makeDelete($data);
		$this->db->exec($sql);
		return true;
	}

	//错题记录函数
	//新增错题记录
	public function addRecord($questionid,$userid,$examid)
	{
		$question = $this->exam->getQuestionByArgs("questionid = '{$questionid}'");
		$knows = $this->section->getKnowsByArgs("knowsid = '{$question['questionknowsid']}'");
		$section = $this->section->getSectionByArgs("sectionid = '{$knows['knowssectionid']}'");
		$args = array("recordexamid"=>$examid,"recordquestionid" => $questionid,"recordquestype" => $question['questiontype'],"recordquestion" => $this->ev->addSlashes(serialize($question['questionhtml'])),"recordsubjectid" => $section['sectionsubjectid'],"recordknowsid" => $question['questionknowsid'],"recorduserid" => $userid,"recordtime" => TIME );
		$data = array("record",$args);
		$sql = $this->sql->makeInsert($data);
		$this->db->exec($sql);
		return $this->db->lastInsertId();
	}

	//根据用户ID和试题ID获取试题是否被收入错题库
	public function getRecordByQuestionAndUserId($id,$userid)
	{
		$data = array(false,'record',array("recordquestionid = '{$id}'","recorduserid = '{$userid}'"));
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql,'recordquestion');
	}

	//删除错误记录
	public function delRecord($recordid)
	{
		$data = array("record","recordid = '{$recordid}'");
		$sql = $this->sql->makeDelete($data);
		$this->db->exec($sql);
		return true;
	}

	//通过用户ID获取错误试题列表
	public function getRecordListByUserid($page,$number = 20,$args = array())
	{
		$page = $page > 0?$page:1;
		$r = array();
		$data = array(false,'record',$args,false,"recordid DESC",array(intval($page-1)*$number,$number));
		$sql = $this->sql->makeSelect($data);
		$r['data'] = $this->db->fetchAll($sql,false,'recordquestion');
		$data = array('count(*) AS number','record',$args);
		$sql = $this->sql->makeSelect($data);
		$t = $this->db->fetch($sql);
		$pages = $this->pg->outPage($this->pg->getPagesNumber($t['number'],$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
	}

	//根据用户和科目获取考试记录列表
	public function getExamHistoryListByArgs($page,$number = 20,$args = array(),$fields = false)
	{
		$page = $page > 0?$page:1;
		$r = array();
		$data = array($fields,'examhistory',$args,false,"ehid DESC",array(intval($page-1)*$number,$number));
		$sql = $this->sql->makeSelect($data);
		$r['data'] = $this->db->fetchAll($sql,'ehid');
		$data = array('count(*) AS number','examhistory',$args);
		$sql = $this->sql->makeSelect($data);
		$t = $this->db->fetch($sql);
		$pages = $this->pg->outPage($this->pg->getPagesNumber($t['number'],$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
	}

	//根据用户和科目获取考试记录列表
	public function getAllExamHistoryByArgs($args = array(),$fields = false)
	{
		$args[] = "examhistory.ehuserid = user.userid";
		$data = array($fields,array('examhistory','user'),$args,false,"ehscore DESC",false);
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetchAll($sql);
	}

	//根据用户和ID获取一个考试记录
	public function getExamHistoryById($id)
	{
		$data = array(false,'examhistory',"ehid = '{$id}'");
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql,array('ehquestion','ehsetting','ehscorelist','ehuseranswer'));
	}

	//根据ID修改一个考试记录
	public function modifyExamHistory($args,$ehid)
	{
		$data = array("examhistory",$args,"ehid = '{$ehid}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return true;
	}

	//根据ID删除一个考试记录
	public function delExamHistory($id,$userid)
	{
		$data = array("examhistory",array("ehid = '{$id}'","ehuserid = '{$userid}'"));
		$sql = $this->sql->makeDelete($data);
		$this->db->exec($sql);
		return true;
	}

	//批量清理考试记录
	public function clearExamHistory($args)
	{
		$data = array("examhistory",$args);
		$sql = $this->sql->makeDelete($data);
		$this->db->exec($sql);
		return true;
	}

	//获取记录数量
	public function getExamHistoryNumber($userid,$basicid,$type = 0)
	{
		$data = array('count(*) AS number',"examhistory",array("ehuserid = '{$userid}'","ehbasicid = '{$basicid}'","ehtype = '{$type}'"));
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetch($sql);
		return $r['number'];
	}

	//删除最后一个考试记录
	public function delLastExamHistory($userid,$subjectid,$type = 0)
	{
		$data = array(false,"examhistory",array("ehuserid = '{$userid}'","ehsubjectid = '{$subjectid}'","ehtype = '{$type}'"),false,"ehid ASC",1);
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetch($sql);
		$data = array("examhistory","ehid = '{$r['ehid']}'");
		$sql = $this->sql->makeDelete($data);
		$this->db->exec($sql);
		return true;
	}

	//添加一个考试记录
	public function addExamHistory($status = 1)
	{
		$exam = $this->exam->getExamSessionBySessionid();
		if(!$exam)return false;
		$user = $this->session->getSessionUser();
		$t = TIME - $exam['examsessionstarttime'];
		if($t >= $exam['examsessiontime']*60)$t = $exam['examsessiontime']*60;
		$args = array(
					'ehtype'=>$exam['examsessiontype'],
					'ehexam'=>$exam['examsession'],
					'ehexamid'=>$exam['examsessionkey'],
					'ehbasicid'=>$exam['examsessionbasic'],
					'ehquestion'=>$this->ev->addSlashes(serialize($exam['examsessionquestion'])),
					'ehsetting'=>$this->ev->addSlashes(serialize($exam['examsessionsetting'])),
					'ehuseranswer'=>$this->ev->addSlashes(serialize($exam['examsessionuseranswer'])),
					'ehstarttime'=>$exam['examsessionstarttime'],
					'ehtime'=>$t,
					'ehscore'=>$exam['examsessionscore'],
					'ehscorelist'=>$this->ev->addSlashes(serialize($exam['examsessionscorelist'])),
					'ehuserid'=>$user['sessionuserid'],
					'ehusername'=>$user['sessionusername'],
					'ehdecide' => $exam['examsessionsetting']['examdecide'],
					'ehstatus' => $status
		);
		$data = array('examhistory',$args);
		$sql = $this->sql->makeInsert($data);
		$this->db->exec($sql);
		$ehid = $this->db->lastInsertId();
		$this->exam->delExamSession();
		return $ehid;
	}

	public function getAvgScore($args)
	{
		$data = array("avg(ehscore) as avgscore",'examhistory',$args,false,false,false);
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetch($sql);
		return $r['avgscore'];
	}

	public function getExamUseNumber($userid,$examid,$basicid,$type = 2)
	{
		$data = array('count(*) AS number',"examhistory",array("ehuserid = '{$userid}'","ehexamid = '{$examid}'","ehbasicid = '{$basicid}'","ehtype = '{$type}'"));
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetch($sql);
		return $r['number'];
	}

	public function getExamScoreListByBasicId($basicid,$page)
	{
		$data = array(
			'select' => false,
			'table' => 'examhistory',
			'query' => array("ehbasicid = '{$basicid}'","ehtype = 2","ehstatus = 1"),
			'orderby' => 'ehscore DESC,ehid DESC',
			'serial' => 'catmanager'
		);
		return $this->db->listElements($page,20,$data);
	}

	public function getUserScoreIndex($basicid,$userid,$score)
	{
		$data = array("count(*) as number",'examhistory',array("ehbasicid = '{$basicid}'","ehscore > '{$score}'"),false,false,false);
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetch($sql);
		return $r['number'] + 1;
	}

	public function getUserTopScore($basicid,$userid)
	{
		$data = array("max(ehscore) as ehscore",'examhistory',array("ehbasicid = '{$basicid}'","ehuserid = '{$userid}'","ehtype = 2"),false,false,false);
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetch($sql);
		if($r['ehscore'] > 0)$s = array('score' => $r['ehscore']);
		else
		$s = array('score' => 0);
		$data = array("count(*) as number",'examhistory',array("ehbasicid = '{$basicid}'","ehscore > '{$s['score']}'","ehtype = 2"),false,false,false);
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetch($sql);
		$s['index'] = $r['number'] + 1;
		return $s;
	}
}

?>
