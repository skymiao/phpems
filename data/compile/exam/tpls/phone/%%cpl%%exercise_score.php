<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<form class="examform form-horizontal" id="form1" name="form1" action="index.php?exam-phone-exampaper-makescore">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam-phone">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-phone-basics"><?php echo $this->tpl_var['data']['currentbasic']['basic']; ?></a> <span class="divider">/</span>
					</li>
					<li class="active">
						成绩单
					</li>
				</ul>
				<legend class="text-center"><h3><?php echo $this->tpl_var['sessionvars']['examsession']; ?></h3></legend>
                <div>
                	<div class="span12">
                		<div class="boardscore">
                			<h1 class="text-center"><?php echo $this->tpl_var['sessionvars']['examsessionscore']; ?>分</h1>
                		</div>
                        <div class="text-center"><a href="index.php?exam-phone-history-view&ehid=<?php echo $this->tpl_var['ehid']; ?>" class="btn btn-info">查看答案和解析</a></div>
                	</div>
                </div>
			</div>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
</body>
</html>