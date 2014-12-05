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
				<li><a href="index.php?exam-master-rowsquestions-rowsdetail&questionid=<?php echo $this->tpl_var['questionparent']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">子试题列表</a> <span class="divider">/</span></li>
				<li class="active">修改子试题</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">修改子试题</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-master-rowsquestions-rowsdetail&questionid=<?php echo $this->tpl_var['questionparent']; ?>&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">子试题列表</a>
				</li>
			</ul>
			<form action="index.php?exam-master-rowsquestions-modifychildquestion" method="post" class="form-horizontal">
				<fieldset>
				<div class="control-group">
					<label class="control-label">题型：</label>
				  	<div class="controls">
					  	<select needle="needle" msg="您必须为要添加的试题选择一种题型" name="args[questiontype]" class="combox" onchange="javascript:setAnswerHtml($(this).find('option:selected').attr('rel'),'answerbox');">
					  		<?php $qid = 0;
 foreach($this->tpl_var['questypes'] as $key => $questype){ 
 $qid++; ?>
					  		<option rel="<?php if($questype['questsort']){ ?>0<?php } else { ?><?php echo $questype['questchoice']; ?><?php } ?>" value="<?php echo $questype['questid']; ?>"<?php if($questype['questid'] == $this->tpl_var['question']['questiontype']){ ?> selected<?php } ?>><?php echo $questype['questype']; ?></option>
					  		<?php } ?>
					  	</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">题干：</label>
				  	<div class="controls">
					  	<textarea class="ckeditor" name="args[question]" id="question"><?php echo $this->tpl_var['question']['question']; ?></textarea>
					  	<span class="help-block">需要填空处请以()表示。</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">备选项：</label>
				  	<div class="controls">
					  	<textarea class="ckeditor" name="args[questionselect]" id="questionselect"><?php echo $this->tpl_var['question']['questionselect']; ?></textarea>
					  	<span class="help-block">无选择项的请不要填写，如填空题、问答题等主观题。</span>
					</div>
				</div>
				<div class="control-group" id="selectnumber">
					<label for="questionselectnumber" class="control-label">备选项数量：</label>
				  	<div class="controls">
					  	<select name="args[questionselectnumber]" id="questionselectnumber">
					  		<option value="0"<?php if($this->tpl_var['question']['questionselectnumber'] == 0){ ?> selected<?php } ?>>0</option>
					  		<option value="2"<?php if($this->tpl_var['question']['questionselectnumber'] == 2){ ?> selected<?php } ?>>2</option>
					  		<option value="4"<?php if($this->tpl_var['question']['questionselectnumber'] == 4){ ?> selected<?php } ?>>4</option>
					  		<option value="5"<?php if($this->tpl_var['question']['questionselectnumber'] == 5){ ?> selected<?php } ?>>5</option>
					  		<option value="6"<?php if($this->tpl_var['question']['questionselectnumber'] == 6){ ?> selected<?php } ?>>6</option>
					  	</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">参考答案：</label>
					<div class="controls">
						<div id="answerbox_1" class="answerbox"<?php if($this->tpl_var['questypes'][$this->tpl_var['question']['questiontype']]['questchoice'] != 1){ ?> style="display:none;"<?php } ?>>
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer1]" value="A"<?php if($this->tpl_var['question']['questionanswer'] == 'A'){ ?> checked<?php } ?>>A</label>
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer1]" value="B"<?php if($this->tpl_var['question']['questionanswer'] == 'B'){ ?> checked<?php } ?>>B</label>
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer1]" value="C"<?php if($this->tpl_var['question']['questionanswer'] == 'C'){ ?> checked<?php } ?>>C</label>
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer1]" value="D"<?php if($this->tpl_var['question']['questionanswer'] == 'D'){ ?> checked<?php } ?>>D</label>
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer1]" value="E"<?php if($this->tpl_var['question']['questionanswer'] == 'E'){ ?> checked<?php } ?>>E</label>
						</div>
						<div id="answerbox_2" class="answerbox"<?php if($this->tpl_var['questypes'][$this->tpl_var['question']['questiontype']]['questchoice'] != 2){ ?> style="display:none;"<?php } ?>>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer2][]" value="A"<?php if(strpos($this->tpl_var['question']['questionanswer'],'A') !== false){ ?> checked<?php } ?>>A</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer2][]" value="B"<?php if(strpos($this->tpl_var['question']['questionanswer'],'B') !== false){ ?> checked<?php } ?>>B</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer2][]" value="C"<?php if(strpos($this->tpl_var['question']['questionanswer'],'C') !== false){ ?> checked<?php } ?>>C</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer2][]" value="D"<?php if(strpos($this->tpl_var['question']['questionanswer'],'D') !== false){ ?> checked<?php } ?>>D</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer2][]" value="E"<?php if(strpos($this->tpl_var['question']['questionanswer'],'E') !== false){ ?> checked<?php } ?>>E</label>
						</div>
						<div id="answerbox_3" class="answerbox"<?php if($this->tpl_var['questypes'][$this->tpl_var['question']['questiontype']]['questchoice'] != 3){ ?> style="display:none;"<?php } ?>>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer3][]" value="A"<?php if(strpos($this->tpl_var['question']['questionanswer'],'A') !== false){ ?> checked<?php } ?>>A</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer3][]" value="B"<?php if(strpos($this->tpl_var['question']['questionanswer'],'B') !== false){ ?> checked<?php } ?>>B</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer3][]" value="C"<?php if(strpos($this->tpl_var['question']['questionanswer'],'C') !== false){ ?> checked<?php } ?>>C</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer3][]" value="D"<?php if(strpos($this->tpl_var['question']['questionanswer'],'D') !== false){ ?> checked<?php } ?>>D</label>
						  	<label class="checkbox inline"><input type="checkbox" name="targs[questionanswer3][]" value="E"<?php if(strpos($this->tpl_var['question']['questionanswer'],'E') !== false){ ?> checked<?php } ?>>E</label>
						</div>
						<div id="answerbox_4" class="answerbox"<?php if($this->tpl_var['questypes'][$this->tpl_var['question']['questiontype']]['questchoice'] != 4){ ?> style="display:none;"<?php } ?>>
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer4]" value="A"<?php if($this->tpl_var['question']['questionanswer'] == 'A'){ ?> checked<?php } ?>>对</label>
						  	<label class="radio inline"><input type="radio" name="targs[questionanswer4]" value="B"<?php if($this->tpl_var['question']['questionanswer'] == 'B'){ ?> checked<?php } ?>>错</label>
						</div>
						<div id="answerbox_0"<?php if(!$this->tpl_var['questypes'][$this->tpl_var['question']['questiontype']]['questsort']){ ?> style="display:none;"<?php } ?> class="answerbox">
					  		<textarea cols="72" rows="7" class="ckeditor" id="questionanswer0" name="targs[questionanswer0]"><?php echo $this->tpl_var['question']['questionanswer']; ?></textarea>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">习题解析：</label>
				  	<div class="controls">
				  		<textarea class="ckeditor" name="args[questiondescribe]" id="questiondescribe"><?php echo $this->tpl_var['question']['questiondescribe']; ?></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">难度：</label>
				  	<div class="controls">
					  	<select class="combox" name="args[questionlevel]" needle="needle" msg="您必须为要添加的试题设置一个难度">
					  		<option value="1"<?php if($this->tpl_var['question']['questionlevel']==1){ ?> selected<?php } ?>>易</option>
					  		<option value="2"<?php if($this->tpl_var['question']['questionlevel']==2){ ?> selected<?php } ?>>中</option>
					  		<option value="3"<?php if($this->tpl_var['question']['questionlevel']==3){ ?> selected<?php } ?>>难</option>
					  	</select>
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
					  	<button class="btn btn-primary" type="submit">提交</button>
					  	<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
						<input type="hidden" name="args[questionparent]" value="<?php echo $this->tpl_var['questionparent']; ?>"/>
						<input type="hidden" name="questionid" value="<?php echo $this->tpl_var['question']['questionid']; ?>"/>
						<input type="hidden" name="modifyquestion" value="1"/>
						<?php $aid = 0;
 foreach($this->tpl_var['search'] as $key => $arg){ 
 $aid++; ?>
						<input type="hidden" name="search[<?php echo $key; ?>]" value="<?php echo $arg; ?>"/>
						<?php } ?>
					</div>
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