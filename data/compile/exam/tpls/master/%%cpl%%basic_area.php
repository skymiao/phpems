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
				<li class="active">地区设置</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">地区设置</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?exam-master-basic-addarea&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">添加地区</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>地区ID</th>
	                    <th>区号</th>
						<th>地区名称</th>
						<th>默认</th>
						<th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
                    <?php $aid = 0;
 foreach($this->tpl_var['areas']['data'] as $key => $area){ 
 $aid++; ?>
					<tr>
						<td><?php echo $area['areaid']; ?></td>
						<td><?php echo $area['areacode']; ?></td>
						<td><?php echo $area['area']; ?></td>
						<td><?php if($area['arealevel']){ ?><em class="icon-ok"></em><?php } else { ?><em class="icon-remove"></em><?php } ?></td>
						<td>
							<div class="btn-group">
	                    		<a class="btn" href="index.php?exam-master-basic&search[basicareaid]=<?php echo $area['areaid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="考场"><em class="icon-th-list"></em></a>
	                    		<a class="btn" href="index.php?exam-master-basic-modifyarea&areaid=<?php echo $area['areaid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-master-basic-delarea&areaid=<?php echo $area['areaid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="删除"><em class="icon-remove"></em></a>
	                    	</div>
						</td>
					</tr>
					<?php } ?>
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
				<ul><?php echo $this->tpl_var['areas']['pages']; ?></ul>
			</div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>