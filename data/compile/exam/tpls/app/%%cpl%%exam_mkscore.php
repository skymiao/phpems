<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="row-fluid">
	<div class="container-fluid examcontent">
		<div class="exambox" id="datacontent">
			<form class="examform form-horizontal" id="form1" name="form1" action="index.php?exam-app-exam-makescore">
				<ul class="breadcrumb">
					<li>
						<span class="icon-home"></span> <a href="index.php?exam">考场选择</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="index.php?exam-app-basics"><?php echo $this->tpl_var['data']['currentbasic']['basic']; ?></a> <span class="divider">/</span>
					</li>
					<li class="active">
						主观题评分
					</li>
				</ul>
				<h3 class="text-center">主观题评分（<?php echo $this->tpl_var['sessionvars']['examsession']; ?>）</h3>
                <div class="well">
                	<ul class="unstyled">
                    	<li><b>阅卷规则</b></li>
                    	<li>1、客观题系统将自动核对学员答案。</li>
                    	<li>2、主观题请参照系统给出的答案自行核对，并给出分数。</li>
                    	<li>3、自行评分完毕后请单击“自行判卷无误，提交”按钮，将即刻为您生成本次测验的成绩单。</li>
                    </ul>
                    <p>以下题为主观题请参照正确答案后自行给出分数</p>
                </div>
				<?php $oid = 0; ?>
				<?php $qid = 0;
 foreach($this->tpl_var['questype'] as $key => $quest){ 
 $qid++; ?>
				<?php if($quest['questsort']){ ?>
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
									<button class="btn" type="button"><em class="icon-heart" title="收藏"></em></button>
								</li>
							</ul>
							<div class="media-body well text-warning">
								<a name="question_<?php echo $question['questionid']; ?>"></a><?php echo html_entity_decode($this->ev->stripSlashes($question['question'])); ?>
							</div>
							<div class="media-body well">
		                    	<ul class="unstyled">
		                        	<li class="text-error">正确答案：</li>
		                            <li class="text-success"><?php echo html_entity_decode($this->ev->stripSlashes($question['questionanswer'])); ?></li>
		                        	<li class="text-info">您的答案：</li>
		                            <li class="text-success"><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['sessionvars']['examsessionuseranswer'][$question['questionid']])); ?></li>
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
		                    <div class="media-body well">
		                  		【请根据参考答案给出分值】
		                  		<input type="text" name="score[<?php echo $question['questionid']; ?>]" value="" maxvalue="<?php echo $this->tpl_var['sessionvars']['examsessionsetting']['examsetting']['questype'][$quest['questid']]['score']; ?>">
		                  		<span class="text-error">提示：本题共<?php echo $this->tpl_var['sessionvars']['examsessionsetting']['examsetting']['questype'][$quest['questid']]['score']; ?>分，可输入0.5的倍数。</span>
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
							<div class="paperexamcontent">
								<ul class="nav nav-tabs">
									<li class="active">
										<span class="badge questionindex"><?php echo $did; ?></span></a>
									</li>
									<li class="btn-group pull-right">
										<button class="btn" type="button"><em class="icon-heart" title="收藏"></em></button>
									</li>
								</ul>
								<div class="media-body well text-warning">
									<a name="question_<?php echo $data['questionid']; ?>"></a><?php echo html_entity_decode($this->ev->stripSlashes($data['question'])); ?>
								</div>
								<div class="media-body well">
									<ul class="unstyled">
			                        	<li class="text-error">正确答案：</li>
			                            <li class="text-success"><?php echo html_entity_decode($this->ev->stripSlashes($data['questionanswer'])); ?></li>
			                        	<li class="text-info">您的答案：</li>
			                            <li class="text-success"><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['sessionvars']['examsessionuseranswer'][$data['questionid']])); ?></li>
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
								<div class="media-body well">
			                  		【请根据参考答案给出分值】
			                  		<input type="text" name="score[<?php echo $data['questionid']; ?>]" value="" maxvalue="<?php echo $this->tpl_var['sessionvars']['examsessionsetting']['examsetting']['questype'][$quest['questid']]['score']; ?>">
			                  		<span class="text-error">提示：本题共<?php echo $this->tpl_var['sessionvars']['examsessionsetting']['examsetting']['questype'][$quest['questid']]['score']; ?>分，可输入0.5的倍数。</span>
			                  	</div>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
				<?php } ?>
				<?php } ?>
				<div class="span12 text-center">
					 <button type="submit" class="btn btn-primary">自行判分完毕，提交分数</button>
					 <input type="hidden" name="makescore" value="1"/>
				</div>
			</form>
		</div>
	</div>
</div>
<?php $this->_compileInclude('foot'); ?>
</body>
</html>