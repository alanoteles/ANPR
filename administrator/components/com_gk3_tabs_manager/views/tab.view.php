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
 * Tab view.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class ViewTab
{	    
    /**
     * ViewTab::addTab()
     * 
     * @return null
     */
     
    function addTab()
    {
    	//
    	$uri =& JURI::getInstance();
    	//
    	$gid = (isset($_GET['gid'])) ? $_GET['gid'] : $_POST['gid'];
		//
    	require_once(JPATH_COMPONENT.DS.'views'.DS.'navigation.view.php');
    	//
		require_once(JPATH_COMPONENT.DS.'models'.DS.'option.php');
		$option_model = new ModelOption();
		$wysiwyg = (int) $option_model->getOption('wysiwyg');
		$article_id = (int) $option_model->getOption('article_id');
		require_once(JPATH_COMPONENT.DS.'views'.DS.'tmpl'.DS.'tab.add.html.php');			
    }

    /**
     * ViewTab::editTab()
     * 
     * @return null
     */
     
    function editTab()
    {
    	global $mainframe;
    	//
    	$uri =& JURI::getInstance();
    	//
    	require_once(JPATH_COMPONENT.DS.'models'.DS.'tab.php');
		$tab_model = new ModelTab();
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$gid = (isset($_GET['gid'])) ? $_GET['gid'] : $_POST['gid'];
		$data = $tab_model->getTab($cid[0]);    	
    	//
    	if($data !== FALSE)
    	{
			//
    		require_once(JPATH_COMPONENT.DS.'views'.DS.'navigation.view.php');
			require_once(JPATH_COMPONENT.DS.'models'.DS.'option.php');
			$option_model = new ModelOption();
			$wysiwyg = (int) $option_model->getOption('wysiwyg');
			$article_id = (int) $option_model->getOption('article_id');
			require_once(JPATH_COMPONENT.DS.'views'.DS.'tmpl'.DS.'tab.edit.html.php');			
		}
		else
		{
			// basic variables
			$option	= JRequest::getCmd('option');
			$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));	
			//
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&c=group&task=view&cid[]='.$gid, JText::_('SELECTED_TAB_DOES_NOT_EXIST'),'error');
		}
    }
}

/* End of file tab.view.php */
/* Location: ./views/gk3_tabs_manager/tab.view.php */