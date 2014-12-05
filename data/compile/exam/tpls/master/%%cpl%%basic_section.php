<?php if(!$this->tpl_var['userhash']){ ?>
<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<?php $this->_compileInclude('menu'); ?>
		</div>
		<div class="span10" id="datacontent">
<?php } ?>
			<ul class="breadcrumb">
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname']; ?></a> <span class="divider">/</span></li>
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-basic-subject">科目管理</a> <span class="divider">/</span></li>
				<li class="active">章节管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">章节管理</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-master-basic-addsection&subjectid=<?php echo $this->tpl_var['subjectid']; ?>">添加章节</a>
				</li>
			</ul>
			<legend><?php echo $this->tpl_var['subjects'][$this->tpl_var['subjectid']]['subject']; ?></legend>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>章节ID</th>
						<th>章节名称</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    <?php $sid = 0;
 foreach($this->tpl_var['sections']['data'] as $key => $section){ 
 $sid++; ?>
					<tr>
						<td><?php echo $section['sectionid']; ?></td>
						<td><?php echo $section['section']; ?></td>
						<td>
							<div class="btn-group">
								<a class="btn" href="index.php?exam-master-basic-point&sectionid=<?php echo $section['sectionid']; ?>&page=<?php echo $this->tpl_var['page']; ?>&basicid=<?php echo $basic['basicid']; ?><?php echo $this->tpl_var['u']; ?>" title="修改模型信息"><em class="icon-th-list"></em></a>
								<a class="btn" href="index.php?exam-master-basic-modifysection&sectionid=<?php echo $section['sectionid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="修改模型信息"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-master-basic-delsection&sectionid=<?php echo $section['sectionid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="删除模型"><em class="icon-remove"></em></a>
							</div>
						</td>
					</tr>
					<?php } ?>
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul><?php echo $this->tpl_var['sections']['pages']; ?></ul>
	        </div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>