<?php

class api_content
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
		$this->tpl = $this->G->make('tpl');
		$this->pg = $this->G->make('pg');
		$this->ev = $this->G->make('ev');
		$this->files = $this->G->make('files');
		$this->category = $this->G->make('category');
		$this->content = $this->G->make('content','content');
		$this->block = $this->G->make('block','content');
		$this->tpl_var = &$this->tpl->tpl_var;
	}

	private function _getBlockContentList($args)
	{
		$catids = $this->category->getChildCategoryString($args['catid']);
		if($args['query'])
		$query = explode("\n",str_replace("\r",'',html_entity_decode($this->ev->stripSlashes($args['query']))));
		else $query = array();
		$query[] = "contentcatid IN ({$catids})";
		$r = $this->content->getContentList($query,1,$args['number']);
		return $r['data'];
	}

	public function parseBlock($blockid)
	{
		$block = $this->block->getBlockById($blockid);
		if($block['blocktype'] == 1)
		{
			echo html_entity_decode($block['blockcontent']['content']);
		}
		elseif($block['blocktype'] == 2)
		{
			if($block['blockcontent']['app'] == 'content')
			{
				$args = array('catid'=>$block['blockcontent']['catid'],'number'=>$block['blockcontent']['number'],'query'=>$block['blockcontent']['query']);
				$blockdata = $this->_getBlockContentList($args);
				$tp = $this->tpl->fetchContent(html_entity_decode($this->ev->stripSlashes($block['blockcontent']['template'])));
				$blockcat = $this->category->getCategoryById($block['blockcontent']['catid']);
				$blockcatchildren = $this->category->getCategoriesByArgs("catparent = '{$block['blockcontent']['catid']}'");
				eval(' ?>'.$tp.'<?php ');
			}
			else
			{
				$args = array('catid'=>$block['blockcontent']['catid'],'number'=>$block['blockcontent']['number'],'query'=>$block['blockcontent']['query']);
				$obj = $this->G->make('api',$block['blockcontent']['app']);
				if(method_exists($obj,'parseBlock'))
				$blockdata = $obj->parseBlock($args);
				else
				return false;
			}
			return true;
		}
		elseif($block['blocktype'] == 3)
		{
			if($block['blockcontent']['sql'])
			{
				$sql = str_replace('[TABLEPRE]',DTH,$block['blockcontent']['sql']);
			}
			else
			{
				$tables = array_filter(explode(',',$block['blockcontent']['dbtable']));
				$args = array_filter(explode("\n",str_replace("\r","",html_entity_decode($this->ev->stripSlashes($block['blockcontent']['query'])))));
				$data = array(false,$tables,$args,false,$block['blockcontent']['order'],$block['blockcontent']['limit']);
				$sql = $this->sql->makeSelect($data);
			}
			$blockdata = $this->db->fetchAll($sql,$block['blockcontent']['index']?$block['blockcontent']['index']:false,$block['blockcontent']['serial']?$block['blockcontent']['serial']:false);
			$tp = $this->tpl->fetchContent(html_entity_decode($this->ev->stripSlashes($block['blockcontent']['template'])));
			eval(' ?>'.$tp.'<?php ');
			return true;
		}
		elseif($block['blocktype'] == 4)
		{
			$tp = $this->tpl->fetchContent(html_entity_decode($this->ev->stripSlashes($block['blockcontent']['content'])));
			eval(' ?>'.$tp.'<?php ');
		}
		else
		return false;
	}
}

?>
