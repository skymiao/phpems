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
					<div>
						<div class="span3">
							<div class="thumbnail"><img alt="300x200" src="<?php if($this->tpl_var['_user']['photo']){ ?><?php echo $this->tpl_var['_user']['photo']; ?><?php } else { ?>app/exam/styles/image/paper.png<?php } ?>" /></div>
						</div>
						<div class="span3">
							<div class="caption">
								<h3><?php echo $this->tpl_var['_user']['username']; ?></h3>
								<p>注册日期：<?php echo date('Y-m-d',$this->tpl_var['_user']['userregtime']); ?></p>
								<p>注册IP：<?php echo $this->tpl_var['_user']['userregip']; ?></p>
								<p>您现有积分：<?php echo $this->tpl_var['_user']['usercoin']; ?></p>
								<p>&nbsp;</p>
								<p><a class="btn" href="index.php?user-center-payfor">充值</a></p>
							</div>
							<div>&nbsp;</div>
						</div>
						<div class="span3">
							<div class="caption">
								<h3>&nbsp;</h3>
								<p>用户组：<?php echo $this->tpl_var['groups'][$this->tpl_var['_user']['usergroupid']]['groupname']; ?></p>
								<p>真实姓名：<?php echo $this->tpl_var['_user']['usertruename']; ?></p>
								<p>邮箱：<?php echo $this->tpl_var['_user']['useremail']; ?></p>
								<p>&nbsp;</p>
							</div>
							<div>&nbsp;</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>