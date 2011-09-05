<?php
/**
* @version		$Id: config.php 221 2011-06-11 17:30:33Z happy_noodle_boy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
class WFInlinepopupsPluginConfig {
	public function getStyles(){	
		$wf = WFEditor::getInstance(); 
		// only required if we're packing css
		if ($wf->getParam('editor.compress_css', 0)) {
			jimport('joomla.filesystem.folder');
			// get UI Theme
			$theme   = $wf->getParam('editor.dialog_theme', 'jce');
			$ui      = JFolder::files(JPATH_COMPONENT_ADMINISTRATOR . DS . 'media' . DS . 'css' . DS . 'jquery' . DS . $theme, '\.css$');
	                    
	 		// add ui theme css file
			return array(
				JPATH_COMPONENT_ADMINISTRATOR . DS . 'media' . DS . 'css' . DS . 'jquery' . DS . $theme . DS . basename($ui[0]),
				dirname(dirname(__FILE__)) . DS . 'css' . DS . 'dialog.css'
			);
		}
	}
}
?>