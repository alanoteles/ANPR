<?php

/**
 * 
 * @version		3.0.0
 * @package		Joomla
 * @subpackage	Tabs Manager GK3
 * @copyright	Copyright (C) 2008 - 2009 GavickPro. All rights reserved.
 * @license		GNU/GPL
 * 
 * ==========================================================================
 * 
 * Basic file for component administration.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Loading component base.css file
// create instances of basic Joomla! classes
$document =& JFactory::getDocument();
$uri =& JURI::getInstance();
// add stylesheets to document header
$document->addStyleSheet( $uri->root().'administrator/components/com_gk3_tabs_manager/interface/css/base.css', 'text/css' );
// Getting controller name from URL
$controllerName = JRequest::getCmd( 'c', 'mainpage' );

// Switching to requested controller
switch($controllerName)
{	
	case 'check_system' :
		// Including requested controller file
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.'check.system.php');
		// Creating new instance of controller
		$controller = new ControllerCheckSystem();
	break;
	
	case 'news' : 
		// Including requested controller file
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.'gavick.news.php');
		// Creating new instance of controller
		$controller = new ControllerGavickNews();
	break;
	
	case 'group' :
		// Including requested controller file
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.'group.php');
		// Creating new instance of controller
		$controller = new ControllerGroup();	
	break;
	
	case 'info' :
		// Including requested controller file
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.'info.php');
		// Creating new instance of controller
		$controller = new ControllerInfo();	
	break;
	
	case 'option' :
		// Including requested controller file
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.'option.php');
		// Creating new instance of controller
		$controller = new ControllerOption();	
	break;
	
	case 'tab':
		// Including requested controller file
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.'tab.php');
		// Creating new instance of controller
		$controller = new ControllerTab();	
	break;
	
	case 'mainpage':
	default:
		// Including requested controller file
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.'base.php');
		// Creating new instance of controller
		$controller = new ControllerBase();	
	break;
}

// Running controller task
$controller->task(JRequest::getCmd( 'task', 'index' ));

/* End of file admin.gk3_tabs_manager.php */
/* Location: ./admin.gk3_tabs_manager.php */