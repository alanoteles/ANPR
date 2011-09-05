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
 * Basic file for component administration - to generate standard toolbar.
 * 
 */

// Loading Toolbar class
require_once(JPATH_COMPONENT.DS.'interface'.DS.'class.toolbar.php');
// creating new instance of Toolbar class
$toolbar = new Toolbar();
// getting $_GET variables from URL
$T_controller = JRequest::getCmd( 'c', 'mainpage' );
$T_task = JRequest::getCmd( 'task', 'index' );

// switching tasks
switch ($T_controller)
{	
	case 'check_system' :
		$toolbar->check_system();
	break;
	
	case 'news' : 
		$toolbar->news();
	break;
	
	case 'group' :
		
		switch($T_task)
		{
			case 'add' :
				$toolbar->add_group();
			break;
			
			case 'edit' :
				$toolbar->edit_group();
			break;

			case 'view' :
				$toolbar->view_group();
			break;
			
			case 'view_groups' : 
			default :
				$toolbar->view_groups();
			break;
		}
		
	break;
	
	case 'info' :
		$toolbar->info();
	break;
	
	case 'option' :
		$toolbar->options();
	break;
	
	case 'tab':
		switch($T_task)
		{
			case 'add' :
				$toolbar->add_tab();	
			break;
			
			case 'edit' :
				$toolbar->edit_tab();
			break;
		}
	break;
	
	case 'mainpage':
	default:
		$toolbar->mainpage();
	break;
}

/* End of file toolbar.gk3_tabs_manager.php */
/* Location: ./toolbar.gk3_tabs_manager.php */