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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-questions">试题管理</a> <span class="divider">/</span></li>
				<li class="active">普通试题管理</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">普通试题管理</a>
				</li>
				<li class="dropdown pull-right">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">添加试题<strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-questions-addquestion&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">单题添加</a></li>
						<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-questions-bataddquestion&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">批量添加</a></li>
						<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-questions-filebataddquestion&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">CSV导入</a></li>
					</ul>
				</li>
			</ul>
			<form action="index.php?exam-master-questions" method="post">
				<table class="table">
					<thead>
		                <tr>
					        <th colspan="2">搜索</th>
					        <th></th>
					        <th></th>
					        <th></th>
					        <th></th>
		                </tr>
		            </thead>
					<tr>
						<td>
							试题ID：
						</td>
						<td>
							<input name="search[questionid]" class="input-small" size="25" type="text" class="number" value="<?php echo $this->tpl_var['search']['questionid']; ?>"/>
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
							科目：
						</td>
						<td>
			        		<select name="search[questionsubjectid]" class="combox input-medium" target="sectionselect" refUrl="?exam-master-questions-ajax-getsectionsbysubjectid&subjectid={value}">
				        		<option value="0">选择科目</option>
						  		<?php $sid = 0;
 foreach($this->tpl_var['subjects'] as $key => $subject){ 
 $sid++; ?>
						  		<option value="<?php echo $subject['subjectid']; ?>"<?php if($subject['subjectid'] == $this->tpl_var['search']['questionsubjectid']){ ?> selected<?php } ?>><?php echo $subject['subject']; ?></option>
						  		<?php } ?>
					  		</select>
			        	</td>
			        	<td>
							章节：
						</td>
						<td>
					  		<select name="search[questionsectionid]" class="combox input-medium" id="sectionselect" target="knowsselect" refUrl="?exam-master-questions-ajax-getknowsbysectionid&sectionid={value}">
					  		<option value="0">选择章节</option>
					  		<?php if($this->tpl_var['sections']){ ?>
					  		<?php $sid = 0;
 foreach($this->tpl_var['sections'] as $key => $section){ 
 $sid++; ?>
					  		<option value="<?php echo $section['sectionid']; ?>"<?php if($section['sectionid'] == $this->tpl_var['search']['questionsectionid']){ ?> selected<?php } ?>><?php echo $section['section']; ?></option>
					  		<?php } ?>
					  		<?php } ?>
					  		</select>
			        	</td>
			        	<td>
							知识点：
						</td>
						<td>
					  		<select name="search[questionknowsid]" id="knowsselect" class="input-medium">
						  		<option value="">选择知识点</option>
						  		<?php if($this->tpl_var['knows']){ ?>
						  		<?php $kid = 0;
 foreach($this->tpl_var['knows'] as $key => $know){ 
 $kid++; ?>
						  		<option value="<?php echo $know['knowsid']; ?>"<?php if($know['knowsid'] == $this->tpl_var['search']['questionknowsid']){ ?> selected<?php } ?>><?php echo $know['knows']; ?></option>
						  		<?php } ?>
						  		<?php } ?>
					  		</select>
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
							试题类型：
						</td>
						<td>
							<select name="search[questiontype]" class="input-medium">
						  		<option value="0">类型不限</option>
						  		<?php $qid = 0;
 foreach($this->tpl_var['questypes'] as $key => $questype){ 
 $qid++; ?>
						  		<option value="<?php echo $questype['questid']; ?>"><?php echo $questype['questype']; ?></option>
						  		<?php } ?>
					  		</select>
						</td>
						<td>
							难度：
						</td>
						<td>
							<select name="search[questionlevel]" class="input-medium">
						  		<option value="0">难度不限</option>
								<option value="1"<?php if($this->tpl_var['search']['questionlevel'] == 1){ ?> checked<?php } ?>>易</option>
								<option value="2"<?php if($this->tpl_var['search']['questionlevel'] == 2){ ?> checked<?php } ?>>中</option>
								<option value="3"<?php if($this->tpl_var['search']['questionlevel'] == 3){ ?> checked<?php } ?>>难</option>
					  		</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<button class="btn btn-primary" type="submit">搜索</button>
							<input type="hidden" value="1" name="search[argsmodel]" />
						</td>
						<td colspan="4"></td>
					</tr>
				</table>
			</form>
			<form action="index.php?exam-master-questions-batdel" method="post">
				<fieldset>
					<table class="table table-hover">
			            <thead>
			                <tr>
			                    <th><input type="checkbox" class="checkall" target="delids"/></th>
			                    <th>ID</th>
						        <th>试题类型</th>
						        <th>试题内容</th>
						        <th>录入人</th>
						        <th>录入时间</th>
						        <th>难度</th>
						        <th>操作</th>
			                </tr>
			            </thead>
			            <tbody>
		                    <?php $qid = 0;
 foreach($this->tpl_var['questions']['data'] as $key => $question){ 
 $qid++; ?>
					        <tr>
								<td><input type="checkbox" name="delids[<?php echo $question['questionid']; ?>]" value="1"></td>
								<td>
									<?php echo $question['questionid']; ?>
								</td>
								<td>
									<?php echo $this->tpl_var['questypes'][$question['questiontype']]['questype']; ?>
								</td>
								<td>
									<a title="查看试题" class="selfmodal" href="javascript:;" url="index.php?exam-master-questions-detail&questionid=<?php echo $question['questionid']; ?>" data-target="#modal"><?php echo $this->G->make('strings')->subString(strip_tags(html_entity_decode($question['question'])),135); ?></a>
								</td>
								<td>
									<?php echo $question['questionusername']; ?>
								</td>
								<td>
									<?php echo date('Y-m-d',$question['questioncreatetime']); ?>
								</td>
								<td>
									<?php if($question['questionlevel']==2){ ?>中<?php } elseif($question['questionlevel']==3){ ?>难<?php } elseif($question['questionlevel']==1){ ?>易<?php } ?>
								</td>
								<td>
									<div class="btn-group">
			                    		<a class="btn" href="index.php?exam-master-questions-modifyquestion&page=<?php echo $this->tpl_var['page']; ?>&questionid=<?php echo $question['questionid']; ?><?php echo $this->tpl_var['u']; ?>" title="修改"><em class="icon-edit"></em></a>
										<a class="btn confirm" href="index.php?exam-master-questions-delquestion&questionparent=0&page=<?php echo $this->tpl_var['page']; ?>&questionid=<?php echo $question['questionid']; ?><?php echo $this->tpl_var['u']; ?>" title="删除"><em class="icon-remove"></em></a>
			                    	</div>
								</td>
					        </tr>
					        <?php } ?>
			        	</tbody>
			        </table>
			        <div class="control-group">
			            <div class="controls">
				            <label class="radio inline">
				                <input type="radio" name="action" value="delete" checked/>删除
				            </label>
				            <?php $sid = 0;
 foreach($this->tpl_var['search'] as $key => $arg){ 
 $sid++; ?>
				            <input type="hidden" name="search[<?php echo $key; ?>]" value="<?php echo $arg; ?>"/>
				            <?php } ?>
				            <label class="radio inline">
				            	<button class="btn btn-primary" type="submit">提交</button>
				            </label>
				            <input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
				        </div>
			        </div>
			        <div class="pagination pagination-right">
			            <ul><?php echo $this->tpl_var['questions']['pages']; ?></ul>
			        </div>
		        </fieldset>
			</form>
	        <div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel">
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
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>