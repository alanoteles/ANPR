<?php
/**
 * @package Component Tag for Joomla! 1.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
require_once JPATH_SITE.DS.'components'.DS.'com_tag'.DS.'helper'.DS.'helper.php';
/**
 * @param	array
 * @return	array
 */
function TagBuildRoute( &$query )
{
	//print_r($query);

	$segments = array();

	if (isset($query['tag'])) {
		$segments[] = $query['tag'];
		unset($query['tag']);
	}

	if (isset($query['view'])) {
		unset($query['view']);
	}
	if(isset($query['task'])&&$query['task']=='tag'){
		unset($query['task']);
	}

	if(isset($query['layout'])){
		unset($query['layout']);
	}
	return $segments;
}

/**
 * @param	array
 * @return	array
 */
function TagParseRoute( $segments )
{
	//print_r($segments);
	
	$vars = array();
	$tag	= array_shift($segments);
	//$vars['tag'] = $tag;
	$vars['tag'] = JoomlaTagsHelper::urlTagname($tag);
	$vars['view'] = 'tag';
	return $vars;
}