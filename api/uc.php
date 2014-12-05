<?php

define('IN_DISCUZ', TRUE);

define('UC_CLIENT_VERSION', '1.5.0');	//note UCenter 版本标识
define('UC_CLIENT_RELEASE', '20081031');

define('API_DELETEUSER', 1);		//note 用户删除 API 接口开关
define('API_RENAMEUSER', 1);		//note 用户改名 API 接口开关
define('API_GETTAG', 1);		//note 获取标签 API 接口开关
define('API_SYNLOGIN', 1);		//note 同步登录 API 接口开关
define('API_SYNLOGOUT', 1);		//note 同步登出 API 接口开关
define('API_UPDATEPW', 1);		//note 更改用户密码 开关
define('API_UPDATEBADWORDS', 1);	//note 更新关键字列表 开关
define('API_UPDATEHOSTS', 1);		//note 更新域名解析缓存 开关
define('API_UPDATEAPPS', 1);		//note 更新应用列表 开关
define('API_UPDATECLIENT', 1);		//note 更新客户端缓存 开关
define('API_UPDATECREDIT', 1);		//note 更新用户积分 开关
define('API_GETCREDITSETTINGS', 1);	//note 向 UCenter 提供积分设置 开关
define('API_GETCREDIT', 1);		//note 获取用户的某项积分 开关
define('API_UPDATECREDITSETTINGS', 1);	//note 更新应用积分设置 开关

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');

define('DISCUZ_ROOT', '../');

//note 普通的 http 通知方式
if(!defined('IN_UC')) {

	error_reporting(0);
	set_magic_quotes_runtime(0);

	defined('MAGIC_QUOTES_GPC') || define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	require_once 'config.inc.php';
	$_DCACHE = $get = $post = array();

	$code = @$_GET['code'];
	parse_str(_authcode($code, 'DECODE', UC_KEY), $get);
	if(MAGIC_QUOTES_GPC) {
		$get = _stripslashes($get);
	}

	$timestamp = time();
	if($timestamp - $get['time'] > 3600) {
		exit('Authracation has expiried');
	}
	if(empty($get)) {
		exit('Invalid Request');
	}
	$action = $get['action'];

	require_once 'uc_client/lib/xml.class.php';
	$post = xml_unserialize(file_get_contents('php://input'));

	if(in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcreditsettings', 'updatecreditsettings'))) {
		/**
		require_once 'include/db_mysql.class.php';
		$GLOBALS['db'] = new dbstuff;
		$GLOBALS['db']->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect, true, $dbcharset);
		print_r($GLOBALS['db']);
		$GLOBALS['tablepre'] = $tablepre;
		unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
		**/
		$uc_note = new uc_note();
		//file_put_contents('aa.txt','1');
		exit($uc_note->$get['action']($get, $post));
	} else {
		exit(API_RETURN_FAILED);
	}
} else {

	/**
	require_once 'config.inc.php';
	require_once 'include/db_mysql.class.php';
	$GLOBALS['db'] = new dbstuff;
	$GLOBALS['db']->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect, true, $dbcharset);
	$GLOBALS['tablepre'] = $tablepre;
	unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
	**/
}

class uc_note {

	var $dbconfig = '';
	var $db = '';
	var $tablepre = '';
	var $appdir = '';
	var $dblink;
	var $sessionid;
	var $cookie;
	var $e;
	var $sessionname = 'currentuser';

	function __construct()
	{
		require_once 'include/db_mysql.class.php';
		$this->dblink = new dbstuff;
		require_once '../lib/config.inc.php';
		$this->dblink->connect(DH, DU, DP, DB, 0, true, HE);
		$this->cookie = $_COOKIE;
		//$this->_getSessionId();
	}

	function _serialize($arr, $htmlon = 0) {
		if(!function_exists('xml_serialize')) {
			include_once 'uc_client/lib/xml.class.php';
		}
		return xml_serialize($arr, $htmlon);
	}

	function _getCookie($par,$nohead = 0)
    {
    	if(isset($this->cookie[CH.$par]))return $this->cookie[CH.$par];
    	elseif(isset($this->cookie[$par]) && $nohead)return $this->cookie[$par];
    	else return false;
	}

	function _setCookie($name,$value,$time=3600)
    {
    	if($time)$time = TIME + $time;
		else $time = 0;
		if(CDO)setCookie(CH.$name,$value,$time,CP,CDO);
    	else setCookie(CH.$name,$value,$time,CP);
    }

    function _getClientIp()
	{
		if(!isset($this->e['ip']))
		{
			if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
				$ip = getenv("HTTP_CLIENT_IP");
			else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
				$ip = getenv("HTTP_X_FORWARDED_FOR");
			else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
				$ip = getenv("REMOTE_ADDR");
			else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
				$ip = $_SERVER['REMOTE_ADDR'];
			else
				$ip = "unknown";
			$this->e['ip'] = $ip;
		}
		return $this->e['ip'];
	}

	function _makeReplace($replace)
	{
		if(!is_array($replace))return false;
		$sql = "REPLACE INTO ";
		if(is_array($replace[0]))
		{
			$tmp = NULL;
			foreach($replace[0] as $p)
			$tmp .= DTH.$p." AS ".$p.",";
			$sql .= rtrim($tmp,',');
		}
		else $sql .= DTH.$replace[0];
		$sql .= " ";

		if(is_array($replace[1]))
		{
			$key = "";
			$value = "";
			foreach($replace[1] as $id => $p)
			{
				$key .= "`".$id."`,";
				$value .= "'".$p."',";
			}
			if(is_array($value))
			$sql .= '('.rtrim($key,',').') VALUES ('.rtrim(implode(',',$value),',').')';
			else
			$sql .= '('.rtrim($key,',').') VALUES ('.rtrim($value,',').')';
		}
		else return false;
		return $sql;
	}

	function _getSessionId()
	{
		$sessionid = $this->_getCookie('psid');
    	if(!$sessionid)
    	{
    		if($this->_getCookie('PHPSESSID',1))
    		{
    			$this->_setCookie('psid',$this->_getCookie('PHPSESSID',1),3600*24);
    			$sessionid = $this->_getCookie('PHPSESSID',1);
    		}
    		else
    		{
    			$sid = md5($this->_getClientIp().'/'.$_SERVER['HTTP_X_FORWARDED_FOR'].'/'.$_SERVER['REMOTE_ADDR'].':'.$_SERVER['REMOTE_PORT'].':'.$_SERVER['HTTP_USER_AGENT'].':'.date('Y-m-d'));
    			$this->_setCookie('psid',$sid,3600*24);
    			$sessionid = $sid;
    		}
    		$data = array('session',array('sessionid'=>$sessionid,'sessionuserid'=>0,'sessionip'=>$this->_getClientIp()));
    		$sql = $this->_makeReplace($data);
    		$this->dblink->query($sql);
    	}
    	$this->sessionid = $sessionid;
    	return $this->sessionid;
	}

	function _encode($info)
	{
		$info = serialize($info);
		$key = CS;
		$kl = strlen($key);
		$il = strlen($info);
		for($i = 0; $i < $il; $i++)
		{
			$p = $i%$kl;
			$info[$i] = chr(ord($info[$i])+ord($key[$p]));
		}
		return urlencode($info);
	}

	/**
	function uc_note() {
		$this->appdir = substr(dirname(__FILE__), 0, -3);
		$this->dbconfig = $this->appdir.'./config.inc.php';
		echo $this->dbconfig.'ll';
		$this->db = $GLOBALS['db'];
		$this->tablepre = $GLOBALS['tablepre'];
	}
	**/

	function test($get, $post) {
		return API_RETURN_SUCCEED;
	}

	function deleteuser($get, $post) {
		$uids = $get['ids'];
		!API_DELETEUSER && exit(API_RETURN_FORBIDDEN);

		return API_RETURN_SUCCEED;
	}

	function renameuser($get, $post) {
		$uid = $get['uid'];
		$usernameold = $get['oldusername'];
		$usernamenew = $get['newusername'];
		if(!API_RENAMEUSER) {
			return API_RETURN_FORBIDDEN;
		}

		return API_RETURN_SUCCEED;
	}

	function gettag($get, $post) {
		$name = $get['id'];
		if(!API_GETTAG) {
			return API_RETURN_FORBIDDEN;
		}

		$return = array();
		return $this->_serialize($return, 1);
	}

	function synlogin($get, $post) {
		$uid = $get['uid'];
		//$username = iconv('gbk','utf-8',$get['username']);
		//gbk版本论坛使用上行
		$username = $get['username'];
		//UTF8版本使用上行
		if(!API_SYNLOGIN) {
			return API_RETURN_FORBIDDEN;
		}
		$sql = "set names utf8";
		$this->dblink->query($sql);
		$sql = "SELECT * FROM ".DTH."user WHERE username = '{$username}'";
		$u = $this->dblink->fetch_first($sql);
		$args = array();
		if(!$u){
			$sql = "SELECT * FROM ".DTH."user_group WHERE groupdefault = '1'";
			$g = $this->dblink->fetch_first($sql);
			$grouid = $g['groupid'];
			$email = $username."@phpems.net";
			$pass = md5(rand(1000,9999));
			$sql = "INSERT INTO ".DTH."user (`username`,`useremail`,`userpassword`,`usergroupid`,`userregtime`,`userregip`) VALUES ('{$username}','{$email}','{$pass}','{$grouid}','".TIME."','".$this->_getClientIp()."')";
			$this->dblink->query($sql);
			$args = array('sessionuserid'=>$this->dblink->insert_id(),'sessionpassword'=>$pass,'sessionip'=>$this->_getClientIp(),'sessiongroupid'=>$grouid,'sessionlogintime'=>TIME,'sessionusername'=>$username);
		}
		else
		$args = array('sessionuserid'=>$u['userid'],'sessionpassword'=>$u['userpassword'],'sessionip'=>$this->_getClientIp(),'sessiongroupid'=>$u['usergroupid'],'sessionlogintime'=>TIME,'sessionusername'=>$u['username']);
		if(!$args['sessiontimelimit'])$args['sessiontimelimit'] = TIME;
    	if(!$this->sessionid)$this->_getSessionId();
    	$args['sessionid'] = $this->sessionid;
    	$args['sessiontimelimit'] = TIME;
    	$data = array('session',$args);
    	$sql = $this->_makeReplace($data);
    	$this->dblink->query($sql);

		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		$this->_setCookie($this->sessionname,$this->_encode($args),3600*24);
		//_setcookie('Example_auth', _authcode($uid."\t".$username, 'ENCODE'));
	}

	function synlogout($get, $post) {
		if(!API_SYNLOGOUT) {
			return API_RETURN_FORBIDDEN;
		}

		//note 同步登出 API 接口
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		//_setcookie('Example_auth', '', -86400 * 365);
		$this->_setCookie($this->sessionname,'',-86400 * 365);
	}

	function updatepw($get, $post) {
		if(!API_UPDATEPW) {
			return API_RETURN_FORBIDDEN;
		}
		$username = $get['username'];
		$password = $get['password'];
		return API_RETURN_SUCCEED;
	}

	function updatebadwords($get, $post) {
		if(!API_UPDATEBADWORDS) {
			return API_RETURN_FORBIDDEN;
		}
		$cachefile = $this->appdir.'./uc_client/data/cache/badwords.php';
		$fp = fopen($cachefile, 'w');
		$data = array();
		if(is_array($post)) {
			foreach($post as $k => $v) {
				$data['findpattern'][$k] = $v['findpattern'];
				$data['replace'][$k] = $v['replacement'];
			}
		}
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'badwords\'] = '.var_export($data, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	}

	function updatehosts($get, $post) {
		if(!API_UPDATEHOSTS) {
			return API_RETURN_FORBIDDEN;
		}
		$cachefile = $this->appdir.'./uc_client/data/cache/hosts.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'hosts\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	}

	function updateapps($get, $post) {
		if(!API_UPDATEAPPS) {
			return API_RETURN_FORBIDDEN;
		}
		$UC_API = $post['UC_API'];

		//note 写 app 缓存文件
		$cachefile = $this->appdir.'./uc_client/data/cache/apps.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'apps\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);

		//note 写配置文件
		if(is_writeable($this->appdir.'./config.inc.php')) {
			$configfile = trim(file_get_contents($this->appdir.'./config.inc.php'));
			$configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
			$configfile = preg_replace("/define\('UC_API',\s*'.*?'\);/i", "define('UC_API', '$UC_API');", $configfile);
			if($fp = @fopen($this->appdir.'./config.inc.php', 'w')) {
				@fwrite($fp, trim($configfile));
				@fclose($fp);
			}
		}

		return API_RETURN_SUCCEED;
	}

	function updateclient($get, $post) {
		if(!API_UPDATECLIENT) {
			return API_RETURN_FORBIDDEN;
		}
		$cachefile = $this->appdir.'./uc_client/data/cache/settings.php';
		$fp = fopen($cachefile, 'w');
		$s = "<?php\r\n";
		$s .= '$_CACHE[\'settings\'] = '.var_export($post, TRUE).";\r\n";
		fwrite($fp, $s);
		fclose($fp);
		return API_RETURN_SUCCEED;
	}

	function updatecredit($get, $post) {
		if(!API_UPDATECREDIT) {
			return API_RETURN_FORBIDDEN;
		}
		$credit = $get['credit'];
		$amount = $get['amount'];
		$uid = $get['uid'];
		return API_RETURN_SUCCEED;
	}

	function getcredit($get, $post) {
		if(!API_GETCREDIT) {
			return API_RETURN_FORBIDDEN;
		}
	}

	function getcreditsettings($get, $post) {
		if(!API_GETCREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
		$credits = array();
		return $this->_serialize($credits);
	}

	function updatecreditsettings($get, $post) {
		if(!API_UPDATECREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}
}

//note 使用该函数前需要 require_once $this->appdir.'./config.inc.php';
function _setcookie($var, $value, $life = 0, $prefix = 1) {
	global $cookiepre, $cookiedomain, $cookiepath, $timestamp, $_SERVER;
	setcookie(($prefix ? $cookiepre : '').$var, $value,
		$life ? $timestamp + $life : 0, $cookiepath,
		$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}

function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
				return '';
			}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}

function _stripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = _stripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}