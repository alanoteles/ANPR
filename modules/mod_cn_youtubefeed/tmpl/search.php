<?php

/**
 * @version		2.0
 * @package		mod_cn_youtubefeed
 * @author    	Caleb Nance
 * @copyright	Copyright (c) 2009 - 2010 CalebNance.com. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * 
 * @file		search.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
$br = '<br />';

# SET HEADER
echo $header;

# GET PARAMS
$videolimit = $params->get('search_limit', '10');
$showtags = $params->get('showtags', '1');

# GET VIDEO SEARCH RESULT COUNT
$video_count = count($videos);
$video_count -= 1;

# DISPLAY ALL VIDEOS FOUND WITH THE KEYWORD IN COMMON
for ( $counter = 1; $counter < $video_count; $counter += 1) {
	
	$title = $videos[$counter][title];
	$author = $videos[$counter][author];
	$link_video = $videos[$counter][link];
	$link_related = $videos[$counter][link_related];
	$link_mobile = $videos[$counter][link_mobile];
	$link_response = $videos[$counter][link_response];
	
	echo '<a href="'. $link_video .'" rel="shadowbox width=700px; height=500px" target="_blank" title="'.$title.'" >'.$title .'</a>';
	echo $br . 'by <a href="http://www.youtube.com/user/'. $author .'" rel="shadowbox width=999px; height=500px" target="_blank" >'. $author.'</a>';
	if($showtags == '1'){
		echo $br;
		echo '<a id="myHeader'.$counter.'" href="javascript:showonlyone(\'newboxes'.$counter.'\');" >Show Tags</a>';
		echo '<div name="newboxes" id="newboxes'.$counter.'" style="display: none;" >';
	
		echo 'Tags: ';
		foreach ($videos[$counter][tag] as $tag ) {
			echo '<a href="http://www.youtube.com/results?search_query='.$tag[0].'&search=tag" rel="shadowbox width=600px; height=600px" target="_blank" >'.$tag[0].'</a> ';		
		}
		echo '</div>';
	}
	echo $br.$br;
};
