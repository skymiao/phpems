<?php if(!$this->tpl_var['userhash']){ ?>
<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<?php $this->_compileInclude('menu'); ?>
		</div>
		<div class="span10" id="datacontent">
<?php } ?>
			<ul class="breadcrumb">
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname']; ?></a> <span class="divider">/</span></li>
				<li class="active">分类管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="javascript:;" onclick="javascript:openall();">分类管理</a>
				</li>
				<li class="dropdown pull-right">
					<a class="dropdown-toggle" href="#" data-toggle="dropdown">添加分类<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-category-add&parent=<?php echo $this->tpl_var['parent']; ?>">添加分类</a></li>
						<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-category&parent=<?php echo $this->tpl_var['categories'][$this->tpl_var['parent']]['catparent']; ?>">上级分类</a></li>
                    </ul>
				</li>
			</ul>
			<legend><?php if($this->tpl_var['parent']){ ?><?php echo $this->tpl_var['categories'][$this->tpl_var['parent']]['catname']; ?><?php } else { ?>一级分类<?php } ?></legend>
			<table class="table table-hover">
				<thead>
					<tr>
						<!--
						<th width="80">排序</th>
						-->
						<th width="80">ID</th>
						<th width="80">缩略图</th>
						<th>分类名称</th>
						<th width="120">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php $cid = 0;
 foreach($this->tpl_var['categorys']['data'] as $key => $category){ 
 $cid++; ?>
					<tr>
						<!--
						<td><input type="text" name="ids[<?php echo $category['catid']; ?>]" value="<?php echo $category['catlite']; ?>" style="width:24px;padding:2px 5px;"/></td>
						-->
						<td><?php echo $category['catid']; ?></td>
						<td><img src="<?php if($category['catimg']){ ?><?php echo $category['catimg']; ?><?php } else { ?>app/core/styles/images/noupload.gif<?php } ?>" alt="" style="width:24px;"/></td>
						<td><a onclick="javascript:openmenu(this);" href="javascript:void(0);" class="icon-plus-sign catool" rel="<?php echo $category['catid']; ?>" data="0" app="<?php echo $this->tpl_var['_app']; ?>"></a><span><?php echo $category['catname']; ?></span></td>
						<td>
							<div class="btn-group">
								<a class="btn" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-category-add&parent=<?php echo $category['catid']; ?><?php echo $this->tpl_var['u']; ?>"><em class="icon-plus"></em></a>
								<a class="btn" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-category-edit&page=<?php echo $this->tpl_var['page']; ?>&catid=<?php echo $category['catid']; ?><?php echo $this->tpl_var['u']; ?>"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-category-del&catid=<?php echo $category['catid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>"><em class="icon-remove"></em></a>
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="pagination pagination-right">
				<ul><?php echo $this->tpl_var['categorys']['pages']; ?></ul>
			</div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>