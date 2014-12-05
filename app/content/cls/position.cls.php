<?php

class position
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
	}

	public function _init()
	{
		$this->positions = NULL;
		$this->sql = $this->G->make('sql');
		$this->db = $this->G->make('db');
		$this->pg = $this->G->make('pg');
		$this->ev = $this->G->make('ev');
	}

	public function getPosList()
	{
		$data = array(false,'position');
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetchAll($sql,'posid');
	}

	public function addPos($args)
	{
		$data = array('position',$args);
		$sql = $this->sql->makeInsert($data);
		$this->db->exec($sql);
		return $this->db->lastInsertId();
	}

	public function delPos($id)
	{
		return $this->db->delElement(array('table' => 'position','query' => "posid = '{$id}'"));
	}

	public function getPosById($id)
	{
		$data = array(false,'position',"posid = '{$id}'");
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql);
	}

	public function modifyPos($id,$args)
	{
		$data = array('position',$args,"posid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	public function getPosContentList($args,$page,$number = 20)
	{
		$data = array(
			'select' => false,
			'table' => 'poscontent',
			'query' => $args,
			'orderby' => 'pcsequence DESC, pcid DESC'
		);
		return $this->db->listElements($page,$number,$data);
	}

	public function getPosContentById($id)
	{
		$data = array(false,'poscontent',"pcid = '{$id}'");
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql);
	}

	public function getPosContentByArgs($args)
	{
		$data = array(false,'poscontent',$args,false,"pcid DESC");
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql);
	}

	public function addPosContent($args)
	{
		$data = array('poscontent',$args);
		$sql = $this->sql->makeInsert($data);
		$this->db->exec($sql);
		return $this->db->lastInsertId();
	}

	public function modifyPosContentByContentId($id,$args)
	{
		$data = array('poscontent',$args,"pccontentid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	public function modifyPosContent($id,$args)
	{
		$data = array('poscontent',$args,"pcid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}

	public function delPosContent($id)
	{
		return $this->db->delElement(array('table' => 'poscontent','query' => "pcid = '{$id}'"));
	}
}

?>
