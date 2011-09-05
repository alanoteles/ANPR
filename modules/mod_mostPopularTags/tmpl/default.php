<?php 
/**
 * @package module mostPopularTags for Joomla! 1.5
 * @version $Id: mod_mostPopularTags.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?php if(isset($list)&&!empty($list)) {?>
<div class="tagCloud"><?php	foreach ($list as $item) {?> <a
	href="<?php echo $item->link; ?>" rel="tag" class="<?php echo $item->class; ?>">
<?php echo $item->name; ?></a> <?php }?>
</div><?php } ?>
