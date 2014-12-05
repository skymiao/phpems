<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-basics"><?php echo $this->tpl_var['data']['currentbasic']['basic']; ?></a> <span class="divider">/</span>
					</li>
					<li class="active">
						模拟考试
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#" data-toggle="tab">模拟考试</a>
					</li>
				</ul>
            	<ul class="unstyled">
                	<li><b>1、</b>点击考试名称按钮进入答题界面，考试开始计时。</li>
                	<li><b>2、</b>在随机考试过程中，您可以通过顶部的考试时间来掌握自己的做题时间。</li>
                	<li><b>3、</b>提交试卷后，可以通过“查看答案和解析”功能进行总结学习。</li>
                	<li><b>4、</b>系统自动记录模拟考试的考试记录，学员考试结束后可以进入“答题记录”功能进行查看。</li>
                	<li>&nbsp;</li>
                </ul>
				<ul class="thumbnails">
					<?php $eid = 0;
 foreach($this->tpl_var['exams']['data'] as $key => $exam){ 
 $eid++; ?>
					<li class="span2">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/Clipboard.png"/>
							<div class="caption">
								<p class="text-center">
									<a class="ajax btn btn-primary" href="index.php?exam-app-exampaper-selectquestions&examid=<?php echo $exam['examid']; ?>" title="<?php echo $exam['exam']; ?>" action-before="clearStorage"><?php echo $this->G->make('strings')->subString($exam['exam'],28); ?></a>
								</p>
							</div>
						</div>
					</li>
					<?php } ?>
				</ul>
				<div class="pagination pagination-right">
		            <ul><?php echo $this->tpl_var['exams']['pages']; ?></ul>
		        </div>
			</div>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
</body>
</html>