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

class TagViewTag extends JView
{

	function display($tpl = null)
	{
		$layout=JRequest::getCmd("layout","default");
		switch ($layout){
			case 'add':
				$this->add($tpl);
				break;
			case 'warning':
				$this->warning($tpl);
				break;
			default:
				$this->defaultTpl($tpl);
		}



	}

	function defaultTpl($tpl=null){
		JToolBarHelper::title(   JText::_( 'Tag Manager' ), 'tag.png' );
		JToolBarHelper::customX('batchsave','save','',JText::_('SAVE'),false);
		JToolBarHelper::spacer();
		JToolBarHelper::customX('clearall','delete','',JText::_('CLEAR ALL'),false);
		JToolBarHelper::spacer();
		JToolBarHelper::back(JText::_('CONTROL PANEL'),'index.php?option=com_tag');
		//get params
		$params = JComponentHelper::getParams('com_tag');
		$this->assignRef('params',		$params);
		//get data
		$tagList=& $this->get('tagList');

		$this->assignRef('tagList',$tagList);

		parent::display($tpl);
	}

	function add($tpl=null){
		$tags=&$this->get('tagsForArticle');
		$this->assignRef('tags',$tags);
		parent::display($tpl);
	}
	function warning($tpl=null){
		parent::display($tpl);
	}

}
