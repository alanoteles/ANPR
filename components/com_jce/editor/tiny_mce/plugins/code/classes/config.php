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
class WFCodePluginConfig
{
	public function getConfig(&$settings)
	{
		// Get JContentEditor instance
		$model 	= JModel::getInstance('editor', 'WFModel');
		$wf 	= WFEditor::getInstance();

		if(!in_array('code', $settings['plugins'])) {
			$settings['plugins'][] = 'code';
		}

		$settings['code_php'] 		= $wf->getParam('editor.allow_php', 0);
		$settings['code_script'] 	= $wf->getParam('editor.allow_javascript', 0);
		$settings['code_style'] 	= $wf->getParam('editor.allow_css', 0);

		$settings['code_cdata'] 	= $wf->getParam('editor.cdata', 1, 1);

		// Invalid Elements
		if ($settings['code_script'] == 1) {
			$model->removeKeys($settings['invalid_elements'], 'script');
		}
		if ($settings['code_style'] == 1) {
			$model->removeKeys($settings['invalid_elements'], 'style');
		}
	}
}
?>