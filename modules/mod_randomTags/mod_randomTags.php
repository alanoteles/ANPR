<?php
/**
 * @package module randomTags for Joomla! 1.5
 * @version $Id: mod_randomTags.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$list = modRandomTagsHelper::getList($params);
require(JModuleHelper::getLayoutPath('mod_randomTags'));
