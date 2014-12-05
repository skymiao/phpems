                            <?php $qid = 0;
 foreach($this->tpl_var['questype'] as $key => $quest){ 
 $qid++; ?>
                            <?php if(!$quest['questsort'] && $this->tpl_var['numbers'][$quest['questid']]){ ?>
                            <option value="<?php echo $quest['questid']; ?>">
                            	<?php echo $quest['questype']; ?>（共<?php echo $this->tpl_var['numbers'][$quest['questid']]; ?>题）
                            </option>
                            <?php } ?>
                        	<?php } ?>