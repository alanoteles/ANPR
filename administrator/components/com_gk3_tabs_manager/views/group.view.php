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
 * Group view.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class ViewGroup
{	
    /**
     * ViewGroup::mainpage()
     * 
     * @return null
     */
     
    function mainpage()
    {
    	$uri =& JURI::getInstance();
    	require_once(JPATH_COMPONENT.DS.'models'.DS.'group.php');
		$group_model = new ModelGroup();
		$rows = $group_model->getGroups();
		require_once(JPATH_COMPONENT.DS.'models'.DS.'option.php');
		$option_model = new ModelOption();
		$group_shortcuts = (int) $option_model->getOption('group_shortcuts');
		require_once(JPATH_COMPONENT.DS.'views'.DS.'navigation.view.php');
		require_once(JPATH_COMPONENT.DS.'views'.DS.'tmpl'.DS.'group.all.html.php');
    }
    
    /**
     * ViewGroup::addGroup()
     * 
     * @return null
     */
     
    function addGroup()
    {
    	//
    	$uri =& JURI::getInstance();
    	//
    	require_once(JPATH_COMPONENT.DS.'views'.DS.'navigation.view.php');
		require_once(JPATH_COMPONENT.DS.'views'.DS.'tmpl'.DS.'group.add.html.php');
    }

    /**
     * ViewGroup::editGroup()
     * 
     * @return null
     */
     
    function editGroup()
    {
    	global $mainframe;
    	//
    	$uri =& JURI::getInstance();
    	//
    	require_once(JPATH_COMPONENT.DS.'models'.DS.'group.php');
		$group_model = new ModelGroup();
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$data = $group_model->getGroupData($cid[0]);    	
    	//
    	if($data !== FALSE)
    	{
			//
    		require_once(JPATH_COMPONENT.DS.'views'.DS.'navigation.view.php');
			require_once(JPATH_COMPONENT.DS.'views'.DS.'tmpl'.DS.'group.edit.html.php');
		}
		else
		{
			// basic variables
			$option	= JRequest::getCmd('option');
			$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
			//
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group', JText::_('SELECTED_GROUP_DOES_NOT_EXIST'),'error');
		}
    }
    
    /**
     * ViewGroup::viewGroup()
     * 
     * @return null
     */
     
    function viewGroup()
    {
    	global $mainframe;
    	//
    	$uri =& JURI::getInstance();
    	//
    	require_once(JPATH_COMPONENT.DS.'models'.DS.'tab.php');
		$group_tab = new ModelTab();
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$rows = $group_tab->getTabs($cid[0]);    	
		require_once(JPATH_COMPONENT.DS.'models'.DS.'option.php');
		$option_model = new ModelOption();
		$tab_shortcuts = (int) $option_model->getOption('tab_shortcuts');
    	//
    	if($rows !== FALSE)
    	{
			//
    		require_once(JPATH_COMPONENT.DS.'views'.DS.'navigation.view.php');
			require_once(JPATH_COMPONENT.DS.'views'.DS.'tmpl'.DS.'group.view.html.php');
		}
		else
		{
			// basic variables
			$option	= JRequest::getCmd('option');
			$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
			//
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group', JText::_('SELECTED_GROUP_DOES_NOT_EXIST'),'error');
		}
    }
}

/* End of file group.view.php */
/* Location: ./views/gk3_tabs_manager/group.view.php */