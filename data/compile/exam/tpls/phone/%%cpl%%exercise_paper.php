<?php $this->_compileInclude('header'); ?>
<body>
<script src="app/exam/styles/js/plugin.js"></script>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<form class="examform form-horizontal" id="form1" name="form1" action="index.php?exam-phone-exercise-score">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam-phone">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-phone-basics"><?php echo $this->tpl_var['data']['currentbasic']['basic']; ?></a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-phone-exercise">强化训练</a> <span class="divider">/</span>
					</li>
					<li class="active">
						<?php echo $this->tpl_var['sessionvars']['examsession']; ?>
					</li>
				</ul>
				<h3 class="text-center"><?php echo $this->tpl_var['sessionvars']['examsession']; ?></h3>
				<?php $oid = 0; ?>
				<?php $qid = 0;
 foreach($this->tpl_var['questype'] as $key => $quest){ 
 $qid++; ?>
				<?php if($this->tpl_var['sessionvars']['examsessionquestion']['questions'][$quest['questid']] || $this->tpl_var['sessionvars']['examsessionquestion']['questionrows'][$quest['questid']]){ ?>
				<?php $oid++; ?>
				<div id="panel-type<?php echo $quest['questid']; ?>" class="tab-pane<?php if((!$this->tpl_var['ctype'] && $qid == 1) || ($this->tpl_var['ctype'] == $quest['questid'])){ ?> active<?php } ?>">
					<ul class="breadcrumb">
						<li>
							<h5><?php echo $oid; ?>、<?php echo $quest['questype']; ?></h5>
						</li>
					</ul>
					<?php $tid = 0; ?>
	                <?php $qnid = 0;
 foreach($this->tpl_var['sessionvars']['examsessionquestion']['questions'][$quest['questid']] as $key => $question){ 
 $qnid++; ?>
	                <?php $tid++; ?>
	                <div id="question_<?php echo $question['questionid']; ?>" class="paperexamcontent">
						<div class="media well">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge badge-info questionindex"><?php echo $tid; ?></span></a>
								</li>
								<li class="btn-group pull-right">
									<button class="btn" type="button" onclick="javascript:favorquestion('<?php echo $question['questionid']; ?>');"><em class="icon-heart" title="收藏"></em></button>
								</li>
							</ul>
							<div class="media-body well text-warning">
								<a name="question_<?php echo $question['questionid']; ?>"></a><?php echo html_entity_decode($this->ev->stripSlashes($question['question'])); ?>
							</div>
							<?php if(!$quest['questsort']){ ?>
							<div class="media-body well">
		                    	<?php echo html_entity_decode($this->ev->stripSlashes($question['questionselect'])); ?>
		                    </div>
							<div class="media-body well">
		                    	<?php if($quest['questchoice'] == 1 || $quest['questchoice'] == 4){ ?>
			                        <?php $sid = 0;
 foreach($this->tpl_var['selectorder'] as $key => $so){ 
 $sid++; ?>
			                        <?php if($key == $question['questionselectnumber']){ ?>
			                        <?php break;; ?>
			                        <?php } ?>
			                        <label class="radio inline"><input type="radio" name="question[<?php echo $question['questionid']; ?>]" rel="<?php echo $question['questionid']; ?>" value="<?php echo $so; ?>" <?php if($so == $this->tpl_var['sessionvars']['examsessionuseranswer'][$question['questionid']]){ ?>checked<?php } ?>/><?php echo $so; ?> </label>
			                        <?php } ?>
		                        <?php } else { ?>
			                        <?php $sid = 0;
 foreach($this->tpl_var['selectorder'] as $key => $so){ 
 $sid++; ?>
			                        <?php if($key >= $question['questionselectnumber']){ ?>
			                        <?php break;; ?>
			                        <?php } ?>
			                        <label class="checkbox inline"><input type="checkbox" name="question[<?php echo $question['questionid']; ?>][<?php echo $key; ?>]" rel="<?php echo $question['questionid']; ?>" value="<?php echo $so; ?>" <?php if(in_array($so,$this->tpl_var['sessionvars']['examsessionuseranswer'][$question['questionid']])){ ?>checked<?php } ?>/><?php echo $so; ?> </label>
			                        <?php } ?>
		                        <?php } ?>
		                    </div>
							<?php } else { ?>
							<div class="media-body well">
								<?php $this->tpl_var['dataid'] = $question['questionid']; ?>
								<textarea class="jckeditor" etype="simple" id="editor<?php echo $this->tpl_var['dataid']; ?>" name="question[<?php echo $this->tpl_var['dataid']; ?>]" rel="<?php echo $question['questionid']; ?>"><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['sessionvars']['examsessionuseranswer'][$this->tpl_var['dataid']])); ?></textarea>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
					<?php $qrid = 0;
 foreach($this->tpl_var['sessionvars']['examsessionquestion']['questionrows'][$quest['questid']] as $key => $questionrow){ 
 $qrid++; ?>
	                <?php $tid++; ?>
	                <div id="questionrow_<?php echo $questionrow['qrid']; ?>">
						<div class="media well">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge badge-info questionindex"><?php echo $tid; ?></span>
								</li>
							</ul>
							<div class="media-body well">
								<?php echo html_entity_decode($this->ev->stripSlashes($questionrow['qrquestion'])); ?>
							</div>
							<?php $did = 0;
 foreach($questionrow['data'] as $key => $data){ 
 $did++; ?>
							<div class="paperexamcontent">
								<ul class="nav nav-tabs">
									<li class="active">
										<span class="badge questionindex"><?php echo $did; ?></span></a>
									</li>
									<li class="btn-group pull-right">
										<button class="btn" type="button" onclick="javascript:favorquestion('<?php echo $data['questionid']; ?>');"><em class="icon-heart" title="收藏"></em></button>
									</li>
								</ul>
								<div class="media-body well text-warning">
									<a name="question_<?php echo $data['questionid']; ?>"></a><?php echo html_entity_decode($this->ev->stripSlashes($data['question'])); ?>
								</div>
								<?php if(!$quest['questsort']){ ?>
								<div class="media-body well">
			                    	<?php echo html_entity_decode($this->ev->stripSlashes($data['questionselect'])); ?>
			                    </div>
								<div class="media-body well">
			                    	<?php if($quest['questchoice'] == 1 || $quest['questchoice'] == 4){ ?>
				                        <?php $sid = 0;
 foreach($this->tpl_var['selectorder'] as $key => $so){ 
 $sid++; ?>
				                        <?php if($key == $data['questionselectnumber']){ ?>
				                        <?php break;; ?>
				                        <?php } ?>
				                        <label class="radio inline"><input type="radio" name="question[<?php echo $data['questionid']; ?>]" rel="<?php echo $data['questionid']; ?>" value="<?php echo $so; ?>" <?php if($so == $this->tpl_var['sessionvars']['examsessionuseranswer'][$data['questionid']]){ ?>checked<?php } ?>/><?php echo $so; ?> </label>
				                        <?php } ?>
			                        <?php } else { ?>
				                        <?php $sid = 0;
 foreach($this->tpl_var['selectorder'] as $key => $so){ 
 $sid++; ?>
				                        <?php if($key >= $data['questionselectnumber']){ ?>
				                        <?php break;; ?>
				                        <?php } ?>
				                        <label class="checkbox inline"><input type="checkbox" name="question[<?php echo $data['questionid']; ?>][<?php echo $key; ?>]" rel="<?php echo $data['questionid']; ?>" value="<?php echo $so; ?>" <?php if(in_array($so,$this->tpl_var['sessionvars']['examsessionuseranswer'][$data['questionid']])){ ?>checked<?php } ?>/><?php echo $so; ?> </label>
				                        <?php } ?>
			                        <?php } ?>
			                    </div>
								<?php } else { ?>
								<div class="media-body well">
									<?php $this->tpl_var['dataid'] = $data['questionid']; ?>
									<textarea class="jckeditor" etype="simple" id="editor<?php echo $this->tpl_var['dataid']; ?>" name="question[<?php echo $this->tpl_var['dataid']; ?>]" rel="<?php echo $data['questionid']; ?>"><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['sessionvars']['examsessionuseranswer'][$this->tpl_var['dataid']])); ?></textarea>
								</div>
								<?php } ?>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
				<?php } ?>
				<div aria-hidden="true" id="submodal" class="modal hide fade" role="dialog" aria-labelledby="#mySubModalLabel">
					<div class="modal-header">
						<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
						<h3 id="mySubModalLabel">
							交卷
						</h3>
					</div>
					<div class="modal-body" id="modal-body" style="max-height:100%;">
						<p>您确认要交卷吗？</p>
					</div>
					<div class="modal-footer">
						 <button onclick="javascript:submitPaper();" type="button" class="btn btn-primary">确定交卷</button>
						 <input type="hidden" name="insertscore" value="1"/>
						 <button aria-hidden="true" class="btn" data-dismiss="modal">再检查一下</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="container toolcontent">
		<div class="footcontent">
			<div class="span8">
				<ul class="unstyled">
					<li><h4><img src="app/core/styles/images/icons/Watches.png" style="width:1.2em;"/> <span id="timer_h">00</span>：<span id="timer_m">00</span>：<span id="timer_s">00</span></h4></li>
				</ul>
			</div>
			<div class="span4">
				<ul class="unstyled">
					<li class="text-right"><a href="#submodal" role="button" class="btn btn-primary" data-toggle="modal"> 交 卷 </a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$.get('index.php?exam-phone-index-ajax-lefttime&rand'+Math.random(),function(data){
		var setting = {
			time:<?php echo $this->tpl_var['sessionvars']['examsessiontime']; ?>,
			hbox:$("#timer_h"),
			mbox:$("#timer_m"),
			sbox:$("#timer_s"),
			finish:function(){submitPaper();}
		}
		setting.lefttime = parseInt(data);
		countdown(setting);
	});
	setInterval(refreshRecord,5000);
	setInterval(saveanswer,300000);

	$('.allquestionnumber').html($('.paperexamcontent').length);
	$('.yesdonumber').html($('#modal-body .badge-info').length);

	initData = $.parseJSON(storage.getItem('questions'));
	if(initData){
		for(var p in initData){
			if(p!='set')
			formData[p]=initData[p];
		}

		var textarea = $('#form1 textarea');
		$.each(textarea,function(){
			var _this = $(this);
			_this.val(initData[_this.attr('name')]);
			CKEDITOR.instances[_this.attr('id')].setData(initData[_this.attr('name')]);
			markQuestion(_this.attr('rel'),true);
		});

		var texts = $('#form1 :input[type=text]');
		$.each(texts,function(){
			var _this = $(this);
			_this.val(initData[_this.attr('name')]);
			markQuestion(_this.attr('rel'),true);
		});

		var radios = $('#form1 :input[type=radio]');
		$.each(radios,function(){
			var _= this, v = initData[_.name];
			var _this = $(this);
			if(v!=''&&v==_.value){
				_.checked = true;
			}else{
				_.checked=false;
			}
			markQuestion(_this.attr('rel'));
		});

		var checkboxs=$('#form1 :input[type=checkbox]');
		$.each(checkboxs,function(){
			var _=this,v=initData[_.name];
			var _this = $(this);
			if(v!=''&&v==_.value){
				_.checked=true;
			}else{
				_.checked=false;
			}
			markQuestion(_this.attr('rel'));
		});
	}

	$('#form1 :input[type=text]').change(function(){
		var _this=$(this);
		var p=[];
		p.push(_this.attr('name'));
		p.push(_this.val());
		set.apply(formData,p);
		markQuestion(_this.attr('rel'));
	});

	$('#form1 :input[type=radio]').change(function(){
		var _=this;
		var _this=$(this);
		var p=[];
		p.push(_.name);
		if(_.checked){
			p.push(_.value);
			set.apply(formData,p);
		}else{
			p.push('');
			set.apply(formData,p);
		}
		markQuestion(_this.attr('rel'));
	});

	$('#form1 textarea').change(function(){
		var _= this;
		var _this=$(this);
		var p=[];
		p.push(_.name);
		p.push(_.value);
		set.apply(formData,p);
		markQuestion(_this.attr('rel'));
	});

	$('#form1 :input[type=checkbox]').change(function(){
		var _= this;
		var _this = $(this);
		var p=[];
		p.push(_.name);
		if(_.checked){
			p.push(_.value);
			set.apply(formData,p);
		}else{
			p.push('');
			set.apply(formData,p);
		}
		markQuestion(_this.attr('rel'));
	});
});
</script>
<?php $this->_compileInclude('foot'); ?>
</body>
</html>