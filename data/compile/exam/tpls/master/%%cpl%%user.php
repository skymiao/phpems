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
				<li class="active">开通课程</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">开通课程</a>
				</li>
			</ul>
	        <form action="index.php?exam-master-users" method="post">
				<table class="table">
					<thead>
						<tr>
							<th colspan="5">搜索</th>
						</tr>
					</thead>
					<tr>
						<td>
							用户ID：
						</td>
						<td class="input">
							<input name="search[userid]" class="inline" size="25" type="text" class="number" value="<?php echo $this->tpl_var['search']['userid']; ?>"/>
						</td>
						<td>
							用户名：
						</td>
						<td class="input">
							<input class="inline" name="search[username]" size="25" type="text" value="<?php echo $this->tpl_var['search']['username']; ?>"/>
						</td>
						<td>
							<button class="btn btn-primary" type="submit">搜索</button>
							<input type="hidden" value="1" name="search[argsmodel]" />
						</td>
					</tr>
				</table>
			</form>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>ID</th>
				        <th>用户名</th>
				        <th>电子邮件</th>
				        <th>注册IP</th>
				        <th>积分点数</th>
				        <th>角色</th>
				        <th>注册时间</th>
				        <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php $uid = 0;
 foreach($this->tpl_var['users']['data'] as $key => $user){ 
 $uid++; ?>
	            	<tr>
	                    <td><?php echo $user['userid']; ?></td>
	                    <td><?php echo $user['username']; ?></td>
						<td><?php echo $user['useremail']; ?></td><td><?php echo $user['userregip']; ?></td>
						<td><?php echo $user['usercoin']; ?></td><td><?php echo $this->tpl_var['groups'][$user['usergroupid']]['groupname']; ?></td>
						<td><?php echo date('Y-m-d H:i:s',$user['userregtime']); ?></td>
						<td>
						  	<div class="btn-group">
	                    		<a class="btn" href="index.php?exam-master-users-basics&userid=<?php echo $user['userid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="开通课程"><em class="icon-th-list"></em></a>
							</div>
						</td>
	                </tr>
	                <?php } ?>
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul><?php echo $this->tpl_var['users']['pages']; ?></ul>
	        </div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>