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
				<li class="active">题型管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">题型管理</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-master-basic-addquestype&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">添加题型</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>题型ID</th>
						<th>题型</th>
						<th>题型分类</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    <?php $qid = 0;
 foreach($this->tpl_var['questypes'] as $key => $questype){ 
 $qid++; ?>
					<tr>
						<td><?php echo $questype['questid']; ?></td>
						<td><?php echo $questype['questype']; ?></td>
						<td><?php if($questype['questsort']){ ?>主观题<?php } else { ?>客观题<?php } ?></td>
						<td>
			          		<div class="btn-group">
								<a class="btn" href="index.php?exam-master-basic-modifyquestype&questid=<?php echo $questype['questid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-master-basic-delquestype&questid=<?php echo $questype['questid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="删除"><em class="icon-remove"></em></a>
							</div>
			          	</td>
					</tr>
					<?php } ?>
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
        		<ul><?php echo $this->tpl_var['questypes']['pages']; ?></ul>
	        </div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>