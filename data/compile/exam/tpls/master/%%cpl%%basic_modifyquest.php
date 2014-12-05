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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-basic-questype">题型管理</a> <span class="divider">/</span></li>
				<li class="active">修改题型</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">修改题型</a>
				</li>
				<li class="pull-right">
					<a href="index.php?exam-master-basic-questype&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">题型管理</a>
				</li>
			</ul>
	        <form action="index.php?exam-master-basic-modifyquestype" method="post" class="form-horizontal">
				<fieldset>
				<div class="control-group">
					<label for="questype" class="control-label">题型名称：</label>
					<div class="controls">
						<input name="args[questype]" id="questype" type="text" size="30" value="<?php echo $this->tpl_var['quest']['questype']; ?>" class="required" alt="请输入题型名称" />
					</div>
				</div>
				<div class="control-group">
					<label for="questsort" class="control-label">题型分类：</label>
					<div class="controls">
						<select class="combox" id="questsort" name="args[questsort]" onchange="javascript:if($(this).val() == '1')$('#choicebox').hide();else $('#choicebox').show();">
							<option value="1"<?php if($this->tpl_var['quest']['questsort']){ ?> selected<?php } ?>>主观题</option>
  							<option value="0"<?php if(!$this->tpl_var['quest']['questsort']){ ?> selected<?php } ?>>客观题</option>
						</select>
					</div>
				</div>
				<div id="choicebox" class="control-group"<?php if($this->tpl_var['quest']['questsort']){ ?> style="display:none;"<?php } ?>>
					<label for="questchoice" class="control-label">选项分类：</label>
					<div class="controls">
						<select class="combox" name="args[questchoice]" id="questchoice">
							<option value="1"<?php if($this->tpl_var['quest']['questchoice']==1){ ?> selected<?php } ?>>单选</option>
	  						<option value="2"<?php if($this->tpl_var['quest']['questchoice']==2){ ?> selected<?php } ?>>多选</option>
	  						<option value="3"<?php if($this->tpl_var['quest']['questchoice']==3){ ?> selected<?php } ?>>不定项选</option>
	  						<option value="4"<?php if($this->tpl_var['quest']['questchoice']==4){ ?> selected<?php } ?>>判断</option>
						</select>
						<span class="help-block">不定项选按照选对答案数给分，判断题将自动生成判断选项。</span>
					</div>
				</div>
				<div class="control-group">
				  	<div class="controls">
					  	<button class="btn btn-primary" type="submit">提交</button>
					  	<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
					  	<input type="hidden" name="questid" value="<?php echo $this->tpl_var['quest']['questid']; ?>"/>
						<input type="hidden" name="modifyquestype" value="1"/>
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