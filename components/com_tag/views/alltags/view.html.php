<?php
/**
 * @package Component Tag for Joomla! 1.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
jimport( 'joomla.application.pathway');

class TagViewAllTags extends JView
{
	function display($tpl = null)
	{
		$allTags=$this->get('AllTags');
        $this->assignRef('allTags',$allTags);
		$this->defaultTpl($tpl);


	}

	function defaultTpl($tpl=null){

		parent::display($tpl);

	}

}
