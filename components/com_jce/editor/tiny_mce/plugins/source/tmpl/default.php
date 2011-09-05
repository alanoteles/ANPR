<?php
/**
 * @version 		$Id: imgmanager.php 58 2011-02-18 12:40:41Z happy_noodle_boy $
 * @package      	JCE
 * @copyright    	Copyright (C) 2006 - 2011 Ryan Demmer. All rights reserved
 * @author			Ryan Demmer
 * @license      	GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die('RESTRICTED');

jimport('joomla.application.component.model');

wfimport('admin.models.editor');

$model = JModel::getInstance('editor', 'WFModel');
echo $model->getToken('source');
?>
