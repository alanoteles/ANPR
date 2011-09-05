<?php // no direct access

defined('_JEXEC') or die('Restricted access'); 

JHTML::script( 'browser.js','modules/mod_globalnews/scripts/',false);
?>

<div id="gn_container_<?php echo $globalnews_id.'_'.$j; ?>">
  <div id="gn_marquee_<?php echo $globalnews_id.'_'.$j; ?>" style="position: absolute;">
    <?php foreach ($list as $item) : ?>
    <div class="gn_news"> <?php echo $item->content; ?>
      <div class="gn_clear"></div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
<?php
if ( $more == 1 && $group->link ) : ?>
<div> <?php echo JHTML::_('link', $group->link, JText::_('More Articles...'), array('class'=>'readon') ); ?> </div>
<?php
endif; ?>
<script type="text/javascript" language="javascript">
<!--
var GN_Browser_<?php echo $globalnews_id.'_'.$j; ?> = new GN_Browser("gn_marquee_<?php echo $globalnews_id.'_'.$j; ?>","gn_container_<?php echo $globalnews_id.'_'.$j; ?>","GN_Browser_<?php echo $globalnews_id.'_'.$j; ?>",<?php echo $params->get('delay', 3000) ?>);
-->
</script>
