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
						考试记录
					</li>
				</ul>
				<ul class="nav nav-tabs">
					<li<?php if($this->tpl_var['ehtype'] == 0){ ?> class="active"<?php } ?>>
						<a href="index.php?exam-app-history">强化训练</a>
					</li>
					<li<?php if($this->tpl_var['ehtype'] == 1){ ?> class="active"<?php } ?>>
						<a href="index.php?exam-app-history&ehtype=1">模拟考试</a>
					</li>
					<li<?php if($this->tpl_var['ehtype'] == 2){ ?> class="active"<?php } ?>>
						<a href="index.php?exam-app-history&ehtype=2">正式考试</a>
					</li>
				</ul>
				<?php if($this->tpl_var['ehtype'] == 0){ ?>
				<p><span class="text-warning">提示：</span>我的错题中的强化训练最多记录最新20条信息。</p>
				<?php } elseif($this->tpl_var['ehtype'] == 1){ ?>
				<p>您一共完成了<b class="text-warning"><?php echo $this->tpl_var['exams']['number']; ?></b>次考试， 平均分为：<b class="text-warning"><?php echo $this->tpl_var['avgscore']; ?></b>分 继续努力吧！</p>
				<?php } elseif($this->tpl_var['ehtype'] == 2){ ?>
				<p>您一共完成了<b class="text-warning"><?php echo $this->tpl_var['exams']['number']; ?></b>次考试， 平均分为：<b class="text-warning"><?php echo $this->tpl_var['avgscore']; ?></b>分 继续努力吧！</p>
				<p><b class="text-warning">注意：</b>正式考试的重做试卷将作为模拟考试记录！</p>
				<?php } ?>
				<table class="table table-bordered table-hover">
					<tr class="info">
						<td>答题记录</td>
						<td>答题时间</td>
						<td>用时</td>
                        <td>得分</td>
						<td>错题数量</td>
						<td>查看错题</td>
						<td>试题解析</td>
						<td>重做试卷</td>
						<td>删除记录</td>
					</tr>
					<?php $eid = 0;
 foreach($this->tpl_var['exams']['data'] as $key => $exam){ 
 $eid++; ?>
					<tr>
						<td><?php echo $exam['ehexam']; ?></td>
						<td><?php echo date('Y-m-d',$exam['ehstarttime']); ?></td>
						<td><?php if($exam['ehtime'] >= 60){ ?><?php if($exam['ehtime']%60){ ?><?php echo intval($exam['ehtime']/60)+1; ?><?php } else { ?><?php echo intval($exam['ehtime']/60); ?><?php } ?>分钟<?php } else { ?><?php echo $exam['ehtime']; ?>秒<?php } ?></td>
                        <td><b class="red"><?php if(!$exam['ehstatus'] && $exam['ehdecide']){ ?>评分中<?php } else { ?><?php echo $exam['ehscore']; ?><?php } ?></b></td>
						<td><b class="red"><?php echo $exam['errornumber']; ?></b></td>
						<td><a href="index.php?exam-app-record-wrongs&ehid=<?php echo $exam['ehid']; ?>">查看错题</a></td>
						<td><a href="index.php?exam-app-history-view&ehid=<?php echo $exam['ehid']; ?>">试题解析</a></td>
						<td><a class="ajax" href="index.php?exam-app-history-redo&ehid=<?php echo $exam['ehid']; ?>" action-before="clearStorage">重做试卷</a></td>
						<td>
							<?php if($this->tpl_var['ehtype'] != 2){ ?>
							<a href="javascript:;" onclick="javascript:delhistory(<?php echo $exam['ehid']; ?>)">删除</a>
							<?php } else { ?>
							-
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
				</table>
	            <?php if($this->tpl_var['exams']['pages'] && $this->tpl_var['ehtype']){ ?>
				<div class="pagination pagination-right">
					<ul><?php echo $this->tpl_var['exams']['pages']; ?></ul>
				</div>
	           <?php } ?>
			</div>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
<script>
var delhistory = function(ehid)
{
 	$.get("index.php?exam-app-history-del&ehid="+ehid+"&rand"+Math.random(),function(data){alert('删除成功');window.location.reload();});
}
</script>
</body>
</html>