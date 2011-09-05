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
 * Gavick News controller.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ControllerGavickNews
{	
	/**
	 * ControllerGavickNews::task()
	 * 
	 * @param mixed $task
	 * @return null
	 */
	 
	function task($task)
	{
		switch($task)
		{
			case 'view_news' : $this->view_news(); break;
			case 'view_all' : $this->view_all(); break;
			case 'info' : $this->info(); break;
			case 'show_mainpage' : global $mainframe;$mainframe->redirect('index.php?option=com_gk3_tabs_manager&c=mainpage'); break;
			case 'index' : 
			default: $this->view_all(); break;
		}
	}
	
	/**
	 * ControllerGavickNews::info()
	 * 
	 * @return null
	 */
	 
	function info()
	{
		global $mainframe;
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		// redirect
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=info&task=help');		
	}
	
	/**
	 * ControllerGavickNews::view_news()
	 * 
	 * @return null
	 */
	 
	function view_news()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'gavick.news.view.php');
		$view = new ViewGavickNews();
		$view->view_news();
	}
	
	/**
	 * ControllerGavickNews::view_all()
	 * 
	 * @return
	 */
	function view_all()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'gavick.news.view.php');
		$view = new ViewGavickNews();
		$view->view_all();
	}
}

/* End of file gavick.news.php */
/* Location: ./controllers/gavick.news.php */