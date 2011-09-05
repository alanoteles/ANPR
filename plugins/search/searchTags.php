<?php
/**
 * @package Plugin searchTags for Joomla! 1.5
 * @version $Id: searchTags.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_SITE.DS.'components'.DS.'com_tag'.DS.'helper'.DS.'helper.php';
$mainframe->registerEvent( 'onSearch', 'plgSearchTags' );
$mainframe->registerEvent( 'onSearchAreas', 'plgSearchTagsAreas' );

$lang = & JFactory::getLanguage();
$lang->load('com_tag', JPATH_SITE);

/**
 * @return array An array of search areas
 */
function &plgSearchTagsAreas()
{
	static $areas = array(
		'tags' => 'Tags'
		);
		return $areas;
}

/**
 * Tags Search method
 *
 * The sql must return the following fields that are
 * used in a common display routine: href, title, section, created, text,
 * browsernav
 * @param string Target search string
 * @param string mathcing option, exact|any|all
 * @param string ordering option, newest|oldest|popular|alpha|category
 * @param mixed An array if restricted to areas, null if search all
 */
function plgSearchTags( $text, $phrase='', $ordering='', $areas=null )
{
	$db		=& JFactory::getDBO();
	$user	=& JFactory::getUser();
	$searchText = $text;
	if (is_array( $areas )) {
		if (!array_intersect( $areas, array_keys( plgSearchTagsAreas() ) )) {
			return array();
		}
	}

	// load plugin params info
	$plugin =& JPluginHelper::getPlugin('search', 'tags');
	$pluginParams = new JParameter( $plugin->params );

	$limit = $pluginParams->def( 'search_limit', 50 );

	$text = trim( $text );
	if ( $text == '' ) {
		return array();
	}

	$text	= $db->Quote( '%'.$db->getEscaped( $text, true ).'%', false );
	$query='select name,name as title,description as text from #__tag_term  where name like '.$text.' order by weight desc,name';

	$db->setQuery( $query, 0, $limit );
	$rows = $db->loadObjectList();

	$count = count( $rows );
	$i;
	for ( $i = 0; $i < $count; $i++ ) {


		//$link='index.php?option=com_tag&task=tag&tag='.urlencode($rows[$i]->name);
        $link='index.php?option=com_tag&task=tag&tag='.JoomlaTagsHelper::urlTagname($rows[$i]->name);
		$rows[$i]->href = JRoute::_($link);
		//print_r($rows[i]);
		$rows[$i]->section 	= JText::_( 'TAG' );
	}

	$return = array();
	foreach($rows AS $key => $tag) {
		if(searchHelper::checkNoHTML($tag, $searchText, array('name', 'title', 'text'))) {
			$return[] = $tag;
		}

	}

	return $return;
}
