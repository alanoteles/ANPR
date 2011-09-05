<?php
/*
 * ARI Ext menu Joomla! module
 *
 * @package		ARI Ext Menu Joomla! module.
 * @version		1.0.0
 * @author		ARI Soft
 * @copyright	Copyright (c) 2009 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');
?>

<div id="<?php echo $menuId; ?>_container" class="ux-menu-container ux-menu-clearfix">
<?php
AriTemplate::display(
	dirname(__FILE__) . DS . 'menu.php', 
	array(
		'menuId' => $menuId,
		'menu' => $menu,
		'menuStartLevel' => $menuStartLevel,
		'menuEndLevel' => $menuEndLevel,
		'menuLevel' => $menuLevel,
		'menuDirection' => $menuDirection,
		'hlCurrentItem' => $hlCurrentItem,
		'hlOnlyActiveItems' => $hlOnlyActiveItems,
		'activeTopId' => $activeTopId,
		'parent' => 0 
	)
);
?>
</div>