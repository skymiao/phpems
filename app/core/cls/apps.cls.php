<?php

class apps_core
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
		$this->ev = $this->G->make('ev');
		$this->files = $this->G->make('files');
	}

	//根据应用名获取应用信息
	public function getApp($appid)
	{
		$data = array(false,'app',"appid = '{$appid}'");
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql,'appsetting');
	}

	//修改应用信息
	public function modifyApp($appid,$args)
	{
		$data = array('app',$args,"appid = '{$appid}'");
		$sql = $this->sql->makeUpdate($data);
		return $this->db->exec($sql);
	}

	//添加应用信息
	public function addApp($appid,$args)
	{
		$args['appid'] = $appid;
		$data = array('app',$args);
		$sql = $this->sql->makeInsert($data);
		$this->db->exec($sql);
		return $this->db->lastInsertId();
	}

	//获取本地应用列表
	public function getLocalAppList()
	{
		return $this->files->listDir('app');
	}

	//获取数据库内应用列表
	public function getAppList($args = 1)
	{
		$data = array(false,'app',$args,false,false,false);
		$sql = $this->sql->makeSelect($data);
		$r = $this->db->fetchAll($sql,'appid','appsetting');
		foreach($r as $key => $p)
		{
			if(!file_exists('app/'.$key))unset($r[$key]);
		}
		return $r;
	}
}

?>
