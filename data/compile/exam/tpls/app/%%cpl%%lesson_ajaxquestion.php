			<form id="form1" name="form1" action="index.php?exam-app-lesson-ajax-questions">
                <?php if($this->tpl_var['question']['questionid']){ ?>
                <div id="question_<?php echo $this->tpl_var['question']['questionid']; ?>" class="paperexamcontent">
					<div class="media well">
						<ul class="nav nav-tabs">
							<li class="active">
								<span class="badge badge-info questionindex"><?php echo $this->tpl_var['number']; ?></span></a>
							</li>
							<li class="btn-group pull-right">
								<button class="btn" type="button" onclick="javascript:favorquestion('<?php echo $this->tpl_var['question']['questionid']; ?>');"><em class="icon-heart" title="收藏"></em></button>
							</li>
						</ul>
						<div class="media-body well text-warning">
							<a name="question_<?php echo $this->tpl_var['question']['questionid']; ?>"></a><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['question']['question'])); ?>
						</div>
						<?php if(!$this->tpl_var['questype']['questsort']){ ?>
						<?php if($this->tpl_var['questype']['questchoice'] != 5){ ?>
						<div class="media-body well">
	                    	<?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['question']['questionselect'])); ?>
	                    </div>
	                    <?php } ?>
						<div class="media-body well questionanswerbox">
	                    	<?php if($this->tpl_var['questype']['questchoice'] == 1 || $this->tpl_var['questype']['questchoice'] == 4){ ?>
		                        <?php $sid = 0;
 foreach($this->tpl_var['selectorder'] as $key => $so){ 
 $sid++; ?>
		                        <?php if($key == $this->tpl_var['question']['questionselectnumber']){ ?>
		                        <?php break;; ?>
		                        <?php } ?>
		                        <label class="radio inline"><input type="radio" name="question[<?php echo $this->tpl_var['question']['questionid']; ?>]" rel="<?php echo $this->tpl_var['question']['questionid']; ?>" value="<?php echo $so; ?>" <?php if($so == $this->tpl_var['sessionvars']['examsessionuseranswer'][$this->tpl_var['question']['questionid']]){ ?>checked<?php } ?>/><?php echo $so; ?> </label>
		                        <?php } ?>
	                        <?php } elseif($this->tpl_var['questype']['questchoice'] == 5){ ?>
			                   	<div class="input-append"><input type="text" class="input-xxlarge" name="question[<?php echo $this->tpl_var['question']['questionid']; ?>]" rel="<?php echo $this->tpl_var['question']['questionid']; ?>" readonly/><span class="btn add-on" onclick="javascript:answerfenlu('<?php echo $this->tpl_var['question']['questionid']; ?>');"><em class="icon-edit"></em></span></div>
		                    <?php } else { ?>
		                        <?php $sid = 0;
 foreach($this->tpl_var['selectorder'] as $key => $so){ 
 $sid++; ?>
		                        <?php if($key >= $this->tpl_var['question']['questionselectnumber']){ ?>
		                        <?php break;; ?>
		                        <?php } ?>
		                        <label class="checkbox inline"><input type="checkbox" name="question[<?php echo $this->tpl_var['question']['questionid']; ?>][<?php echo $key; ?>]" rel="<?php echo $this->tpl_var['question']['questionid']; ?>" value="<?php echo $so; ?>" <?php if(in_array($so,$this->tpl_var['sessionvars']['examsessionuseranswer'][$this->tpl_var['question']['questionid']])){ ?>checked<?php } ?>/><?php echo $so; ?> </label>
		                        <?php } ?>
	                        <?php } ?>
	                    </div>
						<?php } else { ?>
						<div class="media-body well questionanswerbox">
							<?php $this->tpl_var['dataid'] = $this->tpl_var['question']['questionid']; ?>
							<textarea class="jckeditor" etype="simple" id="editor<?php echo $this->tpl_var['dataid']; ?>" name="question[<?php echo $this->tpl_var['dataid']; ?>]" rel="<?php echo $this->tpl_var['question']['questionid']; ?>"><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['sessionvars']['examsessionuseranswer'][$this->tpl_var['dataid']])); ?></textarea>
						</div>
						<?php } ?>
						<div class="media-body well">
							<div class="btn-group pull-right hide answerbox">
			            		<?php if($this->tpl_var['number'] > 1){ ?>
			            		<a class="btn ajax" target="questionpanel" href="index.php?<?php echo $this->tpl_var['_app']; ?>-app-lesson-ajax-questions&number=<?php echo intval($this->tpl_var['number'] - 1); ?>" title="上一题">上一题</a>
			            		<?php } ?>
								<a class="btn ajax" target="questionpanel" href="index.php?<?php echo $this->tpl_var['_app']; ?>-app-lesson-ajax-questions&number=<?php echo intval($this->tpl_var['number'] + 1); ?>" title="下一题">下一题</a>
			            	</div>
			            	<div class="btn-group pull-right">
			            		<a class="btn questionbtn" href="javascript:;" onclick="javascript:$('.questionbtn').addClass('hide');$('.answerbox').removeClass('hide');" title="查看答案">查看答案</a>
			            	</div>
		            	</div>
						<div class="media-body well answerbox hide">
							<h5>答案</h5>
							<?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['question']['questionanswer'])); ?>
						</div>
						<div class="media-body well answerbox hide">
							<h5>解析</h5>
							<?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['question']['questiondescribe'])); ?>
						</div>
					</div>
				</div>
				<?php } else { ?>
                <div id="questionrow_<?php echo $this->tpl_var['question']['qrid']; ?>">
					<div class="media well">
						<ul class="nav nav-tabs">
							<li class="active">
								<span class="badge badge-info questionindex"><?php echo $this->tpl_var['number']; ?></span>
							</li>
						</ul>
						<div class="media-body well">
							<?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['question']['qrquestion'])); ?>
						</div>
						<?php $tmpa = array();; ?>
						<?php $did = 0;
 foreach($this->tpl_var['question']['data'] as $key => $data){ 
 $did++; ?>
						<?php $tmpa[$did] = $data;; ?>
						<?php } ?>
						<?php $did = 0;
 foreach($this->tpl_var['question']['data'] as $key => $data){ 
 $did++; ?>
						<div class="paperexamcontent_<?php echo $data['questionid']; ?>">
							<ul class="nav nav-tabs">
								<li class="active">
									<span class="badge questionindex"><?php echo $did; ?></span>
								</li>
								<li class="btn-group pull-right">
									<button class="btn" type="button" onclick="javascript:favorquestion('<?php echo $data['questionid']; ?>');"><em class="icon-heart" title="收藏"></em></button>
								</li>
							</ul>
							<div class="media-body well text-warning">
								<a name="qrchild_<?php echo $data['questionid']; ?>"></a><?php echo html_entity_decode($this->ev->stripSlashes($data['question'])); ?>
							</div>
							<?php if(!$this->tpl_var['questype']['questsort']){ ?>
							<?php if($this->tpl_var['questype']['questchoice'] != 5){ ?>
							<div class="media-body well">
		                    	<?php echo html_entity_decode($this->ev->stripSlashes($data['questionselect'])); ?>
		                    </div>
		                    <?php } ?>
							<div class="media-body well questionanswerbox">
		                    	<?php if($this->tpl_var['questype']['questchoice'] == 1 || $this->tpl_var['questype']['questchoice'] == 4){ ?>
			                        <?php $sid = 0;
 foreach($this->tpl_var['selectorder'] as $key => $so){ 
 $sid++; ?>
			                        <?php if($key == $data['questionselectnumber']){ ?>
			                        <?php break;; ?>
			                        <?php } ?>
			                        <label class="radio inline"><input type="radio" name="question[<?php echo $data['questionid']; ?>]" rel="<?php echo $data['questionid']; ?>" value="<?php echo $so; ?>" <?php if($so == $this->tpl_var['sessionvars']['examsessionuseranswer'][$data['questionid']]){ ?>checked<?php } ?>/><?php echo $so; ?> </label>
			                        <?php } ?>
		                        <?php } elseif($this->tpl_var['questype']['questchoice'] == 5){ ?>
			                    	<div class="input-append"><input type="text" class="input-xxlarge" name="question[<?php echo $data['questionid']; ?>]" rel="<?php echo $data['questionid']; ?>" readonly/><span class="btn add-on" onclick="javascript:answerfenlu('<?php echo $data['questionid']; ?>');"><em class="icon-edit"></em></span></div>
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
							<div class="media-body well questionanswerbox">
								<?php $this->tpl_var['dataid'] = $data['questionid']; ?>
								<textarea class="jckeditor" etype="simple" id="editor<?php echo $this->tpl_var['dataid']; ?>" name="question[<?php echo $this->tpl_var['dataid']; ?>]" rel="<?php echo $data['questionid']; ?>"><?php echo html_entity_decode($this->ev->stripSlashes($this->tpl_var['sessionvars']['examsessionuseranswer'][$this->tpl_var['dataid']])); ?></textarea>
							</div>
							<?php } ?>
							<div class="media-body well">
								<div class="btn-group pull-right hide answerbox">
				            		<?php if($this->tpl_var['number'] > 1){ ?>
					            		<?php if($did == 1){ ?>
					            		<a class="btn ajax" target="questionpanel" href="index.php?<?php echo $this->tpl_var['_app']; ?>-app-lesson-ajax-questions&number=<?php echo intval($this->tpl_var['number'] - $this->tpl_var['prenumer']); ?>" title="上一题">上一题</a>
					            		<?php } else { ?>
					            		<a class="btn" href="#qrchild_<?php echo $tmpa[$did - 1]['questionid']; ?>" title="上一题">上一题</a>
					            		<?php } ?>
					            	<?php } else { ?>
					            		<?php if($did > 1){ ?>
					            		<a class="btn" href="#qrchild_<?php echo $tmpa[$did - 1]['questionid']; ?>" title="上一题">上一题</a>
					            		<?php } ?>
				            		<?php } ?>
				            		<?php if($did < count($tmpa)){ ?>
				            		<a class="btn" href="#qrchild_<?php echo $tmpa[$did + 1]['questionid']; ?>" title="下一题">下一题</a>
				            		<?php } else { ?>
					            		<?php if(($did + $this->tpl_var['number']) < $this->tpl_var['allnumber']){ ?>
										<a class="btn ajax" target="questionpanel" href="index.php?<?php echo $this->tpl_var['_app']; ?>-app-lesson-ajax-questions&number=<?php echo intval($this->tpl_var['number'] + count($tmpa)); ?>" title="下一题">下一题</a>
										<?php } ?>
									<?php } ?>
				            	</div>
				            	<div class="btn-group pull-right">
				            		<a class="btn questionbtn" href="javascript:;" onclick="javascript:$('.paperexamcontent_<?php echo $data['questionid']; ?>').find('.questionbtn').addClass('hide');$('.paperexamcontent_<?php echo $data['questionid']; ?>').find('.answerbox').removeClass('hide');" title="查看答案">查看答案</a>
				            	</div>
			            	</div>
							<div class="media-body well answerbox hide">
								<h5>答案</h5>
								<?php echo html_entity_decode($this->ev->stripSlashes($data['questionanswer'])); ?>
							</div>
							<div class="media-body well answerbox hide">
								<h5>解析</h5>
								<?php echo html_entity_decode($this->ev->stripSlashes($data['questiondescribe'])); ?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
			</form>