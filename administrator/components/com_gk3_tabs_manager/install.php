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
 * Installation file.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Back function
function BackToInstall($e)
{
	// show error in alert
	echo '<script> alert("'.$e.'");window.history.go(-1);</script>';
	// stop script
	exit();
}

// install function
function com_install() 
{
	// creatung database interface
	$database = & JFactory::getDBO();
	// Swhowing header
	echo "<h2>Tabs Manager GK3</h2>";
	// component database actualization
	$database->setQuery('
	UPDATE 
		#__components 
	SET 
		`admin_menu_img` = "../administrator/components/com_gk3_tabs_manager/interface/images/com_logo_gk3.png"
	WHERE 
		`name` = "gk3_tabs_manager" 
		AND 
		`option` = "com_gk3_tabs_manager"
	');
	// when error - go back
	if (!$database->query()) BackToInstall($database->getErrorMsg());
	// actualization of link database
	$database->setQuery('
	UPDATE 
		#__components 
	SET 
		`link` = "option=com_gk3_tabs_manager" 
	WHERE 
		`name` = "gk3_tabs_manager" 
		AND 
		`option` = "com_gk3_tabs_manager"
	');
	// when error - go back
	if (!$database->query()) BackToInstall($database->getErrorMsg());
	// when all is OK - show info about successfull installation
	echo '<big>Thumbs Up!!!... or should we say, tabs up!!</big><p>That\'s right! More powerful and easy than ever, Tabs Manager Component reach level 3. An impressive and fantastic tool, with compliments from GavickPro Team, that will help you optimize and upgrade your Joomla!1.5 website, providing an easy and intuitive tabs production of high quality design for modules, articles or custom XHTML code display.</p><p>In addition, the Tabs Manager GK3 offers all websites developers the flexibility to produce their own concept of design, integrating easily unique CSS style. Therefore, no matter if you are a beginner or an expert, Tabs GK3 Manager component will help you take a step forward, for the most professional high quality presentation.</p><strong>An overview of Tabs manager GK3 component key features:</strong><ul><li>Joomla! 1.5 Native.</li><li>Javascript Framework Mootools</li><li>Option for use compressed engine script</li><li>New technique of assets Java Scripts files</li><li>Creation of tabs groups presentation</li><li>Custom tabs names</li><li>Provided with Tab GK1 module for content display</li><li>Support for multi language translation for components, plugins, extensions and modules</li><li>3 different styles presentation (horizontal, vertical and accordion)</li><li>Customize user style option formatting (for advanced users)</li><li>Integration of WYSIWYG editor for custom XHTML content production</li><li>Easy administration with Modalbox effect display</li><li>Lightweight, modern and fast-loading design.</li><li>Easy and friendly administration</li><li>Different amazing styles transitions effects</li><li>W3C XHTML 1.0 Transitional. W3C CSS Valid</li><li>Fully compatible IE7+, Firefox 2+, Flock 0.7+, Netscape, Safari, Opera 9.5, Chrome</li></ul>'; 
}

/* End of file install.php */
/* Location: ./install.php */