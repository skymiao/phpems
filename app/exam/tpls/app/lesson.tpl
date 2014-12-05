{x2;include:header}
<body>
{x2;include:nav}
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-basics">{x2;$data['currentbasic']['basic']}</a> <span class="divider">/</span>
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
				{x2;tree:$sections,section,sid}
				<table class="table table-hover table-bordered">
					<tr class="info"><td colspan="6">{x2;v:section['section']}</td></tr>
					<tr>
						{x2;tree:$basic['basicknows'][v:section['sectionid']],know,kid}
				    	<td><a href="index.php?route=exam-app-lesson-lessonnumber&knowsid={x2;v:know}" target="lessonknows" class="ajax">{x2;$knows[v:know]['knows']}</a></td>
				    	{x2;if:v:kid % 6 == 0}</tr><tr>{x2;endif}
				    	{x2;endtree}
				    	{x2;if:(v:kid % 6 != 0) && (v:kid/6 >= 1)}
				    	{x2;eval: v:mod = 6 - v:kid % 6;}
				    	<td colspan="{x2;v:mod}"></td>
				    	{x2;endif}
					</tr>
				</table>
				{x2;endif}
				<div id="lessonknows"></div>
			</div>
		</div>
	</div>
</div>
{x2;include:foot}
</body>
</html>