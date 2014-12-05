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
						成绩单
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#">成绩单</a>
					</li>
				</ul>
				<p>您的最高分：<span class="text-warning"><?php echo $this->tpl_var['s']['score']; ?></span> 您的最好名次：<span class="text-warning"><?php echo $this->tpl_var['s']['index']; ?></span></p>
				<table class="table table-bordered table-hover">
					<tr class="info">
						<td>名次</td>
						<td>用户名</td>
                        <td>得分</td>
						<td>考试时间</td>
						<td>用时</td>
					</tr>
					<?php $sid = 0;
 foreach($this->tpl_var['scores']['data'] as $key => $score){ 
 $sid++; ?>
					<tr>
						<td><?php echo ($this->tpl_var['page'] - 1)*20 + $sid; ?></td>
						<td><?php echo $score['ehusername']; ?></td>
						<td><?php echo $score['ehscore']; ?></td>
						<td><?php echo date('Y-m-d H:i:s',$score['ehstarttime']); ?></td>
						<td><?php if($score['ehtime'] >= 60){ ?><?php if($score['ehtime']%60){ ?><?php echo intval($score['ehtime']/60)+1; ?><?php } else { ?><?php echo intval($score['ehtime']/60); ?><?php } ?>分钟<?php } else { ?><?php echo $score['ehtime']; ?>秒<?php } ?></td>
					</tr>
				<?php } ?>
				</table>
				<div class="pagination pagination-right">
					<ul><?php echo $this->tpl_var['scores']['pages']; ?></ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
</body>
</html>