<?php
/**
* @version		$Id: mod_globalnews.php 2008 Vargas $
* @package		Joomla
* @license		GNU/GPL, see LICENSE.php
*/

defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__) . DS . 'helper.php');

global $globalnews_id;

if ( !$globalnews_id ) :
	$globalnews_id = 1;
endif;

$cat      = modGlobalNewsHelper::getGN_Cats($params);
$total    = count ( $cat );
$cols     = $params->get( 'cols', 1 );
$empty    = $params->get( 'empty', 0 );
$layout   = $params->get( 'layout', 'list' );
$show_cat = $params->get( 'show_cat', 1 );
$width    = $params->get( 'width', 'auto' );

if ( $width == 'auto' ) : $width = 100/$cols . '%'; endif;

modGlobalNewsHelper::addGN_CSS($params, $layout, $globalnews_id);

require(JModuleHelper::getLayoutPath('mod_globalnews'));

$globalnews_id++;