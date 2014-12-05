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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-basic">科目管理</a> <span class="divider">/</span></li>
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-basic-section&subjectid=<?php echo $this->tpl_var['section']['sectionsubjectid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">章节管理</a> <span class="divider">/</span></li>
				<li><a href="index.php?exam-master-basic-point&sectionid=<?php echo $this->tpl_var['knows']['knowssectionid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">知识点管理</a> <span class="divider">/</span></li>
				<li class="active">修改知识点</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">修改知识点</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?exam-master-basic-point&sectionid=<?php echo $this->tpl_var['knows']['knowssectionid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">知识点管理</a>
				</li>
			</ul>
        	<form action="index.php?exam-master-basic-modifypoint" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="knows">知识点名称：</label>
					<div class="controls">
						<input id="knows" name="args[knows]" type="text" size="30" value="<?php echo $this->tpl_var['knows']['knows']; ?>" needle="needle" alt="请输入知识点名称"/>
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
					  	<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="knowsid" value="<?php echo $this->tpl_var['knows']['knowsid']; ?>"/>
						<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
						<input type="hidden" name="modifypoint" value="1"/>
					</div>
				</div>
			</form>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>