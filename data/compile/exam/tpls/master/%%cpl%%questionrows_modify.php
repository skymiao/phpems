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
				<li class="active">修改题冒题</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">修改题冒题</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-rowsquestions&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">题冒题管理</a>
				</li>
			</ul>
			<form action="?exam-master-rowsquestions-modifyquestion" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label">知识点：</label>
					<div class="controls">
						<textarea cols="72" rows="4" class="input-xxlarge" name="args[qrknowsid]" id="questionknowsid" readonly><?php $kid = 0;
 foreach($this->tpl_var['question']['qrknowsid'] as $key => $know){ 
 $kid++; ?><?php echo $know['knowsid']; ?>:<?php echo $know['knows']; ?><?php echo "
"; ?><?php } ?></textarea>
		  			</div>
		  		</div>
				<div class="control-group">
			  		<div class="controls">
				  		<select class="combox" target="isectionselect" refUrl="index.php?exam-master-questions-ajax-getsectionsbysubjectid&subjectid={value}">
			        		<option value="0">选择科目</option>
					  		<?php $sid = 0;
 foreach($this->tpl_var['subjects'] as $key => $subject){ 
 $sid++; ?>
					  		<option value="<?php echo $subject['subjectid']; ?>"><?php echo $subject['subject']; ?></option>
					  		<?php } ?>
				  		</select>
				  		<select class="combox" id="isectionselect" target="iknowsselect" refUrl="index.php?exam-master-questions-ajax-getknowsbysectionid&sectionid={value}">
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
					<label class="control-label" for="qrtype">题型：</label>
					<div class="controls">
					  	<select id="qrtype" needle="needle" msg="您必须为要添加的试题选择一种题型" name="args[qrtype]">
					  		<?php $qid = 0;
 foreach($this->tpl_var['questypes'] as $key => $questype){ 
 $qid++; ?>
					  		<option rel="<?php if($questype['questsort']){ ?>0<?php } else { ?><?php echo $questype['questchoice']; ?><?php } ?>" value="<?php echo $questype['questid']; ?>"<?php if($questype['questid'] == $this->tpl_var['question']['qrtype']){ ?> selected<?php } ?>><?php echo $questype['questype']; ?></option>
					  		<?php } ?>
					  	</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="qrquestion">题干：</label>
				  	<div class="controls">
				  		<textarea id="qrquestion" class="ckeditor" name="args[qrquestion]" id="question"><?php echo $this->tpl_var['question']['qrquestion']; ?></textarea>
				  		<span class="help-block">需要填空处请以()表示。</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="qrlevel">难度：</label>
				  	<div class="controls">
					  	<select id="qrlevel" name="args[qrlevel]" needle="needle" msg="您必须为要添加的试题设置一个难度">
					  		<option value="1"<?php if($this->tpl_var['question']['qrlevel']==1){ ?> selected<?php } ?>>易</option>
					  		<option value="2"<?php if($this->tpl_var['question']['qrlevel']==2){ ?> selected<?php } ?>>中</option>
					  		<option value="3"<?php if($this->tpl_var['question']['qrlevel']==3){ ?> selected<?php } ?>>难</option>
					  	</select>
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
					  	<button class="btn btn-primary" type="submit">提交</button>
					  	<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
					  	<input type="hidden" name="questionid" value="<?php echo $this->tpl_var['question']['qrid']; ?>"/>
					  	<input type="hidden" name="modifyquestion" value="1"/>
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
