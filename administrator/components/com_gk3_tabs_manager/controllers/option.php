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
 * Option controller.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ControllerOption
{
	
	/**
	 * ControllerOption::task()
	 * 
	 * @param mixed $task
	 * @return null
	 */
	 
	function task($task)
	{
		if($task == 'show_mainpage')
		{
			global $mainframe;
			$mainframe->redirect('index.php?option=com_gk3_tabs_manager&c=mainpage');
		}
		else
		{
			// switching task
			if($task == 'save')
			{
				$this->save();
			}
			elseif($task != 'info')
			{
				$this->index();	
			}
			else
			{
				$this->info();
			}	
		}
	}
	
	/**
	 * ControllerOption::index()
	 * 
	 * @return null
	 */
	 
	function index()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'option.view.php');
		ViewOption::mainpage();
	}
	
	/**
	 * ControllerOption::info()
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
	 * ControllerOption::save()
	 * 
	 * @return null
	 */
	 
	function save()
	{
		global $mainframe;
		require_once(JPATH_COMPONENT.DS.'models'.DS.'option.php');
		$option_model = new ModelOption();
		// basic variables
		$option	= JRequest::getCmd('option');
		//
		$tmpl = $_POST['tmpl'];
		//
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
		// operation success ?
		if($option_model->setOptions())
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=option'.(($tmpl == 'component') ? '&tmpl=component' : ''), JText::_('SETTINGS_HAVE_BEEN_SAVED'));
		}
		else
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=option'.(($tmpl == 'component') ? '&tmpl=component' : ''), JText::_('SETTINGS_HAVE_NOT_BEEN_SAVED'), 'error');		
		}
	}
}

/* End of file option.php */
/* Location: ./controllers/option.php */