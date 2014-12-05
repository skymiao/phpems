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
					<a href="#">已删试题</a>
				</li>
			</ul>
	        <table class="table table-hover">
	            <thead>
	                <tr>
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
	                    		<a class="btn ajax" href="index.php?exam-master-questions-backquestion&page=<?php echo $this->tpl_var['page']; ?>&questionid=<?php echo $question['questionid']; ?><?php echo $this->tpl_var['u']; ?>" title="恢复本题将会恢复本题下所有已删除子题"><em class="icon-edit"></em></a>
								<a class="btn confirm" href="index.php?exam-master-recyle-finaldelquestion&questionparent=0&page=<?php echo $this->tpl_var['page']; ?>&questionid=<?php echo $question['questionid']; ?><?php echo $this->tpl_var['u']; ?>" title="彻底删除"><em class="icon-remove"></em></a>
	                    	</div>
						</td>
			        </tr>
			        <?php } ?>
	        	</tbody>
	        </table>
			<div class="pagination pagination-right">
				<ul><?php echo $this->tpl_var['questions']['pages']; ?></ul>
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
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>