<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<div class="examform" style="position:relative;">
				<div class="scoreArea"><?php echo $this->tpl_var['sessionvars']['examsessionscore']; ?></div>
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-basics"><?php echo $this->tpl_var['data']['currentbasic']['basic']; ?></a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-history&ehtype=<?php echo $this->tpl_var['ehtype']; ?>">考试记录</a> <span class="divider">/</span>
					</li>
					<li class="active">
						查看解析
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
	                <div id="question_<?php echo $question['questionid']; ?>" class="paperexamcontent decidediv">
						<?php if($this->tpl_var['sessionvars']['examsessionscorelist'][$question['questionid']] && $this->tpl_var['sessionvars']['examsessionscorelist'][$question['questionid']] == $this->tpl_var['sessionvars']['examsessionsetting']['examsetting']['questype'][$quest['questid']]['score']){ ?><div class="right"></div><?php } else { ?><div class="wrong"></div><?php } ?>
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
		                    <?php } ?>
							<div class="media-body well">
		                  		<p class="text-error">本题得分：<?php echo $this->tpl_var['sessionvars']['examsessionscorelist'][$question['questionid']]; ?>分</p>
		                  	</div>
							<div class="media-body well">
		                    	<ul class="unstyled">
		                        	<li class="text-error">正确答案：</li>
		                            <li class="text-success"><?php echo html_entity_decode($this->ev->stripSlashes($question['questionanswer'])); ?></li>
		                        	<li class="text-info">您的答案：</li>
		                            <li class="text-success"><?php if(is_array($this->tpl_var['sessionvars']['examsessionuseranswer'][$question['questionid']])){ ?><?php echo implode('',$this->tpl_var['sessionvars']['examsessionuseranswer'][$question['questionid']]); ?><?php } else { ?><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['sessionvars']['examsessionuseranswer'][$question['questionid']])); ?><?php } ?></li>
		                        	<li><span class="text-info">所在章：</span><?php $kid = 0;
 foreach($question['questionknowsid'] as $key => $knowsid){ 
 $kid++; ?>&nbsp;&nbsp;<?php echo $this->tpl_var['globalsections'][$this->tpl_var['globalknows'][$knowsid['knowsid']]['knowssectionid']]['section']; ?>&nbsp;<?php } ?></li>
		                        	<li class="text-success"><span class="text-info">知识点：</span><?php $kid = 0;
 foreach($question['questionknowsid'] as $key => $knowsid){ 
 $kid++; ?>&nbsp;&nbsp;<?php echo $this->tpl_var['globalknows'][$knowsid['knowsid']]['knows']; ?>&nbsp;<?php } ?></li>
		                        	<li class="text-info">答案解析：</li>
		                        	<li class="text-success"><?php echo html_entity_decode($this->ev->stripSlashes($question['questiondescribe'])); ?></li>
		                        </ul>
		                    </div>
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
							<div class="paperexamcontent decidediv">
								<?php if($this->tpl_var['sessionvars']['examsessionscorelist'][$data['questionid']] && $this->tpl_var['sessionvars']['examsessionscorelist'][$data['questionid']] == $this->tpl_var['sessionvars']['examsessionsetting']['examsetting']['questype'][$quest['questid']]['score']){ ?><div class="right"></div><?php } else { ?><div class="wrong"></div><?php } ?>
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
			                    <?php } ?>
								<div class="media-body well">
			                  		<p class="text-error">本题得分：<?php echo $this->tpl_var['sessionvars']['examsessionscorelist'][$data['questionid']]; ?>分</p>
			                  	</div>
								<div class="media-body well">
									<ul class="unstyled">
			                        	<li class="text-error">正确答案：</li>
			                            <li class="text-success"><?php echo html_entity_decode($this->ev->stripSlashes($data['questionanswer'])); ?></li>
			                        	<li class="text-info">您的答案：</li>
			                            <li class="text-success"><?php if(is_array($this->tpl_var['sessionvars']['examsessionuseranswer'][$data['questionid']])){ ?><?php echo implode('',$this->tpl_var['sessionvars']['examsessionuseranswer'][$data['questionid']]); ?><?php } else { ?><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['sessionvars']['examsessionuseranswer'][$data['questionid']])); ?><?php } ?></li>
			                        	<li><span class="text-info">所在章：</span><?php $kid = 0;
 foreach($questionrow['qrknowsid'] as $key => $knowsid){ 
 $kid++; ?>&nbsp;&nbsp;<?php echo $this->tpl_var['globalsections'][$this->tpl_var['globalknows'][$knowsid['knowsid']]['knowssectionid']]['section']; ?>&nbsp;<?php } ?></li>
			                        	<li><span class="text-info">知识点：</span><?php $kid = 0;
 foreach($questionrow['qrknowsid'] as $key => $knowsid){ 
 $kid++; ?>&nbsp;&nbsp;<?php echo $this->tpl_var['globalknows'][$knowsid['knowsid']]['knows']; ?>&nbsp;<?php } ?></li>
			                        	<li class="text-info">答案解析：</li>
		                        		<li class="text-success"><?php echo html_entity_decode($this->ev->stripSlashes($data['questiondescribe'])); ?></li>
			                        </ul>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
</body>
</html>