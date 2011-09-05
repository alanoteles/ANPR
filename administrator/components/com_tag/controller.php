<?php
/**
 * @package Component Tag for Joomla! 1.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
jimport('joomla.application.component.controller');

/**
 * Joomla Tag component Controller
 *
 */
class TagController extends JController
{
	function __construct()
	{
		parent::__construct();

	}

	function display()
	{
		$view=JRequest::getVar('view');
		if(!isset($view)){
			JRequest::setVar( 'view', 'frontpage' );
		}
		parent::display();
	}

}
?>
