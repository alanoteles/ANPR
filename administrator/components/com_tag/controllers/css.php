<?php
/**
 * @package Component Tag for Joomla! 1.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/


defined('_JEXEC') or die();

class TagControllerCss extends TagController
{

	function __construct()
	{
		parent::__construct();
	}
	function execute( $task ){
		switch ($task){
			case 'save':
				$this->save();
				break;
			case 'restore':
				$this->restore();
				break;

			default:
				$this->display();
		}

	}

	/**
	 * display the form
	 * @return void
	 */
	function display()
	{
		JRequest::setVar( 'view', 'css' );
		parent::display();
	}




	function save()
	{

		$updatedCss=$_POST['csscontent'];
		$tagCssFile=JPATH_COMPONENT_SITE.DS.'css'.DS.'tagcloud.css';
		file_put_contents($tagCssFile,$updatedCss);

		JRequest::setVar( 'view', 'css' );
		parent::display();

	}
	function restore(){
		$tagCssFile=JPATH_COMPONENT_SITE.DS.'css'.DS.'tagcloud.css';
		$defaultCssFile=JPATH_COMPONENT_SITE.DS.'css'.DS.'tagcloud.default.css';
		$defaultCssFileContent=file_get_contents($defaultCssFile);
		file_put_contents($tagCssFile,$defaultCssFileContent);

		JRequest::setVar( 'view', 'css' );
		parent::display();
	}

}
?>
