<?php

class block_content
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
	}

	public function _init()
	{
		$this->categories = NULL;
		$this->tidycategories = NULL;
		$this->sql = $this->G->make('sql');
		$this->db = $this->G->make('db');
		$this->pg = $this->G->make('pg');
		$this->ev = $this->G->make('ev');
	}

	public function getBlockList($args,$page,$number = 20)
	{
		$data = array(
			'select' => false,
			'table' => 'block',
			'query' => $args,
			'orderby' => 'blockid DESC'
		);
		return $this->db->listElements($page,$number,$data);
	}

	public function addBlock($args)
	{
		$data = array('block',$args);
		$sql = $this->sql->makeInsert($data);
		$this->db->exec($sql);
		return $this->db->lastInsertId();
	}

	public function delBlock($id)
	{
		return $this->db->delElement(array('table' => 'block','query' => "blockid = '{$id}'"));
	}

	public function getBlockById($id)
	{
		$data = array(false,'block',"blockid = '{$id}'");
		$sql = $this->sql->makeSelect($data);
		return $this->db->fetch($sql,'blockcontent');
	}

	public function modifyBlock($id,$args)
	{
		$data = array('block',$args,"blockid = '{$id}'");
		$sql = $this->sql->makeUpdate($data);
		$this->db->exec($sql);
		return $this->db->affectedRows();
	}
}

?>
