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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-rowsquestions&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">题冒题管理</a> <span class="divider">/</span></li>
				<li class="active">子试题列表</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">子试题列表</a>
				</li>
				<li class="dropdown pull-right">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">添加子试题<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-rowsquestions-addchildquestion&questionid=<?php echo $this->tpl_var['questionparent']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">单题添加</a></li>
						<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-rowsquestions-bataddchildquestion&questionid=<?php echo $this->tpl_var['questionparent']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">批量添加</a></li>
					</ul>
				</li>
			</ul>
			<form action="index.php?exam-master-rowsquestions-done" method="post">
				<table class="table table-hover">
					<thead>
						<tr>
					        <th>题冒</th>
					        <th></th>
						</tr>
					</thead>
					<tbody>
				        <tr>
				          <td width="100">所属知识点：</td>
				          <td><?php $kid = 0;
 foreach($this->tpl_var['question']['qrknowsid'] as $key => $know){ 
 $kid++; ?>&nbsp;<?php echo $know['knows']; ?><?php } ?>&nbsp;</td>
				        </tr>
				        <tr>
				          <td>题帽：</td>
				          <td><?php echo html_entity_decode($this->tpl_var['question']['qrquestion']); ?></td>
				        </tr>
			        </tbody>
				</table>
				<div class="input">&nbsp;</div>
				<table class="table table-hover">
					<thead>
						<tr>
					        <th>ID</th>
					        <th>排序</th>
					        <th>试题类型</th>
					        <th>试题内容</th>
					        <th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php $qid = 0;
 foreach($this->tpl_var['question']['data'] as $key => $question){ 
 $qid++; ?>
						<tr>
							<td><?php echo $question['questionid']; ?></td>
							<td><input style="width:24px;padding:2px 5px;" type="text" name="sequence[<?php echo $question['questionid']; ?>]" value="<?php echo $question['questionsequence']; ?>" /></td>
							<td><?php echo $this->tpl_var['questypes'][$question['questiontype']]['questype']; ?></td>
							<td>
								<a title="查看试题" class="selfmodal" href="javascript:;" url="index.php?exam-master-questions-detail&questionid=<?php echo $question['questionid']; ?>" title="查看试题" data-target="#modal"><?php echo strip_tags(html_entity_decode($question['question'])); ?></a>
							</td>
							<td>
								<div class="btn-group">
		                    		<a class="btn" href="index.php?exam-master-rowsquestions-modifychildquestion&page=<?php echo $this->tpl_var['page']; ?>&questionparent=<?php echo $this->tpl_var['question']['qrid']; ?>&questionid=<?php echo $question['questionid']; ?><?php echo $this->tpl_var['u']; ?>" title="修改"><em class="icon-edit"></em></a>
									<a class="btn confirm" href="index.php?exam-master-rowsquestions-delchildquestion&questionparent=<?php echo $this->tpl_var['question']['qrid']; ?>&page=<?php echo $this->tpl_var['page']; ?>&questionid=<?php echo $question['questionid']; ?><?php echo $this->tpl_var['u']; ?>" title="删除"><em class="icon-remove"></em></a>
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
			            <input type="hidden" name="modifyfieldsequence" value="1"/>
  						<input type="hidden" name="questionparent" value="<?php echo $this->tpl_var['questionparent']; ?>"/>
			            <input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
			        </div>
		        </div>
		        <div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="#myModalLabel">
					<div class="modal-header">
						<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
						<h3 id="myModalLabel">
							试题详情
						</h3>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer">
						 <button aria-hidden="true" class="btn" data-dismiss="modal">关闭</button>
					</div>
				</div>
			</form>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>