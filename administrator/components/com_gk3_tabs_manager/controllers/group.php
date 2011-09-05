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
 * Group controller.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ControllerGroup
{
	
	/**
	 * ControllerGroup::task()
	 * 
	 * @param mixed $task
	 * @return null
	 */
	 
	function task($task)
	{
		switch($task)
		{
			case 'info' : $this->info(); break;
			case 'add' : $this->addGroupForm(); break;
			case 'add_group' : $this->addGroup(); break;
			case 'edit' : $this->editGroupForm(); break;
			case 'edit_group' : $this->editGroup(); break;
			case 'delete_group' : $this->removeGroup(); break;
			case 'view' : $this->viewGroup(); break;
			case 'cancel' : $this->cancel(); break;
			case 'show_mainpage' : global $mainframe;$mainframe->redirect('index.php?option=com_gk3_tabs_manager&c=mainpage'); break;
			case 'index' : 
			default: $this->index(); break;
		}
	}
	
	/**
	 * ControllerGroup::index()
	 * 
	 * @return null
	 */
	 
	function index()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'group.view.php');
		ViewGroup::mainpage();
	}
	
	/**
	 * ControllerGroup::info()
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
	 * ControllerGroup::addGroupForm()
	 * 
	 * @return null
	 */
	 
	function addGroupForm()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'group.view.php');
		ViewGroup::addGroup();
	}
	
	/**
	 * ControllerGroup::addGroup()
	 * 
	 * @return null
	 */
	 
	function addGroup()
	{
		global $mainframe;
		require_once(JPATH_COMPONENT.DS.'models'.DS.'group.php');
		$group_model = new ModelGroup();
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
		// operation success ?
		if($group_model->addGroup())
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group', JText::_('GROUP_HAS_BEEN_ADDED'));
		}
		else
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group', JText::_('GROUP_HAS_NOT_BEEN_ADDED'), 'error');		
		}
	}

	/**
	 * ControllerGroup::editGroupForm()
	 * 
	 * @return null
	 */
	 
	function editGroupForm()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'group.view.php');
		ViewGroup::editGroup();
	}

	/**
	 * ControllerGroup::editGroup()
	 * 
	 * @return null
	 */
	 
	function editGroup()
	{
		global $mainframe;
		require_once(JPATH_COMPONENT.DS.'models'.DS.'group.php');
		$group_model = new ModelGroup();
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
		// operation success
		if($group_model->editGroup())
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group', JText::_('GROUP_HAS_BEEN_EDITED'));
		}
		else
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group', JText::_('GROUP_HAS_NOT_BEEN_EDITED'), 'error');		
		}
	}
	
	/**
	 * ControllerGroup::removeGroup()
	 * 
	 * @return null
	 */
	 
	function removeGroup()
	{
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		require_once(JPATH_COMPONENT.DS.'models'.DS.'group.php');
		$group_model = new ModelGroup();
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
		// operation success ?
		if($group_model->removeGroup($cid))
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group', JText::_('SELECTED_GROUPS_HAVE_BEEN_REMOVED'));
		}
		else
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group', JText::_('SELECTED_GROUPS_HAVE_NOT_BEEN_REMOVED'), 'error');		
		}
	}
	
	/**
	 * ControllerGroup::viewGroup()
	 * 
	 * @return null
	 */
	 
	function viewGroup()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'group.view.php');
		$view = new ViewGroup();
		$view->viewGroup();
	}
	
	/**
	 * ControllerGroup::cancel()
	 * 
	 * @return null
	 */
	 
	function cancel()
	{
		global $mainframe;
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		// redirect
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group', JText::_('PREVIOUS_ACTION_HAS_BEEN_CANCELED'), 'notice');	
	}
}

/* End of file group.php */
/* Location: ./controllers/group.php */