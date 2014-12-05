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
				<li class="active">修改模型</li>
			</ul>
	    	<form action="?user-master-module-modify" method="post" class="form-horizontal">
				<fieldset>
					<legend><?php echo $this->tpl_var['module']['modulename']; ?></legend>
					<div class="control-group">
						<label for="modulename" class="control-label">模型名称：</label>
						<div class="controls">
							<input type="text" size="40" name="args[modulename]" needle="needle" datatype="username" id="modulename" value="<?php echo $this->tpl_var['module']['modulename']; ?>"/>
						</div>
					</div>
			        <div class="control-group">
				        <label class="control-label" for="moduledescribe">模型描述：</label>
		          		<div class="controls">
		          			<textarea rows="7" class="input-xxlarge" name="args[moduledescribe]" id="moduledescribe"><?php echo $this->tpl_var['module']['moduledescribe']; ?></textarea>
			        	</div>
			        </div>
			        <div class="control-group">
						<div class="controls">
							<button class="btn btn-primary" type="submit">提交</button>
				        	<input type="hidden" name="moduleid" value="<?php echo $this->tpl_var['module']['moduleid']; ?>"/>
				        	<input type="hidden" name="modifymodule" value="1"/>
							<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
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