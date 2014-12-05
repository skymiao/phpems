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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">试卷管理</a> <span class="divider">/</span></li>
				<li class="active">手工组卷修改</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">手工组卷修改</a>
				</li>
				<li class="pull-right">
					<a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-exams&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">试卷管理</a>
				</li>
			</ul>
	        <form action="index.php?exam-master-exams-modify" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label">试卷名称：</label>
			  		<div class="controls">
			  			<input type="text" name="args[exam]" value="<?php echo $this->tpl_var['exam']['exam']; ?>" needle="needle" msg="您必须为该试卷输入一个名称"/>
			  		</div>
				</div>
				<div class="control-group">
					<label class="control-label">评卷方式</label>
					<div class="controls">
						<label class="radio inline">
							<input name="args[examdecide]" type="radio" value="1"<?php if($this->tpl_var['exam']['examdecide']){ ?> checked<?php } ?>/>教师评卷
						</label>
						<label class="radio inline">
							<input name="args[examdecide]" type="radio" value="0"<?php if(!$this->tpl_var['exam']['examdecide']){ ?> checked<?php } ?>/>学生自评
						</label>
						<span class="help-block">教师评卷时有主观题则需要教师在后台评分后才能显示分数，无主观题自动显示分数。</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">考试科目：</label>
				  	<div class="controls">
					  	<label class="radio inline">
						  	<input type="hidden" name="args[examsubject]" value="<?php echo $this->tpl_var['exam']['examsubject']; ?>" />
						  	<?php echo $this->tpl_var['subjects'][$this->tpl_var['exam']['examsubject']]['subject']; ?>
					  	</label>
			  		</div>
				</div>
				<div class="control-group">
					<label class="control-label">考试时间：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][examtime]" size="4" needle="needle" class="inline" value="<?php echo $this->tpl_var['exam']['examsetting']['examtime']; ?>"/> 分钟
			  		</div>
				</div>
				<div class="control-group">
					<label class="control-label">来源：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][comfrom]" value="<?php echo $this->tpl_var['exam']['examsetting']['comfrom']; ?>" size="4"/>
			  		</div>
				</div>
				<div class="control-group">
					<label class="control-label">试卷总分：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][score]" value="<?php echo $this->tpl_var['exam']['examsetting']['score']; ?>" size="4" needle="needle" msg="你要为本考卷设置总分" datatype="number"/>
			  		</div>
				</div>
				<div class="control-group">
					<label class="control-label">及格线：</label>
			  		<div class="controls">
			  			<input type="text" name="args[examsetting][passscore]" value="<?php echo $this->tpl_var['exam']['examsetting']['passscore']; ?>" size="4" needle="needle" msg="你要为本考卷设置一个及格分数线" datatype="number"/>
			  		</div>
				</div>
				<?php $qid = 0;
 foreach($this->tpl_var['questypes'] as $key => $questype){ 
 $qid++; ?>
				<div class="control-group">
					<label class="control-label"><?php echo $questype['questype']; ?>：</label>
					<div class="controls">
						<span class="info">共&nbsp;</span>
						<input id="iselectallnumber_<?php echo $questype['questid']; ?>" type="text" class="input-mini" needle="needle" name="args[examsetting][questype][<?php echo $questype['questid']; ?>][number]" value="<?php echo $this->tpl_var['exam']['examsetting']['questype'][$questype['questid']]['number']; ?>" size="2" msg="您必须填写总题数"/>
						<span class="info">&nbsp;题，每题&nbsp;</span><input class="input-mini" needle="needle" type="text" name="args[examsetting][questype][<?php echo $questype['questid']; ?>][score]" value="<?php echo $this->tpl_var['exam']['examsetting']['questype'][$questype['questid']]['score']; ?>" size="2" msg="您必须填写每题的分值"/>
						<span class="info">&nbsp;分，描述&nbsp;</span><input class="input-mini" type="text" name="args[examsetting][questype][<?php echo $questype['questid']; ?>][describe]" value="<?php echo $this->tpl_var['exam']['examsetting']['questype'][$questype['questid']]['describe']; ?>" size="12"/>
						<span class="info">&nbsp;已选题数：<a id="ialreadyselectnumber_<?php echo $key; ?>"><?php echo intval($this->tpl_var['exam']['examnumber'][$key]); ?></a>&nbsp;&nbsp;题</span>
						<span class="info">&nbsp;<a class="selfmodal btn" href="javascript:;" data-target="#modal" url="index.php?exam-master-exams-selected&questionids={iselectquestions_<?php echo $key; ?>}&rowsquestionids={iselectrowsquestions_<?php echo $key; ?>}" valuefrom="iselectquestions_<?php echo $key; ?>|iselectrowsquestions_<?php echo $key; ?>">看题</a></span>
						<span class="info">&nbsp;<a class="selfmodal btn" href="javascript:;" data-target="#modal" url="index.php?exam-master-exams-selectquestions&search[questionsubjectid]=<?php echo $this->tpl_var['exam']['examsubject']; ?>&search[questiontype]=<?php echo $key; ?>&questionids={iselectquestions_<?php echo $key; ?>}&rowsquestionids={iselectrowsquestions_<?php echo $key; ?>}&useframe=1" valuefrom="iselectquestions_<?php echo $key; ?>|iselectrowsquestions_<?php echo $key; ?>">选题</a></span>
	  					<input type="hidden" id="iselectquestions_<?php echo $key; ?>" name="args[examquestions][<?php echo $key; ?>][questions]" value="<?php echo $this->tpl_var['exam']['examquestions'][$key]['questions']; ?>"/>
	  					<input type="hidden" id="iselectrowsquestions_<?php echo $key; ?>" name="args[examquestions][<?php echo $key; ?>][rowsquestions]" value="<?php echo $this->tpl_var['exam']['examquestions'][$key]['rowsquestions']; ?>"/>
			  		</div>
				</div>
				<?php } ?>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="submitsetting" value="1"/>
						<input name="examid" type="hidden" value="<?php echo $this->tpl_var['exam']['examid']; ?>">
			  		</div>
				</div>
			</form>
			<div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="#myModalLabel">
				<div class="modal-header">
					<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
					<h3 id="myModalLabel">
						试题列表
					</h3>
				</div>
				<div class="modal-body" id="modal-body"></div>
				<div class="modal-footer">
					 <button aria-hidden="true" class="btn" data-dismiss="modal">完成</button>
				</div>
			</div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>