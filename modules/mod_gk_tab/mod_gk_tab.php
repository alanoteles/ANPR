<?php
	
	/**
	* GK Tab - main PHP file
	* @package Joomla!
	* @Copyright (C) 2009 Gavick.com
	* @ All rights reserved
	* @ Joomla! is Free Software
	* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
	* @ version $Revision: 1.0.0 $
	**/
	
	// no direct access
	defined('_JEXEC') or die('Restricted access');
	
	// helper loading
	require_once (dirname(__FILE__).DS.'helper.php');
	// 
	if (!class_exists('GK_Date')) 
	{
		require_once (dirname(__FILE__).DS.'gk_classes'.DS.'date.class.php');
	}
	//
	$helper = new GKTabHelper(); 
	// run variables validation
	$helper->init($params);
	// creating XHTML code	
	$helper->render($params);

?>