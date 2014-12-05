<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam-phone">考场选择</a> <span class="divider">/</span>
					</li>
					<li class="active">
						<?php echo $this->tpl_var['data']['currentbasic']['basic']; ?>
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#" data-toggle="tab">学习考试</a>
					</li>
				</ul>
				<ul class="thumbnails">
					<li class="span6">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/Pensils.png"/>
							<div class="caption">
								<p class="text-center">
									<a class="btn btn-primary" href="index.php?exam-phone-exercise">强化训练</a>
								</p>
							</div>
						</div>
					</li>
					<li class="span6">
						<div class="thumbnail">
							<img src="app/core/styles/images/icons/Pocket.png"/>
							<div class="caption">
								<p class="text-center">
									<a class="btn btn-primary" href="index.php?exam-phone-favor">习题收藏</a>
								</p>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
</body>
</html>