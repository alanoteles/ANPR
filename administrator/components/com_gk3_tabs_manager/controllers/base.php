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
 * Base controller.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ControllerBase
{
	/**
	 * ControllerBase::task()
	 * 
	 * @param mixed $task
	 * @return null
	 */
	 
	function task($task)
	{
		if($task != 'show_mainpage')
		{
			switch($task)
			{
				case 'info' : 
					global $mainframe;
					// basic variables
					$option	= JRequest::getCmd('option');
					$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
					// redirect
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=info&task=help');			
				break;
	
				case 'group' :
					global $mainframe;
					// basic variables
					$option	= JRequest::getCmd('option');
					$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
					// redirect
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group');
				break;
	
				case 'tab' :
					global $mainframe;
					// basic variables
					$option	= JRequest::getCmd('option');
					$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
					// redirect
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=tab');
				break;
							
				case 'option' :
					global $mainframe;
					// basic variables
					$option	= JRequest::getCmd('option');
					$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
					// redirect
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=option');
				break;
				
				case 'check_system' : 
					global $mainframe;
					// basic variables
					$option	= JRequest::getCmd('option');
					$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
					// redirect
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=check_system');			
				break;
				
				case 'news' : 
					global $mainframe;
					// basic variables
					$option	= JRequest::getCmd('option');
					$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
					// redirect
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=news');			
				break;
						
				case 'index' : 
				default:
					$this->index();
				break;
			}
		}
		else
		{
			$this->index();
		}
	}
	
	/**
	 * ControllerBase::index()
	 * 
	 * @return null
	 */
	 
	function index()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'mainpage.view.php');
		ViewMainpage::mainpage();
	}
}

/* End of file base.php */
/* Location: ./controllers/base.php */