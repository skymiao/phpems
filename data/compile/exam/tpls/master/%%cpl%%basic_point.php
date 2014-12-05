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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-basic-section&subjectid=<?php echo $this->tpl_var['section']['sectionsubjectid']; ?>">章节管理</a> <span class="divider">/</span></li>
				<li class="active">知识点管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">知识点管理</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-master-basic-addpoint&sectionid=<?php echo $this->tpl_var['section']['sectionid']; ?><?php echo $this->tpl_var['u']; ?>">添加知识点</a>
				</li>
			</ul>
			<legend><?php echo $this->tpl_var['section']['section']; ?></legend>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>知识点ID</th>
						<th>知识点名称</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    <?php $kid = 0;
 foreach($this->tpl_var['knows']['data'] as $key => $know){ 
 $kid++; ?>
					<tr>
						<td><?php echo $know['knowsid']; ?></td>
						<td><?php echo $know['knows']; ?></td>
						<td>
							<div class="btn-group">
								<a class="btn" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-basic-modifypoint&knowsid=<?php echo $know['knowsid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="修改知识点"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-basic-delpoint&sectionid=<?php echo $know['knowssectionid']; ?>&knowsid=<?php echo $know['knowsid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="删除知识点"><em class="icon-remove"></em></a>
							</div>
						</td>
					</tr>
					<?php } ?>
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul><?php echo $this->tpl_var['knows']['pages']; ?></ul>
	        </div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>