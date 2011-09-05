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
 * Option view.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class ViewOption
{	
    /**
     * ViewOption::mainpage()
     * 
     * @return null
     */
     
    function mainpage()
    {
    	$uri =& JURI::getInstance();
    	$modal_news =  (JRequest::getCmd( 'tmpl', '' ) == 'component') ? 1 : 0;
		require_once(JPATH_COMPONENT.DS.'models'.DS.'option.php');
		$option_model = new ModelOption();
		$rows = $option_model->getOptions();
		require_once(JPATH_COMPONENT.DS.'views'.DS.'navigation.view.php');
		require_once(JPATH_COMPONENT.DS.'views'.DS.'tmpl'.DS.'options.html.php');
    }
}

/* End of file option.view.php */
/* Location: ./views/gk3_tabs_manager/option.view.php */