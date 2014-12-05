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
					<li>
						<a href="index.php?exam-app-lesson">课后练习</a> <span class="divider">/</span>
					</li>
					<li class="active">
						<?php echo $this->tpl_var['knows']['knows']; ?>（<?php echo $this->tpl_var['questype']['questype']; ?>）
					</li>
				</ul>
				<div id="questionpanel"></div>
			</div>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
<script type="text/javascript">
$(document).ready(function(){
	submitAjax({"url":"index.php?exam-app-lesson-ajax-questions","target":"questionpanel"});
});
</script>
</body>
</html>