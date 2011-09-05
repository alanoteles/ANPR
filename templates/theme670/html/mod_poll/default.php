<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="form2">
<?php $dif = 0;?>
<div class="poll<?php echo $params->get('moduleclass_sfx'); ?>">
	<div class="clear">
        <div class="question">
            <?php echo $poll->title; ?>
        </div>
        <div class="poll-body">
            <?php for ($i = 0, $n = count($options); $i < $n; $i ++) : 
                 $dif++; 
                 if ($dif % 2) { 
                     ?><div class="section"><?php 
                 } else { 
                 ?><div class="section2"><?php 
                 } ?>
                    <div class="radio <?php echo $tabclass_arr[$tabcnt]; ?><?php echo $params->get('moduleclass_sfx'); ?>">
                        <input type="radio" name="voteid" id="voteid<?php echo $options[$i]->id;?>" value="<?php echo $options[$i]->id;?>" alt="<?php echo $options[$i]->id;?>" />
                    </div>
                    <div class="var <?php echo $tabclass_arr[$tabcnt]; ?><?php echo $params->get('moduleclass_sfx'); ?>">
                        <label for="voteid<?php echo $options[$i]->id;?>">
                            <?php echo $options[$i]->text; ?>
                        </label>
                    </div>
                </div>
                <?php	$tabcnt = 1 - $tabcnt;?>
            <?php endfor; ?>
        </div>
        <div class="buttons clear">
            <input type="submit" name="task_button" class="button-poll-left" value="<?php echo JText::_('Vote'); ?>" />
           <input type="button" name="option" class="button-poll-right" value="<?php echo JText::_('Results'); ?>" onclick="document.location.href='<?php echo JRoute::_("index.php?option=com_poll&id=$poll->slug".$itemid); ?>'" />
        </div>
    </div>
</div>

<input type="hidden" name="option" value="com_poll" />
<input type="hidden" name="task" value="vote" />
<input type="hidden" name="id" value="<?php echo $poll->id;?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>