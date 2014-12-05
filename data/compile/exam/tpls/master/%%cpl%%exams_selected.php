				<table class="table table-hover">
					<tr>
						<td>
							<b>普通试题</b>
						</td>
					</tr>
					<?php $qid = 0;
 foreach($this->tpl_var['questions'] as $key => $question){ 
 $qid++; ?>
					<tr id="selectedq_<?php echo $question['questionid']; ?>">
						<td>
							<table>
								<tr>
									<td width="80"><label class="checkbox inline"><?php if(!$this->tpl_var['show']){ ?><input type="checkbox" del="selectedq_<?php echo $question['questionid']; ?>" rel="1" value="<?php echo $question['questionid']; ?>" onclick="javascript:doselectquestions(this,'iselectquestions_<?php echo $question['questiontype']; ?>','ialreadyselectnumber_<?php echo $question['questiontype']; ?>');" checked /><?php } ?>第<?php echo $qid; ?>题</label></td>
									<td>&nbsp;</td>
								</tr>
								<?php if($question['questionknowsid']){ ?>
								<tr>
									<td>所属知识点：</td>
									<td><?php $kid = 0;
 foreach($question['questionknowsid'] as $key => $know){ 
 $kid++; ?>&nbsp;<?php echo $know['knows']; ?><?php } ?>&nbsp;</td>
								</tr>
								<?php } ?>
								<tr>
									<td>标题：</td>
									<td><?php echo strip_tags(html_entity_decode($question['question'])); ?></td>
								</tr>
								<tr>
									<td>备选项：</td>
									<td>
									<?php echo html_entity_decode($this->ev->stripSlashes($question['questionselect'])); ?>
									</td>
								</tr>
								<tr>
									<td>答案：</td>
									<td><?php echo html_entity_decode($this->ev->stripSlashes($question['questionanswer'])); ?></td>
								</tr>
								<tr>
									<td>解析：</td>
									<td><?php echo html_entity_decode($this->ev->stripSlashes($question['questiondescribe'])); ?>&nbsp;</td>
								</tr>
								<tr>
									<td>难度：</td>
									<td><?php if($question['questionlevel']==1){ ?>易<?php } elseif($question['questionlevel']==2){ ?>中<?php } elseif($question['questionlevel']==3){ ?>难<?php } ?>&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<td>
							<b>题帽题</b>
						</td>
					</tr>
					<?php $qid = 0;
 foreach($this->tpl_var['rowsquestions'] as $key => $rowsquestion){ 
 $qid++; ?>
					<tr id="selectedqr_<?php echo $rowsquestion['qrid']; ?>">
						<td>
							<div>
								<table>
									<tr>
									<td width="80"><label class="checkbox inline"><?php if(!$this->tpl_var['show']){ ?><input type="checkbox" del="selectedqr_<?php echo $rowsquestion['qrid']; ?>" rel="<?php echo $rowsquestion['qrnumber']; ?>" value="<?php echo $rowsquestion['qrid']; ?>" onclick="javascript:doselectquestions(this,'iselectrowsquestions_<?php echo $rowsquestion['qrtype']; ?>','ialreadyselectnumber_<?php echo $rowsquestion['qrtype']; ?>');" checked /><?php } ?><b>第<?php echo $qid; ?>大题</b></label></td>
									<td>&nbsp;</td>
									</tr>
									<tr>
									<td>所属知识点：</td>
									<td><?php $kid = 0;
 foreach($rowsquestion['qrknowsid'] as $key => $know){ 
 $kid++; ?>&nbsp;<?php echo $know['knows']; ?><?php } ?>&nbsp;</td>
									</tr>
									<tr>
									<td>题帽：</td>
									<td><?php echo html_entity_decode($this->ev->stripSlashes($rowsquestion['qrquestion'])); ?></td>
									</tr>
								</table>
								<?php $cqid = 0;
 foreach($rowsquestion['data'] as $key => $question){ 
 $cqid++; ?>
								<table class="searchContent" width="96%">
									<tr>
										<td width="80">第<?php echo $cqid; ?>题</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>标题：</td>
										<td><?php echo strip_tags(html_entity_decode($question['question'])); ?></td>
									</tr>
									<tr>
										<td>备选项：</td>
										<td>
										<?php echo html_entity_decode($this->ev->stripSlashes($question['questionselect'])); ?>
										</td>
									</tr>
									<tr>
										<td>答案：</td>
										<td><?php echo html_entity_decode($this->ev->stripSlashes($question['questionanswer'])); ?></td>
									</tr>
									<tr>
										<td>解析：</td>
										<td><?php echo html_entity_decode($this->ev->stripSlashes($question['questiondescribe'])); ?>&nbsp;</td>
									</tr>
									<tr style="display:none;">
										<td>难度：</td>
										<td><?php if($question['questionlevel']==2){ ?>中<?php } elseif($question['questionlevel']==3){ ?>难<?php } elseif($question['questionlevel']==1){ ?>易<?php } ?>&nbsp;</td>
									</tr>
								</table>
								<?php } ?>
							</div>
						</td>
					</tr>
					<?php } ?>
				</table>