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
 * Info controller.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ControllerInfo
{
	
	/**
	 * ControllerInfo::task()
	 * 
	 * @param mixed $task
	 * @return null
	 */
	 
	function task($task)
	{
		if($task != 'show_mainpage')
		{
			$this->index();
		}
		else
		{
			global $mainframe;
			$mainframe->redirect('index.php?option=com_gk3_tabs_manager&c=mainpage');
		}
	}
	
	/**
	 * ControllerInfo::index()
	 * 
	 * @return null
	 */
	 
	function index()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'info.view.php');
		ViewInfo::mainpage();
	}
}

/* End of file info.php */
/* Location: ./controllers/info.php */