<?php
/**
 * @package Component Tag for Joomla! 1.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die( 'Restricted access' );
class JoomlaTagsHelper{
	function param($name,$default=''){
		static $params;
		if (!isset( $params )){
			$params = JComponentHelper::getParams('com_tag');
		}

		return $params->get($name,$default);
	}
	function tag_alphasort($tag1, $tag2)
	{
		if($tag1->name == $tag2->name)
		{
			return 0;
		}
		return ($tag1->name < $tag2->name) ? -1 : 1;
	}
	function tag_popularasort($tag1, $tag2)
	{
		if($tag1->ct == $tag2->ct)
		{
			return 0;
		}
		return ($tag1->ct < $tag2->ct) ? -1 : 1;
	}
	function tag_latestasort($tag1, $tag2)
	{
		if($tag1->created == $tag2->created)
		{
			return 0;
		}
		return ($tag1->created < $tag2->created) ? -1 : 1;
	}
	function hitsasort($tag1, $tag2)
	{
		if($tag1->hits == $tag2->hits)
		{
			return 0;
		}
		return ($tag1->hits < $tag2->hits) ? -1 : 1;
	}
	function getComponentVersion()
	{
		static $version;

		if( !isset($version) ) {
			$xml = JFactory::getXMLParser('Simple');

			$xmlFile = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tag'.DS.'manifest.xml';

			if( file_exists($xmlFile) ) {
				if( $xml->loadFile($xmlFile) ) {
					$root =& $xml->document;
					$element =& $root->getElementByPath('version');
					$version = $element ? $element->data() : '';
				}
			}
		}

		return $version;
	}
	function preHandle($tag){
		$tag=JoomlaTagsHelper::tripChars($tag);
		$tag=JString::trim($tag);
		$tag=JoomlaTagsHelper::unUrlTagname($tag);
		$toLowcase=JoomlaTagsHelper::param('lowcase',1);
		if($toLowcase){
			$tag=JString::strtolower($tag);
		}
		return $tag;
	}

	function ucwords($word){
		if(JoomlaTagsHelper::param('capitalize')){
			return JString::ucwords($word);
		}else{
			return $word;
		}
	}

	function urlTagname($tagname) {
		return preg_replace(
		array('/-/', '/\+/'),
		array('%3A', '-'),
		urlencode($tagname)
		);
		//return urlencode($tagname);
	}

	function unUrlTagname($tagname) {
		return preg_replace(
		 			'/[:-]/',
		 			' ',
		urldecode($tagname)
		);
		//return urldecode($tagname);
	}

	function truncate($blurb) {
		$blurb = strip_tags($blurb);
		$blurb = str_replace('"', '\"', $blurb);
		$words = explode(' ', trim($blurb));

		if (count($words) > 15) {
			$blurb = implode(' ', array_splice($words, 0, 15)) . '...';
		}

		return $blurb;
	}

	function tripChars($name){
		$stripChars=JoomlaTagsHelper::param('StripCharacters');

		$stripCharList = array();
		$stripCharList = explode('|', $stripChars);
		$mustTripChars=array('|',"'","\"");

		$stripCharList=array_merge($stripCharList,$mustTripChars);
		$stripCharList=array_unique($stripCharList);
		$finalRemoveChaList=array();
		foreach($stripCharList as $c){
			if($c!='-'){
				$finalRemoveChaList[]=$c;
			}

		}

		$name=str_replace($finalRemoveChaList,'',$name);
        $name=str_replace('-',' ',$name);
		return $name;
	}

	function isValidName($name) {
		$valid = true;

		$name=JoomlaTagsHelper::preHandle($name);
		if(empty($name)) $valid = false;

		if ($valid) {
			return $name;
		} else {
			return false;
		}
	}
}
?>