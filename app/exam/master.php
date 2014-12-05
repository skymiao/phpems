<?php

class app
{
	public $G;

	//初始化信息
	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->session = $this->G->make('session');
		$this->user = $this->G->make('user','user');
		$this->_user = $_user = $this->session->getSessionUser();
		$group = $this->user->getGroupById($_user['sessiongroupid']);
		if($group['groupmoduleid'] != 1)
		{
			if($this->ev->get('userhash'))
			exit(json_encode(array(
				'statusCode' => 300,
				"message" => "请您重新登录",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?core-master-login"
			)));
			else
			{
				header("location:?core-master-login");
				exit;
			}
		}
		//生产一个对象
		$this->tpl = $this->G->make('tpl');
		$this->sql = $this->G->make('sql');
		$this->db = $this->G->make('db');
		$this->pg = $this->G->make('pg');
		$this->html = $this->G->make('html');
		$this->apps = $this->G->make('apps','core');
		$this->basic = $this->G->make('basic','exam');
		$this->area = $this->G->make('area','exam');
		$this->section = $this->G->make('section','exam');
		$this->exam = $this->G->make('exam','exam');
		$this->favor = $this->G->make('favor','exam');
		$this->tpl->assign('action',$this->ev->url(2)?$this->ev->url(2):'exams');
		$this->tpl->assign('_user',$this->user->getUserById($this->_user['sessionuserid']));
		$this->tpl->assign('sectionorder',array(1=>'第一章','第二章','第三章','第四章','第五章','第六章','第七章','第八章','第九章','第十章','第十一章','第十二章','第十三章','第十四章','第十五章','第十六章','第十七章','第十八章','第十九章','第二十章','第二十一章','第二十二章'));
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
		$localapps = $this->apps->getLocalAppList();
		$apps = $this->apps->getAppList();
		$this->tpl->assign('localapps',$localapps);
		$this->tpl->assign('apps',$apps);
	}

	//设置基础信息，包括题型、地区、科目及关联关系
	public function basic()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('u',$u);
		$page = $this->ev->get('page');
		$this->tpl->assign('page',$page);
		switch($subaction)
		{
			case 'section':
			$subjectid = $this->ev->get('subjectid');
			$subjects = $this->basic->getSubjectList();
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$sections = $this->section->getSectionList($page,10,"sectionsubjectid = '{$subjectid}'");
			$this->tpl->assign('sections',$sections);
			$this->tpl->assign('subjectid',$subjectid);
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->display('basic_section');
			break;

			case 'addsection':
			if($this->ev->get('insertsection'))
			{
				$args = $this->ev->get('args');
				$section = $this->section->getSectionByArgs(array("section = '{$args['section']}'","sectionsubjectid = '{$args['sectionsubjectid']}'"));
				if($section)
				{
					$message = array(
						'statusCode' => 300,
						"message" => "操作失败，该科目下已经存在同名的章节"
					);
				}
				else
				{
					$this->section->addSection($args);
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
					    "forwardUrl" => "index.php?exam-master-basic-section&subjectid={$args['sectionsubjectid']}"
					);
				}
				$this->G->R($message);
			}
			else
			{
				$subjectid = $this->ev->get('subjectid');
				$subjects = $this->basic->getSubjectList();
				$this->tpl->assign('subjectid',$subjectid);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('basic_addsection');
			}
			break;

			case 'modifysection':
			if($this->ev->get('modifysection'))
			{
				$args = $this->ev->get('args');
				$page = $this->ev->get('page');
				$sectionid = $this->ev->get('sectionid');
				$section = $this->section->getSectionByArgs("sectionid = '{$sectionid}'");
				$tpsection = $this->section->getSectionByArgs(array("sectionsubjectid = '{$section['sectionsubjectid']}'","section = '{$args['section']}'","sectionid != '{$sectionid}'"));
				if($tpsection)
				{
					$message = array(
						'statusCode' => 300,
						"message" => "操作失败，本科目下已经存在这个章节",
					    "forwardUrl" => "index.php?exam-master-basic-section&subjectid={$section['sectionsubjectid']}&page={$page}"
					);
				}
				else
				{
					$this->section->modifySection($sectionid,$args);
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
					    "forwardUrl" => "index.php?exam-master-basic-section&subjectid={$section['sectionsubjectid']}&page={$page}"
					);
				}
				$this->G->R($message);
			}
			else
			{
				$page = $this->ev->get('page');
				$sectionid = $this->ev->get('sectionid');
				$section = $this->section->getSectionByArgs("sectionid = '{$sectionid}'");
				$subjects = $this->basic->getSubjectList();
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('section',$section);
				$this->tpl->display('basic_modifysection');
			}
			break;

			//删除章节
			case 'delsection':
			$sectionid = $this->ev->get('sectionid');
			$page = $this->ev->get('page');
			$section = $this->section->getSectionByArgs("sectionid = '{$sectionid}'");
			$this->section->delSection($sectionid);
			$message = array(
				"statusCode" => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-basic-section&subjectid={$section['sectionsubjectid']}&page={$page}"
			);
			$this->G->R($message);
			break;

			//知识点管理
			case 'point':
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$sectionid = $this->ev->get('sectionid');
			$section = $this->section->getSectionByArgs("sectionid = '{$sectionid}'");
			if(!$section['sectionid'])
			{
				header('location:index.php?exam-master-subject');
				exit;
			}
			else
			{
				$subjects = $this->basic->getSubjectList();
				$knows = $this->section->getKnowsList($page,10,array("knowssectionid = '{$sectionid}'","knowsstatus = 1"));
				$this->tpl->assign('section',$section);
				$this->tpl->assign('knows',$knows);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('basic_point');
			}
			break;

			case 'addpoint':
			if($this->ev->get('insertknows'))
			{
				$args = $this->ev->get('args');
				$page = $this->ev->get('page');
				$knows = explode(",",$args['knows']);
				foreach($knows as $know)
				{
					if($know)
					{
						$data = $this->section->getKnowsByArgs(array("knowsstatus = 1","knows = '{$know}'","knowssectionid = '{$args['knowssectionid']}'"));
						if($data)
						{
							$errmsg .= $know.',';
						}
						else
						$this->section->addKnows(array("knowssectionid" => $args['knowssectionid'],"knows" => $know));
					}
				}
				$errmsg = trim($errmsg,' ,');
				if($errmsg)$errmsg = $errmsg.'等知识点已经存在，程序自动忽略！';
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功！".$errmsg,
				    "forwardUrl" => "index.php?exam-master-basic-point&sectionid={$args['knowssectionid']}"
				);
				$this->G->R($message);
			}
			else
			{
				$page = $this->ev->get('page');
				$page = $page > 0?$page:1;
				$sectionid = $this->ev->get('sectionid');
				$section = $this->section->getSectionByArgs("sectionid = '{$sectionid}'");
				if(!$section['sectionid'])
				{
					header('location:index.php?exam-master-subject');
					exit;
				}
				else
				{
					$subjects = $this->basic->getSubjectList();
					$knows = $this->section->getKnowsList($page,10,array("knowssectionid = '{$sectionid}'","knowsstatus = 1"));
					$this->tpl->assign('section',$section);
					$this->tpl->assign('subjects',$subjects);
					$this->tpl->display('basic_addpoint');
				}
			}
			break;

			case 'modifypoint':
			if($this->ev->get('modifypoint'))
			{
				$args = $this->ev->get('args');
				$page = $this->ev->get('page');
				$knowsid = $this->ev->get('knowsid');
				$knows = $this->section->getKnowsByArgs("knowsid = '{$knowsid}'");
				$tpknows = $this->section->getKnowsByArgs(array("knowssectionid = '{$knows['knowssectionid']}'","knows = '{$args['knows']}'","knowsid != '{$knowsid}'"));
				if($tpknows)
				{
					$message = array(
						"statusCode" => 300,
						"message" => "操作失败，该章节下已经存在同名的知识点"
					);
				}
				else
				{
					$this->section->modifyKnows($knowsid,$args);
					$message = array(
						"statusCode" => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
					    "forwardUrl" => "index.php?exam-master-basic-point&sectionid={$knows['knowssectionid']}&page={$page}"
					);
				}
				$this->G->R($message);
			}
			else
			{
				$page = $this->ev->get('page');
				$knowsid = $this->ev->get('knowsid');
				$knows = $this->section->getKnowsByArgs("knowsid = '{$knowsid}'");
				$section = $this->section->getSectionByArgs("sectionid = '{$knows['knowssectionid']}'");
				$this->tpl->assign('section',$section);
				$this->tpl->assign('knows',$knows);
				$this->tpl->display('basic_modifypoint');
			}
			break;

			//删除知识点
			case 'delpoint':
			$knowsid = $this->ev->get('knowsid');
			$sectionid = $this->ev->get('sectionid');
			$page = $this->ev->get('page');
			$this->section->delKnows($knowsid);
			$message = array(
				"statusCode" => 200,
				"message" => "操作成功！",
				"callbackType" => "forward",
			    "forwardUrl" => "reload"
			);
			$this->G->R($message);
			break;

			//科目列表
			case 'subject':
			$subjects = $this->basic->getSubjectList();
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->display('basic_subject');
			break;

			//添加科目
			case 'addsubject':
			if($this->ev->get('insertsubject'))
			{
				$args = array('subject' => $this->ev->get('subject'));
				$data = $this->basic->getSubjectByName($args['subject']);
				if($data)
				{
					$message = array(
					'statusCode' => 300,
					"message" => "操作失败，该科目已经存在"
					);
					$this->G->R($message);
				}
				$this->basic->addSubject($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-basic-subject"
				);
				$this->G->R($message);
			}
			else
			{
				$subjects = $this->basic->getSubjectList();
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('basic_addsubject');
			}
			break;

			//修改科目
			case 'modifysubject':
			if($this->ev->get('modifysubject'))
			{
				$args = $this->ev->get('args');
				$subjectid = $this->ev->get('subjectid');
				$this->basic->modifySubject($subjectid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-basic-subject"
				);
				$this->G->R($message);
			}
			else
			{
				$subjectid = $this->ev->get('subjectid');
				$subject = $this->basic->getSubjectById($subjectid);
				$this->tpl->assign('subject',$subject);
				$this->tpl->display('basic_modifysubject');
			}
			break;

			//删除科目
			case 'delsubject':
			$subjectid = $this->ev->get('subjectid');
			$section = $this->section->getSectionByArgs("sectionsubjectid = '{$subjectid}'");
			if($section)
			$message = array(
				'statusCode' => 300,
				"message" => "操作失败，请删除该科目下所有章节后再删除本科目"
			);
			else
			{
				$this->basic->delSubject($subjectid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-basic-subject"
				);
			}
			$this->G->R($message);
			break;

			//题型列表
			case 'questype':
			$questypes = $this->basic->getQuestypeList();
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->display('basic_questype');
			break;

			//题型列表
			case 'addquestype':
			if($this->ev->get('insertquestype'))
			{
				$args = $this->ev->get('args');
				$page = $this->ev->get('page');
				$this->basic->addQuestype($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-basic-questype&page={$page}"
				);
				$this->G->R($message);
			}
			else
			{
				$this->tpl->display('basic_addquestype');
			}
			break;

			//修改题型
			case 'modifyquestype':
			if($this->ev->get('modifyquestype'))
			{
				$args = $this->ev->get('args');
				$page = $this->ev->get('page');
				$questid = $this->ev->get('questid');
				$this->basic->modifyQuestype($questid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-basic-questype&page={$page}"
				);
				$this->G->R($message);
			}
			else
			{
				$questid = $this->ev->get('questid');
				$quest = $this->basic->getQuestypeById($questid);
				$this->tpl->assign('quest',$quest);
				$this->tpl->display('basic_modifyquest');
			}
			break;

			//删除题型
			case 'delquestype':
			$questid = $this->ev->get('questid');
			$page = $this->ev->get('page');
			$this->basic->delQuestype($questid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-basic-questype&page={$page}"
			);
			$this->G->R($message);
			break;

			case 'delarea':
			$areaid = intval($this->ev->get('areaid'));
			$this->area->delArea($areaid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-basic-area&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			case 'modifyarea':
			if($this->ev->get('modifyarea'))
			{
				$args = $this->ev->get('args');
				$areaid = $this->ev->get('areaid');
				$this->area->modifyArea($areaid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-basic-area&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$page = intval($this->ev->get('page'));
				$areaid = intval($this->ev->get('areaid'));
				$area = $this->area->getAreaById($areaid);
				$this->tpl->assign('page',$page);
				$this->tpl->assign('area',$area);
				$this->tpl->display('basic_modifyarea');
			}
			break;

			case 'addarea':
			if($this->ev->get('insertarea'))
			{
				$args = $this->ev->get('args');
				$id = $this->area->addArea($args);
				if(!$id)
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败，区号已存在"
				);
				else
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-basic-area&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$this->tpl->display('basic_addarea');
			}
			break;

			case 'area':
			$areas = $this->area->getAreaListByPage($page,10);
			$this->tpl->assign('areas',$areas);
			$this->tpl->display('basic_area');
			break;

			//删除考试设置信息
			case 'delbasic':
			$page = $this->ev->get('page');
			$basicid = $this->ev->get('basicid');
			$this->basic->delBasic($basicid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-basic&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			//删除考试设置信息
			case 'batdelbasic':
			$page = $this->ev->get('page');
			$basicid = $this->ev->get('basicid');
			$this->basic->delBasic($basicid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-basic&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			case 'modifybasic':
			$page = $this->ev->get('page');
			if($this->ev->get('modifybasic'))
			{
				$basicid = $this->ev->get('basicid');
				$args = $this->ev->get('args');
				$this->basic->setBasicConfig($basicid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-basic&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$basicid = $this->ev->get('basicid');
				$basic = $this->basic->getBasicById($basicid);
				$subjects = $this->basic->getSubjectList();
				$areas = $this->area->getAreaList();
				$this->tpl->assign('areas',$areas);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('basic',$basic);
				$this->tpl->display('basic_modify');
			}
			break;

			case 'setexamrange':
			$page = $this->ev->get('page');
			$basicid = $this->ev->get('basicid');
			if($this->ev->get('setexamrange'))
			{
				$args = $this->ev->get('args');
				$args['basicsection'] = array();
				if(is_array($args['basicknows']))
				foreach($args['basicknows'] as $key => $p)
				{
					$args['basicsection'][] = $key;
				}
				$args['basicexam']['opentime']['start'] = strtotime($args['basicexam']['opentime']['start']);
				$args['basicexam']['opentime']['end'] = strtotime($args['basicexam']['opentime']['end']);
				$args['basicsection'] = $this->ev->addSlashes(serialize($args['basicsection']));
				$args['basicknows'] = $this->ev->addSlashes(serialize($args['basicknows']));
				$args['basicexam'] = $this->ev->addSlashes(serialize($args['basicexam']));
				$this->basic->setBasicConfig($basicid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-basic&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$basic = $this->basic->getBasicById($basicid);
				$subjects = $this->basic->getSubjectList();
				$areas = $this->area->getAreaList();
				$tmpknows = $this->section->getAllKnowsBySubject($basic['basicsubjectid']);
				$knows = array();
				$sections = $this->section->getSectionListByArgs("sectionsubjectid = '{$basic['basicsubjectid']}'");
				foreach($tmpknows as $p)
				{
					$knows[$p['knowssectionid']][] = $p;
				}
				$tpls = array();
				foreach(glob("app/exam/tpls/app/exampaper_paper*.tpl") as $p)
				{
					$tpls['ep'][] = substr(basename($p),0,-4);
				}
				foreach(glob("app/exam/tpls/app/exam_paper*.tpl") as $p)
				{
					$tpls['pp'][] = substr(basename($p),0,-4);
				}
				$this->tpl->assign('tpls',$tpls);
				$this->tpl->assign('basic',$basic);
				$this->tpl->assign('areas',$areas);
				$this->tpl->assign('sections',$sections);
				$this->tpl->assign('knows',$knows);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('basic_examrange');
			}
			break;

			case 'add':
			if($this->ev->get('insertbasic'))
			{
				$args = $this->ev->get('args');
				$page = $this->ev->get('page');
				$id = $this->basic->addBasic($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-basic-setexamrange&basicid={$id}&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$subjects = $this->basic->getSubjectList();
				$areas = $this->area->getAreaList();
				$this->tpl->assign('areas',$areas);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('basic_add');
			}
			break;

			default:
			$page = $this->ev->get('page');
			$page = $page > 1?$page:1;
			$subjects = $this->basic->getSubjectList();
			if(!$search)
			$args = 1;
			else
			$args = array();
			if($search['basicid'])$args[] = "basicid = '{$search['basicid']}'";
			else
			{
				if($search['keyword'])$args[] = "basic LIKE '%{$search['keyword']}%'";
				if($search['basicareaid'])$args[] = "basicareaid = '{$search['basicareaid']}'";
				if($search['basicsubjectid'])$args[] = "basicsubjectid = '{$search['basicsubjectid']}'";
				if($search['basicapi'])$args[] = "basicapi = '{$search['basicapi']}'";
			}
			$basics = $this->basic->getBasicList($page,10,$args);
			$areas = $this->area->getAreaList();
			$this->tpl->assign('areas',$areas);
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('basics',$basics);
			$this->tpl->display('basic');
			break;
		}
	}

	public function index()
	{
		$this->tpl->display('index');
	}

	public function asks()
	{
		$subaction = $this->ev->url(3);
		switch($subaction)
		{
			//删除一个问题
			case 'del':
			$askid = $this->ev->get('askid');
			$page = $this->ev->get('page');
			$this->answer->delAsksById($askid);
			$this->G->msg(array('url'=>'?exam-master-asks&page='.$page));
			break;

			//删除一个追问的问题
			case 'delanswer':
			$answerid = $this->ev->get('answerid');
			$answer = $this->answer->getAnswerById($answerid);
			$page = $this->ev->get('page');
			$this->answer->delAnswerById($answerid);
			$this->G->msg(array('url'=>'?exam-master-asks-detail&askid='.$answer['answeraskid'].'&page='.$page));
			break;

			//批量删除追问问题
			case 'done':
			$page = $this->ev->get('page');
			$ids = $this->ev->get('delids');
			foreach($ids as $key => $id)
			{
				$this->answer->delAsksById($id);
			}
			$this->G->msg(array('url'=>'?exam-master-asks&page='.$page));
			break;

			//问题详细页面
			case 'detail':
			$askid = $this->ev->get('askid');
			$ask = $this->answer->getAskById($askid);
			$question = $this->exam->getQuestionByArgs("questionid = '{$ask['askquestionid']}'");
			$answers = $this->answer->getAnswerList($page,20,array("answeraskid = '{$ask['askid']}'"));
			$this->tpl->assign('question',$question);
			$this->tpl->assign('answers',$answers);
			$this->tpl->display('ask_answer');
			break;

			//问题回复
			case 'rely':
			$answerid = $this->ev->get('answerid');
			$args = $this->ev->get('args');
			$args['answertime'] = TIME;
			$args['answerteacher'] = $this->_user['sessionusername'];
			$args['answerteacherid'] = $this->_user['sessionuserid'];
			$id = $this->answer->giveAnswer($answerid,$args);
			$this->G->msg(array('url'=>'?exam-master-asks-detail&askid='.$id.'&page='.$page));
			break;

			//问题列表
			default:
			$sargs = $this->ev->get('args');
			$page = $this->ev->get('page');
			$page = $page > 1?$page:1;
			$args = array("asks.askquestionid = questions.questionid");
			if($sargs['asksubjectid'])$args[] = "asks.asksubjectid = '{$sargs['asksubjectid']}'";
			if($sargs['asklasttime'])$args[] = "asks.asklasttime >= '{$sargs['asklasttime']}'";
			if($sargs['askuserid'])$args[] = "asks.asklastteacherid = '{$sargs['askuserid']}'";
			if($sargs['askstatus'])
			{
				if($sargs['askstatus'] == -1)
				$args[] = "asks.askstatus = '0'";
				else
				$args[] = "asks.askstatus = '1'";
			}
			$subjects = $this->basic->getSubjectList();
			$asks = $this->answer->getAskList($page,20,$args);
			$this->tpl->assign('args',$sargs);
			$this->tpl->assign('asks',$asks);
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->display('asks');
		}
	}

	public function questions()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('u',$u);
		$page = $this->ev->get('page');
		$this->tpl->assign('page',$page);
		switch($subaction)
		{
			//搜索问题
			case 'makequery':
			$message = array(
				"statusCode" => 200,
				"message" => "操作成功，正在转入查询结果",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-questions{$u}"
			);
			$this->G->R($message);
			break;

			case 'filebataddquestion':
			setlocale(LC_ALL,'zh_CN');
			if($this->ev->get('insertquestion'))
			{
				$page = $this->ev->get('page');
				$uploadfile = $this->ev->get('uploadfile');
				$knowsid = trim($this->ev->get('knowsid'));
				$this->exam->importQuestionBat($uploadfile,$knowsid);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-questions&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			$this->tpl->display('question_filebatadd');
			break;

			//添加问题
			case 'addquestion':
			if($this->ev->get('insertquestion'))
			{
				$type = $this->ev->get('type');
				$questionparent = $this->ev->get('questionparent');
				//批量添加
				if($type)
				{
					$page = $this->ev->get('page');
					$content = $this->ev->get('content');
					$this->exam->insertQuestionBat($content,$questionparent);
				}
				//单个添加
				else
				{
					$args = $this->ev->get('args');
					$targs = $this->ev->get('targs');
					if(!$questionparent)$questionparent = $args['questionparent'];
					$questype = $this->basic->getQuestypeById($args['questiontype']);
					$args['questionuserid'] = $this->_user['sessionuserid'];
					if($questype['questsort'])$choice = 0;
					else $choice = $questype['questchoice'];
					$args['questionanswer'] = $targs['questionanswer'.$choice];
					if(is_array($args['questionanswer']))$args['questionanswer'] = implode('',$args['questionanswer']);
					$page = $this->ev->get('page');
					$args['questioncreatetime'] = TIME;
					$args['questionusername'] = $this->_user['sessionusername'];
					$this->exam->addQuestions($args);
				}
				if($questionparent)
				{
					$this->exam->resetRowsQuestionNumber($questionparent);
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
						"callbackType" => "forward",
						"forwardUrl" => "index.php?exam-master-rowsquestions-rowsdetail&questionid={$questionparent}&page={$page}{$u}"
					);
				}
				else
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-questions&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{

				$questypes = $this->basic->getQuestypeList();
				$subjects = $this->basic->getSubjectList();
				$sections = $this->section->getSectionListByArgs("sectionsubjectid = '{$search['questionsubjectid']}'");
				$knows = $this->section->getKnowsListByArgs(array("knowsstatus = 1","knowssectionid = '{$search['questionsectionid']}'"));
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('sections',$sections);
				$this->tpl->assign('knows',$knows);
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->display('question_add');
			}
			break;

			//添加问题
			case 'bataddquestion':
			if($this->ev->get('insertquestion'))
			{
				$page = $this->ev->get('page');
				$content = $this->ev->get('content');
				$this->exam->insertQuestionBat($content,$questionparent);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-questions&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$this->tpl->display('question_batadd');
			}
			break;

			//删除问题
			case 'delquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$questionparent = $this->ev->get('questionparent');
			$this->exam->delQuestions($questionid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-questions&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			//批量删除问题
			case 'batdel':
			$page = $this->ev->get('page');
			$delids = $this->ev->get('delids');
			foreach($delids as $questionid => $p)
			$this->exam->delQuestions($questionid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-questions&page={$page}{$u}"
			);
			$this->G->R($message);
			break;


			//恢复被删除的问题
			case 'backquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$questions = $this->exam->backQuestions($questionid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-recyle&page={$page}"
			);
			$this->G->R($message);
			break;

			//编辑问题
			case 'modifyquestion':
			if($this->ev->get('modifyquestion'))
			{
				$page = $this->ev->get('page');
				$args = $this->ev->get('args');
				$questionid = $this->ev->get('questionid');
				$targs = $this->ev->get('targs');
				$questype = $this->basic->getQuestypeById($args['questiontype']);
				if($questype['questsort'])$choice = 0;
				else $choice = $questype['questchoice'];
				$args['questionanswer'] = $targs['questionanswer'.$choice];
				if(is_array($args['questionanswer']))$args['questionanswer'] = implode('',$args['questionanswer']);
				$this->exam->modifyQuestions($questionid,$args);
				if($args['questionparent'])
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
					"forwardUrl" => "index.php?exam-master-questions&page={$page}{$u}"
				);
				else
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-questions&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$page = $this->ev->get('page');
				$questionparent = $this->ev->get('questionparent');
				$knowsid = $this->ev->get('knowsid');
				$questionid = $this->ev->get('questionid');
				$questypes = $this->basic->getQuestypeList();
				$question = $this->exam->getQuestionByArgs("questionid = '{$questionid}'");
				$subjects = $this->basic->getSubjectList();
				foreach($question['questionknowsid'] as $key => $p)
				{
					$knows = $this->section->getKnowsByArgs("knowsid = '{$p['knowsid']}'");
					$question['questionknowsid'][$key]['knows'] = $knows['knows'];
				}
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('questionparent',$questionparent);
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign('page',$page);
				$this->tpl->assign('knowsid',$knowsid);
				$this->tpl->assign('question',$question);
				if($questionparent)
				$this->tpl->display('questionchildrows_modify');
				else
				$this->tpl->display('questions_modify');
			}
			break;

			case 'ajax':
			switch($this->ev->url(4))
			{
				//根据章节获取知识点信息
				case 'getknowsbysectionid':
				$sectionid = $this->ev->get('sectionid');
				$aknows = $this->section->getKnowsListByArgs(array("knowssectionid = '{$sectionid}'","knowsstatus = 1"));
				$data = array(array("",'选择知识点'));
				foreach($aknows as $knows)
				{
					$data[] = array($knows['knowsid'],$knows['knows']);
				}
				foreach($data as $p)
				{
					echo "<option value=\"{$p[0]}\">{$p[1]}</option>";
				}
				//exit(json_encode($data));
				break;

				//根据科目获取章节信息
				case 'getsectionsbysubjectid':
				$esid = $this->ev->get('subjectid');
				$aknows = $this->section->getSectionListByArgs(array("sectionsubjectid = '{$esid}'"));
				$data = array(array(0,'选择章节'));
				foreach($aknows as $knows)
				{
					$data[] = array($knows['sectionid'],$knows['section']);
				}
				foreach($data as $p)
				{
					echo "<option value=\"{$p[0]}\">{$p[1]}</option>";
				}
				//exit(json_encode($data));
				break;

				default:
			}
			break;

			case 'detail':
			$questionid = $this->ev->get('questionid');
			$questionparent = $this->ev->get('questionparent');
			if($questionparent)
			{
				$questions = $this->exam->getQuestionByArgs("questionparent = '{$questionparent}'");
			}
			else
			{
				$question = $this->exam->getQuestionByArgs("questionid = '{$questionid}'");
				$sections = array();
				foreach($question['questionknowsid'] as $key => $p)
				{
					$knows = $this->section->getKnowsByArgs("knowsid = '{$p['knowsid']}'");
					$question['questionknowsid'][$key]['knows'] = $knows['knows'];
					$sections[] = $this->section->getSectionByArgs("sectionid = '{$knows['knowssectionid']}'");
				}
				$subject = $this->basic->getSubjectById($sections[0]['sectionsubjectid']);
			}
			$this->tpl->assign("subject",$subject);
			$this->tpl->assign("sections",$sections);
			$this->tpl->assign("question",$question);
			$this->tpl->assign("questions",$questions);
			$this->tpl->display('question_detail');
			break;

			//试题列表（可根据条件进行查询）
			default:
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$args = array("quest2knows.qkquestionid = questions.questionid","questions.questionstatus = '1'","questions.questionparent = 0","quest2knows.qktype = 0" );
			if($search['questionid'])
			{
				$args[] = "questions.questionid = '{$search['questionid']}'";
			}
			if($search['keyword'])
			{
				$args[] = "questions.question LIKE '%".$search['keyword']."%'";
			}
			if($search['knowsids'])
			{
				$args[] = "questions.questionknowsid IN (".$search['knowsids'].")";
			}
			if($search['stime'])
			{
				$args[] = "questions.questioncreatetime >= '".strtotime($search['stime'])."'";
			}
			if($search['etime'])
			{
				$args[] = "questions.questioncreatetime <= '".strtotime($search['etime'])."'";
			}
			if($search['questiontype'])
			{
				$args[] = "questions.questiontype = '".$search['questiontype']."'";
			}
			if($search['questionlevel'])
			{
				$args[] = "questions.questionlevel = '{$search['questionlevel']}'";
			}
			if($search['questionknowsid'])
			{
				$args[] = "quest2knows.qkknowsid = '".$search['questionknowsid']."'";
			}
			else
			{
				$tmpknows = '0';
				if($search['questionsectionid'])
				{
					$knows = $this->section->getKnowsListByArgs(array("knowsstatus = 1","knowssectionid = '{$search['questionsectionid']}'"));
					foreach($knows as $p)
					{
						if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
					}
					$args[] = "quest2knows.qkknowsid IN ({$tmpknows})";
				}
				elseif($search['questionsubjectid'])
				{
					$knows = $this->section->getAllKnowsBySubject($search['questionsubjectid']);
					foreach($knows as $p)
					{
						if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
					}
					$args[] = "quest2knows.qkknowsid IN ({$tmpknows})";
				}
			}
			$questypes = $this->basic->getQuestypeList();
			if($search)
			$questions = $this->exam->getQuestionsList($page,10,$args);
			else
			$questions = $this->exam->getSimpleQuestionsList($page,10,array("questions.questionstatus = '1'","questionparent = 0"));
			$subjects = $this->basic->getSubjectList();
			$sections = $this->section->getSectionListByArgs("sectionsubjectid = '{$search['questionsubjectid']}'");
			$knows = $this->section->getKnowsListByArgs(array("knowsstatus = 1","knowssectionid = '{$search['questionsectionid']}'"));
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('sections',$sections);
			$this->tpl->assign('knows',$knows);
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign('questions',$questions);
			$this->tpl->display('questions');
		}
	}

	public function rowsquestions()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('u',$u);
		$page = $this->ev->get('page');
		$this->tpl->assign('page',$page);
		$questypes = $this->basic->getQuestypeList();
		switch($subaction)
		{
			//删除问题
			case 'delquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$question = $this->exam->getQuestionRowsByArgs("qrid = '{$questionid}'");
			if($question['data'])
			{
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败，请先删除子试题"
				);
				$this->G->R($message);
			}
			$this->exam->delQuestionRows($questionid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-rowsquestions&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			//批量删除问题
			case 'batdel':
			$page = $this->ev->get('page');
			$delids = $this->ev->get('delids');
			foreach($delids as $questionid => $p)
			$this->exam->delQuestionRows($questionid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-rowsquestions&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			//删除子问题
			case 'delchildquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$questionparent = $this->ev->get('questionparent');
			$this->exam->delQuestions($questionid);
			$this->exam->resetRowsQuestionNumber($questionparent);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
				"forwardUrl" => "index.php?exam-master-rowsquestions-rowsdetail&questionid={$questionparent}&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			//恢复被删除的问题
			case 'backquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$questions = $this->exam->backQuestionRows($questionid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-recyle-rows&page={$page}"
			);
			$this->G->R($message);
			break;

			//编辑问题
			case 'modifyquestion':
			if($this->ev->get('modifyquestion'))
			{
				$page = $this->ev->get('page');
				$args = $this->ev->get('args');
				$questionid = $this->ev->get('questionid');
				$this->exam->modifyQuestionRows($questionid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-rowsquestions&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$page = $this->ev->get('page');
				$questionid = $this->ev->get('questionid');
				$question = $this->exam->getQuestionRowsByArgs("qrid = '{$questionid}'");
				$subjects = $this->basic->getSubjectList();
				$questypes = $this->basic->getQuestypeList();
				foreach($question['qrknowsid'] as $key => $p)
				{
					$knows = $this->section->getKnowsByArgs("knowsid = '{$p['knowsid']}'");
					$question['qrknowsid'][$key]['knows'] = $knows['knows'];
				}
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('page',$page);
				$this->tpl->assign('question',$question);
				$this->tpl->display('questionrows_modify');
			}
			break;

			//编辑子问题
			case 'modifychildquestion':
			if($this->ev->get('modifyquestion'))
			{
				$page = $this->ev->get('page');
				$args = $this->ev->get('args');
				$questionid = $this->ev->get('questionid');
				$targs = $this->ev->get('targs');
				$questype = $this->basic->getQuestypeById($args['questiontype']);
				if($questype['questsort'])$choice = 0;
				else $choice = $questype['questchoice'];
				$args['questionanswer'] = $targs['questionanswer'.$choice];
				if(is_array($args['questionanswer']))$args['questionanswer'] = implode('',$args['questionanswer']);
				$this->exam->modifyQuestions($questionid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
					"forwardUrl" => "index.php?exam-master-rowsquestions-rowsdetail&questionid={$args['questionparent']}&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$page = $this->ev->get('page');
				$questionparent = $this->ev->get('questionparent');
				$knowsid = $this->ev->get('knowsid');
				$questionid = $this->ev->get('questionid');
				$questypes = $this->basic->getQuestypeList();
				$question = $this->exam->getQuestionByArgs("questionid = '{$questionid}'");
				$subjects = $this->basic->getSubjectList();
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('questionparent',$questionparent);
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign('page',$page);
				$this->tpl->assign('knowsid',$knowsid);
				$this->tpl->assign('question',$question);
				$this->tpl->display('questionchildrows_modify');
			}
			break;

			case 'detail':
			$questionid = $this->ev->get('questionid');
			$question = $this->exam->getQuestionRowsByArgs("qrid = '{$questionid}'");
			$sections = array();
			foreach($question['qrknowsid'] as $key => $p)
			{
				$knows = $this->section->getKnowsByArgs("knowsid = '{$p['knowsid']}'");
				$question['qrknowsid'][$key]['knows'] = $knows['knows'];
				$sections[] = $this->section->getSectionByArgs("sectionid = '{$knows['knowssectionid']}'");
			}
			$subject = $this->basic->getSubjectById($sections[0]['sectionsubjectid']);
			$this->tpl->assign("subject",$subject);
			$this->tpl->assign("sections",$sections);
			$this->tpl->assign("question",$question);
			$this->tpl->display('questionrows_detail');
			break;

			case 'rowsdetail':
			$questionid = $this->ev->get('questionid');
			$question = $this->exam->getQuestionRowsByArgs("qrid = '{$questionid}'");
			$questypes = $this->basic->getQuestypeList();
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign("question",$question);
			$this->tpl->assign("questionparent",$questionid);
			$this->tpl->display('questionrows_list');
			break;

			case 'addchildquestion':
			if($this->ev->get('insertquestion'))
			{
				$questionparent = $this->ev->get('questionparent');
				$args = $this->ev->get('args');
				$targs = $this->ev->get('targs');
				if(!$questionparent)$questionparent = $args['questionparent'];
				$questype = $this->basic->getQuestypeById($args['questiontype']);
				$args['questionuserid'] = $this->_user['sessionuserid'];
				if($questype['questsort'])$choice = 0;
				else $choice = $questype['questchoice'];
				$args['questionanswer'] = $targs['questionanswer'.$choice];
				if(is_array($args['questionanswer']))$args['questionanswer'] = implode('',$args['questionanswer']);
				$page = $this->ev->get('page');
				$args['questioncreatetime'] = TIME;
				$args['questionusername'] = $this->_user['sessionusername'];
				$this->exam->addQuestions($args);
				$this->exam->resetRowsQuestionNumber($questionparent);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
					"forwardUrl" => "index.php?exam-master-rowsquestions-rowsdetail&questionid={$questionparent}&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$questionid = $this->ev->get('questionid');
				$question = $this->exam->getQuestionRowsByArgs("qrid = '{$questionid}'");
				$questypes = $this->basic->getQuestypeList();
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign("question",$question);
				$this->tpl->assign("questionparent",$questionid);
				$this->tpl->display('questionrows_addchild');
			}
			break;

			case 'bataddchildquestion':
			if($this->ev->get('insertquestion'))
			{
				$questionparent = $this->ev->get('questionparent');
				$page = $this->ev->get('page');
				$content = $this->ev->get('content');
				$this->exam->insertQuestionBat($content,$questionparent);
				$this->exam->resetRowsQuestionNumber($questionparent);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"forwardUrl" => "index.php?exam-master-rowsquestions-rowsdetail&questionid={$questionparent}&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$questionid = $this->ev->get('questionid');
				$question = $this->exam->getQuestionRowsByArgs("qrid = '{$questionid}'");
				$questypes = $this->basic->getQuestypeList();
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign("question",$question);
				$this->tpl->assign("questionparent",$questionid);
				$this->tpl->display('questionrows_bataddchild');
			}
			break;

			case 'done':
			$sequence = $this->ev->get('sequence');
			$questionparent = $this->ev->get('questionparent');
			foreach($sequence as $key => $l)
			{
				$this->exam->modifyQuestionSequence($key,array('questionsequence'=>$l));
			}
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
				"forwardUrl" => "index.php?exam-master-rowsquestions-rowsdetail&questionid={$questionparent}&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			case 'bataddquestionrows':
			if($this->ev->get('insertquestion'))
			{
				$page = $this->ev->get('page');
				$content = $this->ev->get('content');
				$this->exam->insertQuestionRowsBat($content);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-rowsquestions&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$subjects = $this->basic->getSubjectList();
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('questionrows_batadd');
			}
			break;

			case 'addquestionrows':
			if($this->ev->get('insertquestion'))
			{
				$args = $this->ev->get('args');
				$args['qrtime'] = TIME;
				$args['qruserid'] = $this->_user['sessionuserid'];
				$args['qrusername'] = $this->_user['sessionusername'];
				$this->exam->addQuestionRows($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-rowsquestions&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$subjects = $this->basic->getSubjectList();
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('questionrows_add');
			}
			break;

			//试题列表（可根据条件进行查询）
			default:
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$args = array("quest2knows.qkquestionid = questionrows.qrid","questionrows.qrstatus = '1'");
			if($search['questionid'])
			{
				$args[] = "questionrows.qrid = '{$search['questionid']}'";
			}
			if($search['questiontype'])
			{
				$args[] = "questionrows.qrtype = '{$search['questiontype']}'";
			}
			if($search['keyword'])
			{
				$args[] = "questionrows.qrquestion LIKE '%".$search['keyword']."%'";
			}
			if($search['stime'])
			{
				$args[] = "questionrows.qrtime >= '".strtotime($search['stime'])."'";
			}
			if($search['etime'])
			{
				$args[] = "questionrows.qrtime <= '".strtotime($search['etime'])."'";
			}
			if($search['qrlevel'])
			{
				$args[] = "questionrows.qrlevel = '{$search['qrlevel']}'";
			}
			if($search['questionknowsid'])
			{
				$args[] = "quest2knows.qkknowsid = '".$search['questionknowsid']."'";
			}
			else
			{
				$tmpknows = '0';
				if($search['questionsectionid'])
				{
					$knows = $this->section->getKnowsListByArgs(array("knowsstatus = 1","knowssectionid = '{$search['questionsectionid']}'"));
					foreach($knows as $p)
					{
						if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
					}
					$args[] = "quest2knows.qkknowsid IN ({$tmpknows})";
				}
				elseif($search['questionsubjectid'])
				{
					$knows = $this->section->getAllKnowsBySubject($search['questionsubjectid']);
					foreach($knows as $p)
					{
						if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
					}
					$args[] = "quest2knows.qkknowsid IN ({$tmpknows})";
				}
			}
			$questions = $this->exam->getQuestionrowsList($page,10,$args);
			$subjects = $this->basic->getSubjectList();
			$sections = $this->section->getSectionListByArgs("sectionsubjectid = '{$search['questionsubjectid']}'");
			$knows = $this->section->getKnowsListByArgs(array("knowsstatus = 1","knowssectionid = '{$search['questionsectionid']}'"));
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('sections',$sections);
			$this->tpl->assign('knows',$knows);
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign('questions',$questions);
			$this->tpl->display('questionrows');
		}
	}

	public function recyle()
	{
		$subaction = $this->ev->url(3);
		switch($subaction)
		{
			//恢复被删除的知识点
			case 'backknows':
			$knowsid = $this->ev->get('knowsid');
			$page = $this->ev->get('page');
			$nknow = $this->section->getKnowsByArgs("knowsid = '{$knowsid}'");
			$know = $this->section->getKnowsByArgs(array("knowsstatus = 1","knows = '{$nknow['knows']}'"),"knowssectionid = '{$nknow['knowssectionid']}'");
			if($know)
			{
				$message = array(
					'statusCode' => 300,
					"message" => "操作失败，所在章节下存在同名且未删除的知识点"
				);
				$this->G->R($message);
			}
			$this->section->backKnows($knowsid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-recyle-knows&page={$page}"
			);
			$this->G->R($message);
			break;

			case 'delknows':
			$knowsid = $this->ev->get('knowsid');
			$page = $this->ev->get('page');
			$this->section->delKnows($knowsid,true);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-recyle-knows&page={$page}"
			);
			$this->G->R($message);
			break;

			//被删除的知识点列表
			case 'knows':
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$args = array("knowsstatus = '0'");
			$knows = $this->section->getKnowsList($page,10,"knowsstatus = 0");
			$this->tpl->assign('page',$page);
			$this->tpl->assign('knows',$knows);
			$this->tpl->display('recyle_knows');
			break;

			//被删除的题帽题列表
			case 'rows':
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$args = array("questionrows.qrstatus = '0'","questionrows.qrid = quest2knows.qkquestionid","quest2knows.qktype = 1");
			$questypes = $this->basic->getQuestypeList();
			$questions = $this->exam->getQuestionrowsList($page,20,$args);
			$this->tpl->assign('page',$page);
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign('questions',$questions);
			$this->tpl->display('recyle_rowsquestions');
			break;

			//彻底删除问题
			case 'finaldelquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$this->exam->fanalDelQuestions($questionid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-recyle&page={$page}"
			);
			$this->G->R($message);
			break;

			//彻底删除问题
			case 'finaldelrowsquestion':
			$page = $this->ev->get('page');
			$questionid = $this->ev->get('questionid');
			$this->exam->finalDelQuestionRows($questionid);
			$this->exam->fanalDelQuestionsByArgs("questionparent = '{$questionid}'");
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-recyle-rows&page={$page}"
			);
			$this->G->R($message);
			break;

			//被删除的试题列表
			default:
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$args = array("quest2knows.qkquestionid = questions.questionid","questions.questionstatus = '0'","questions.questionparent = 0","quest2knows.qktype = 0" );
			$questypes = $this->basic->getQuestypeList();
			$questions = $this->exam->getQuestionsList($page,20,$args);
			$this->tpl->assign('page',$page);
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign('questions',$questions);
			$this->tpl->display('recyle_questions');
			break;
		}
	}

	public function tools()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$questypes = $this->basic->getQuestypeList();
		switch($subaction)
		{
			case 'clearouttimeexamsession':
			if($search['argsmodel'])
			{
				if($search['stime'])$time = strtotime($search['stime']);
				$this->session->clearOutTimeUser($time);
				$this->exam->clearOutTimeExamSession($time);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "callbackType" => "forward",
				    "forwardUrl" => "reload"
				);
			}
			else
			$message = array(
				'statusCode' => 300,
				"message" => "请先选择查询条件"
			);
			$this->G->R($message);
			break;

			case 'clearsession':
			$this->tpl->display('tools_session');
			break;

			case 'clearquestionrows':
			if($search['argsmodel'])
			{
				$args = array("quest2knows.qkquestionid = questionrows.qrid");
				if($search['questionid'])
				{
					$args[] = "questionrows.qrid = '{$search['questionid']}'";
				}
				if($search['questiontype'])
				{
					$args[] = "questionrows.qrtype = '{$search['questiontype']}'";
				}
				if($search['keyword'])
				{
					$args[] = "questionrows.qrquestion LIKE '%".$search['keyword']."%'";
				}
				if($search['stime'])
				{
					$args[] = "questionrows.qrtime >= '".strtotime($search['stime'])."'";
				}
				if($search['etime'])
				{
					$args[] = "questionrows.qrtime <= '".strtotime($search['etime'])."'";
				}
				if($search['qrlevel'])
				{
					$args[] = "questionrows.qrlevel = '{$search['qrlevel']}'";
				}
				if($search['questionknowsid'])
				{
					$args[] = "quest2knows.qkknowsid = '".$search['questionknowsid']."'";
				}
				else
				{
					$tmpknows = '0';
					if($search['questionsectionid'])
					{
						$knows = $this->section->getKnowsListByArgs(array("knowsstatus = 1","knowssectionid = '{$search['questionsectionid']}'"));
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = "quest2knows.qkknowsid IN ({$tmpknows})";
					}
					elseif($search['questionsubjectid'])
					{
						$knows = $this->section->getAllKnowsBySubject($search['questionsubjectid']);
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = "quest2knows.qkknowsid IN ({$tmpknows})";
					}
				}
				$questions = $this->exam->getQuestionRowsByArgs($args,'qrid');
				foreach($questions as $n)
				{
					$this->exam->finalDelQuestionRows($n['qrid']);
				}
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "callbackType" => "forward",
				    "forwardUrl" => "reload"
				);
				$this->G->R($message);
			}
			else
			{
				$message = array(
					'statusCode' => 300,
					"message" => "请先选择查询条件"
				);
				$this->G->R($message);
			}
			break;

			case 'clearhistory':
			if($search['argsmodel'])
			{
				if($search['stime'] || $search['etime'])
				{
					$args = array();
					if($search['stime'])$args[] = "ehstarttime >= ".strtotime($search['stime']);
					if($search['etime'])$args[] = "ehstarttime <= ".strtotime($search['etime']);
					$this->favor->clearExamHistory($args);
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功",
					    "callbackType" => "forward",
					    "forwardUrl" => "reload"
					);
					$this->G->R($message);
				}
				else
				{
					$message = array(
						'statusCode' => 300,
						"message" => "请先选择起止时间"
					);
					$this->G->R($message);
				}
			}
			else
			$this->tpl->display('tools_history');
			break;

			case 'clearquestions':
			if($search['argsmodel'])
			{
				$args = array("quest2knows.qkquestionid = questions.questionid","questions.questionparent = 0","quest2knows.qktype = 0" );
				if($search['knowsids'])
				{
					$args[] = "questions.questionknowsid IN (".$search['knowsids'].")";
				}
				if($search['stime'])
				{
					$args[] = "questions.questioncreatetime >= '".strtotime($search['stime'])."'";
				}
				if($search['etime'])
				{
					$args[] = "questions.questioncreatetime <= '".strtotime($search['etime'])."'";
				}
				if($search['questiontype'])
				{
					$args[] = "questions.questiontype = '".$search['questiontype']."'";
				}
				if($search['questionlevel'])
				{
					$args[] = "questions.questionlevel = '{$search['questionlevel']}'";
				}
				if($search['questionknowsid'])
				{
					$args[] = "quest2knows.qkknowsid = '".$search['questionknowsid']."'";
				}
				else
				{
					$tmpknows = '0';
					if($search['questionsectionid'])
					{
						$knows = $this->section->getKnowsListByArgs(array("knowsstatus = 1","knowssectionid = '{$search['questionsectionid']}'"));
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = "quest2knows.qkknowsid IN ({$tmpknows})";
					}
					elseif($search['questionsubjectid'])
					{
						$knows = $this->section->getAllKnowsBySubject($search['questionsubjectid']);
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = "quest2knows.qkknowsid IN ({$tmpknows})";
					}
				}
				$questions = $this->exam->getQuestionListByArgs($args,'questionid');
				foreach($questions as $n)
				{
					$this->exam->fanalDelQuestions($n['questionid']);
				}
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "callbackType" => "forward",
				    "forwardUrl" => "reload"
				);
				$this->G->R($message);
			}
			else
			{
				$message = array(
					'statusCode' => 300,
					"message" => "请先选择查询条件"
				);
				$this->G->R($message);
			}
			break;

			default:
			$subjects = $this->basic->getSubjectList();
			$sections = $this->section->getSectionListByArgs("sectionsubjectid = '{$search['questionsubjectid']}'");
			$knows = $this->section->getKnowsListByArgs(array("knowsstatus = 1","knowssectionid = '{$search['questionsectionid']}'"));
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('sections',$sections);
			$this->tpl->assign('knows',$knows);
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->display('tools');
			break;
		}
	}

	public function exams()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('u',$u);
		$page = $this->ev->get('page');
		$this->tpl->assign('page',$page);
		switch($subaction)
		{
			//删除一个考试配置
			case 'delexam':
			$examid = $this->ev->get('examid');
			$page = $this->ev->get('page');
			$this->exam->delExamSetting($examid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-exams&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			case 'ajax':
			switch($this->ev->url(4))
			{
				default:
				$subjectid = $this->ev->get('subjectid');
				$type = $this->ev->get('type');
				if($subjectid)
				{
					$basic = $this->basic->getBasicBySubjectId($subjectid);
					$questypes = $this->basic->getQuestypeList();
					$this->tpl->assign('questypes',$questypes);
					$this->tpl->assign("type",$type);
					$this->tpl->assign("subjectid",$subjectid);
					$this->tpl->assign("basic",$basic);
					$this->tpl->display('exams_ajaxsetting');
				}
			}
			break;

			case 'del':
			$page = $this->ev->get('page');
			$examid = $this->ev->get('examid');
			$this->exam->delExamSetting($examid);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-exams&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			case 'autopage':
			if($this->ev->get('submitsetting'))
			{
				$args = $this->ev->get('args');
				$args['examsetting'] = $this->ev->addSlashes(serialize($args['examsetting']));
				$args['examauthorid'] = $this->_user['sessionuserid'];
				$args['examauthor'] = $this->_user['sessionusername'];
				$args['examtype'] = 1;
				$this->exam->addExamSetting($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
				    "forwardUrl" => "index.php?exam-master-exams&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$subjects = $this->basic->getSubjectList();
				$questypes = $this->basic->getQuestypeList();
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('exams_auto');
			}
			break;

			case 'selfpage':
			if($this->ev->get('submitsetting'))
			{
				$args = $this->ev->get('args');
				$args['examsetting'] = $this->ev->addSlashes(serialize($args['examsetting']));
				$args['examauthorid'] = $this->_user['sessionuserid'];
				$args['examauthor'] = $this->_user['sessionusername'];
				$args['examtype'] = 2;
				$args['examquestions'] = $this->ev->addSlashes(serialize($args['examquestions']));
				$id = $this->exam->addExamSetting($args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-exams-examself&examid={$id}&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$subjects = $this->basic->getSubjectList();
				$questypes = $this->basic->getQuestypeList();
				$this->tpl->assign('questypes',$questypes);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->display('exams_self');
			}
			break;

			case 'selected':
			$show = $this->ev->get('show');
			$questionids = trim($this->ev->get('questionids')," ,");
			$rowsquestionids = trim($this->ev->get('rowsquestionids')," ,");
			if(!$questionids)$questionids = '0';
			if(!$rowsquestionids)$rowsquestionids = '0';
			$questions = $this->exam->getQuestionListByArgs(array("questionstatus = 1","questionid IN ({$questionids})"));
			$rowsquestions = array();
			$rowsquestionids = explode(',',$rowsquestionids);
			foreach($rowsquestionids as $p)
			{
				if($p)
				$rowsquestions[$p] = $this->exam->getQuestionRowsByArgs(array("qrstatus = 1","qrid = '{$p}'"));
			}
			$this->tpl->assign('rowsquestions',$rowsquestions);
			$this->tpl->assign('questions',$questions);
			$this->tpl->assign('show',$show);
			$this->tpl->display('exams_selected');
			break;

			case 'selectquestions':
			$useframe = $this->ev->get('useframe');
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$this->pg->setUrlTarget('modal-body" class="ajax');
			if(!$search['questionisrows'])
			{
				$args = array("quest2knows.qkquestionid = questions.questionid","questions.questionstatus = '1'","questions.questionparent = 0","quest2knows.qktype = 0" );
				if($search['keyword'])
				{
					$args[] = "questions.question LIKE '%".$search['keyword']."%'";
				}
				if($search['knowsids'])
				{
					$args[] = "questions.questionknowsid IN (".$search['knowsids'].")";
				}
				if($search['stime'])
				{
					$args[] = "questions.questioncreatetime >= '".strtotime($search['stime'])."'";
				}
				if($search['etime'])
				{
					$args[] = "questions.questioncreatetime <= '".strtotime($search['etime'])."'";
				}
				if($search['questiontype'])
				{
					$args[] = "questions.questiontype = '".$search['questiontype']."'";
				}
				if($search['questionlevel'])
				{
					$args[] = "questions.questionlevel = '{$search['questionlevel']}'";
				}
				if($search['questionknowsid'])
				{
					$args[] = "quest2knows.qkknowsid = '".$search['questionknowsid']."'";
				}
				else
				{
					$tmpknows = '0';
					if($search['questionsectionid'])
					{
						$knows = $this->section->getKnowsListByArgs(array("knowsstatus = 1","knowssectionid = '{$search['questionsectionid']}'"));
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = "quest2knows.qkknowsid IN ({$tmpknows})";
					}
					elseif($search['questionsubjectid'])
					{
						$knows = $this->section->getAllKnowsBySubject($search['questionsubjectid']);
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = "quest2knows.qkknowsid IN ({$tmpknows})";
					}
				}

				$questions = $this->exam->getQuestionsList($page,10,$args);
			}
			else
			{
				$args = array("quest2knows.qkquestionid = questionrows.qrid","questionrows.qrstatus = '1'");
				if($search['keyword'])
				{
					$args[] = "questionrows.qrquestion LIKE '%".$search['keyword']."%'";
				}
				if($search['questiontype'])
				{
					$args[] = "questionrows.qrtype = '{$search['questiontype']}'";
				}
				if($search['stime'])
				{
					$args[] = "questionrows.qrtime >= '".strtotime($search['stime'])."'";
				}
				if($search['etime'])
				{
					$args[] = "questionrows.qrtime <= '".strtotime($search['etime'])."'";
				}
				if($search['qrlevel'])
				{
					$args[] = "questionrows.qrlevel = '{$search['qrlevel']}'";
				}
				if($search['questionknowsid'])
				{
					$args[] = "quest2knows.qkknowsid = '".$search['questionknowsid']."'";
				}
				else
				{
					$tmpknows = '0';
					if($search['questionsectionid'])
					{
						$knows = $this->section->getKnowsListByArgs(array("knowsstatus = 1","knowssectionid = '{$search['questionsectionid']}'"));
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = "quest2knows.qkknowsid IN ({$tmpknows})";
					}
					elseif($search['questionsubjectid'])
					{
						$knows = $this->section->getAllKnowsBySubject($search['questionsubjectid']);
						foreach($knows as $p)
						{
							if($p['knowsid'])$tmpknows .= ','.$p['knowsid'];
						}
						$args[] = "quest2knows.qkknowsid IN ({$tmpknows})";
					}
				}
				$questions = $this->exam->getQuestionrowsList($page,10,$args);
			}
			if($useframe)$questions['pages'] = str_replace('&useframe=1','',$questions['pages']);
			$questypes = $this->basic->getQuestypeList();
			$sections = $this->section->getSectionListByArgs("sectionsubjectid = '{$search['questionsubjectid']}'");
			$knows = $this->section->getKnowsListByArgs(array("knowsstatus = 1","knowssectionid = '{$search['questionsectionid']}'"));
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('sections',$sections);
			$this->tpl->assign('knows',$knows);
			$this->tpl->assign('questypes',$questypes);
			$this->tpl->assign('questiontype',$search['questiontype']);
			$this->tpl->assign('questions',$questions);
			$this->tpl->assign('useframe',$useframe);
			$this->tpl->display('selectquestions');
			break;

			case 'modify':
			if($this->ev->get('submitsetting'))
			{
				$examid = $this->ev->get('examid');
				$args = $this->ev->get('args');
				$args['examsetting'] = $this->ev->addSlashes(serialize($args['examsetting']));
				$args['examquestions'] = $this->ev->addSlashes(serialize($args['examquestions']));
				$this->exam->modifyExamSetting($examid,$args);
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-exams&page={$page}{$u}"
				);
				$this->G->R($message);
			}
			else
			{
				$examid = $this->ev->get('examid');
				$exam = $this->exam->getExamSettingById($examid);
				$subjects = $this->basic->getSubjectList();
				$questypes = $this->basic->getQuestypeList();
				foreach($exam['examquestions'] as $key => $p)
				{
					$exam['examnumber'][$key] = $this->exam->getExamQuestionNumber($p);
				}
				$this->tpl->assign('search',$search);
				$this->tpl->assign('subjects',$subjects);
				$this->tpl->assign('exam',$exam);
				$this->tpl->assign('questypes',$questypes);
				if($exam['examtype'] == 1)
				$this->tpl->display('exams_modifyauto');
				else
				$this->tpl->display('exams_modifyself');
			}
			break;

			//考试设置列表
			default:
			$page = $this->ev->get('page');
			$page = $page > 0?$page:1;
			$args = array();
			if($search)
			{
				if($search['examsubject'])$args[] = "examsubject = '{$search['examsubject']}'";
				if($search['examtype'])$args[] = "examtype = '{$search['examtype']}'";
			}
			if(!count($args))$args = 1;
			$exams = $this->exam->getExamSettingList($page,10,$args);
			$subjects = $this->basic->getSubjectList();
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('exams',$exams);
			$this->tpl->display('exams');
		}
	}

	public function users()
	{
		$subaction = $this->ev->url(3);
		$search = $this->ev->get('search');
		$page = $this->ev->get('page');
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('page',$page);
		$this->tpl->assign('u',$u);
		switch($subaction)
		{
			case 'basics':
			$page = $this->ev->get('page');
			$page = $page > 1?$page:1;
			$userid = $this->ev->get('userid');
			$subjects = $this->basic->getSubjectList();
			if(!$search)
			$args = 1;
			else
			$args = array();
			if($search['basicid'])$args[] = "basicid = '{$search['basicid']}'";
			else
			{
				if($search['keyword'])$args[] = "basic LIKE '%{$search['keyword']}%'";
				if($search['basicareaid'])$args[] = "basicareaid = '{$search['basicareaid']}'";
				if($search['basicsubjectid'])$args[] = "basicsubjectid = '{$search['basicsubjectid']}'";
				if($search['basicapi'])$args[] = "basicapi = '{$search['basicapi']}'";
			}
			$basics = $this->basic->getBasicList($page,10,$args);
			$areas = $this->area->getAreaList();
			$openbasics = $this->basic->getOpenBasicsByUserid($userid);
			$this->tpl->assign('basics',$basics);
			$this->tpl->assign('openbasics',$openbasics);
			$this->tpl->assign('areas',$areas);
			$this->tpl->assign('subjects',$subjects);
			$this->tpl->assign('basics',$basics);
			$this->tpl->assign('userid',$userid);
			$this->tpl->display('users_basic');
			break;

			case 'openbasics':
			$basicid = $this->ev->get('basicid');
			$userid = $this->ev->get('userid');
			if($this->basic->getOpenBasicByUseridAndBasicid($userid,$basicid))
			{
				$message = array(
					'statusCode' => 300,
					"message" => "您已经开通了本考场"
				);
			}
			else
			{
				$this->basic->openBasic(array('obuserid'=>$userid,'obbasicid'=>$basicid,'obendtime' => TIME + 30*24*3600));
				$message = array(
					'statusCode' => 200,
					"message" => "操作成功",
					"callbackType" => "forward",
				    "forwardUrl" => "index.php?exam-master-users-basics&userid={$userid}{$u}"
				);
			}
			$this->G->R($message);
			break;

			case 'closebasics':
			$basicid = $this->ev->get('basicid');
			$userid = $this->ev->get('userid');
			$ob = $this->basic->getOpenBasicByUseridAndBasicid($userid,$basicid);
			$this->basic->delOpenBasic($ob['obid']);
			$message = array(
				'statusCode' => 200,
				"message" => "操作成功",
				"callbackType" => "forward",
			    "forwardUrl" => "index.php?exam-master-users-basics&userid={$ob['obuserid']}&page={$page}{$u}"
			);
			$this->G->R($message);
			break;

			case 'batopen':
			if($this->ev->get('batopen'))
			{
				$userids = $this->ev->get('userids');
				$usernames = $this->ev->get('usernames');
				$usergroupids = $this->ev->get('usergroupids');
				$basics = $this->ev->get('basics');
				$days = $this->ev->get('days');
				if($userids && $basics && $days)
				{
					$userids = explode(",",$userids);
					$basics = explode(",",$basics);
					foreach($userids as $userid)
					{
						foreach($basics as $basicid)
						{
							$this->basic->openBasic(array('obuserid'=>$userid,'obbasicid'=>$basicid,'obendtime' => TIME + $days*24*3600));
						}
					}
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功"
					);
				}
				elseif($usernames && $basics && $days)
				{
					$usernames = implode("','",array_unique(explode(",",$usernames)));
					$basics = explode(",",$basics);
					$userids = $this->user->getUsersByArgs("username IN ('{$usernames}')");
					foreach($userids as $user)
					{
						foreach($basics as $basicid)
						{
							$this->basic->openBasic(array('obuserid'=>$user['userid'],'obbasicid'=>$basicid,'obendtime' => TIME + $days*24*3600));
						}
					}
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功"
					);
				}
				elseif($usergroupids && $basics && $days)
				{
					$usergroupids = implode(",",array_unique(explode(",",$usergroupids)));
					$basics = explode(",",$basics);
					$userids = $this->user->getUsersByArgs("usergroupid IN ({$usergroupids})");
					foreach($userids as $user)
					{
						foreach($basics as $basicid)
						{
							$this->basic->openBasic(array('obuserid'=>$user['userid'],'obbasicid'=>$basicid,'obendtime' => TIME + $days*24*3600));
						}
					}
					$message = array(
						'statusCode' => 200,
						"message" => "操作成功"
					);
				}
				else
				{
					$message = array(
						'statusCode' => 300,
						"message" => "参数错误"
					);
				}
				$this->G->R($message);
			}
			else
			$this->tpl->display('user_batopen');
			break;

			default:
			$page = $this->ev->get('page')?$this->ev->get('page'):1;
			$search = $this->ev->get('search');
			$u = '';
			if($search)
			{
				foreach($search as $key => $arg)
				{
					$u .= "&search[{$key}]={$arg}";
				}
				$args = array();
			}
			else $args = 1;
			if($search['userid'])
			$args[] = "userid = '{$search['userid']}'";
			elseif($search['groupid'] || $search['username'])
			{
				$args = array();
				if($search['groupid'])
				$args[] = "usergroupid = '{$search['groupid']}'";
				if($search['username'])
				$args[] = "username LIKE '%{$search['username']}%'";
			}
			$users = $this->user->getUserList($page,10,$args);
			$groups = $this->user->getUserGroups();
			$this->tpl->assign('groups',$groups);
			$this->tpl->assign('users',$users);
			$this->tpl->display('user');
			break;
		}
	}
}

?>