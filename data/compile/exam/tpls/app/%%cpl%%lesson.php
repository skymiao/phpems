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
						课后练习
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#" data-toggle="tab">课后练习</a>
					</li>
				</ul>
				<?php $sid = 0;
 foreach($this->tpl_var['sections'] as $key => $section){ 
 $sid++; ?>
				<table class="table table-hover table-bordered">
					<tr class="info"><td colspan="6"><?php echo $section['section']; ?></td></tr>
					<tr>
						<?php $kid = 0;
 foreach($this->tpl_var['basic']['basicknows'][$section['sectionid']] as $key => $know){ 
 $kid++; ?>
				    	<td><a href="index.php?route=exam-app-lesson-lessonnumber&knowsid=<?php echo $know; ?>" target="lessonknows" class="ajax"><?php echo $this->tpl_var['knows'][$know]['knows']; ?></a></td>
				    	<?php if($kid % 6 == 0){ ?></tr><tr><?php } ?>
				    	<?php } ?>
				    	<?php if(($kid % 6 != 0) && ($kid/6 >= 1)){ ?>
				    	<?php $mod = 6 - $kid % 6;; ?>
				    	<td colspan="<?php echo $mod; ?>"></td>
				    	<?php } ?>
					</tr>
				</table>
				<?php } ?>
				<div id="lessonknows"></div>
			</div>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
</body>
</html>