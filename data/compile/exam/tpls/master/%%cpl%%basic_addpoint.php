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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-basic-subject">科目管理</a> <span class="divider">/</span></li>
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-basic-section&subjectid=<?php echo $this->tpl_var['section']['sectionsubjectid']; ?>&page=<?php echo $this->tpl_var['page']; ?>">章节管理</a> <span class="divider">/</span></li>
				<li class="active">知识点管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">知识点管理</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-master-basic-addpoint&sectionid=<?php echo $this->tpl_var['section']['sectionid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">添加知识点</a>
				</li>
			</ul>
	        <form action="index.php?exam-master-basic-addpoint" method="post" class="form-horizontal">
				<fieldset>
				<legend><?php echo $this->tpl_var['section']['section']; ?></legend>
				<div class="control-group">
					<label for="knows" class="control-label">知识点名称：</label>
					<div class="controls">
						<input id="knows" name="args[knows]" type="text" size="30" value="" needle="needle" msg="请输入知识点名称" />
						<span class="help-block">可用通过英文逗号隔开多个知识点名称来批量录入</span>
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
						<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="insertknows" value="1"/>
						<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
						<input type="hidden" name="args[knowssectionid]" value="<?php echo $this->tpl_var['section']['sectionid']; ?>"/>
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
		</div>