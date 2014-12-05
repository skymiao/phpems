<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="span2 exambox">
			<div class="examform">
				<div>
					<?php $this->_compileInclude('menu'); ?>
				</div>
			</div>
		</div>
		<div class="span10 exambox" id="datacontent">
			<div class="examform">
				<div>
					<ul class="breadcrumb">
						<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-app">用户中心</a> <span class="divider">/</span></li>
						<li class="active">隐私设置</li>
					</ul>
					<div id="tabs-694325" class="tabbable">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#panel-344373" data-toggle="tab">用户资料</a>
							</li>
							<li>
								<a href="#panel-788885" data-toggle="tab">修改密码</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="panel-344373" class="tab-pane active">
								<form action="index.php?user-center-privatement" method="post" class="form-horizontal">
									<fieldset>
										<legend><?php echo $this->tpl_var['user']['username']; ?></legend>
										<?php $fid = 0;
 foreach($this->tpl_var['forms'] as $key => $form){ 
 $fid++; ?>
										<div class="control-group">
											<label for="<?php echo $form['id']; ?>" class="control-label"><?php echo $form['title']; ?>：</label>
											<div class="controls">
											<?php echo $form['html']; ?>
											</div>
										</div>
										<?php } ?>
										<div class="control-group">
											<div class="controls">
												<button class="btn btn-primary" type="submit">提交</button>
												<input type="hidden" name="modifyuserinfo" value="1"/>
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
							</div>
							<div id="panel-788885" class="tab-pane">
								<form action="index.php?user-center-privatement" method="post" class="form-horizontal">
									<fieldset>
										<legend><?php echo $this->tpl_var['user']['username']; ?></legend>
										<div class="control-group">
											<label for="oldpassowrd" class="control-label">旧密码：</label>
											<div class="controls">
												<input id="oldpassowrd" type="password" name="oldpassword" needle="true" datatype="password" msg="密码字数必须在6位以上"/>
											</div>
										</div>
										<div class="control-group">
											<label for="passowrd1" class="control-label">新密码：</label>
											<div class="controls">
												<input id="passowrd1" type="password" name="args[password]" needle="true" datatype="password" msg="密码字数必须在6位以上"/>
											</div>
										</div>
										<div class="control-group">
											<label for="password2" class="control-label">重复密码：</label>
											<div class="controls">
												<input id="password2" type="password" name="args[password2]" needle="true" equ="passowrd1" msg="前后两次密码必须一致且不能为空"/>
											</div>
										</div>
										<div class="control-group">
											<div class="controls">
												<button class="btn btn-primary" type="submit">提交</button>
												<input type="hidden" name="modifyuserpassword" value="1"/>
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>