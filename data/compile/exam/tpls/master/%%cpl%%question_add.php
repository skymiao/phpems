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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-questions&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">普通试题管理</a> <span class="divider">/</span></li>
				<li class="active">添加普通试题</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加普通试题</a>
				</li>
				<li class="pull-right">
					<a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-questions&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">普通试题管理</a>
				</li>
			</ul>
			<form action="index.php?exam-master-questions-addquestion" method="post" class="form-horizontal">
				<fieldset>
				<div class="control-group">
					<label class="control-label">知识点：</label>
				  	<div class="controls">
				  		<textarea class="input-xxlarge" rows="4" needle="needle" min="1" msg="您最少需要选定一个知识点" name="args[questionknowsid]" id="questionknowsid" readonly></textarea>
					</div>
				</div>
				<div class="control-group">
			  		<div class="controls">
				  		<select class="combox" target="isectionselect" refUrl="?exam-master-questions-ajax-getsectionsbysubjectid&subjectid={value}">
			        		<option value="0">选择科目</option>
					  		<?php $sid = 0;
 foreach($this->tpl_var['subjects'] as $key => $subject){ 
 $sid++; ?>
					  		<option value="<?php echo $subject['subjectid']; ?>"><?php echo $subject['subject']; ?></option>
					  		<?php } ?>
				  		</select>
				  		<select class="combox" id="isectionselect" target="iknowsselect" refUrl="?exam-master-questions-ajax-getknowsbysectionid&sectionid={value}">
				  			<option value="0">选择章节</option>
				  		</select>
				  		<select class="combox" id="iknowsselect">
				  		<option value="0">选择知识点</option>
				  		</select>
					</div>
				</div>
				<div class="control-group">
			  		<div class="controls">
			  			<input type="button" class="btn" value="选定" onclick="javascript:setKnowsList('questionknowsid','iknowsselect','+');"/>
			  			<input type="button" class="btn" value="清除" onclick="javascript:setKnowsList('questionknowsid','iknowsselect','-');"/>
					</div>
				</div>
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
				<div class="input" id="selectnumber">
					<label class="control-label">备选项数量：</label>
				  	<div class="controls">
					  	<select class="combox" name="args[questionselectnumber]">
					  		<option value="0">0</option>
					  		<option value="2">2</option>
					  		<option value="4" selected>4</option>
					  		<option value="5">5</option>
					  		<option value="6">6</option>
					  	</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">参考答案：</label>
					<div class="controls">
						<div id="answerbox_1" class="answerbox">
						  	<label class="radio inline">
						  		<input type="radio" name="targs[questionanswer1]" value="A" checked>A
						  	</label>
						  	<label class="radio inline">
						  		<input type="radio" name="targs[questionanswer1]" value="B">B
						  	</label>
						  	<label class="radio inline">
						  		<input type="radio" name="targs[questionanswer1]" value="C">C
						  	</label>
						  	<label class="radio inline">
						  		<input type="radio" name="targs[questionanswer1]" value="D">D
						  	</label>
						  	<label class="radio inline">
						  		<input type="radio" name="targs[questionanswer1]" value="E">E
						  	</label>
						</div>
						<div id="answerbox_2" style="display:none;" class="answerbox">
						  	<label class="checkbox inline">
						  		<input type="checkbox" name="targs[questionanswer2][]" value="A">A
						  	</label>
						  	<label class="checkbox inline">
						  		<input type="checkbox" name="targs[questionanswer2][]" value="B">B
						  	</label>
						  	<label class="checkbox inline">
						  		<input type="checkbox" name="targs[questionanswer2][]" value="C">C
						  	</label>
						  	<label class="checkbox inline">
						  		<input type="checkbox" name="targs[questionanswer2][]" value="D">D
						  	</label>
						  	<label class="checkbox inline">
						  		<input type="checkbox" name="targs[questionanswer2][]" value="E">E
						  	</label>
						</div>
						<div id="answerbox_3" style="display:none;" class="answerbox">
						  	<label class="checkbox inline">
						  		<input type="checkbox" name="targs[questionanswer3][]" value="A">A
						  	</label>
						  	<label class="checkbox inline">
						  		<input type="checkbox" name="targs[questionanswer3][]" value="B">B
						  	</label>
						  	<label class="checkbox inline">
						  		<input type="checkbox" name="targs[questionanswer3][]" value="C">C
						  	</label>
						  	<label class="checkbox inline">
						  		<input type="checkbox" name="targs[questionanswer3][]" value="D">D
						  	</label>
						  	<label class="checkbox inline">
						  		<input type="checkbox" name="targs[questionanswer3][]" value="E">E
						  	</label>
						</div>
						<div id="answerbox_4" class="answerbox" style="display:none;">
						  	<label class="radio inline">
						  		<input type="radio" name="targs[questionanswer4]" value="A" checked>对
						  	</label>
						  	<label class="radio inline">
						  		<input type="radio" name="targs[questionanswer4]" value="B">错
						  	</label>
						</div>
						<div id="answerbox_0" style="display:none;" class="answerbox">
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
					  		<option value="1"<?php if(!$this->tpl_var['question']['questionlevel']==1){ ?> selected<?php } ?>>易</option>
					  		<option value="2"<?php if(!$this->tpl_var['question']['questionlevel']==2){ ?> selected<?php } ?>>中</option>
					  		<option value="3"<?php if(!$this->tpl_var['question']['questionlevel']==3){ ?> selected<?php } ?>>难</option>
					  	</select>
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
					  	<button class="btn btn-primary" type="submit">提交</button>
					  	<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
					  	<input type="hidden" name="insertquestion" value="1"/>
					  	<?php $aid = 0;
 foreach($this->tpl_var['search'] as $key => $arg){ 
 $aid++; ?>
						<input type="hidden" name="search[<?php echo $key; ?>]" value="<?php echo $arg; ?>"/>
						<?php } ?>
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