<?php

class app
{
	public $G;
	private $sc = 'testSys&dongao';

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->files = $this->G->make('files');
		$this->session = $this->G->make('session');
		$this->user = $this->G->make('user','user');
		$this->apps = $this->G->make('apps','core');
		$this->_user = $this->session->getSessionUser();
		$_user = $this->session->getSessionUser();
		$group = $this->user->getGroupById($_user['sessiongroupid']);
		if(!$_user['sessionuserid'])
		{
			if($this->ev->get('userhash'))
			exit(json_encode(array(
				'statusCode' => 300,
				"message" => "请您重新登录",
			    "callbackType" => 'forward',
			    "forwardUrl" => "?core-master-login"
			)));
			else
			{
				header("location:index.php?user-app-login");
				exit;
			}
		}
	}

	public function test()
	{
		$this->strings = $this->G->make('strings');
		$a = "abcdef-_''";
		if($this->strings->isAllowKey($a))
		echo 'aaasdsd';
		$args = $this->ev->get('args');
		$this->sql = $this->G->make('sql');
		$sql = $this->sql->makeUpdate(array('user',$args,"userid = 1"));
		echo $sql;
	}

	public function index()
	{
		header("location:".'index.php?'.$this->G->app.'-app');
	}

	public function uploadify()
	{
		echo '1';
	}

	public function upload()
	{
		$fn = $this->ev->get('CKEditorFuncNum');
		$path = 'files/attach/images/content/'.date('Ymd').'/';
		$fileurl = $this->files->uploadFile($this->ev->getFile('upload'),$path);
		$message = '上传成功!';
		$str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.', \''.$fileurl.'\', \''.$message.'\');</script>';
		echo $str;
	}

	public function uploadfile()
	{
		$fn = $this->ev->get('CKEditorFuncNum');
		$path = 'files/attach/files/content/'.date('Ymd').'/';
		$fileurl = $this->files->uploadFile($this->ev->getFile('upload'),$path);
		$message = '上传成功!';
		$str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.', \''.WP.'/'.$fileurl.'\', \''.$message.'\');</script>';
		echo $str;
	}

	public function swfupload()
	{
		$path = 'files/attach/images/content/'.date('Ymd').'/';
		$fileurl = $this->files->uploadFile($this->ev->getFile('Filedata'),$path);
		if($this->ev->get('imgwidth') || $this->ev->get('imgheight'))
		{
			if($this->files->thumb($fileurl,$fileurl.'.png',$this->ev->get('imgwidth'),$this->ev->get('imgheight')))
			$thumb = $fileurl.'.png';
			else
			$thumb = $fileurl;
		}
		else
		$thumb = $fileurl;
		exit(json_encode(array('thumb' => $thumb)));
	}

	public function swfuploadvideo()
	{
		$path = 'files/attach/images/content/'.date('Ymd').'/';
		$fileurl = $this->files->uploadFile($this->ev->getFile('Filedata'),$path);
		echo $fileurl;
	}

	public function logout()
	{
		header("location:".'index.php?'.$this->G->app.'-app');
	}

	public function manage()
	{
		if(!$_SESSION['manager']['userid'])
		{
			$this->G->error(array('url'=>'?sales-login'));
			exit;
		}
		$this->tpl->assign('manager',$_SESSION['manager']);
		$action = $this->ev->url(2)?$this->ev->url(2):'input';
		$this->tpl->assign('action',$action);
		switch($action)
		{
			case 'output':
			$subaction = $this->ev->url(3);
			switch($subaction)
			{
				case 'ajax':
				$args = $this->ev->get('args');
				$username = $args['outputuser'];
				$user = $this->user->getUserByUserName($username);
				if($user['userid'])echo '1';
				else echo '0';
				exit;
				break;

				case 'ajaxadd':
				$itemname = $this->ev->get('itemname');
				$suppliers = $this->user->getSuppliers();
				$item = $this->user->getItemByName($itemname);
				$tmp = array();
				if($item['itemid'])				{

					$tmp['data'] = '<tr id="additemtr_'.$item['itemid'].'">
			          <td>'.$item['itemid'].'<input type="hidden" name="args[outputitems]['.$item['itemid'].'][recorditem]" value="'.$item['itemid'].'" /></td>
			          <td>'.$item['itemname'].'</td>
			          <td><input type="text" class="g-ipt" name="args[outputitems]['.$item['itemid'].'][recordnumber]" size="6" id="number_'.$item['itemid'].'" value="0" onblur="javascript:tj(\''.$item['itemid'].'\');"/></td>
			          <td id="exist_'.$item['itemid'].'">'.$item['itemnumber'].'</td>
			          <td id="cost_'.$item['itemid'].'">'.$item['itemprice'].'<input type="hidden" name="args[outputitems]['.$item['itemid'].'][recordprice]" value="'.$item['itemprice'].'" /></td>
			          <td>'.$item['itemstandards'].'</td>
			          <td>'.$suppliers[$item['itemsupplier']]['suppliername'].'</td>
			          <td>'.$item['itemdescribe'].'</td>
			          <td id="hj_'.$item['itemid'].'" class="eachhj">0</td>
			        </tr>';
			        $tmp['id'] = $item['itemid'];
			        $tmp['isnormal'] = $item['itemisnormal'];
			        $tmp['isgift'] = $item['itemisgift'];
				}
				else $tmp['id'] = 0;
				echo json_encode($tmp);
				exit;
				break;

				case 'ajaxaddgift':
				$itemname = $this->ev->get('itemname');
				$suppliers = $this->user->getSuppliers();
				$item = $this->user->getItemByName($itemname);
				$tmp = array();
				if($item['itemid'])				{

					$tmp['data'] = '<tr id="addgifttr_'.$item['itemid'].'">
			          <td>'.$item['itemid'].'<input type="hidden" name="args[outputgift]['.$item['itemid'].'][recorditem]" value="'.$item['itemid'].'" /></td>
			          <td>'.$item['itemname'].'</td>
			          <td><input type="text" class="g-ipt" name="args[outputgift]['.$item['itemid'].'][recordnumber]" size="6" id="gnumber_'.$item['itemid'].'" value="0" onblur="javascript:gtj(\''.$item['itemid'].'\');"/></td>
			          <td id="gexist_'.$item['itemid'].'">'.$item['itemnumber'].'</td>
			          <td id="gcost_'.$item['itemid'].'">'.$item['itemprice'].'</td>
			          <td>'.$item['itemstandards'].'</td>
			          <td>'.$suppliers[$item['itemsupplier']]['suppliername'].'</td>
			          <td>'.$item['itemdescribe'].'</td>
			          <td id="ghj_'.$item['itemid'].'" class="geachhj">0</td>
			        </tr>';
			        $tmp['id'] = $item['itemid'];
			        $tmp['isnormal'] = $item['itemisnormal'];
			        $tmp['isgift'] = $item['itemisgift'];
				}
				else $tmp['id'] = 0;
				echo json_encode($tmp);
				exit;
				break;

				case 'deloutputorder':
				$outputorder = $this->ev->get('outputorder');
				$this->user->delOutputOrder($outputorder);
				$this->G->msg(array('url'=>'?sales-master-output-manage'));
				exit;
				break;

				case 'outputdetail':
				$suppliers = $this->user->getSuppliers();
				$this->tpl->assign('suppliers',$suppliers);
				$outputorder = $this->ev->get('outputorder');
				$order = $this->user->getOutputByOrder($outputorder);
				$this->tpl->assign('order',$order);
				$recorditems = $this->user->getRecordItemsByOrder($outputorder);
				foreach($recorditems as $key => $p)
				{
					$recorditems[$key]['allprice'] = $p['recordprice']*$p['recordnumber'];
				}
				$this->tpl->assign('recorditems',$recorditems);
				$items = $this->user->getItems();
				$this->tpl->assign('items',$items);
				$this->tpl->display($subaction);
				exit;
				break;

				case 'printoutputorder':
				$suppliers = $this->user->getSuppliers();
				$this->tpl->assign('suppliers',$suppliers);
				$outputorder = $this->ev->get('outputorder');
				$order = $this->user->getOutputByOrder($outputorder);
				$this->tpl->assign('order',$order);
				$recorditems = $this->user->getRecordItemsByOrder($outputorder);
				foreach($recorditems as $key => $p)
				{
					$recorditems[$key]['allprice'] = $p['recordprice']*$p['recordnumber'];
				}
				$this->tpl->assign('recorditems',$recorditems);
				$items = $this->user->getItems();
				$this->tpl->assign('items',$items);
				$this->tpl->display($subaction);
				exit;
				break;

				case 'outputorder':
				if($this->ev->post('insertoutput'))
				{
					$args = $this->ev->post('args');
					foreach($args['outputitems'] as $key => $item)
					{
						if($item['recordnumber'] < 1)unset($args['outputitems'][$key]);
					}
					foreach($args['outputgift'] as $key => $item)
					{
						if($item['recordnumber'] < 1)unset($args['outputgift'][$key]);
					}
					$id = $this->user->insertOutput($args);
					if($args['outputorder'])$this->G->msg(array('url'=>'?sales-master-output-manage'));
					else
					$this->G->error(array('url'=>'?sales-master-output-manage'));
					exit;
				}
				else
				{
					$suppliers = $this->user->getSuppliers();
					$this->tpl->assign('suppliers',$suppliers);
					$items = $this->user->searchItems(array(array('itemisnormal = 1','itemnumber > 0'),false,'itemid DESC'));
					$gifts = $this->user->searchItems(array(array('itemisgift = 1','itemnumber > 0'),false,'itemid DESC'));
					$this->tpl->assign('items',$items);
					$this->tpl->assign('gifts',$gifts);
					$this->tpl->display($subaction);
				}
				exit;
				break;

				default:
				$page = $this->ev->get('page');
				$args = 1;
				if($this->ev->get('starttime') || $this->ev->get('endtime') || $this->ev->get('username') )
				{
					$args = array();
					if($this->ev->get('username'))$args['username'] = "outputuser = '".trim($this->ev->get('username'))."'";
					if($this->ev->get('starttime'))$args['starttime'] = "outputtime >= '".strtotime($this->ev->get('starttime'))."'";
					if($this->ev->get('endtime'))$args['endtime'] = "outputtime <= '".strtotime($this->ev->get('endtime'))."'";
				}
				$outputs = $this->user->getOutputOrders($page,20,$args);
				$this->tpl->assign('searchuser',$this->ev->get('username'));
				$this->tpl->assign('outputs',$outputs);
			}
			break;

			case 'instock':
			if($_SESSION['manager']['username'] != 'songqingwei')
			{
				$this->G->error(array('url'=>'?sales-master-user-manage'));
				exit;
			}
			$subaction = $this->ev->url(3);
			switch($subaction)
			{
				case 'ajax':
				$args = $this->ev->get('args');
				$itemname = $args['itemname'];
				$item = $this->user->getItemByName($itemname);
				if($item['itemid'])echo '0';
				else echo '1';
				exit;
				break;

				case 'record':
				$page = $this->ev->get('page');
				$args = 1;
				if($this->ev->get('starttime') || $this->ev->get('endtime') || $this->ev->get('itemid') )
				{
					$args = array();
					if($this->ev->get('itemid'))$args['itemid'] = "recorditem = '".trim($this->ev->get('itemid'))."'";
					if($this->ev->get('starttime'))$args['starttime'] = "recordtime >= '".strtotime($this->ev->get('starttime'))."'";
					if($this->ev->get('endtime'))$args['endtime'] = "recordtime <= '".strtotime($this->ev->get('endtime'))."'";
				}
				$records = $this->user->getRecordItemHistory($page,20,$args);
				$this->tpl->assign('item',$this->user->getItemById($this->ev->get('itemid')));
				$this->tpl->assign('records',$records);
				$this->tpl->display($subaction);
				exit;
				break;

				case 'modifyinstock':
				$itemid = $this->ev->get('itemid');
				if($this->ev->post('modifyitem'))
				{
					$args = $this->ev->post('args');
					$id = $this->user->modifyItem($args,$itemid);
					if($id)$this->G->msg(array('url'=>'?sales-master-instock-manage'));
					else
					$this->G->error(array('url'=>'?sales-master-instock-manage'));
					exit;
				}
				else
				{	$suppliers = $this->user->getSuppliers();
					$this->tpl->assign('suppliers',$suppliers);
					$item = $this->user->getItemById($itemid);
					$this->tpl->assign('item',$item);
				}
				$this->tpl->display($subaction);
				exit;
				break;

				default:
				if($this->ev->post('insertitem'))
				{
					$args = $this->ev->post('args');
					$id = $this->user->insertItem($args);
					if($id)$this->G->msg(array('url'=>'?sales-master-instock-manage'));
					else
					$this->G->error(array('url'=>'?sales-master-instock-manage'));
					exit;
				}
				else
				{	$suppliers = $this->user->getSuppliers();
					$this->tpl->assign('suppliers',$suppliers);
					$items = $this->user->getItems();
					$this->tpl->assign('items',$items);
				}
			}
			break;

			case 'buy':
			$subaction = $this->ev->url(3);
			switch($subaction)
			{
				case 'ajax':
				$args = $this->ev->get('args');
				$username = $args['piguser'];
				$user = $this->user->getUserByUserName($username);
				if($user['userid'])echo '1';
				else echo '0';
				exit;
				break;

				case 'delpigorder':
				$pigorder = $this->ev->get('pigorder');
				$this->user->delPigOrder($pigorder);
				$this->G->msg(array('url'=>'?sales-master-buy-manage'));
				break;

				case 'buyorder':
				if($this->ev->get('insertpig'))
				{
					$args = $this->ev->post('args');
					$piginfo = $this->ev->post('piginfo');
					foreach($piginfo['all'] as $key => $p)
					{
						if($p)
						{
							$tmp = array('price'=>$piginfo['price'],'all'=>$p,'more'=>$piginfo['more'],'exp'=>$piginfo['exp'],'jz'=>$p - $piginfo['more'],'hj'=>($p - $piginfo['more'])*$piginfo['price'] - $piginfo['exp']);
							$args['piginfo'][] = $tmp;
						}
					}
					$args['piginfo'] = serialize($args['piginfo']);
					$id = $this->user->insertPigOrder($args);
					if($args['pigorder'])$this->G->msg(array('url'=>'?sales-master-buy-manage'));
					else
					$this->G->error(array('url'=>'?sales-master-buy-manage'));

					exit;
				}
				else
				{
					$pig = $this->user->getPigPrice();
					$suppliers = $this->user->getSuppliers('supplierisreciver = 1');
					$this->tpl->assign('suppliers',$suppliers);
					$this->tpl->assign('pig',$pig);
					$this->tpl->display($subaction);
				}
				exit;
				break;

				case 'buydetail':
				$pigorder = $this->ev->get('pigorder');
				$order = $this->user->getPigOrderById($pigorder);
				$history =  $this->user->getPayPigListByOrder($pigorder);
				$suppliers = $this->user->getSuppliers();
				$this->tpl->assign('suppliers',$suppliers);
				$this->tpl->assign('order',$order);
				$this->tpl->assign('history',$history);
				$this->tpl->display($subaction);
				exit;
				break;

				case 'printbuyorder':
				$pigorder = $this->ev->get('pigorder');
				$order = $this->user->getPigOrderById($pigorder);
				$history =  $this->user->getPayPigListByOrder($pigorder);
				$suppliers = $this->user->getSuppliers();
				$this->tpl->assign('suppliers',$suppliers);
				$this->tpl->assign('order',$order);
				$this->tpl->assign('history',$history);
				$this->tpl->display($subaction);
				exit;
				break;

				case 'pay':
				if($this->ev->get('insertpay'))
				{
					$args = $this->ev->get('args');
					$this->user->payPig($args);
				}
				$this->G->msg(array('url'=>'?sales-master-buy-buydetail&pigorder='.$args['payorder']));
				exit;
				break;

				case 'pigprice':
				if($this->ev->get('insertpig'))
				{
					$args = $this->ev->post('args');
					$id = $this->user->updatePigPrice($args);
					if($id)$this->G->msg(array('url'=>'?sales-master-buy-pigprice'));
					else
					$this->G->error(array('url'=>'?sales-master-buy-pigprice'));
					exit;
				}
				else
				{
					$pig = $this->user->getPigPrice();
					$this->tpl->assign('pig',$pig);
				}
				$this->tpl->display($subaction);
				exit;
				break;

				default:
				$page = $this->ev->get('page');
				$args = 1;
				if($this->ev->get('starttime') || $this->ev->get('endtime') || $this->ev->get('username') || $this->ev->get('supplierid'))
				{
					$args = array();
					if($this->ev->get('username'))$args['username'] = "piguser = '".trim($this->ev->get('username'))."'";
					if($this->ev->get('supplierid'))$args['supplierid'] = "pigsupplier = '".trim($this->ev->get('supplierid'))."'";
					if($this->ev->get('starttime'))$args[] = "pigtime >= '".strtotime($this->ev->get('starttime'))."'";
					if($this->ev->get('endtime'))$args[] = "pigtime <= '".strtotime($this->ev->get('endtime'))."'";
				}
				$this->tpl->assign('searchuser',$this->ev->get('username'));
				$this->tpl->assign('supplierid',$this->ev->get('supplierid'));
				$suppliers = $this->user->getSuppliers();
				$this->tpl->assign('suppliers',$suppliers);
				$orders = $this->user->getPigOrders($page,20,$args);
				$this->tpl->assign('orders',$orders);
			}
			break;

			case 'user':
			$subaction = $this->ev->url(3);
			switch($subaction)
			{
				case 'ajax':
				$args = $this->ev->get('args');
				$username = $args['username'];
				$user = $this->user->getUserByUserName($username);
				if($user['userid'])echo '0';
				else echo '1';
				exit;
				break;

				case 'savemoney':
				if($this->ev->get('insertsave'))
				{
					$args = $this->ev->get('args');
					$id = $this->user->userSaveMoney($args);
					if($id)$this->G->msg(array('url'=>'?sales-master-user-modifyuser&userid='.$id));
					else
					$this->G->error(array('url'=>'?sales-master-user-savemoney'));
				}
				else
				$this->tpl->display($subaction);
				exit;
				break;

				case 'money':
				$page = $this->ev->get('page');
				$userid = $this->ev->get('userid');
				$args = array();
				if($this->ev->get('starttime') || $this->ev->get('endtime'))
				{

					if($this->ev->get('starttime'))$args[] = "histime >= '".strtotime($this->ev->get('starttime'))."'";
					if($this->ev->get('endtime'))$args[] = "histime <= '".strtotime($this->ev->get('endtime'))."'";
				}
				$args[] = "hisuserid = '{$userid}'";
				$histories = $this->user->getUserMoneyHistory($page,20,$args);
				$user = $this->user->getUserById($userid);
				foreach($histories['data'] as $id => $history)
				{
					if($history['hisorder'][0] == 'P')
					{
						$histories['data'][$id]['url'] = '?sales-master-buy-buydetail&pigorder='.$history['hisorder'];
					}
					elseif($history['hisorder'][0] == 'O')
					{
						$histories['data'][$id]['url'] = '?sales-master-output-outputdetail&outputorder='.$history['hisorder'];
					}
				}
				$this->tpl->assign('histories',$histories);
				$this->tpl->assign('user',$user);
				$this->tpl->display($subaction);
				exit;
				break;

				case 'modifyuser':
				$userid = $this->ev->get('userid');
				if($this->ev->post('modifyuser'))
				{
					$args = $this->ev->post('args');
					if($this->ev->file['userphoto']['name'])
					{
						$files = $this->G->make('files');
						$args['userphoto'] = $files->uploadFile($this->ev->file['userphoto'],'files/attach/images/photo/');
					}
					$id = $this->user->modifyUser($args,$userid);
					if($id)$this->G->msg(array('url'=>'?sales-master-user-manage'));
					else
					$this->G->error(array('url'=>'?sales-master-user-manage'));
					exit;
				}
				else
				{
					$user = $this->user->getUserById($userid);
					$this->tpl->assign('user',$user);
					$this->tpl->display($subaction);
				}
				exit;
				break;

				case 'search':
				$searchuser = $this->ev->get('username');
				$users['data'][0] = $this->user->getUserByUserName($searchuser);
				$this->tpl->assign('users',$users);
				$this->tpl->display('user','user_search');
				exit;
				break;

				default:
				if($this->ev->post('insertuser'))
				{
					$args = $this->ev->post('args');
					$files = $this->G->make('files');
					if($this->ev->file['userphoto']['name'])
					{
						$args['userphoto'] = $files->uploadFile($this->ev->file['userphoto'],'files/attach/images/photo/');
					}
					$id = $this->user->insertUser($args);
					if($id)$this->G->msg(array('url'=>'?sales-master-user-manage'));
					else
					$this->G->error(array('url'=>'?sales-master-user-manage'));
					exit;
				}
				else
				{
					$page = $this->ev->get('page');
					$users = $this->user->getUserList($page);
					$this->tpl->assign('users',$users);
				}
			}
			break;

			case 'manager':
			if($_SESSION['manager']['username'] != 'songqingwei')
			{
				$this->G->error(array('url'=>'?sales-master-user-manage'));
				exit;
			}
			$subaction = $this->ev->url(3);
			switch($subaction)
			{
				case 'modifymanager':
				$userid = $this->ev->get('userid');
				if($this->ev->post('modifymanager'))
				{
					$args = $this->ev->post('args');
					$userid = $this->ev->post('userid');
					if($args['userpassword'] == $args['userpassword2'])
					{
						$args['userpassword'] = md5($args['userpassword']);
						unset($args['userpassword2']);
						$id = $this->user->modifyManager($args,$userid);
					}
					else
					$this->G->error(array('url'=>'?sales-master-manager-manage'));
					if($id)$this->G->msg(array('url'=>'?sales-master-manager-manage'));
					else
					$this->G->error(array('url'=>'?sales-master-manager-manage'));
					exit;
				}
				else
				{
					$user = $this->user->getManagerById($userid);
					$this->tpl->assign('user',$user);
					$this->tpl->display($subaction);
				}
				exit;
				break;

				case 'delmanager':
				$userid = $this->ev->get('userid');
				$this->user->delManager($userid);
				$this->G->msg(array('url'=>'?sales-master-manager-manage'));
				exit;
				break;

				default:
				if($this->ev->post('insertmanager'))
				{
					$args = $this->ev->post('args');
					if($args['userpassword'] == $args['userpassword2'])
					{
						$args['userpassword'] = md5($args['userpassword']);
						unset($args['userpassword2']);
						$id = $this->user->insertManager($args);
					}
					else
					$this->G->error(array('url'=>'?sales-master-manager-manage'));
					if($id)$this->G->msg(array('url'=>'?sales-master-manager-manage'));
					else
					$this->G->error(array('url'=>'?sales-master-manager-manage'));
					exit;
				}
				else
				{
					$page = $this->ev->get('page');
					$users = $this->user->getManagers($page);
					$this->tpl->assign('users',$users);
				}
			}
			break;

			case 'supplier':
			$subaction = $this->ev->url(3);
			switch($subaction)
			{
				case 'ajax':
				$args = $this->ev->get('args');
				$suppliername = $args['suppliername'];
				$supplier = $this->user->getSupplierBySupplierName($suppliername);
				if($supplier['supplierid'])echo '0';
				else echo '1';
				exit;
				break;

				case 'modifysupplier':
				$supplierid = $this->ev->get('supplierid');
				if($this->ev->post('modifysupplier'))
				{
					$args = $this->ev->post('args');
					if(!isset($args['supplierissupplier']))$args['supplierissupplier'] = 0;
					if(!isset($args['supplierisreciver']))$args['supplierisreciver'] = 0;
					$id = $this->user->modifySupplier($args,$supplierid);
					if($id)$this->G->msg(array('url'=>'?sales-master-supplier-manage'));
					else
					$this->G->error(array('url'=>'?sales-master-supplier-manage'));
					exit;
				}
				else
				{
					$supplier = $this->user->getSupplierById($supplierid);
					$this->tpl->assign('supplier',$supplier);
					$this->tpl->display($subaction);
				}
				exit;
				break;

				case 'money':
				$page = $this->ev->get('page');
				$supplierid = $this->ev->get('supplierid');
				$args = array();
				if($this->ev->get('starttime') || $this->ev->get('endtime'))
				{

					if($this->ev->get('starttime'))$args[] = "histime >= '".strtotime($this->ev->get('starttime'))."'";
					if($this->ev->get('endtime'))$args[] = "histime <= '".strtotime($this->ev->get('endtime'))."'";
				}
				$args[] = "hisuserid = '{$supplierid}'";
				$histories = $this->user->getSupplierMoneyHistory($page,20,$args);
				$supplier = $this->user->getSupplierById($supplierid);
				foreach($histories['data'] as $id => $history)
				{
					if($history['hisorder'][0] == 'P')
					{
						$histories['data'][$id]['url'] = '?sales-master-buy-buydetail&pigorder='.$history['hisorder'];
					}
					elseif($history['hisorder'][0] == 'I')
					{
						$histories['data'][$id]['url'] = '?sales-master-input-inputdetail&inputorder='.$history['hisorder'];
					}
				}
				$this->tpl->assign('histories',$histories);
				$this->tpl->assign('supplier',$supplier);
				$this->tpl->display('s'.$subaction);
				exit;
				break;

				default:
				if($this->ev->post('insertsupplier'))
				{
					$args = $this->ev->post('args');
					$id = $this->user->insertSupplier($args);
					if($id)$this->G->msg(array('url'=>'?sales-master-supplier-manage'));
					else
					$this->G->error(array('url'=>'?sales-master-supplier-manage'));
					exit;
				}
				else
				{
					$suppliers = $this->user->getSuppliers();
					$this->tpl->assign('suppliers',$suppliers);
				}
			}
			break;

			default:
			if($_SESSION['manager']['username'] != 'songqingwei')
			{
				$this->G->error(array('url'=>'?sales-master-user-manage'));
				exit;
			}
			$subaction = $this->ev->url(3);
			switch($subaction)
			{
				case 'delinputorder':
				$inputorder = $this->ev->get('inputorder');
				$this->user->delInputOrder($inputorder);
				$this->G->msg(array('url'=>'?sales-master-input-manage'));
				exit;
				break;

				case 'ajaxadd':
				$itemname = $this->ev->get('itemname');
				$suppliers = $this->user->getSuppliers();
				$item = $this->user->getItemByName($itemname);
				$tmp = array();
				if($item['itemid'])				{

					$tmp['data'] = '<tr id="additemtr_'.$item['itemid'].'">
			          <td>'.$item['itemid'].'<input type="hidden" name="args[inputitems]['.$item['itemid'].'][recorditem]" value="'.$item['itemid'].'" /></td>
			          <td>'.$item['itemname'].'</td>
			          <td><input type="text" class="g-ipt" name="args[inputitems]['.$item['itemid'].'][recordnumber]" size="6" id="number_'.$item['itemid'].'" value="0" onblur="javascript:tj(\''.$item['itemid'].'\');"/></td>
			          <td>'.$item['itemnumber'].'</td>
			          <td id="cost_'.$item['itemid'].'">'.$item['itemcost'].'<input type="hidden" name="args[inputitems]['.$item['itemid'].'][recordprice]" value="'.$item['itemcost'].'" /></td>
			          <td>'.$item['itemstandards'].'</td>
			          <td>'.$suppliers[$item['itemsupplier']]['suppliername'].'</td>
			          <td>'.$item['itemdescribe'].'</td>
			          <td id="bcost_'.$item['itemid'].'">'.$item['itemback'].'<input type="hidden" name="args[inputitems]['.$item['itemid'].'][recordback]" value="'.$item['itemback'].'"/></td>
			          <td id="bhj_'.$item['itemid'].'" class="beachhj">0</td>
			          <td id="hj_'.$item['itemid'].'" class="eachhj">0</td>
			        </tr>';
			        $tmp['id'] = $item['itemid'];
			        $tmp['isnormal'] = $item['itemisnormal'];
			        $tmp['isgift'] = $item['itemisgift'];
				}
				else $tmp['id'] = 0;
				echo json_encode($tmp);
				exit;
				break;

				case 'inputorder':
				if($this->ev->post('insertinput'))
				{
					$args = $this->ev->get('args');
					foreach($args['inputitems'] as $key => $item)
					{
						if($item['recordnumber'] < 1)unset($args['inputitems'][$key]);
					}
					$id = $this->user->insertInput($args);
					if($args['inputorder'])$this->G->msg(array('url'=>'?sales-master-input-manage'));
					else
					$this->G->error(array('url'=>'?sales-master-input-manage'));
					exit;
				}
				else
				{
					$suppliers = $this->user->getSuppliers();
					$this->tpl->assign('suppliers',$suppliers);
					$items = $this->user->getItems();
					$this->tpl->assign('items',$items);
					$this->tpl->display($subaction);
					exit;
				}
				break;

				case 'inputdetail':
				$suppliers = $this->user->getSuppliers();
				$this->tpl->assign('suppliers',$suppliers);
				$inputorder = $this->ev->get('inputorder');
				$order = $this->user->getInputByOrder($inputorder);
				$this->tpl->assign('order',$order);
				$recorditems = $this->user->getRecordItemsByOrder($inputorder);
				foreach($recorditems as $key => $p)
				{
					$recorditems[$key]['allback'] = $p['recordback']*$p['recordnumber'];
					$recorditems[$key]['allprice'] = $p['recordprice']*$p['recordnumber'];
				}
				$this->tpl->assign('recorditems',$recorditems);
				$items = $this->user->getItems();
				$this->tpl->assign('items',$items);
				$this->tpl->display($subaction);
				exit;
				break;

				case 'printinputorder':
				$suppliers = $this->user->getSuppliers();
				$this->tpl->assign('suppliers',$suppliers);
				$inputorder = $this->ev->get('inputorder');
				$order = $this->user->getInputByOrder($inputorder);
				$this->tpl->assign('order',$order);
				$recorditems = $this->user->getRecordItemsByOrder($inputorder);
				foreach($recorditems as $key => $p)
				{
					$recorditems[$key]['allback'] = $p['recordback']*$p['recordnumber'];
					$recorditems[$key]['allprice'] = $p['recordprice']*$p['recordnumber'];
				}
				$this->tpl->assign('recorditems',$recorditems);
				$items = $this->user->getItems();
				$this->tpl->assign('items',$items);
				$this->tpl->display($subaction);
				exit;
				break;

				default:
				$page = $this->ev->get('page');
				$args = 1;
				if($this->ev->get('starttime') || $this->ev->get('endtime') || $this->ev->get('supplierid'))
				{
					$args = array();
					if($this->ev->get('supplierid'))$args['supplierid'] = "inputsupplier = '".$this->ev->get('supplierid')."'";
					if($this->ev->get('starttime'))$args['starttime'] = "inputtime >= '".strtotime($this->ev->get('starttime'))."'";
					if($this->ev->get('endtime'))$args['endtime'] = "inputtime <= '".strtotime($this->ev->get('endtime'))."'";
					$this->tpl->assign('supplierid',$this->ev->get('supplierid'));
				}
				$suppliers = $this->user->getSuppliers();
				$this->tpl->assign('suppliers',$suppliers);
				$inputs = $this->user->getInputOrders($page,20,$args);
				$this->tpl->assign('inputs',$inputs);
			}
			break;
		}
		$this->tpl->display($action);
	}
}

?>