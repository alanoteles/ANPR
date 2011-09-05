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
 * CheckSystem controller.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ControllerCheckSystem
{
    // component version
	var $version = '<strong>3.1.2 stable</strong>';
	// status of component tables
	var $groupsDB_status = false;
	var	$tabsDB_status = false;
	var	$optionsDB_status = false;
	// prefix for database tables
	var $prefix = '';	
	
	/**
	 * ControllerCheckSystem::task()
	 * 
	 * @param mixed $task
	 * @return null
	 */
	 
	function task($task)
	{
		switch($task)
		{
			case 'info' : $this->info(); break;
			case 'show_mainpage' : global $mainframe;$mainframe->redirect('index.php?option=com_gk3_tabs_manager&c=mainpage'); break; 
			case 'index' : 
			default: $this->index(); break;
		}
	}
	
	/**
	 * ControllerCheckSystem::index()
	 * 
	 * @return null
	 */
	 
	function index()
	{
		require_once(JPATH_COMPONENT.DS.'views'.DS.'check.system.view.php');
		ViewCheckSystem::mainpage();
	}
	
	/**
	 * ControllerCheckSystem::info()
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
	 * ControllerCheckSystem::DBStatus()
	 * 
	 * @return null
	 */
	 
	function DBStatus()
	{
		// getting tables list
		$db =& JFactory::getDBO();
		$results = $db->getTableList();
		// getting prefix values
		$jconf = new JConfig();
		$this->prefix = $jconf->dbprefix;	
		// setting tables status
		for($i=0;$i < count($results);$i++)
		{
			if($results[$i] == $this->prefix.'gk3_tabs_manager_groups') $this->groupsDB_status = true;
			if($results[$i] == $this->prefix.'gk3_tabs_manager_tabs') $this->tabsDB_status = true;
			if($results[$i] == $this->prefix.'gk3_tabs_manager_options') $this->optionsDB_status = true;
		}	
	}

	/**
	 * ControllerCheckSystem::DBTableStatus()
	 * 
	 * @param mixed $table
	 * @return null
	 */
	 
	function DBTableStatus($table)
	{
		// check table name and write
		if($table == 'gk3_tabs_manager_groups')
		{
			echo ($this->groupsDB_status) ? 
			'<strong><font color="green">'.JText::_('CSC_YES').'</font></strong>' : 
			'<strong><font color="red">'.JText::_('CSC_NO').'</font></strong>';
		}
		elseif($table == 'gk3_tabs_manager_tabs')
		{
			echo ($this->tabsDB_status) ? 
			'<strong><font color="green">'.JText::_('CSC_YES').'</font></strong>' : 
			'<strong><font color="red">'.JText::_('CSC_NO').'</font></strong>';
		}
		elseif($table == 'gk3_tabs_manager_options')
		{
			echo ($this->optionsDB_status) ? 
			'<strong><font color="green">'.JText::_('CSC_YES').'</font></strong>' : 
			'<strong><font color="red">'.JText::_('CSC_NO').'</font></strong>';
		}
	}
}

/* End of file check.system.php */
/* Location: ./controllers/check.system.php */