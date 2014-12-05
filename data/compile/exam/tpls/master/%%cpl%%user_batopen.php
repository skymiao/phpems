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
				<li class="active">批量开通课程</li>
			</ul>
			<div id="tabs-260773" class="tabbable">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#panel-65699" data-toggle="tab">用户名列表开通</a>
					</li>
					<li>
						<a href="#panel-880294" data-toggle="tab">用户ID列表开通</a>
					</li>
					<li>
						<a href="#panel-888294" data-toggle="tab">用户组开通</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="panel-65699" class="tab-pane active">
						<form action="index.php?exam-master-users-batopen" method="post" class="form-horizontal">
							<div class="control-group">
								<label class="control-label">用户名：</label>
							  	<div class="controls">
							  		<textarea class="input-xxlarge" rows="4" needle="needle" min="1" msg="您最少需要填写一个用户" name="usernames"></textarea>
							  		<span class="help-block">每个用户名请使用英文逗号隔开</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">考场ID：</label>
							  	<div class="controls">
								  	<textarea class="input-xxlarge" rows="4" needle="needle" msg="您最少需要填写一个考场" name="basics"></textarea>
							  		<span class="help-block">每个考场ID请使用英文逗号隔开</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">时长：</label>
							  	<div class="controls">
								  	<input name="days" class="inline" type="text" needle="needle" msg="您最少需要填写一天" value="1"/> 天
								</div>
							</div>
							<div class="control-group">
							  	<div class="controls">
								  	<button class="btn btn-primary" type="submit">提交</button>
								  	<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
								  	<input type="hidden" name="batopen" value="1"/>
								</div>
							</div>
						</form>
					</div>
					<div id="panel-880294" class="tab-pane">
						<form action="index.php?exam-master-users-batopen" method="post" class="form-horizontal">
							<div class="control-group">
								<label class="control-label">用户ID：</label>
							  	<div class="controls">
							  		<textarea class="input-xxlarge" rows="4" needle="needle" min="1" msg="您最少需要填写一个用户" name="userids"></textarea>
							  		<span class="help-block">每个ID请使用英文逗号隔开</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">考场ID：</label>
							  	<div class="controls">
								  	<textarea class="input-xxlarge" rows="4" needle="needle" msg="您最少需要填写一个考场" name="basics"></textarea>
							  		<span class="help-block">每个考场ID请使用英文逗号隔开</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">时长：</label>
							  	<div class="controls">
								  	<input name="days" class="inline" type="text" needle="needle" msg="您最少需要填写一天" value="1"/> 天
								</div>
							</div>
							<div class="control-group">
							  	<div class="controls">
								  	<button class="btn btn-primary" type="submit">提交</button>
								  	<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
								  	<input type="hidden" name="batopen" value="1"/>
								</div>
							</div>
						</form>
					</div>
					<div id="panel-888294" class="tab-pane">
						<form action="index.php?exam-master-users-batopen" method="post" class="form-horizontal">
							<div class="control-group">
								<label class="control-label">用户组ID：</label>
							  	<div class="controls">
							  		<textarea class="input-xxlarge" rows="4" needle="needle" min="1" msg="您最少需要填写一个用户组" name="usergroupids"></textarea>
							  		<span class="help-block">每个ID请使用英文逗号隔开</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">考场ID：</label>
							  	<div class="controls">
								  	<textarea class="input-xxlarge" rows="4" needle="needle" msg="您最少需要填写一个考场" name="basics"></textarea>
							  		<span class="help-block">每个考场ID请使用英文逗号隔开</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">时长：</label>
							  	<div class="controls">
								  	<input name="days" class="inline" type="text" needle="needle" msg="您最少需要填写一天" value="1"/> 天
								</div>
							</div>
							<div class="control-group">
							  	<div class="controls">
								  	<button class="btn btn-primary" type="submit">提交</button>
								  	<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
								  	<input type="hidden" name="batopen" value="1"/>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>