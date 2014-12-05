<?php

class exam_exam
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
	}

	public function _init()
	{
		if(!$this->init)
		{
			$this->sql = $this->G->make('sql');
			$this->db = $this->G->make('db');
			$this->pg = $this->G->make('pg');
			$this->ev = $this->G->make('ev');
			$this->section = $this->G->make('section','exam');
			$this->session = $this->G->make('session');
			$this->question = $this->G->make('question','exam');
			$this->init = 1;
		}
	}

	//增加一个考试会话
	//参数：会话信息数组
	//返回值：true
	public function insertExamSession($args)
	{
		$args['examsessionid'] = $this->session->getSessionId();
		$args['examsessionstarttime'] = TIME;
		$data = array('examsession',$args);
		$sql = $this->sql->makeInsert($data);
		$this->db->exec($sql);
		return true;
	}

	//清除考试会话
	//参数：无
	//返回值：无
	public function clearExamSession()
	{
		$sessionid = $this->session->getSessionId();
	}

	public function clearOutTimeExamSession($time)
    {
    	if(!$time)
    	$date = TIME-6*24*3600;
    	else
    	$date = $time;
    	$data = array('examsession',"examsessionstarttime < '{$date}'");
    	$sql = $this->sql->makeDelete($data);
	    $this->db->exec($sql);
    	return true;
    }

	//修改考试会话内容
	//参数：会话内容数组
	//返回值：true
	public function modifyExamSession($args)
	{
		$sessionid = $this->session->getSessionId();
		$data = array('examsession',$args,"examsessionid = '{$sessionid}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return true;
	}

	//清除会话内容
	public function delExamSession()
	{
		$sessionid = $this->session->getSessionId();
		$data = array('examsession',"examsessionid = '{$sessionid}'");
		$sql = $this->sql->makeDelete($data);
		$this->db->exec($sql);
		return true;
	}

	//获取当前考试会话信息
	//参数：无
	//返回值：会话信息数组
	public function getExamSessionBySessionid()
	{
		$sessionid = $this->session->getSessionId();
		$data = array(false,'examsession',"examsessionid = '{$sessionid}'");
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql,array('examsessionquestion','examsessionsign','examsessionsetting','examsessionuseranswer','examsessionscorelist'));
	}

	//获取考试设置信息列表
	//参数：当前页码，每页显示数，查询条件数组
	//返回值：考试设置信息列表数组
	public function getExamSettingList($page,$number = 20,$args = array())
	{
		$page = $page > 0?$page:1;
		$r = array();
		$data = array(false,'exams',$args,false,'examid DESC',array(intval($page-1)*$number,$number));
		$sql = $this->sql->makeSelect($data);
		$r['data'] = $this->db->fetchAll($sql,false,array('examsetting','examquestions','examscore'));
		$data = array('count(*) AS number','exams',$args);
		$sql = $this->sql->makeSelect($data);
		$t = $this->db->fetch($sql);
		$pages = $this->pg->outPage($this->pg->getPagesNumber($t['number'],$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
	}

	//根据参数获取设置好的考试信息列表，用于抽题使用
	//参数：当前页码，每页显示数，查询条件数组
	//返回值：考试设置信息列表数组
	public function getRandExamSetting($subjectid)
	{
		/**
		$sql = "SELECT * FROM `".DTH."exams` AS r1 JOIN (SELECT ROUND(RAND() * (SELECT MAX(examid) FROM `".DTH."exams`)) AS id) AS r2 WHERE r1.examid >= r2.id AND r1.examsubject = '{$subjectid}' AND r1.examtype = '2' ORDER BY r1.examid ASC LIMIT 1";
		**/
		$data = array("examid","exams",array("examsubject = '{$subjectid}'","examtype = 2"),false,false,false);
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetchAll($sql);
		$examid = $r[array_rand($r,1)]['examid'];
		$data = array(false,"exams","examid = '{$examid}'",false,false,false);
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql,array('examsetting','examquestions'));
	}

	//根据ID获取一个考试设置
	//参数：考试设置ID
	//返回值：考试设置信息数组
	public function getExamSettingById($id)
	{
		$data = array(false,'exams',"examid = '{$id}'");
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql,array('examsetting','examquestions'));
	}

	//获取已设置考题的数量
	public function getExamQuestionNumber($number = false)
	{
		if(!is_array($number))return false;
		else
		{
			$number['questions'] = trim($number['questions']," ,");
			$number['rowsquestions'] = trim($number['rowsquestions']," ,");
			if($number['questions'])
			{
				$data = array('count(*) as number','questions',array("questionid IN ({$number['questions']})","questionstatus = 1"));
				$sql = $this->sql->makeSelect($data);
				$stmp = $this->db->fetch($sql);
				$snumber = $stmp['number'];
			}
			else
			$snumber = 0;
			if($number['rowsquestions'])
			{
				$data = array('sum(qrnumber) as number','questionrows',array("qrid IN ({$number['rowsquestions']})","qrstatus = 1"));
				$sql = $this->sql->makeSelect($data);
				$tmp = $this->db->fetch($sql);
				return $snumber+$tmp['number'];
			}
			else return $snumber;
		}
	}

	//根据参数获取一个考试设置
	//参数：考试设置查询参数（数组或者字符串）
	//返回值：考试设置信息数组
	public function getExamSettingByArgs($args)
	{
		$data = array(false,'exams',$args);
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql,'examsetting');
	}

	//根据参数修改一个考试设置
	//参数：考试ID，参数（数组）
	//返回值：受影响记录数
	public function modifyExamSetting($id,$args)
	{
		$data = array('exams',$args,"examid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	//删除考试设置
	//参数：考试ID
	//返回值：受影响记录数
	public function delExamSetting($id)
	{
		$data = array('exams',"examid = '{$id}'");
		$sql = $this->sql->makeDelete($data);
		//$data = array('exams',array("examstatus"=>0),"examid = '{$id}'");
		//$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	//增加考试设置
	//参数：考试设置参数（数组）
	//返回值：插入ID
	public function addExamSetting($args)
	{
		$args['examtime'] = TIME;
		$data = array('exams',$args);
		$sql = $this->sql->makeInsert($data);
		$this->db->exec($sql);
		return $this->db->lastInsertId();
	}

	//增加试题
	//参数：试题参数（数组）
	//返回值：插入ID
	public function addQuestions($args)
	{
		$data = array('questions',$args);
		$sql = $this->sql->makeInsert($data);
		$this->db->exec($sql);
		$r = $this->db->lastInsertId();
		if($args['questionparent'])$qktype = 1;
		else $qktype = 0;
		$question = $this->getQuestionByArgs("questionid = '{$r}'");
		$questionknowsid = $this->ev->addSlashes(serialize($this->parseQuestionKnows($args['questionknowsid'],$r,$qktype)));
		//$questionhtml = $this->ev->addSlashes(serialize($this->question->parse($question)));
		$data = array('questions',array('questionknowsid'=>$questionknowsid),"questionid = '{$r}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $r;
	}

	public function parseQuestionKnows($knows,$questionid = NULL,$qktype = 0)
	{
		$ks = explode("\n",$knows);
		$data = array();
		foreach($ks as $p)
		{
			if($p)
			{
				$p = explode(":",$p,2);
				$data[] = array('knowsid'=>$p[0],'knows'=>$p[1]);
				if($questionid)
				{
					$sqldata = array('quest2knows',array('qkquestionid'=>$questionid,'qkknowsid'=>$p[0],'qktype'=>$qktype));
					$sql = $this->sql->makeInsert($sqldata);
					$this->db->exec($sql);
				}
			}
		}
		return $data;
	}

	//增加特殊题型
	//暂时不用
	public function addQuestionRows($args)
	{
		$args['qrstatus'] = 1;
		$data = array('questionrows',$args);
		$sql = $this->sql->makeInsert($data);
		$this->db->exec($sql);
		$r = $this->db->lastInsertId();
		$questionknowsid = $this->ev->addSlashes(serialize($this->parseQuestionKnows($args['qrknowsid'],$r,1)));
		$data = array('questionrows',array('qrknowsid'=>$questionknowsid),"qrid = '{$r}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $r;
	}

	//批量导入试题
	//参数：批量试题内容字符串，知识点ID
	//返回值：true
	public function importQuestionBat($uploadfile,$tknowsid,$questionparent = 0)
	{
		$handle = fopen($uploadfile,"r");
		while ($data = fgetcsv($handle))
		{
			$args = array();
			$question = $data;
			if(count($question) >= 6)
			{
				$args['questiontype'] = intval($question[0]);
				$args['question'] = $this->ev->addSlashes(htmlspecialchars(iconv("GBK","UTF-8",trim($question[1]," \n\t"))));
				$args['questionselect'] = $this->ev->addSlashes(htmlspecialchars(iconv("GBK","UTF-8",trim($question[2]," \n\t"))));
				$args['questionselectnumber'] = intval(trim($question[3]," \n\t"));
				$args['questionanswer'] = $this->ev->addSlashes(htmlspecialchars(iconv("GBK","UTF-8",trim($question[4]," \n\t"))));
				$args['questiondescribe'] = $this->ev->addSlashes(htmlspecialchars(iconv("GBK","UTF-8",trim($question[5]," \n\t"))));
				if(!$tknowsid)
				$questionknowsid = trim($question[6]," \n\t");
				else
				$questionknowsid = $tknowsid;
				if($questionknowsid)
				{
					$questionknowsid = explode(',',$questionknowsid);
					$tmpkid = '0';
					foreach($questionknowsid as $knowsid)
					{
						$knowsid = intval($knowsid);
						if($knowsid)$tmpkid .= ",".$knowsid;
					}
					$knows = $this->section->getKnowsListByArgs("knowsid IN ({$tmpkid})");
					$args['questionknowsid'] = '';
					foreach($knows as $p)
					{
						$args['questionknowsid'] .= $p['knowsid'].':'.$p['knows']."\n";
					}
				}
				if($questionparent)$args['questionparent'] = $questionparent;
				$args['questionlevel'] = intval(trim($question[7]," \n\t"));
				$args['questioncreatetime'] = TIME;
				$this->addQuestions($args);
			}
		}
		return true;
	}

	//批量增加试题
	//参数：批量试题内容字符串，知识点ID
	//返回值：true
	public function insertQuestionBat($content,$questionparent)
	{
		$content = str_replace(" ","",$content);
		$content = str_replace("()","( )",$content);
		$content = str_replace("\t","",$content);
		$content = str_replace("\r","\n",$content);
		$content = str_replace("\n\n","\n",$content);
		$content = explode("======",$content);
		foreach($content as $q)
		{
			$args = array();
			$question = explode("------",$q);
			if(count($question) >= 6)
			{
				$args['questiontype'] = intval($question[0]);
				$args['question'] = trim($question[1]," \n\t");
				$args['questionselect'] = trim($question[2]," \n\t");
				$args['questionselectnumber'] = trim($question[3]," \n\t");
				$args['questionanswer'] = trim($question[4]," \n\t");
				$args['questiondescribe'] = trim($question[5]," \n\t");
				$questionknowsid = trim($question[6]," \n\t");
				if($questionknowsid)
				{
					$questionknowsid = explode(',',$questionknowsid);
					$tmpkid = '0';
					foreach($questionknowsid as $knowsid)
					{
						$knowsid = intval($knowsid);
						if($knowsid)$tmpkid .= ",".$knowsid;
					}
					$knows = $this->section->getKnowsListByArgs("knowsid IN ({$tmpkid})");
					$args['questionknowsid'] = '';
					foreach($knows as $p)
					{
						$args['questionknowsid'] .= $p['knowsid'].':'.$p['knows']."\n";
					}
				}
				if($questionparent)$args['questionparent'] = $questionparent;
				$args['questionlevel'] = trim($question[7]," \n\t");;
				$args['questioncreatetime'] = TIME;
				$this->addQuestions($args);
			}
		}
		return true;
	}

	//批量增加特殊试题
	//参数：批量试题内容字符串，知识点ID
	//返回值：true
	public function insertQuestionRowsBat($content,$knowsid)
	{
		$content = str_replace(" ","",$content);
		$content = str_replace("()","( )",$content);
		$content = str_replace("\t","",$content);
		$content = str_replace("\r","\n",$content);
		$content = str_replace("\n\n","\n",$content);
		$content = explode("======",$content);
		foreach($content as $key => $q)
		{
			$args = array();
			$question = explode("------",$q);
			if(count($question) >= 3)
			{
				$args['qrquestion'] = trim($question[0]," \n\t");
				$args['qrtype'] = intval($question[1]);
				$args['qrlevel'] = intval($question[3]);
				$args['qrtime'] = TIME;
				$questionknowsid = trim($question[2]," \n\t");
				$questionknowsid = explode(',',$questionknowsid);
				$tmpkid = '0';
				foreach($questionknowsid as $knowsid)
				{
					$knowsid = intval($knowsid);
					if($knowsid)$tmpkid .= ",".$knowsid;
				}
				$knows = $this->section->getKnowsListByArgs("knowsid IN ({$tmpkid})");
				$args['qrknowsid'] = '';
				foreach($knows as $p)
				{
					$args['qrknowsid'] .= $p['knowsid'].':'.$p['knows']."\n";
				}
				$this->addQuestionRows($args);
			}
		}
		//$this->modifyQuestions($questionparent,array('questionnumber'=>$sequence));
		return true;
	}

	//按照ID删除试题
	//参数：试题ID
	//返回值：受影响记录数
	public function delQuestions($id)
	{
		$data = array('questions',array('questionstatus'=>'0'),"questionid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	//按照参数删除试题
	//参数：试题ID
	//返回值：受影响记录数
	public function delQuestionsByArgs($args)
	{
		$data = array('questions',array('questionstatus'=>'0'),$args);
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	//按照ID彻底删除试题
	//参数：试题ID
	//返回值：受影响记录数
	public function fanalDelQuestions($id)
	{
		$data = array('questions',"questionid = '{$id}'");
		$sql = $this->sql->makeDelete($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	//按照参数彻底删除试题
	//参数：$args
	//返回值：受影响记录数
	public function fanalDelQuestionsByArgs($args)
	{
		$data = array('questions',$args);
		$sql = $this->sql->makeDelete($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	//按照ID删除题帽题
	//参数：题帽题ID
	//返回值：受影响记录数
	public function delQuestionRows($id)
	{
		$data = array('questionrows',array('qrstatus'=>'0'),"qrid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	//按照ID彻底删除题帽题
	//参数：题帽题ID
	//返回值：受影响记录数
	public function finalDelQuestionRows($id)
	{
		$data = array('questionrows',"qrid = '{$id}'");
		$sql = $this->sql->makeDelete($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	//按照ID删除题帽题下子试题
	//参数：试题ID
	//返回值：受影响记录数
	public function delRowsQuestions($id)
	{
		$r = $this->getQuestionByArgs("questionid = '{$id}'");
		$data = array('questions',array('questionstatus'=>'0'),"questionid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		if($r['questionparent'])
		{
			$this->resetRowsQuestionNumber($id);
		}
		return $this->db->affectedRows();
	}

	public function resetRowsQuestionNumber($id)
	{
		if(!$id)return false;
		$data = array('count(*) AS number','questions',array("questionparent = '{$id}'","questionstatus = 1"));
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetch($sql);
		$data = array('questionrows',array('qrnumber'=>$r['number']),"qrid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	//恢复试题
	//参数：试题ID
	//返回值：受影响记录数
	public function backQuestions($id)
	{
		$data = array('questions',array('questionstatus'=>'1'),"questionid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	//恢复题帽题
	//参数：试题ID
	//返回值：受影响记录数
	public function backQuestionRows($id)
	{
		$data = array('questionrows',array('qrstatus'=>'1'),"qrid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		$data = array('questions',array('questionstatus'=>'1'),"questionparent = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		$this->resetRowsQuestionNumber($id);
		return $this->db->affectedRows();
	}

	//修改试题
	//参数：试题ID，更改参数（数组）
	//返回值：受影响记录数
	public function modifyQuestions($id,$args)
	{
		if($args['questionknowsid'])
		$this->clearQuestKnowsByQuestionid($id);
		$data = array('questions',$args,"questionid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		$r = $this->getQuestionByArgs("questionid = '{$id}'");
		$nargs = array();
		if($args['questionknowsid'])
		{
			$nargs['questionknowsid'] = $this->ev->addSlashes(serialize($this->parseQuestionKnows($args['questionknowsid'],$id,0)));
			//$nargs['questionhtml'] = $this->ev->addSlashes(serialize($this->question->parse($r)));
			$data = array('questions',$nargs,"questionid = '{$id}'");
			$sql = $this->sql->makeUpdate($data);
			$this->db->exec($sql);
		}
		return $this->db->affectedRows();
	}

	public function modifyQuestionSequence($id,$args)
	{
		$data = array('questions',$args,"questionid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	public function modifyQuestionRows($id,$args)
	{
		$this->clearQuestKnowsByQuestionid($id,1);
		$data = array('questionrows',$args,"qrid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		$r = $this->getQuestionRowsByArgs("qrid = '{$id}'");
		$nargs['qrknowsid'] = $this->ev->addSlashes(serialize($this->parseQuestionKnows($args['qrknowsid'],$id,1)));
		$data = array('questionrows',$nargs,"qrid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	public function clearQuestKnowsByQuestionid($questionid,$qktype = 0)
	{
		$data = array('quest2knows',array("qkquestionid = '{$questionid}'","qktype = '{$qktype}'"));
		$sql = $this->sql->makeDelete($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	//根据参数获取单一普通试题
	//参数：参数（数组或者字符串）
	//返回值：试题内容数组
	public function getQuestionByArgs($args)
	{
		$data = array(false,'questions',$args);
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql,array('questionhtml','questionknowsid'));
	}

	//根据参数获取试题总数量
	//参数：参数（数组或者字符串）
	//返回值：试题内容数组
	public function getQuestionNumberByQuestypeAndKnowsid($questype,$knowsid)
	{
		if(!$knowsid)$knowsid = '0';
		$data = array("count(*) AS number",array('questions','quest2knows'),array("questions.questiontype = '{$questype}'","questions.questionparent = 0","questions.questionstatus = 1","questions.questionid = quest2knows.qkquestionid","quest2knows.qkknowsid IN ({$knowsid})","quest2knows.qktype = 0"),false,false,false);
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetch($sql);
		$data = array("sum(qrnumber) AS number",array('questionrows','quest2knows'),array("questionrows.qrtype = '{$questype}'","questionrows.qrstatus = 1","questionrows.qrid = quest2knows.qkquestionid","quest2knows.qkknowsid IN ({$knowsid})","quest2knows.qktype = 1"),false,false,false);
		$sql = $this->sql->makeSelect($data);
		$m = $this->db->fetch($sql);
		return $r['number']+$m['number'];
	}

	//根据参数获取单一题帽试题
	//参数：参数（数组或者字符串）
	//返回值：试题内容数组
	public function getQuestionRowsByArgs($args,$fields = false)
	{
		$data = array($fields,array('questionrows','quest2knows'),$args);
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetch($sql,array('qrknowsid'));
		if($r['qrid'])
		$r['data'] = $this->getSimpleQuestionListByArgs(array("questionparent = '{$r['qrid']}'","questionstatus = 1"));
		return $r;
	}

	public function getQuestionRowsById($id,$fields = false)
	{
		$data = array($fields,'questionrows',"qrid = {$id}");
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetch($sql,array('qrknowsid'));
		if($r['qrid'])
		$r['data'] = $this->getSimpleQuestionListByArgs(array("questionparent = '{$r['qrid']}'","questionstatus = 1"));
		return $r;
	}

	//根据参数获取所有普通试题列表
	//参数：参数（数组或者字符串）
	//返回值：试题内容列表数组
	public function getQuestionListByArgs($args,$fields = false)
	{
		$data = array($fields,array('questions','quest2knows'),$args,false,array("questionsequence ASC","questionid ASC"),false);
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetchAll($sql,'questionid',array('questionhtml','questionknowsid'));
	}

	public function getSimpleQuestionListByArgs($args,$fields = false)
	{
		$data = array($fields,'questions',$args,false,array("questionsequence ASC","questionid ASC"),false);
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetchAll($sql,'questionid',array('questionhtml','questionknowsid'));
	}

	public function getQuestionListByIds($ids,$fields = false)
	{
		$data = array($fields,'questions',"questionid IN ($ids)",false,array("questionsequence ASC","questionid ASC"),false);
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetchAll($sql,'questionid',array('questionhtml','questionknowsid'));
	}

	//根据知识点获取试题列表
	//参数：当前页码，每页显示数量，参数（数组或者字符串）
	//返回值：试题内容列表数组
	public function getQuestionsList($page,$number = 20,$args = 1)
	{
		$page = $page > 0?$page:1;
		$r = array();
		$data = array('DISTINCT questions.*',array('questions','quest2knows'),$args,false,'questions.questionid DESC',array(intval($page-1)*$number,$number));
		$sql = $this->sql->makeSelect($data);
		$r['data'] = $this->db->fetchAll($sql,false,array('questionhtml','questionknowsid'));
		$data = array('count(DISTINCT questions.questionid) AS number',array('questions','quest2knows'),$args);
		$sql = $this->sql->makeSelect($data);
		$t = $this->db->fetch($sql);
		$pages = $this->pg->outPage($this->pg->getPagesNumber($t['number'],$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
	}

	public function getSimpleQuestionsList($page,$number = 20,$args = 1)
	{
		$page = $page > 0?$page:1;
		$r = array();
		$data = array(false,'questions',$args,false,'questionid DESC',array(intval($page-1)*$number,$number));
		$sql = $this->sql->makeSelect($data);
		$r['data'] = $this->db->fetchAll($sql,false,array('questionhtml','questionknowsid'));
		$data = array('count(*) AS number','questions',$args);
		$sql = $this->sql->makeSelect($data);
		$t = $this->db->fetch($sql);
		$pages = $this->pg->outPage($this->pg->getPagesNumber($t['number'],$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
	}

	//根据知识点获取题帽试题列表
	//参数：当前页码，每页显示数量，参数（数组或者字符串）
	//返回值：试题内容列表数组
	public function getQuestionrowsList($page,$number = 20,$args = 1)
	{
		$page = $page > 0?$page:1;
		$r = array();
		$data = array('DISTINCT questionrows.*',array('questionrows','quest2knows'),$args,false,'questionrows.qrid DESC',array(intval($page-1)*$number,$number));
		$sql = $this->sql->makeSelect($data);
		$r['data'] = $this->db->fetchAll($sql,false,array('questionknowsid'));
		$data = array('count(DISTINCT questionrows.qrid) AS number',array('questionrows','quest2knows'),$args);
		$sql = $this->sql->makeSelect($data);
		$t = $this->db->fetch($sql);
		$pages = $this->pg->outPage($this->pg->getPagesNumber($t['number'],$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
	}
}

?>