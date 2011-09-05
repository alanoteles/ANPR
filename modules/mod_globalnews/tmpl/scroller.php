<?php // no direct access

defined('_JEXEC') or die('Restricted access'); 

JHTML::script( 'scroller.js','modules/mod_globalnews/scripts/',false);
?>

<script type="text/javascript" language="javascript">
<!--
var GN_Pausecontent_<?php echo $globalnews_id.'_'.$j; ?>=new Array();

<?php  $k=0;  foreach ($list as $item) : 
${'content'.$k} = $item->content;
${'content'.$k} = preg_replace( "/[\n\t\r]+/",' ',${'content'.$k} );
${'content'.$k} = str_replace( "'", "\\'",${'content'.$k} ); ?>
GN_Pausecontent_<?php echo $globalnews_id.'_'.$j; ?>[<?php echo $k; ?>]='<?php echo ${'content'.$k}; ?>';
<?php  $k++;  endforeach; ?>

new GN_Pausescroller(GN_Pausecontent_<?php echo $globalnews_id.'_'.$j; ?>, "gn_scroller_<?php echo $globalnews_id.'_'.$j; ?>", "", <?php echo $params->get('delay', 3000) ?>);
-->
</script>
<?php
if ( $more == 1 && $group->link ) : ?>
<div> <?php echo JHTML::_('link', $group->link, JText::_('More Articles...'), array('class'=>'readon') ); ?> </div>
<?php
endif;