<?php

/**
 * @version		2.0
 * @package		mod_cn_youtubefeed
 * @author    	Caleb Nance
 * @copyright	Copyright (c) 2009 - 2010 CalebNance.com. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 *
 *				mod_cn_youtubefeed.php
 */
 
 // Include the syndicate functions only once

	require_once (dirname(__FILE__).DS.'helper.php');
	
	$document = JFactory::getDocument();
	$document->addStylesheet('modules/mod_cn_youtubefeed/assets/mod_cn_youtubefeed.css');
	$document->addStylesheet('modules/mod_cn_youtubefeed/assets/carousel.css');
	$document->addScript('modules/mod_cn_youtubefeed/assets/carousel.js');
	$document->addStylesheet('modules/mod_cn_youtubefeed/assets/lightbox.css');
	$document->addscript('modules/mod_cn_youtubefeed/assets/lightbox.js');
	$document->addscript('modules/mod_cn_youtubefeed/assets/javascript.js');
					
	# LAYOUT OF THE VIEW
	$module_layout = $params->get('view', 'default');
	
	# GET THE FEED
	$mod_use = $params->get('mod_use', 'default');
	if($mod_use == 'default') {
		$feed = modYouTubeFeedHelper::getYouTubeFeed($params);
		$videos = modYouTubeFeedHelper::getYouTubeVideos($feed, $params);
		$links = modYouTubeFeedHelper::getYouTubeLink($feed, $params);
	}
	if($mod_use == 'search'){
		$feed_search = modYouTubeFeedHelper::getSearchYouTubeFeed($params);
		$videos = modYouTubeFeedHelper::getYouTubeSearchVideos($feed_search, $params);
		$module_layout = 'search';
	}
	
	# GET HEADER
	$header = modYouTubeFeedHelper::getHeader($params);
	
	# CHECKS IF ANY FEEDS ARE EMPTY
	if(empty($feed) && empty($feed_search)) {
		echo '<p>The RSS feed didn\'t load properly, please refresh the page.</p> <p>If the problem persists, please let me know. <a href="http://www.calebnance.com" target="_blank" >CalebNance.com</a></p>';
		return;
	}
	
	require(JModuleHelper::getLayoutPath('mod_cn_youtubefeed', $layout = $module_layout));