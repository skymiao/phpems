<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#panel-461715" data-toggle="tab">我的考场</a>
					</li>
				</ul>
				<ul class="thumbnails">
					<?php $bid = 0;
 foreach($this->tpl_var['basics'] as $key => $basic){ 
 $bid++; ?>
					<li class="span6">
						<div class="thumbnail">
							<img alt="300x200" src="<?php if($basic['basicthumb']){ ?><?php echo $basic['basicthumb']; ?><?php } else { ?>app/exam/styles/image/paper.png<?php } ?>"/>
							<div class="caption">
								<p class="text-center">
									<a class="ajax btn btn-primary" href="index.php?<?php echo $this->tpl_var['_app']; ?>-phone-index-setCurrentBasic&basicid=<?php echo $basic['basicid']; ?>" title="<?php echo $basic['basic']; ?>"><?php echo $this->G->make('strings')->subString($basic['basic'],15); ?></a>
								</p>
							</div>
						</div>
					</li>
					<?php if($bid % 2 == 0){ ?>
					</ul>
					<ul class="thumbnails">
					<?php } ?>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
</body>
</html>