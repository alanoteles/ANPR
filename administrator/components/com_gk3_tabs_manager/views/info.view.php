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
 * Info view.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class ViewInfo
{	
    /**
     * ViewInfo::mainpage()
     * 
     * @return null
     */
     
    function mainpage()
    {
    	//
    	$uri =& JURI::getInstance();
    	//
    	$modal_news =  (JRequest::getCmd( 'tmpl', '' ) == 'component') ? 1 : 0;
		//
		require_once(JPATH_COMPONENT.DS.'views'.DS.'navigation.view.php');
		require_once(JPATH_COMPONENT.DS.'views'.DS.'tmpl'.DS.'info.html.php');
    }
}

/* End of file info.view.php */
/* Location: ./views/gk3_tabs_manager/.view.php */