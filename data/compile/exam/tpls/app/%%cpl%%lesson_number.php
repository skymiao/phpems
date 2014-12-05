                            <table class="table table-hover table-bordered">
								<tr class="success"><td colspan="6"><?php echo $this->tpl_var['knows']['knows']; ?></td></tr>
	                            <tr>
	                            <?php $qid = 0;
 foreach($this->tpl_var['questype'] as $key => $quest){ 
 $qid++; ?>
	                            	<td>
	                            	<?php echo $quest['questype']; ?>（共<?php echo $this->tpl_var['numbers'][$quest['questid']]; ?>题）
	                            	<?php if($this->tpl_var['numbers'][$quest['questid']]){ ?>
	                            	<a href="index.php?exam-app-lesson-ajax-setlesson&questype=<?php echo $quest['questid']; ?>&knowsid=<?php echo $this->tpl_var['knows']['knowsid']; ?>" class="btn btn-primary ajax" action-before="clearStorage">练习</a>
	                            	<?php } else { ?>
	                            	<a href="javascript:;" class="btn">练习</a>
	                            	<?php } ?>
	                            	</td>
	                            	<?php if($qid % 6 == 0){ ?>
                            	</tr>
                            	<tr>
	                            	<?php } ?>
	                        	<?php } ?>
	                        	</tr>
                        	</table>