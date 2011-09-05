<?php
/**
 * @package Component Tag for Joomla! 1.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );

class TagViewCss extends JView
{

	function display($tpl = null)
	{

		$this->defaultTpl($tpl);

	}

	function defaultTpl($tpl=null){
		JToolBarHelper::title(   JText::_( 'TEMPLATE MANAGER' ), 'tag.png' );
		JToolBarHelper::save('save',JText::_('SAVE'));
		JToolBarHelper::spacer();
		JToolBarHelper::customX('restore','default','',JText::_('RESTORE DEFAULT'),false);
		JToolBarHelper::spacer();
		JToolBarHelper::back(JText::_( 'CONTROL PANEL'),'index.php?option=com_tag');
		$tagCssFile=JPATH_COMPONENT_SITE.DS.'css'.DS.'tagcloud.css';
		$isCssWritable=is_writable($tagCssFile);
		$cssFileContent=file_get_contents($tagCssFile);
		$this->assign('isCssWritable',$isCssWritable);
		$this->assignRef('cssFileName',$tagCssFile);
		$this->assignRef('cssFileContent',$cssFileContent);
		parent::display($tpl);
	}



}
