{x2;if:!$userhash}
{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			{x2;include:menu}
		</div>
		<div class="span10" id="datacontent">
{x2;endif}
			<ul class="breadcrumb">
				<li><a href="index.php?{x2;$_app}-teach">{x2;$apps[$_app]['appname']}</a> <span class="divider">/</span></li>
				<li><a href="index.php?{x2;$_app}-teach-users">课程成绩</a> <span class="divider">/</span></li>
				<li class="active">成绩统计</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">成绩统计</a>
				</li>
				<li class="pull-right">
					<a class="ajax" href="index.php?{x2;$_app}-teach-users-outscore&basicid={x2;$basicid}">导出成绩</a>
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
                    {x2;tree:$exams['data'],exam,eid}
			        <tr>
						<td>
							{x2;v:exam['ehid']}
						</td>
						<td>
							{x2;v:exam['ehusername']}
						</td>
						<td>
							{x2;v:exam['ehscore']}
						</td>
						<td>
							{x2;v:exam['ehexam']}
						</td>
						<td>
							{x2;v:exam['ehtime']}分钟
						</td>
						<td>
							{x2;if:v:exam['ehtype'] == 1}随机组卷{x2;else}手工组卷{x2;endif}
						</td>
						<td><a class="btn btn-primary" href="index.php?exam-teach-users-readpaper&ehid={x2;v:exam['ehid']}" target="_blank">阅卷</a>&nbsp;<a class="btn btn-primary hide" href="index.php?exam-teach-users-changescore&ehid={x2;v:exam['ehid']}" target="_blank">纠分</a></td>
			        </tr>
			        {x2;endtree}
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul>{x2;$exams['pages']}</ul>
	        </div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}