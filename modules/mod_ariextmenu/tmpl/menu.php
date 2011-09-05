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

$menuId = AriUtils::getParam($params, 'menuId');
$menu = AriUtils::getParam($params, 'menu');
$menuStartLevel = AriUtils::getParam($params, 'menuStartLevel');
$menuEndLevel = AriUtils::getParam($params, 'menuEndLevel');
$menuLevel = AriUtils::getParam($params, 'menuLevel');
$menuDirection = AriUtils::getParam($params, 'menuDirection');
$parent = AriUtils::getParam($params, 'parent');
$hlCurrentItem = AriUtils::getParam($params, 'hlCurrentItem');
$hlOnlyActiveItems = AriUtils::getParam($params, 'hlOnlyActiveItems');
$activeTopId = AriUtils::getParam($params, 'activeTopId');

$isMainLevel = ($menuLevel == $menuStartLevel);

$ulClass = $isMainLevel ? 'ux-menu' : 'ux-menu-sub ux-menu-init-hidden';
if ($isMainLevel)
	$ulClass .= $menuDirection == 'horizontal' ? ' ux-menu-horizontal' : ' ux-menu-vertical';
$currentLevelMenu = $menu->getItems(ARI_MENU_LEVEL_PARAM, $menuLevel);
?>

<?php
if ($currentLevelMenu):
	$parentParam = ARI_MENU_PARENT_PARAM;
?>
	<ul<?php if ($isMainLevel): ?> id="<?php echo $menuId; ?>"<?php endif; ?> class="<?php echo $ulClass; ?>">
		<?php
			$i = 0;
			$menuCnt = count($currentLevelMenu);
			foreach ($currentLevelMenu as $menuItem):
				if ((!J1_6 && !$menuItem->published) || ($parent && $menuItem->$parentParam != $parent) || !$menu->authorize($menuItem->id))
					continue ;

				$hasChilds = (($menuEndLevel < 0 || $menuLevel + 1 <= $menuEndLevel) && $menu->hasChilds($menuItem->id));
				if (($menuItem->type == 'separator' && !$hasChilds)) 
					continue;

				if ($isMainLevel && $hlOnlyActiveItems && !$menu->isChildOrSelf($menuItem->id, $activeTopId))
				{
					$activeItem = $menu->getItem($activeTopId);
					if ($activeItem->$parentParam != $menuItem->$parentParam)
						continue ;
				}

				$aAttr = array('href' => $menu->getLink($menuItem->id));
				switch ($menuItem->browserNav)
				{
					case 1:
						$aAttr['target'] = '_blank';
						break;
							
					case 2:
						$aAttr['onclick'] = "window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,');return false;";
						break;
				}

				$menuAbsLevel = $menuLevel - $menuStartLevel;
				$isSelected = ($hlCurrentItem && $menu->isSelfOrParentActive($menuItem->id));
				$liClass = $isMainLevel ? 'ux-menu-item-main' : '';
				$liClass .= ' ux-menu-item-level-' . $menuAbsLevel;
				if ($hasChilds)
					$liClass .= ' ux-menu-item-parent';
				$liClass .= ' ux-menu-item' . $menuItem->id;
				if ($isMainLevel)
					$liClass .= ' ux-menu-item-parent-pos' . $i;
				if ($isSelected)
					$liClass .= ' current';
					
				$aClass = ' ux-menu-link-level-' . $menuAbsLevel;
				if ($isMainLevel)
					$aClass .= ' ux-menu-link-first';
				if ($i == $menuCnt - 1)
					$aClass .= ' ux-menu-link-last';
				if ($isSelected)
					$aClass .= ' current';
				if ($hasChilds)
					$aClass .= ' ux-menu-link-parent';
				if ($aClass)
					$aAttr['class'] = $aClass;					
		?>
			<li<?php if ($liClass): ?> class="<?php echo $liClass; ?>"<?php endif; ?>>
				<a<?php echo AriHtmlHelper::getAttrStr($aAttr); ?>>
					<?php echo stripslashes(htmlspecialchars(J1_6 ? $menuItem->title : $menuItem->name)); ?>
					<?php if ($hasChilds):?>
					<span class="ux-menu-arrow"></span>
					<?php endif;?>
				</a>
			<?php
				if ($hasChilds && ($menuEndLevel < 0 || $menuLevel + 1 <= $menuEndLevel)):
					AriTemplate::display(
						__FILE__, 
						array(
							'menu' => $menu,
							'menuStartLevel' => $menuStartLevel,
							'menuEndLevel' => $menuEndLevel,
							'menuLevel' => $menuLevel + 1,
							'menuDirection' => $menuDirection,
							'parent' => $menuItem->id,
							'hlCurrentItem' => $hlCurrentItem,
							'hlOnlyActiveItems' => $hlOnlyActiveItems,
							'activeTopId' => $activeTopId 
						)
					);
				endif;
			?>
			</li>
		<?php
				++$i;
			endforeach;
		?>
	</ul>
<?php
endif; 
?>