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
 * Tab controller.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ControllerTab
{
	
	/**
	 * ControllerTab::task()
	 * 
	 * @return null
	 */
	function task($task)
	{
		// switching task
		switch($task)
		{
			case 'saveorder' : $this->saveOrder(); break;
			case 'delete_tab' : $this->removeTab(); break;
			case 'publish_tab' : $this->publishTab(); break;
			case 'unpublish_tab' : $this->unpublishTab(); break;
			case 'info' : $this->info(); break;	
			case 'access_tab' : $this->accessTab(); break;
			case 'add' : $this->addTabForm(); break;
			case 'add_tab' : $this->addTab(); break;
			case 'edit' : $this->editTabForm(); break;
			case 'edit_tab' : $this->editTab(); break;
			case 'apply_tab' : $this->applyTab(); break;
			case 'cancel' : $this->cancel(); break;
			case 'show_mainpage' : global $mainframe;$mainframe->redirect('index.php?option=com_gk3_tabs_manager&c=mainpage'); break;
			case 'index' : 
			default: $this->index(); break;
		}
	}
	
	/**
	 * ControllerTab::index()
	 * 
	 * @return null
	 */
	function index()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'group.view.php');
		ViewGroup::mainpage();
	}
	
	/**
	 * ControllerTab::info()
	 * 
	 * @return null
	 */
	function info()
	{
		global $mainframe;
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		// reditect
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=info&task=help');	
	}
	
	/**
	 * ControllerTab::publishTab()
	 * 
	 * @return null
	 */
	function publishTab()
	{
		global $mainframe;
		require_once(JPATH_COMPONENT.DS.'models'.DS.'tab.php');
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$gid = JRequest::getString( 'gid', '', 'get' );
		$tab_model = new ModelTab();
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
		// operation success ?
		if($tab_model->publishTab($cid))
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('TAB_HAS_BEEN_PUBLISHED'));
		}
		else
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('TAB_DOES_NOT_EXIST'), 'error');		
		}		
	}
	
	/**
	 * ControllerTab::unpublishTab()
	 * 
	 * @return null
	 */
	function unpublishTab()
	{
		global $mainframe;
		require_once(JPATH_COMPONENT.DS.'models'.DS.'tab.php');
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$gid = JRequest::getString( 'gid', '', 'get' );
		$tab_model = new ModelTab();
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
		// operation success ?
		if($tab_model->unpublishTab($cid))
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('TAB_HAS_BEEN_UNPUBLISHED'));
		}
		else
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('TAB_DOES_NOT_EXIST'), 'error');		
		}
	}
	
	/**
	 * ControllerTab::saveOrder()
	 * 
	 * @return null
	 */
	function saveOrder()
	{
		global $mainframe;
		$order = JRequest::getVar( 'order', array (0), 'get', 'array' );
		$gid = JRequest::getString( 'gid', '', 'get' );
		require_once(JPATH_COMPONENT.DS.'models'.DS.'tab.php');
		$tab_model = new ModelTab();
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
		// save order
		$tab_model->orderTab($order, $gid);
		// redirect
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('TABS_ORDER_HAVE_BEEN_SAVED'));
	}
	
	/**
	 * ControllerTab::accessTab()
	 * 
	 * @return null
	 */
	function accessTab()
	{
		global $mainframe;
		require_once(JPATH_COMPONENT.DS.'models'.DS.'tab.php');
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$gid = JRequest::getString( 'gid', '', 'get' );
		$level = JRequest::getString( 'level', '', 'get' );
		$tab_model = new ModelTab();
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
		// operation success ?
		if($tab_model->accessTab($level, $cid[0]))
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('TAB_STATUS_HAS_BEEN_CHANGED'));
		}
		else
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('TAB_STATUS_HAS_NOT_BEEN_CHANGED'), 'error');		
		}
	}
	
	/**
	 * ControllerTab::removeTab()
	 * 
	 * @return null
	 */
	function removeTab()
	{
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$gid = JRequest::getString( 'gid', '', 'get' );
		require_once(JPATH_COMPONENT.DS.'models'.DS.'tab.php');
		$tab_model = new ModelTab();
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
		// operation success ?
		if($tab_model->removeTab($cid))
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('SELECTED_TABS_HAVE_BEEN_REMOVED'));
		}
		else
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('SELECTED_TABS_HAVE_NOT_BEEN_REMOVED'), 'error');		
		}
	}

	/**
	 * ControllerTab::addTabForm()
	 * 
	 * @return null
	 */
	function addTabForm()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'tab.view.php');
		ViewTab::addTab();
	}
	
	/**
	 * ControllerTab::addTab()
	 * 
	 * @return null
	 */
	 
	function addTab()
	{
		global $mainframe;
		require_once(JPATH_COMPONENT.DS.'models'.DS.'tab.php');
		$tab_model = new ModelTab();
		// basic variables
		$option	= JRequest::getCmd('option');
		$gid = $_POST['gid'];
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
		// operation success ?
		if($tab_model->addTab())
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('TAB_HAS_BEEN_ADDED'));
		}
		else
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('TAB_HAS_NOT_BEEN_ADDED'), 'error');		
		}
	}

	/**
	 * ControllerTab::editTabForm()
	 * 
	 * @return null
	 */
	 
	function editTabForm()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'tab.view.php');
		ViewTab::editTab();
	}

	/**
	 * ControllerTab::editTab()
	 * 
	 * @return null
	 */
	 
	function editTab()
	{
		global $mainframe;
		require_once(JPATH_COMPONENT.DS.'models'.DS.'tab.php');
		$tab_model = new ModelTab();
		$gid = $_POST['gid'];
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
		// operation success ?
		if($tab_model->editTab($cid[0]))
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('TAB_HAS_BEEN_EDITED'));
		}
		else
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('TAB_HAS_NOT_BEEN_EDITED'), 'error');		
		}
	}
	
	/**
	 * ControllerTab::applyTab()
	 * 
	 * @return null
	 */
	 
	function applyTab()
	{
		global $mainframe;
		require_once(JPATH_COMPONENT.DS.'models'.DS.'tab.php');
		$tab_model = new ModelTab();
		$gid = $_POST['gid'];
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
		// operation success ?
		if($tab_model->editTab($cid[0]))
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=tab&task=edit&gid='.$gid.'&cid[]='.$cid[0], JText::_('TAB_HAS_BEEN_EDITED'));
		}
		else
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=tab&task=edit&gid='.$gid.'&cid[]='.$cid[0], JText::_('TAB_HAS_NOT_BEEN_EDITED'), 'error');		
		}
	}
	
	/**
	 * ControllerTab::cancel()
	 * 
	 * @return null
	 */
	 
	function cancel()
	{
		global $mainframe;
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$gid = (isset($_POST['gid'])) ? $_POST['gid'] : $_GET['gid'];
		// redirect
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('PREVIOUS_ACTION_HAS_BEEN_CANCELED'), 'notice');	
	}
}

/* End of file tab.php */
/* Location: ./controllers/tab.php */