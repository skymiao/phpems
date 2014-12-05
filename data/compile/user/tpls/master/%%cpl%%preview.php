<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<?php $this->_compileInclude('menu'); ?>
		</div>
		<div class="span10" id="datacontent">
			<ul class="breadcrumb">
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname']; ?></a> <span class="divider">/</span></li>
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-module">模型管理</a> <span class="divider">/</span></li>
				<li class="active">模型预览</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">模型预览</a>
				</li>
				<li class="dropdown pull-right">
					 <a class="dropdown-toggle" href="#" data-toggle="dropdown">模型列表<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li>
							<a href="index.php?user-master-module">模型列表</a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="index.php?user-master-module-fields&moduleid=<?php echo $this->tpl_var['module']['moduleid']; ?>">字段管理</a>
						</li>
					</ul>
				</li>
			</ul>
			<form class="form-horizontal">
				<fieldset>
					<legend><?php echo $this->tpl_var['module']['modulename']; ?></legend>
					<?php $fid = 0;
 foreach($this->tpl_var['forms'] as $key => $form){ 
 $fid++; ?>
					<div class="control-group">
						<label for="<?php echo $form['id']; ?>"><?php echo $form['title']; ?>：</label>
						<?php echo $form['html']; ?>
					</div>
					<?php } ?>
				</fieldset>
			</form>
		</div>
	</div>
</div>
</body>
</html>