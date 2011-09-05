<?php
/*
 * ARI Ext menu
 *
 * @package		ARI Ext Menu
 * @version		1.0.0
 * @author		ARI Soft
 * @copyright	Copyright (c) 2009 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

AriKernel::import('Web.JSON.JSONHelper');

class AriExtMenuHelper
{
	function loadAssets($loadExtJS = true)
	{
		static $loaded;
		
		if ($loaded)
			return ;

		$rootUrl = JURI::root(true) . '/modules/mod_ariextmenu/mod_ariextmenu/';
		$jsUrl = $rootUrl . 'js/';
		$cssUrl = $rootUrl . 'js/css/';

		$doc =& JFactory::getDocument();
		$doc->addStyleSheet($cssUrl . 'menu.min.css');
		$doc->addStyleSheet($cssUrl . 'menu.fix.css');
		$doc->addCustomTag('<!--[if IE]><link rel="stylesheet" type="text/css" href="' . $cssUrl . 'menu.ie.min.css" /><![endif]-->');
		if ($loadExtJS)
			$doc->addScript($jsUrl . 'ext-core.js');
		$doc->addScript($jsUrl . 'menu.min.js');
		$doc->addCustomTag('<!--[if lt IE 8]><script type="text/javascript" src="' . $jsUrl . 'fix.js"></script><![endif]-->');
		
		$loaded = true;
	}
	
	function initMenu($id, $params)
	{
		$loadExtJs = (bool)$params->get('loadExtJS', true);
		$loadMethod = $params->get('loadMethod', 'ready');
		AriExtMenuHelper::loadAssets($loadExtJs);
		
		$defMenuConfig = array(
			'direction' => 'horizontal',
			'delay' => 0.2,
			'autoWidth' => true,
			'transitionType' => 'fade',
			'transitionDuration' => 0.3,
			'animate' => true
		);

		$config = array();
		foreach ($defMenuConfig as $key => $defValue)
		{
			$value = AriUtils::parseValueBySample($params->get($key, $defValue), $defValue);
			if ($value != $defValue) $config[$key] = $value;
		}

		$zIndex = intval($params->get('zIndex', -1), 10);
		if ($zIndex > 0) $config['zIndex'] = $zIndex;
		
		$doc =& JFactory::getDocument();
		if ($loadMethod == 'load')
		{
			$doc->addScriptDeclaration(
				sprintf('Ext.EventManager.on(window, "load", function() { new Ext.ux.Menu("' . $id . '", %1$s); Ext.get("' . $id . '").select(".ux-menu-sub").removeClass("ux-menu-init-hidden"); });',
					AriJSONHelper::encode($config)));
		}
		else
		{
			$doc->addScriptDeclaration(
				sprintf('Ext.onReady(function() { new Ext.ux.Menu("' . $id . '", %1$s); Ext.get("' . $id . '").select(".ux-menu-sub").removeClass("ux-menu-init-hidden"); });',
					AriJSONHelper::encode($config)));
		}
		
		AriExtMenuHelper::addCustomStyles($id, $params);
	}
	
	function addCustomStyles($id, $params)
	{
		$styles = str_replace(array('{$id}'), array($id), $params->get('style'));
		$styles .= sprintf('UL#%1$s LI A{font-size:%2$s;font-weight:%3$s;text-transform:%4$s;text-align:%5$s;}',
			$id,
			$params->get('fontSize', '12px'),
			$params->get('fontWeight', 'normal'),
			$params->get('textTransform', 'none'),
			$params->get('textAlign', 'left'));
			
		$bgColor = $params->get('bgColor');
		if ($bgColor)
			$styles .= sprintf('UL#%1$s LI A{background:%2$s none;}',
				$id,
				$bgColor);
		$textColor = $params->get('textColor');
		if ($textColor)
			$styles .= sprintf('UL#%1$s LI A{color:%2$s;}',
				$id,
				$textColor);
				
		$bgHoverColor = $params->get('bgHoverColor');
		if ($bgHoverColor)
			$styles .= sprintf('UL#%1$s LI A:hover,UL#%1$s LI A:focus,UL#%1$s LI A.ux-menu-link-hover{background:%2$s none;}',
				$id,
				$bgHoverColor);
		$textHoverColor = $params->get('textHoverColor');
		if ($textHoverColor)
			$styles .= sprintf('UL#%1$s LI A:hover,UL#%1$s LI A:focus,UL#%1$s LI A.ux-menu-link-hover{color:%2$s;}',
				$id,
				$textHoverColor);
				
		$bgCurrentColor = $params->get('bgCurrentColor');
		if ($bgCurrentColor)
			$styles .= sprintf('UL#%1$s LI A.current{background:%2$s none;}',
				$id,
				$bgCurrentColor);
		$textCurrentColor = $params->get('textCurrentColor');
		if ($textCurrentColor)
			$styles .= sprintf('UL#%1$s LI A.current{color:%2$s;}',
				$id,
				$textCurrentColor);
		
		$inheritMain = (bool)$params->get('inheritMain', true);
		if (!$inheritMain)
		{
			$styles .= sprintf('UL#%1$s LI UL.ux-menu-sub A{font-size:%2$s;font-weight:%3$s;text-transform:%4$s;text-align:%5$s;}',
				$id,
				$params->get('sub_fontSize', '12px'),
				$params->get('sub_fontWeight', 'normal'),
				$params->get('sub_textTransform', 'none'),
				$params->get('sub_textAlign', 'left'));
				
			$bgColor = $params->get('sub_bgColor');
			if ($bgColor)
				$styles .= sprintf('UL#%1$s LI UL.ux-menu-sub A{background:%2$s none;}',
					$id,
					$bgColor);
			$textColor = $params->get('sub_textColor');
			if ($textColor)
				$styles .= sprintf('UL#%1$s LI UL.ux-menu-sub A{color:%2$s;}',
					$id,
					$textColor);
					
			$bgHoverColor = $params->get('sub_bgHoverColor');
			if ($bgHoverColor)
				$styles .= sprintf('UL#%1$s LI UL.ux-menu-sub A:hover,UL#%1$s LI UL.ux-menu-sub A:focus,UL#%1$s LI UL.ux-menu-sub A.ux-menu-link-hover{background:%2$s none;}',
					$id,
					$bgHoverColor);
			$textHoverColor = $params->get('sub_textHoverColor');
			if ($textHoverColor)
				$styles .= sprintf('UL#%1$s LI UL.ux-menu-sub A:hover,UL#%1$s LI UL.ux-menu-sub A:focus,UL#%1$s LI UL.ux-menu-sub A.ux-menu-link-hover{color:%2$s;}',
					$id,
					$textHoverColor);
					
			$bgCurrentColor = $params->get('sub_bgCurrentColor');
			if ($bgCurrentColor)
				$styles .= sprintf('UL#%1$s LI UL.ux-menu-sub A.current{background:%2$s none;}',
					$id,
					$bgCurrentColor);
			$textCurrentColor = $params->get('sub_textCurrentColor');
			if ($textCurrentColor)
				$styles .= sprintf('UL#%1$s LI UL.ux-menu-sub A.current{color:%2$s;}',
					$id,
					$textCurrentColor);				
		}

		if ($styles)
		{
			$doc =& JFactory::getDocument();
			$doc->addStyleDeclaration($styles);
		}
	}
}