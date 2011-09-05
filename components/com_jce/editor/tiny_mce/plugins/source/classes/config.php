<?php
/**
 * @version		$Id: config.php 226 2011-06-13 09:59:05Z happy_noodle_boy $
 * @package      JCE
 * @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
 * @author		Ryan Demmer
 * @license      GNU/GPL
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class WFSourcePluginConfig
{
	public function getConfig(&$settings)
	{
		$wf = WFEditor::getInstance();

		$settings['source_higlight'] 	= $wf->getParam('source.highlight', 1, 1);
		$settings['source_numbers'] 	= $wf->getParam('source.numbers', 1, 1);
		$settings['source_wrap'] 		= $wf->getParam('source.wrap', 1, 1);
		$settings['source_theme'] 		= $wf->getParam('source.theme', 'textmate', 'textmate');
	}
	
	public function getStyles() {
		$wf = WFEditor::getInstance();
		
		// return file(s) array
		if ($wf->getParam('editor.compress_css', 0)) {			
			return array(dirname(dirname(__FILE__)) . DS . 'css' . DS . 'editor.css');
		}
		
		// use document instance	
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::root(true) . '/components/com_jce/editor/tiny_mce/plugins/source/css/editor.css?version=' . $wf->getVersion());
	}
}
?>