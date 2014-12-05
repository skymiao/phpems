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
				<li class="active">回收站</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">已删知识点</a>
				</li>
			</ul>
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
	                    		<a class="btn ajax" href="index.php?exam-master-recyle-backknows&page=<?php echo $this->tpl_var['page']; ?>&knowsid=<?php echo $know['knowsid']; ?><?php echo $this->tpl_var['u']; ?>" title="修改"><em class="icon-edit"></em></a>
								<a class="btn ajax" href="index.php?exam-master-recyle-delknows&page=<?php echo $this->tpl_var['page']; ?>&knowsid=<?php echo $know['knowsid']; ?><?php echo $this->tpl_var['u']; ?>" title="删除"><em class="icon-remove"></em></a>
	                    	</div>
	                    </td>
					</tr>
					<?php } ?>
	        	</tbody>
	        </table>
	        <!--
	        <div class="control-group">
	            <div class="controls">
		            <label class="radio inline">
		                <input type="radio" name="action" value="reback" />恢复
		            </label>
		            <label class="radio inline">
		                <input type="radio" name="action" value="delete" />删除
		            </label>
		            <?php $sid = 0;
 foreach($this->tpl_var['search'] as $key => $arg){ 
 $sid++; ?>
		            <input type="hidden" name="search[<?php echo $key; ?>]" value="<?php echo $arg; ?>"/>
		            <?php } ?>
		            <label class="radio inline">
		            	<button class="btn btn-primary" type="submit">提交</button>
		            </label>
		            <input type="hidden" name="modifycontentsequence" value="1"/>
		            <input type="hidden" name="catid" value="<?php echo $this->tpl_var['catid']; ?>"/>
		            <input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
		        </div>
	        </div>
			-->
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