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

class TagViewImport extends JView
{

	function display($tpl = null)
	{

		$this->defaultTpl($tpl);

	}

	function defaultTpl($tpl=null){
		JToolBarHelper::title(   JText::_( 'IMPORT TAGS FROM OTHER COMPONENTS' ), 'tag.png' );

		JToolBarHelper::spacer();
		JToolBarHelper::customX('import','default','',JText::_('IMPORT'),false);
		JToolBarHelper::spacer();
		JToolBarHelper::back(JText::_( 'CONTROL PANEL'),'index.php?option=com_tag');

		parent::display($tpl);
	}



}
