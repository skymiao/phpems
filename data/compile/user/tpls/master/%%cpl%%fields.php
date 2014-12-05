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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-module">用户模型</a> <span class="divider">/</span></li>
				<li class="active">字段管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">字段管理</a>
				</li>
				<li class="dropdown pull-right"> <a class="dropdown-toggle" href="#" data-toggle="dropdown">添加字段<strong class="caret"></strong></a>
                    <ul class="dropdown-menu">
						<li><a href="index.php?user-master-module-preview&moduleid=<?php echo $this->tpl_var['moduleid']; ?>">模型预览</a></li>
						<li class="divider"></li>
						<li><a href="index.php?user-master-module-addfield&moduleid=<?php echo $this->tpl_var['moduleid']; ?>">添加模型字段</a></li>
						<li><a href="index.php?user-master-module-addfield&moduleid=<?php echo $this->tpl_var['moduleid']; ?>&fieldpublic=1">添加公共字段</a></li>
                    </ul>
				</li>
			</ul>
		    <form action="?user-master-module-fields" method="post">
			    <fieldset>
					<legend><?php echo $this->tpl_var['module']['modulename']; ?></legend>
				    <table class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>排序</th>
								<th>字段名</th>
								<th>字段类型</th>
								<th>别名</th>
								<th>字段长度</th>
								<th>数据类型</th>
								<th>HTML类型</th>
								<th>索引</th>
								<th>字段描述</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php $fid = 0;
 foreach($this->tpl_var['fields'] as $key => $field){ 
 $fid++; ?>
							<tr>
								<td><?php echo $field['fieldid']; ?></td>
								<td><input type="text" name="ids[<?php echo $field['fieldid']; ?>]" value="<?php echo $field['fieldsequence']; ?>" class="liter"/></td>
								<td><?php echo $field['field']; ?></td>
								<td><?php if($field['fieldpublic']){ ?>公共<?php } else { ?>模型<?php } ?>字段</td>
								<td><?php echo $field['fieldtitle']; ?></td>
								<td><?php if($field['fieldlength']){ ?><?php echo $field['fieldlength']; ?><?php } else { ?>默认<?php } ?></td>
								<td><?php echo $field['fieldtype']; ?></td>
								<td><?php echo $field['fieldhtmltype']; ?></td>
								<td><?php if($field['fieldindextype']){ ?><?php echo $field['fieldindextype']; ?><?php } else { ?>NULL<?php } ?></td>
								<td><?php echo $field['fielddescribe']; ?></td>
								<td>
									<div class="btn-group">
										<?php if($field['fieldlock']){ ?>
										<a class="btn ajax" href="index.php?user-master-module-forbiddenfield&fieldid=<?php echo $field['fieldid']; ?>&moduleid=<?php echo $this->tpl_var['moduleid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="启用"><em class="icon-ban-circle"></em></a>
										<?php } else { ?>
										<a class="btn ajax" href="index.php?user-master-module-forbiddenfield&fieldid=<?php echo $field['fieldid']; ?>&moduleid=<?php echo $this->tpl_var['moduleid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="禁用"><em class="icon-ok-circle"></em></a>
										<?php } ?>
										<a class="btn" href="index.php?user-master-module-modifyfield&fieldid=<?php echo $field['fieldid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="修改字段"><em class="icon-edit"></em></a>
										<?php if(!$field['fieldsystem']){ ?>
										<a class="btn ajax" href="index.php?user-master-module-delfield&fieldid=<?php echo $field['fieldid']; ?>&moduleid=<?php echo $this->tpl_var['moduleid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="删除字段"><em class="icon-remove"></em></a>
										<?php } ?>
									</div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="control-group">
						<div class="controls">
							<button class="btn btn-primary" type="submit">更改排序</button>
				            <input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>">
				            <input type="hidden" name="modifyfieldsequence" value="1"/>
	          				<input type="hidden" name="moduleid" value="<?php echo $this->tpl_var['moduleid']; ?>"/>
							<?php $aid = 0;
 foreach($this->tpl_var['search'] as $key => $arg){ 
 $aid++; ?>
							<input type="hidden" name="search[<?php echo $key; ?>]" value="<?php echo $arg; ?>"/>
							<?php } ?>
						</div>
					</div>
				</fieldset>
			</form>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>