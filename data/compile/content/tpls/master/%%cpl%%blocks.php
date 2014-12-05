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
				<li class="active">标签管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">标签管理</a>
				</li>
				<li class="pull-right">
					<a href="index.php?content-master-blocks-add&page=<?php echo $this->tpl_var['page']; ?>">添加标签</a>
				</li>
			</ul>
			<table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>ID</th>
				        <th>名称</th>
				        <th>位置</th>
				        <th>类型</th>
				        <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php $kid = 0;
 foreach($this->tpl_var['blocks']['data'] as $key => $block){ 
 $kid++; ?>
	            	<tr>
	                    <td><?php echo $block['blockid']; ?></td>
				        <td><?php echo $block['block']; ?></td>
				        <td><?php echo $block['blockposition']; ?></td>
				        <td>
				        	<div class="dropdown">
					        	<a class="dropdown-toggle" href="#" data-toggle="dropdown"><?php if($block['blocktype'] == 1){ ?>固定内容<?php } elseif($block['blocktype'] == 2){ ?>分类列表<?php } elseif($block['blocktype'] == 3){ ?>SQL<?php } elseif($block['blocktype'] == 4){ ?>模板模式<?php } ?><strong class="caret"></strong></a>
					        	<ul class="dropdown-menu">
						        	<li><a href="javascript:;">切换模式</a></li>
									<li class="divider"></li>
									<li><a class="ajax" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-blocks-change&blockid=<?php echo $block['blockid']; ?>&blocktype=1&page=<?php echo $this->tpl_var['page']; ?>">固定内容</a></li>
									<li><a class="ajax" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-blocks-change&blockid=<?php echo $block['blockid']; ?>&blocktype=2&page=<?php echo $this->tpl_var['page']; ?>">分类列表</a></li>
									<li><a class="ajax" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-blocks-change&blockid=<?php echo $block['blockid']; ?>&blocktype=3&page=<?php echo $this->tpl_var['page']; ?>">SQL模式</a></li>
									<li><a class="ajax" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-blocks-change&blockid=<?php echo $block['blockid']; ?>&blocktype=4&page=<?php echo $this->tpl_var['page']; ?>">模板模式</a></li>
			                    </ul>
		                    </div>
				        </td>
				        <td>
				        	<div class="btn-group">
								<a class="btn" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-blocks-modify&blockid=<?php echo $block['blockid']; ?>&page=<?php echo $this->tpl_var['page']; ?>" title="修改模型信息"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-blocks-del&blockid=<?php echo $block['blockid']; ?>&page=<?php echo $this->tpl_var['page']; ?>" title="删除模型"><em class="icon-remove"></em></a>
							</div>
						</td>
	                </tr>
	                <?php } ?>
	        	</tbody>
	        </table>
			<div class="pagination pagination-right">
				<ul><?php echo $this->tpl_var['blocks']['pages']; ?></ul>
			</div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>