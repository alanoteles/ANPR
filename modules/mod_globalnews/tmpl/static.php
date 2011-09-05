<?php // no direct access

defined('_JEXEC') or die('Restricted access');
echo '<div class="border-bot">';
foreach ($list as $item) :  ?>

<div class="gn_static_1">
	<?php echo $item->content; ?>
</div>
<?php 
endforeach; ?>
</div>
<?php
if ( $more == 1 && $group->link ) : ?>
<div class="box_button"> <?php echo JHTML::_('link', $group->link, JText::_('See all >'), array('class'=>'readon') ); ?> </div>
<?php
endif;