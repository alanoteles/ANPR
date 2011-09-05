<?php

defined('_JEXEC') or die('Restricted access');

$linkMore = '';
$linkNext = '';
if ( $more == 1 && $group->link ) {
	$linkMore = '<a href=\"'.$group->link.'\">'.JText::_('More Articles...').'</a>';
}
if ( $params->get( 'next', 1 ) == 1 ) {
 	$linkNext = JText::_('Next');
}
JHTML::script( 'slider.js','modules/mod_globalnews/scripts/',false);
?>

<div id="gn_slider_<?php echo $globalnews_id.'_'.$j; ?>" class="gn_slider_<?php echo $globalnews_id; ?>">
  <div class="gn_opacitylayer">
  <?php foreach ($list as $item) : ?>
    <div class="gn_news">
	<?php echo $item->content; ?>
	</div>
  <?php endforeach; ?>
  </div>
</div>
<div class="gn_pagination_<?php echo $globalnews_id; ?>" id="paginate-gn_slider_<?php echo $globalnews_id.'_'.$j; ?>"></div>
<?php

$doc = &JFactory::getDocument();

if (!defined('_MOD_VARGAS_ONLOAD')) {
    define ('_MOD_VARGAS_ONLOAD',1);
    $doc->addScriptDeclaration("function addLoadEvent(func) { if (typeof window.onload != 'function') { window.onload = func; } else { var oldonload = window.onload; window.onload = function() { if (oldonload) { oldonload(); } func(); } } }");
}

$doc->addScriptDeclaration("addLoadEvent(function(){GN_ContentSlider('gn_slider_".$globalnews_id."_".$j."',".$params->get('delay',3000).",'".$linkNext."','".$linkMore."');});");

?>