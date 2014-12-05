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
				<?php if($this->tpl_var['catid']){ ?>
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-contents">内容管理</a> <span class="divider">/</span></li>
				<li class="active"><?php echo $this->tpl_var['categories'][$this->tpl_var['catid']]['catname']; ?></li>
				<?php } else { ?>
				<li class="active">内容管理</li>
				<?php } ?>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">内容管理</a>
				</li>
				<li class="dropdown pull-right">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">添加内容<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?content-master-contents-add&catid=<?php echo $this->tpl_var['catid']; ?>&page=<?php echo $this->tpl_var['page']; ?>">添加内容</a></li>
						<li><a href="index.php?content-master-contents&catid=<?php echo $this->tpl_var['categories'][$this->tpl_var['catid']]['catparent']; ?>&page=<?php echo $this->tpl_var['page']; ?>">上级分类</a></li>
					</ul>
				</li>
			</ul>
			<h4><?php if($this->tpl_var['catid']){ ?><?php echo $this->tpl_var['categories'][$this->tpl_var['catid']]['catname']; ?><?php } else { ?>所有内容<?php } ?></h4>
			<form action="index.php?content-master-contents" method="post">
				<table class="table">
			        <tr>
						<td>
							内容ID：
						</td>
						<td>
							<input name="search[contentid]" class="input-small" size="25" type="text" class="number" value="<?php echo $this->tpl_var['search']['contentid']; ?>"/>
						</td>
						<td>
							录入时间：
						</td>
						<td>
							<input class="input-small datetimepicker" data-date="<?php echo date('Y-m-d',TIME); ?>" data-date-format="yyyy-mm-dd" type="text" name="search[stime]" size="10" id="stime" value="<?php echo $this->tpl_var['search']['stime']; ?>"/> - <input class="input-small datetimepicker" data-date="<?php echo date('Y-m-d',TIME); ?>" data-date-format="yyyy-mm-dd" size="10" type="text" name="search[etime]" id="etime" value="<?php echo $this->tpl_var['search']['etime']; ?>"/>
						</td>
						<td>
							关键字：
						</td>
						<td>
							<input class="input-small" name="search[keyword]" size="25" type="text" value="<?php echo $this->tpl_var['search']['keyword']; ?>"/>
						</td>
					</tr>
			        <tr>
						<td>
							录入人：
						</td>
			        	<td>
			        		<input class="input-small" name="search[username]" size="25" type="text" value="<?php echo $this->tpl_var['search']['username']; ?>"/>
			        	</td>
			        	<td>
							内容模型：
						</td>
						<td>
							<select name="search[contentmoduleid]" class="input-medium">
						  		<option value="0">不限</option>
						  		<?php $mid = 0;
 foreach($this->tpl_var['modules'] as $key => $module){ 
 $mid++; ?>
						  		<option value="<?php echo $module['moduleid']; ?>"<?php if($this->tpl_var['search']['contentmoduleid'] == $module['moduleid']){ ?> selected<?php } ?>><?php echo $module['modulename']; ?></option>
						  		<?php } ?>
					  		</select>
						</td>
						<td>
							<button class="btn btn-primary" type="submit">提交</button>
						</td>
						<td></td>
			        </tr>
			        <tr>
						<td>
							分类：
						</td>
						<td colspan="5">
					  		<div class="form-inline control-group">
						  		<select msg="您必须选择一个分类" class="autocombox input-medium" name="search[contentcatid]" refUrl="index.php?content-master-category-ajax-getchildcategory&catid={value}">
					            	<option value="">选择一级分类</option>
					            	<?php $cid = 0;
 foreach($this->tpl_var['parentcat'] as $key => $cat){ 
 $cid++; ?>
					            	<option value="<?php echo $cat['catid']; ?>"><?php echo $cat['catname']; ?></option>
					            	<?php } ?>
					            </select>
				            </div>
			        	</td>
					</tr>
				</table>
				<div class="input">
					<input type="hidden" value="1" name="search[argsmodel]" />
				</div>
			</form>
			<form action="index.php?content-master-contents-lite" method="post">
				<fieldset>
					<table class="table table-hover">
			            <thead>
			                <tr>
			                    <th><input type="checkbox" class="checkall" target="delids"/></th>
			                    <th>权重</th>
			                    <th>ID</th>
			                    <th>缩略图</th>
						        <th>标题</th>
						        <th>分类</th>
						        <th>发布时间</th>
						        <th>操作</th>
			                </tr>
			            </thead>
			            <tbody>
			            	<?php $cid = 0;
 foreach($this->tpl_var['contents']['data'] as $key => $content){ 
 $cid++; ?>
			            	<tr>
			                    <td><input type="checkbox" name="delids[<?php echo $content['contentid']; ?>]" value="1"></td>
			                    <td><input type="text" name="ids[<?php echo $content['contentid']; ?>]" value="<?php echo $content['contentsequence']; ?>" style="width:24px;padding:2px 5px;"/></td>
			                    <td><?php echo $content['contentid']; ?></td>
			                    <td class="picture"><img src="<?php if($content['contentthumb']){ ?><?php echo $content['contentthumb']; ?><?php } else { ?>app/core/styles/images/noupload.gif<?php } ?>" alt="" style="width:24px;"/></td>
			                    <td>
			                        <?php echo $content['contenttitle']; ?>
			                    </td>
			                    <td>
			                    	<a href="?content-master-contents&catid=<?php echo $content['contentcatid']; ?>" target=""><?php echo $this->tpl_var['categories'][$content['contentcatid']]['catname']; ?></a>
			                    </td>
			                    <td>
			                    	<?php echo date('Y-m-d',$content['contentinputtime']); ?>
			                    </td>
			                    <td class="actions">
			                    	<div class="btn-group">
			                    		<a class="btn" href="index.php?content-master-contents-edit&catid=<?php echo $content['contentcatid']; ?>&contentid=<?php echo $content['contentid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="修改"><em class="icon-edit"></em></a>
										<a class="btn confirm" href="index.php?content-master-contents-del&catid=<?php echo $content['cncatid']; ?>&contentid=<?php echo $content['contentid']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>" title="删除"><em class="icon-remove"></em></a>
			                    	</div>
			                    </td>
			                </tr>
			                <?php } ?>
			        	</tbody>
			        </table>
			        <div class="control-group">
			            <div class="controls">
				            <label class="radio inline">
				                <input type="radio" name="action" value="modify" checked/>排序
				            </label>
				            <!--
				            <label class="radio inline">
				                <input type="radio" name="action" value="moveposition" />推荐
				            </label>
				            -->
				            <label class="radio inline">
				                <input type="radio" name="action" value="copycategory"/>复制
				            </label>
				            <label class="radio inline">
				                <input type="radio" name="action" value="movecategory" />移动
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
					<div class="pagination pagination-right">
						<ul><?php echo $this->tpl_var['contents']['pages']; ?></ul>
					</div>
				</fieldset>
			</form>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>