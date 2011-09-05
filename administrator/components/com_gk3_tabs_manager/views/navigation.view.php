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
 * Navigation view.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class ViewNavigation
{
    /**
     * ViewNavigation::generate()
     * 
     * @param mixed $navigation_array
     * @return null
     */
     
    function generate($navigation_array)
    {
    	//
    	$uri =& JURI::getInstance();
		//
		require_once(JPATH_COMPONENT.DS.'views'.DS.'tmpl'.DS.'navigation.html.php');
    }
}

/* End of file navigation.view.php */
/* Location: ./views/gk3_tabs_manager/navigation.view.php */