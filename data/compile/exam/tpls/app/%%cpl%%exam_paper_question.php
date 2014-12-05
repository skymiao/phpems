<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="#myModalLabel">
	<div class="modal-header">
		<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
		<h3 id="myModalLabel">
			试题列表
		</h3>
	</div>
	<div class="modal-body" id="modal-body" style="max-height:560px;">
		<?php $oid = 0; ?>
		<?php $qmid = 0; ?>
    	<?php $qid = 0;
 foreach($this->tpl_var['questype'] as $key => $quest){ 
 $qid++; ?>
    	<?php if($this->tpl_var['sessionvars']['examsessionquestion']['questions'][$quest['questid']] || $this->tpl_var['sessionvars']['examsessionquestion']['questionrows'][$quest['questid']]){ ?>
        <?php $oid++; ?>
        <dl class="clear">
        	<dt class="float_l"><b><?php echo $oid; ?>、<?php echo $quest['questype']; ?></b></dt>
            <dd>
            	<?php $tid = 0; ?>
                <?php $qnid = 0;
 foreach($this->tpl_var['sessionvars']['examsessionquestion']['questions'][$quest['questid']] as $key => $question){ 
 $qnid++; ?>
                <?php $tid++; ?>
                <?php $qmid++; ?>
            	<a id="sign_<?php echo $question['questionid']; ?>" href="javascript:;" onclick="javascript:gotoquestion(<?php echo $question['questionid']; ?>,<?php echo $quest['questid']; ?>);" rel="0" class="badge questionindex<?php if($this->tpl_var['sessionvars']['examsessionsign'][$question['questionid']]){ ?> signBorder<?php } ?>"><?php echo $tid; ?></a>
            	<?php } ?>
            	<?php $qrid = 0;
 foreach($this->tpl_var['sessionvars']['examsessionquestion']['questionrows'][$quest['questid']] as $key => $questionrow){ 
 $qrid++; ?>
                <?php $tid++; ?>
                <?php $did = 0;
 foreach($questionrow['data'] as $key => $data){ 
 $did++; ?>
                <?php $qmid++; ?>
				<a id="sign_<?php echo $data['questionid']; ?>" href="javascript:;" onclick="javascript:gotoquestion(<?php echo $data['questionid']; ?>,<?php echo $quest['questid']; ?>);" rel="0" class="badge questionindex<?php if($this->tpl_var['sessionvars']['examsessionsign'][$data['questionid']]){ ?> signBorder<?php } ?>"><?php echo $tid; ?>-<?php echo $did; ?></a>
                <?php } ?>
                <?php } ?>
            </dd>
        </dl>
        <?php } ?>
        <?php } ?>
	</div>
	<div class="modal-footer">
		 <button aria-hidden="true" class="btn" data-dismiss="modal">隐藏</button>
	</div>
</div>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<form class="examform form-horizontal" id="form1" name="form1" method="post" action="index.php?exam-app-exam-score">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-basics"><?php echo $this->tpl_var['data']['currentbasic']['basic']; ?></a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-exam">正式考试</a> <span class="divider">/</span>
					</li>
					<li class="active">
						<?php echo $this->tpl_var['sessionvars']['examsession']; ?>
					</li>
				</ul>
				<h3 class="text-center"><?php echo $this->tpl_var['sessionvars']['examsession']; ?></h3>
				<?php $oid = 0; ?>
				<?php $qcid = 0; ?>
				<?php $qid = 0;
 foreach($this->tpl_var['questype'] as $key => $quest){ 
 $qid++; ?>
				<?php if($this->tpl_var['sessionvars']['examsessionquestion']['questions'][$quest['questid']] || $this->tpl_var['sessionvars']['examsessionquestion']['questionrows'][$quest['questid']]){ ?>
				<?php $oid++; ?>
				<div id="panel-type-<?php echo $quest['questid']; ?>" class="questionpanel tab-pane<?php if((!$this->tpl_var['ctype'] && $qid == 1) || ($this->tpl_var['ctype'] == $quest['questid'])){ ?> active<?php } ?>">
					<ul class="breadcrumb">
						<li>
							<h5><?php echo $oid; ?>、<?php echo $quest['questype']; ?><?php echo $this->tpl_var['sessionvars']['examsessionsetting']['examsetting']['questype'][$quest['questid']]['describe']; ?></h5>
						</li>
					</ul>
					<?php $tid = 0; ?>
	                <?php $qnid = 0;
 foreach($this->tpl_var['sessionvars']['examsessionquestion']['questions'][$quest['questid']] as $key => $question){ 
 $qnid++; ?>
	                <?php $tid++; ?>
	                <?php $qcid++; ?>
	                <div id="question_<?php echo $question['questionid']; ?>" class="paperexamcontent">
						<div class="media well">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge badge-info questionindex"><?php echo $tid; ?></span></a>
								</li>
								<li class="btn-group pull-right">
									<button class="btn" type="button" onclick="javascript:signQuestion('<?php echo $question['questionid']; ?>',this);"><em class="<?php if($this->tpl_var['sessionvars']['examsessionsign'][$question['questionid']]){ ?>icon-star<?php } else { ?>icon-star-empty<?php } ?>" title="标注"></em></button>
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
							<div class="media-body well">
								<div class="btn-group pull-right">
				            		<?php if($qcid > 1){ ?>
				            		<a class="btn" href="javascript:;" onclick="javascript:gotoindexquestion(<?php echo $qcid - 2; ?>,<?php echo $quest['questid']; ?>);" title="上一题">上一题</a>
				            		<?php } ?>
				            		<?php if($qcid < $qmid){ ?>
				            		<a class="btn" href="javascript:;" onclick="javascript:gotoindexquestion(<?php echo $qcid; ?>,<?php echo $quest['questid']; ?>);" title="下一题">下一题</a>
									<?php } ?>
				            	</div>
			            	</div>
						</div>
					</div>
					<?php } ?>
					<?php $qrid = 0;
 foreach($this->tpl_var['sessionvars']['examsessionquestion']['questionrows'][$quest['questid']] as $key => $questionrow){ 
 $qrid++; ?>
	                <?php $tid++; ?>
	                <?php $did = 0;
 foreach($questionrow['data'] as $key => $data){ 
 $did++; ?>
	                <?php $qcid++; ?>
	                <div id="question_<?php echo $data['questionid']; ?>" class="paperexamcontent">
						<div class="media well">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge badge-info questionindex"><?php echo $tid; ?></span>
								</li>
							</ul>
							<div class="media-body well">
								<?php echo html_entity_decode($this->ev->stripSlashes($questionrow['qrquestion'])); ?>
							</div>
							<div>
								<ul class="nav nav-tabs">
									<li class="active">
										<span class="badge questionindex"><?php echo $did; ?></span></a>
									</li>
									<li class="btn-group pull-right">
										<button class="btn" type="button" onclick="javascript:signQuestion('<?php echo $data['questionid']; ?>',this);"><em class="<?php if($this->tpl_var['sessionvars']['examsessionsign'][$data['questionid']]){ ?>icon-star<?php } else { ?>icon-star-empty<?php } ?>" title="标注"></em></button>
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
							<div class="media-body well">
								<div class="btn-group pull-right">
				            		<?php if($qcid > 1){ ?>
				            		<a class="btn" href="javascript:;" onclick="javascript:gotoindexquestion(<?php echo $qcid - 2; ?>,<?php echo $quest['questid']; ?>);" title="上一题">上一题</a>
				            		<?php } ?>
				            		<?php if($qcid < $qmid){ ?>
				            		<a class="btn" href="javascript:;" onclick="javascript:gotoindexquestion(<?php echo $qcid; ?>,<?php echo $quest['questid']; ?>);" title="下一题">下一题</a>
									<?php } ?>
				            	</div>
			            	</div>
						</div>
					</div>
					<?php } ?>
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
						<p>共有试题 <span class="allquestionnumber">50</span> 题，已做 <span class="yesdonumber">0</span> 题。您确认要交卷吗？</p>
					</div>
					<div class="modal-footer">
						 <button type="button" onclick="javascript:submitPaper();" class="btn btn-primary">确定交卷</button>
						 <input type="hidden" name="insertscore" value="1"/>
						 <button aria-hidden="true" class="btn" type="button" data-dismiss="modal">再检查一下</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="toolcontent">
		<div class="container-fluid footcontent">
			<div class="span2">
				<ul class="unstyled">
					<li><h4><img src="app/core/styles/images/icons/Watches.png" style="width:1.3em;"/> <span id="timer_h">00</span>：<span id="timer_m">00</span>：<span id="timer_s">00</span></h4></li>
				</ul>
			</div>
			<div class="span2">
				<ul class="unstyled">
					<li><h6><a href="#top"><em class="icon-circle-arrow-up"></em>回顶部</a> &nbsp; <a href="#modal" data-toggle="modal"><em class="icon-calendar"></em>试题列表</a></h6></li>
				</ul>
			</div>
			<div class="span6">
				<ul class="unstyled">
					<li><h6>已做 <span class="yesdonumber">0</span> 题 共 <span class="allquestionnumber">50</span> 题 总分：<span class="orange"><?php echo $this->tpl_var['sessionvars']['examsessionsetting']['examsetting']['score']; ?></span>分 合格分数线：<span class="orange"><?php echo $this->tpl_var['sessionvars']['examsessionsetting']['examsetting']['passscore']; ?></span>分 考试时间：<span class="orange"><?php echo $this->tpl_var['sessionvars']['examsessionsetting']['examsetting']['examtime']; ?></span>分钟</h6></li>
				</ul>
			</div>
			<div class="span2">
				<ul class="unstyled">
					<li class="text-right"><a href="#submodal" role="button" class="btn btn-primary" data-toggle="modal"> 交 卷 </a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function gotoquestion(questid,questypeid)
{
	$(".questionpanel").hide();
	$(".paperexamcontent").hide();
	$("#panel-type-"+questypeid).show();
	$("#question_"+questid).show();
	$('#modal').modal('hide');
}
function gotoindexquestion(index)
{
	$(".questionpanel").hide();
	$(".paperexamcontent").hide();
	$(".paperexamcontent").eq(index).show();
	$(".paperexamcontent").eq(index).parents(".questionpanel").show();
}
$(document).ready(function(){
	$.get('index.php?exam-app-index-ajax-lefttime&rand'+Math.random(),function(data){
		var setting = {
			<?php if($this->tpl_var['data']['currentbasic']['basicexam']['opentime']['start'] && $this->tpl_var['data']['currentbasic']['basicexam']['opentime']['end']){ ?>
			<?php if($this->tpl_var['data']['currentbasic']['basicexam']['opentime']['end']-300 <= ($this->tpl_var['sessionvars']['examsessiontime'] * 60 + $this->tpl_var['sessionvars']['examsessionstarttime'])){ ?>
			time:<?php echo intval(($this->tpl_var['data']['currentbasic']['basicexam']['opentime']['end']- 300 - $this->tpl_var['sessionvars']['examsessionstarttime'])/60); ?>,
			<?php } else { ?>
			time:<?php echo $this->tpl_var['sessionvars']['examsessiontime']; ?>,
			<?php } ?>
			<?php } else { ?>
			time:<?php echo $this->tpl_var['sessionvars']['examsessiontime']; ?>,
			<?php } ?>
			hbox:$("#timer_h"),
			mbox:$("#timer_m"),
			sbox:$("#timer_s"),
			finish:function(){submitPaper();}
		}
		setting.lefttime = parseInt(data);
		countdown(setting);
	});

	var m = function(){
		$(".questionpanel").hide();
		$(".questionpanel:first").show();
		$(".paperexamcontent").hide();
		$(".paperexamcontent:first").show();
	};
	m();
	//setInterval(refreshRecord,15000);
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
			if(initData[_this.attr('name')] && initData[_this.attr('name')] != '')
			batmark(_this.attr('rel'),initData[_this.attr('name')]);
		});

		var texts = $('#form1 :input[type=text]');
		$.each(texts,function(){
			var _this = $(this);
			_this.val(initData[_this.attr('name')]);
			if(initData[_this.attr('name')] && initData[_this.attr('name')] != '')
			batmark(_this.attr('rel'),initData[_this.attr('name')]);
		});

		var radios = $('#form1 :input[type=radio]');
		$.each(radios,function(){
			var _= this, v = initData[_.name];
			var _this = $(this);
			if(v!=''&&v==_.value){
				_.checked = true;
				batmark(_this.attr('rel'),initData[_this.attr('name')]);
			}else{
				_.checked=false;
			}
		});

		var checkboxs=$('#form1 :input[type=checkbox]');
		$.each(checkboxs,function(){
			var _=this,v=initData[_.name];
			var _this = $(this);
			if(v!=''&&v==_.value){
				_.checked=true;
				batmark(_this.attr('rel'),initData[_this.attr('name')]);
			}else{
				_.checked=false;
			}
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