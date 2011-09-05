<?php
/*
 * ARI Framework Lite
 *
 * @package		ARI Framework Lite
 * @version		1.0.0
 * @author		ARI Soft
 * @copyright	Copyright (c) 2009 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

jimport('joomla.application.menu');

define('ARI_MENU_LEVEL_PARAM', J1_6 ? 'level' : 'sublevel');
define('ARI_MENU_PARENT_PARAM', J1_6 ? 'parent_id' : 'parent');

class AriMenu extends JMenu
{
	var $_menuType;
	var $_options;
	
	function __construct($menuType, $options = array())
	{
		$this->_menuType = $menuType;
		$this->_options = $options;
		
		parent::__construct($options);
	}
	
	function authorise($id)
	{
		$lang =& JFactory::getLanguage();
		$langTag = $lang->get('tag');
		$menuItem = $this->getItem($id);
		
		if (!empty($menuItem->language) && $menuItem->language != '*' && $menuItem->language != $langTag)
			return false;
		
		return parent::authorise($id);
	}
	
	function authorize($id)
	{
		if (J1_6)
			return $this->authorise($id);
		else
		{
			$user =& JFactory::getUser();

			return parent::authorize($id, $user->get('aid'));
		}
	}
	
	function getLevel($menuItem)
	{
		return J1_6 ? $menuItem->level : $menuItem->sublevel;
	}
	
	function getTopParent($id)
	{
		$menuItem = $this->getItem($id);
		if (empty($menuItem->tree))
			return 0;
		$tree = $menuItem->tree;
		
		return $tree[0];
	}
	
	function isChildOrSelf($id, $parentId)
	{
		$menuItem = $this->getItem($id);
		$tree = $menuItem->tree;
	
		return in_array($parentId, $tree);
	}
	
	function getSubMenu($startLevel = 0, $endLevel = -1, $parentId = null)
	{
		$menu = $this->getMenu();

		return new AriMenu($this->_menuType, array(
			'startLevel' => $startLevel,
			'endLevel' => $endLevel,
			'parent' => $parentId
		));
	}
	
	function hasChilds($id)
	{
		$parentParam = ARI_MENU_PARENT_PARAM;
		$menuItem =& $this->getItem($id);		
		if (is_null($menuItem))
			return false;
			
		$subItems = $this->getItems(ARI_MENU_LEVEL_PARAM, $this->getLevel($menuItem) + 1);
		if (empty($subItems))
			return false;

		foreach ($subItems as $subItem)
		{
			if ($subItem->$parentParam == $id)
				return true;
		}
		
		return false;
	}
	
	function getActive()
	{
		$app =& JFactory::getApplication();
		$menu = $app->getMenu();
		$active = $menu->getActive();
			
		return $active;
	}

	function isSelfOrParentActive($id)
	{
		$menuActive = $this->getActive();
		if (is_null($menuActive))
			return false;

		if ($menuActive->id == $id)
			return true;
			
		$currentItem = $this->resolveAliasById($id);
		if (empty($currentItem) || empty($currentItem->tree))
			return false;
			
		$tree = $currentItem->tree;
			
		return in_array($menuActive->id, $tree) && (array_search($menuActive->id, $tree) >= array_search($id, $tree));
	}
	
	function getLink($id)
	{
		$link = null;
		$menuItem =& $this->getItem($id);
		if (is_null($menuItem))
			return $link;
			
		$menuParams = $this->getParams($id);
		$link = $menuItem->link;
		$menuType = $menuItem->type;
		$menuId = $menuItem->id;
		if ($menuItem->type == 'menulink' || $menuItem->type == 'alias')
		{
			$aliasId = J1_6
				? $menuParams->get('aliasoptions')
				: $this->getItemId($link);
			if ($aliasId > 0)
			{
				$app =& JFactory::getApplication();
				$menu = $app->getMenu();
				
				$aliasMenuItem =& $menu->getItem($aliasId);
				$menuType = $aliasMenuItem->type;
				$link = $aliasMenuItem->link;
				$menuId = $aliasMenuItem->id;				
			}
		}

		$id = $menuItem->id;
		if ($link)
		{
			if ($menuType == 'url')
			{ 
				if ((strpos($link, 'index.php?') === 0) && (strpos($link, 'Itemid=') === false)) 
				{
					$link .= '&amp;Itemid=' . $menuId;
				}
			}
			else 
			{
				$router = JSite::getRouter();
				$link = $router->getMode() == JROUTER_MODE_SEF ? 'index.php?Itemid=' . $menuId : $link . '&Itemid=' . $menuId; 
			}

			if (strcasecmp(substr($link, 0, 4), 'http') && (strpos($link, 'index.php?') !== false))
			{
				$secure = $menuParams->def('secure', 0);
				$link = JRoute::_($link, true, $secure);
			}
					
			$link = JRoute::_($link, false);
		}
		else 
		{ 
			$link = 'javascript:void(0);';
		}

		return $link;
	}
	
	function resolveAliasById($id)
	{
		$menuItem =& $this->resolveAlias($this->getItem($id));
		
		$app =& JFactory::getApplication();
		$menu = $app->getMenu();
		
		return $menuItem ? $menu->getItem($menuItem->id) : 0;
	}
	
	function resolveAlias($menuItem)
	{
		if ($menuItem && $menuItem->type == 'menulink' || $menuItem->type == 'alias')
		{
			$menuParams = $this->getParams($menuItem->id);
			$aliasId = J1_6
				? $menuParams->get('aliasoptions')
				: $this->getItemId($menuItem->link);
				
			if ($aliasId > 0)
			{
				$app =& JFactory::getApplication();
				$menu = $app->getMenu();
				
				$menuItem = $this->resolveAlias($menu->getItem($aliasId));
			}
		}
		
		return $menuItem;
	}
	
	function load()
	{
		$app =& JFactory::getApplication();
		$menu = $app->getMenu();

		$startLevel = isset($this->_options['startLevel']) ? $this->_options['startLevel'] : 0;
		$endLevel = isset($this->_options['endLevel']) ? $this->_options['endLevel'] : -1;
		$parent = isset($this->_options['parent']) ? $this->_options['parent'] : null;

		$originalMenuItems = $menu->getItems('menutype', $this->_menuType);
		$menuItems = array();
		
		$parentParam = ARI_MENU_PARENT_PARAM;
		foreach ($originalMenuItems as $menuItem)
		{
			if ($menuItem->menutype != $this->_menuType || 
				$this->getLevel($menuItem) < $startLevel || 
				($endLevel > -1 && $this->getLevel($menuItem) > $endLevel))
				continue ;
				
			if ($parent)
			{
				$isChild = false;
				$parentMenuItem = $menuItem;
				while ($parentMenuItem)
				{
					if ($parentMenuItem->$parentParam == $parent)
					{
						$isChild = true;
						break;
					}
					
					$parentMenuItem = $menu->getItem($parentMenuItem->$parentParam);
				}
				
				if (!$isChild)
					continue ;
			}

			$menuItems[$menuItem->id] = $menuItem;
		}

		$this->_items = $menuItems;

		return $this->_items;
	}

	function getItemId($query)
	{
		$matches = array();
		preg_match('/Itemid=([0-9]+)/', $query, $matches);

		return isset($matches[1]) ? $matches[1] : 0;
	}
}