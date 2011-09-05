<?php // no direct access
defined('_JEXEC') or die('Restricted access');

$i = $j = 0;

foreach ($cat as $group) :

	$listCondition = $group->cond;
	$list  = modGlobalNewsHelper::getGN_List($params,$listCondition);

	if (count($list) || $empty != 0) :

		$more  = $params->get('more', 1);

		$i++; $j++; ?>

<div style="float:left;width:<?php echo $width; ?>;">
  <div class="globalnews" style="margin:<?php echo $params->get('margin', '2px'); ?>">
    <?php 
  		if ( $show_cat != 0 ) : ?>
    <div class="gn_header_<?php echo $globalnews_id; ?>"> <span class="gn_header"><?php echo $group->image . $group->title; ?></span>
      <div class="gn_clear"></div>
    </div>
    <?php endif;
		if ( count ( $list) > 0 ) :
        	require(JModuleHelper::getLayoutPath('mod_globalnews', $layout));
        endif; ?>
  </div>
</div>
<?php 
		if ( $i == $cols && $j != $total ) : ?>
<div class="gn_clear"></div>
<?php
			$i=0; 
		endif;
	endif;
endforeach; ?>
<div class="gn_clear"></div>
