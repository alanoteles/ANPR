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
 * Toolbar class.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class Toolbar{
	
	function check_system()
	{
		JToolBarHelper::title( 'Tabs Manager GK3 - '.JText::_( 'TOOLBAR_CHECKSYSTEM' ) );
		JToolBarHelper::back();		
		JToolBarHelper::custom( 'show_mainpage', 'frontpage.png', 'frontpage_f2.png', JText::_('MAINPAGE'), false, false );
		JToolBarHelper::custom( 'info', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
	}
	
	function news()
	{
		JToolBarHelper::title( 'Tabs Manager GK3 - '.JText::_( 'TOOLBAR_GAVICKNEWS' ) );
		JToolBarHelper::back();
		JToolBarHelper::custom( 'show_mainpage', 'frontpage.png', 'frontpage_f2.png', JText::_('MAINPAGE'), false, false );
		JToolBarHelper::custom( 'info', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
	}
	
	function info()
	{
		JToolBarHelper::title( 'Tabs Manager GK3 - '.JText::_( 'TOOLBAR_INFO' ) );
		JToolBarHelper::back();
		JToolBarHelper::custom( 'show_mainpage', 'frontpage.png', 'frontpage_f2.png', JText::_('MAINPAGE'), false, false );
		JToolBarHelper::custom( 'info', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );		
	}
	
	function options()
	{
		JToolBarHelper::title( 'Tabs Manager GK3 - '.JText::_( 'TOOLBAR_OPTIONS' ) );
		JToolBarHelper::back();
		JToolBarHelper::custom( 'show_mainpage', 'frontpage.png', 'frontpage_f2.png', JText::_('MAINPAGE'), false, false );
		JToolBarHelper::save( 'save' );
		JToolBarHelper::custom( 'info', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );		
	}
	
	function mainpage()
	{
		JToolBarHelper::title( 'Tabs Manager GK3 - '.JText::_( 'TOOLBAR_MAINPAGE' ) );
		JToolBarHelper::back();
		JToolBarHelper::custom( 'show_mainpage', 'frontpage.png', 'frontpage_f2.png', JText::_('MAINPAGE'), false, false );
		JToolBarHelper::custom( 'group', 'edit.png', 'edit_f2.png', JText::_('MANAGE_GROUPS'), false, false );
		JToolBarHelper::custom( 'option', 'config.png', 'config_f2.png', JText::_('OPTIONS'), false, false );
		JToolBarHelper::custom( 'check_system', 'apply.png', 'apply_f2.png', JText::_('CHECK_SYSTEM'), false, false );
		JToolBarHelper::custom( 'news', 'css.png', 'css_f2.png', JText::_('GAVICK_NEWS'), false, false );
		JToolBarHelper::custom( 'info', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );	
	}
	
	function view_groups()
	{
		JToolBarHelper::title( 'Tabs Manager GK3 - '.JText::_( 'TOOLBAR_VIEWGROUPS' ) );
		JToolBarHelper::back();
		JToolBarHelper::custom( 'show_mainpage', 'frontpage.png', 'frontpage_f2.png', JText::_('MAINPAGE'), false, false );
		JToolBarHelper::addNew( 'add', JText::_( 'TOOLBAR_B_ADDGROUP' ));
		JToolBarHelper::editListX( 'edit', JText::_( 'TOOLBAR_B_EDITGROUP' ));
		JToolBarHelper::custom( 'view', 'preview.png', 'preview_f2.png', JText::_( 'TOOLBAR_B_VIEWGROUP' ), true, false );
		JToolBarHelper::deleteList( JText::_('TOOLBAR_B_REALLYWANTREMOVEGROUPS'), 'delete_group');
		JToolBarHelper::custom( 'info', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
	}
	
	function add_group()
	{
		JToolBarHelper::title( JText::_( 'Tabs Manager GK3 - '.JText::_('TOOLBAR_ADDGROUP' ) ));
		JToolBarHelper::back();
		JToolBarHelper::custom( 'show_mainpage', 'frontpage.png', 'frontpage_f2.png', JText::_('MAINPAGE'), false, false );
		JToolBarHelper::save( 'add_group' );
		JToolBarHelper::cancel( 'cancel', JText::_('CLOSE') );
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
	}
	
	function edit_group()
	{
		JToolBarHelper::title( JText::_( 'Tabs Manager GK3 - '.JText::_('TOOLBAR_EDITGROUP' ) ));
		JToolBarHelper::back();
		JToolBarHelper::custom( 'show_mainpage', 'frontpage.png', 'frontpage_f2.png', JText::_('MAINPAGE'), false, false );
		JToolBarHelper::save( 'edit_group' );
		JToolBarHelper::cancel( 'cancel', JText::_('CLOSE') );
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
	}
	
	function view_group()
	{
		JToolBarHelper::title( 'Tabs Manager GK3 - '.JText::_('TOOLBAR_VIEWGROUP') );
		JToolBarHelper::back();
		JToolBarHelper::custom( 'show_mainpage', 'frontpage.png', 'frontpage_f2.png', JText::_('MAINPAGE'), false, false );
		JToolBarHelper::custom( 'publish_tab', 'publish.png', 'publish_f2.png', JText::_( 'TOOLBAR_B_PUBLISHTAB' ), true, false );
		JToolBarHelper::custom( 'unpublish_tab', 'unpublish.png', 'unpublish_f2.png', JText::_( 'TOOLBAR_B_UNPUBLISHTAB' ), true, false );
		JToolBarHelper::addNew( 'add', JText::_( 'TOOLBAR_B_ADDTAB' ));
		JToolBarHelper::editListX( 'edit', JText::_( 'TOOLBAR_B_EDITTAB' ));
		JToolBarHelper::deleteList( JText::_( 'TOOLBAR_B_REALLYWANTREMOVETABS' ), 'delete_tab');
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
	}

	function add_tab()
	{
		JToolBarHelper::title( 'Tabs Manager GK3 - '.JText::_( 'TOOLBAR_ADDTAB' ) );
		JToolBarHelper::back();
		JToolBarHelper::custom( 'show_mainpage', 'frontpage.png', 'frontpage_f2.png', JText::_('MAINPAGE'), false, false );
		JToolBarHelper::save( 'add_tab' );
		JToolBarHelper::cancel( 'cancel', JText::_('CLOSE') );
		JToolBarHelper::custom( 'info', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
	}
	
	function edit_tab()
	{
		JToolBarHelper::title( 'Tabs Manager GK3 - '.JText::_( 'TOOLBAR_EDITTAB' ));
		JToolBarHelper::back();
		JToolBarHelper::custom( 'show_mainpage' , 'frontpage.png', 'frontpage_f2.png' , JText::_('MAINPAGE') , false , false );
		JToolBarHelper::custom( 'apply_tab', 'apply.png', 'apply_f2.png', JText::_('APPLY'), false, false );
		JToolBarHelper::save( 'edit_tab' );
		JToolBarHelper::cancel( 'cancel' , JText::_('CLOSE') );
		JToolBarHelper::custom( 'info' , 'help.png' , 'help_f2.png' , JText::_('HELP') , false , false );
	}
}

/* End of file class.toolbar.php */
/* Location: ./interface/class.toolbar.php */