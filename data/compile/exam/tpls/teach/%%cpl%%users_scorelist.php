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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-teach"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname']; ?></a> <span class="divider">/</span></li>
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-teach-users">课程成绩</a> <span class="divider">/</span></li>
				<li class="active">成绩统计</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">成绩统计</a>
				</li>
				<li class="pull-right">
					<a class="ajax" href="index.php?<?php echo $this->tpl_var['_app']; ?>-teach-users-outscore&basicid=<?php echo $this->tpl_var['basicid']; ?>">导出成绩</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>ID</th>
	                    <th>考生用户名</th>
	                    <th>分数</th>
				        <th>考试名称</th>
				        <th>考试用时</th>
				        <th>组卷类型</th>
				        <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    <?php $eid = 0;
 foreach($this->tpl_var['exams']['data'] as $key => $exam){ 
 $eid++; ?>
			        <tr>
						<td>
							<?php echo $exam['ehid']; ?>
						</td>
						<td>
							<?php echo $exam['ehusername']; ?>
						</td>
						<td>
							<?php echo $exam['ehscore']; ?>
						</td>
						<td>
							<?php echo $exam['ehexam']; ?>
						</td>
						<td>
							<?php echo $exam['ehtime']; ?>分钟
						</td>
						<td>
							<?php if($exam['ehtype'] == 1){ ?>随机组卷<?php } else { ?>手工组卷<?php } ?>
						</td>
						<td><a class="btn btn-primary" href="index.php?exam-teach-users-readpaper&ehid=<?php echo $exam['ehid']; ?>" target="_blank">阅卷</a>&nbsp;<a class="btn btn-primary hide" href="index.php?exam-teach-users-changescore&ehid=<?php echo $exam['ehid']; ?>" target="_blank">纠分</a></td>
			        </tr>
			        <?php } ?>
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul><?php echo $this->tpl_var['exams']['pages']; ?></ul>
	        </div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>