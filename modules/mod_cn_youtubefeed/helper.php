<?php

/**
 * @version		2.0
 * @package		mod_cn_youtubefeed
 * @author    	Caleb Nance
 * @copyright	Copyright (c) 2009 - 2010 CalebNance.com. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 *
 * file			helper.php
 */

/*
 * Make sure this file is being included by mod_youtubefeed.php
 */

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class modYouTubeFeedHelper
{
	# GETS THE YOUTUBE VIDEO LIST
	function getYouTubeFeed($params)
	{
		$rssurl = "http://gdata.youtube.com/feeds/base/standardfeeds/";
		$rssurl	.= $params->get('rssurl', 'most_popular?client=ytapi-youtube-browse&amp;alt=rss&amp;time=today');
		
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL,$rssurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,$timeout);
		$result = curl_exec($ch);
		curl_close($ch);
		
		$xml = simplexml_load_string($result);
		return $xml;
	}
	# GETS THE YOUTUBE SEARCH RESULTS
	function getSearchYouTubeFeed($params) {
		$search_word = $params->get('search', 'calebcanhelp22');
		$search_first = $params->get('search_start', '1');
		$search_limit = $params->get('search_limit', '5');
		
		$rssurl = "http://gdata.youtube.com/feeds/api/videos?q=". $search_word ."&start-index=". $search_first ."&max-results=". $search_limit ."&v=2";
		
		if($search_limit > '25'){ echo 'Search Limit is above 25, please set it to 25 or below.'; return; }
		
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL,$rssurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,$timeout);
		$result = curl_exec($ch);
		curl_close($ch);
		
		$xml = simplexml_load_string($result);
		return $xml;
	}
	# GETS THE HEADER FOR ALL VIEWS
	function getHeader($params)
	{
		# GET PARAMS
		$modalColor 	= $params->get('modalColor', '000000');
		$modalOpacity	= $params->get('modalOpacity', '0.5');
		$header ='<head><script type="text/javascript">Shadowbox.init({ overlayColor: "#'.$modalColor.'", overlayOpacity: '.$modalOpacity.' });</script><style>#sb-loading-inner span{background:url('.JURI::base().'modules/mod_cn_youtubefeed/images/loading.gif) no-repeat;padding-left:34px;display:inline-block;}#sb-nav-close{background-image:url('.JURI::base().'modules/mod_cn_youtubefeed/images/close.png);}#sb-nav-next{background-image:url('. JURI::base().'modules/mod_cn_youtubefeed/images/next.png);}#sb-nav-previous{background-image:url('.JURI::base().'modules/mod_cn_youtubefeed/images/previous.png);}#sb-nav-play{background-image:url('.JURI::base().'modules/mod_cn_youtubefeed/images/play.png);}#sb-nav-pause{background-image:url('.JURI::base().'modules/mod_cn_youtubefeed/images/pause.png);}</style></head>';
		return $header;
	}
	# FIND REPLACE FUNCTION
	function get_string_youtube($description, $start, $end){
		$description = " ".$description;
		$ini = strpos($description,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);    
		$len = strpos($description,$end,$ini) - $ini;
		return substr($description,$ini,$len);
	}
	# FIND REPLACE FUNCTION SPECIFICALLY FOR TIME
	function get_string_youtube_time($video_time, $start, $end){
		$video_time = " ".$video_time;
		$ini = strpos($video_time,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);    
		$len = strpos($video_time,$end,$ini) - $ini;
		return substr($video_time,$ini,$len);
	}
	# SETS DISPLAY FOR ALL THE YOUTUBE VIDEOS
	function getYouTubeVideos($feed, $params) {
		
		$title = $feed->channel->image->title;
		$count = 0;
		$br = '<br />';
		$feed_total = count($feed->channel->item);
		
		# SET PARAM VARS
		$rssurl = $params->get('rssurl', 'most_popular?client=ytapi-youtube-browse&amp;alt=rss&amp;time=today');
		$modwidth = $params->get('modwidth', '200');
		$charlimit = $params->get('charlimit', '30');
		$videolimit = $params->get('videolimit', '10');
		$imgshow = $params->get('imgshow', '1');
		$showviews = $params->get('showviews', '1');
		$showtime = $params->get('showtime', '1');
		$showuser = $params->get('showuser', '1');
		$timepub = $params->get('timepub', '1');
		$timesetup = $params->get('timesetup', 'D d, Y h:i a');
		$module_layout = $params->get('view', 'default');
		
		foreach ($feed->channel->item as $item ) {
			
			$title = $item->title;
    		$guid = $item->guid;
			$description = $item->description;
			$link = $item->link;
			$author = $item->author;
			
			# GET IMAGE FROM FEED DESCRIPTION
			$thumb_img = modYouTubeFeedHelper::get_string_youtube($description,"<img",">");
			
			# GET VIEWS OF VIDEO
			$video_views = modYouTubeFeedHelper::get_string_youtube($description, "Views:</span>", "</div>");
			
			# GET TIME OF VIDEO
			$video_time = modYouTubeFeedHelper::get_string_youtube($description, 'Time:', '</td>');
			$video_time = modYouTubeFeedHelper::get_string_youtube_time($video_time, '">', '</');
			
			# GET LINK OF VIDEO
			$link = modYouTubeFeedHelper::get_string_youtube_time($link, 'http://www.youtube.com/watch?v', '&feature=youtube_gdat');
			$link = str_replace('=', 'http://www.youtube.com/v/', $link);
			
			# GET VIDEO PUBLISHER
			$video_user = modYouTubeFeedHelper::get_string_youtube($description, 'From:</span>', '</div>');
			$user_plain = modYouTubeFeedHelper::get_string_youtube($video_user, '">', '<');
			$video_user = str_replace('href="', 'target="_blank" onClick="pause_video_click()" rel="shadowbox width=999px; height=600px" href="', $video_user); 
			$user_plain = ucwords($user_plain);
			
			# SET DATE TO BE EDITED
			$pub_date = $item->pubDate;
			$pub_date = strtotime($pub_date);
			
			# LIMIT THE TITLE
			$title = substr($title,0, $charlimit);
			
			# SET VALUES FROM PARAMS
			$slide = '';
			if($imgshow == '1') $slide = '<a href="'.$link.'&autoplay=1" onClick="stoprot(); pause_video_click()" rel="shadowbox[image] width=200px; height=150px" title="User: '.$user_plain. ' Views: ' . $video_views.' " target="_blank" ><img '.$thumb_img .' /></a>' . $br;
			$slide .= '<a href="'.$link.'&autoplay=1" onClick="pause_video_click()" rel="shadowbox[title] width=200px; height=150px" title="User: '.$user_plain. ' Views: ' . $video_views.' " target="_blank" >'.$title .'...</a>'. $br;			
			if($showtime == '1') $slide .= 'Time: ' . $video_time . $br;
			if($showviews == '1') $slide .= 'Views: ' . $video_views . $br;
			if($showuser == '1') $slide .= $video_user . $br;
			if($timepub == '1') $slide .= date($timesetup, $pub_date);
			$array[$count] = $slide;
			$count += 1;
			if($videolimit == '0'){ $videolimit = '20';}
			if($videolimit > '20'){ $videolimit = '20';}
						
			# SETS ALL VARIABLES INTO AN ARRAY TO BE ABLE TO PASS TO THE LAYOUT
			if($feed_total > $videolimit) {
				if($videolimit <  $count) {
					$array[count] = $videolimit;
					return $array;
				}
			}
		}
		
		return $array;
		
	
	}
	# SETS DISPLAY FOR ALL THE YOUTUBE VIDEOS SEARCH RESULTS
	function getYouTubeSearchVideos($feed_search, $params) {
		
		$search_limit = $params->get('search_limit', '5');
		$search_video = $feed_search->entry;
		$feed_total = count($feed_search->entry);
		
		if($search_limit < $feed_total){ $feed_total = $search_limit; }
		
		$youtube_logo = $feed_search->logo;
		$count = 0;
		
		foreach ($feed_search->entry as $search_video ) {
			
			# SETS VARS
			$title = $search_video->title;
			$link = $search_video->link;
			$video_link = $search_video->content[src];
			$link_to_vid = $link[0][href];
			$link_response = $link[1][href];
			$link_related = $link[2][href];
			$link_mobile = $link[3][href];
			$author = $search_video->author->name;
			$user_link = $search_video->author->uri;
			$category = $search_video->category[1];
			$category = $category->attributes();
			$category = $category->term;
			
			$link = str_replace('&app=youtube_gdata', '', $link[1]);
			$tag_count = 0;
			$tag_num = 0;
			foreach ($search_video->category as $tag ) {
				$tag_count += 1;
				$tag = $tag->attributes();
				if($tag_count >= 4) {
					$array[$count][tag][$tag_num] = $tag[1];
					$tag_num += 1;
				}
			}
			
			$array[$count][title] = $title;
			$array[$count][author] = $author;
			$array[$count][link] = $video_link;
			$array[$count][author] = $author;
			$array[$count][link_mobile] = $link_mobile;
			$array[$count][link_response] = $link_response;
			$array[$count][link_related] = $link_related;
			
			$count += 1;
			
			
			# SETS ALL VARIABLES INTO AN ARRAY TO BE ABLE TO PASS TO THE LAYOUT
				if($search_limit <=  $count) {
					$array[count] = $search_limit;
					return $array;
				}
			
		}
		
			
	}
	# SETS YOUTUBE VIDEO TO BE ABLE TO DISPLAY IN SHADOWBOX
	function getYouTubeLink($feed, $params) {
		
		$title = $feed->channel->image->title;
		$count = 0;
		$feed_total = count($feed->channel->item);
		$videolimit = $params->get('videolimit', '10');
		foreach ($feed->channel->item as $item ) {
			
			$link = $item->link;
			$description = $item->description;
			$link = modYouTubeFeedHelper::get_string_youtube_time($link, 'http://www.youtube.com/watch?v', '&feature=youtube_gdat');
			$thumb_img = modYouTubeFeedHelper::get_string_youtube($description,"<img",">");
			$image_thumb = '<img '.$thumb_img .' />';
			$link = str_replace('=', 'http://www.youtube.com/v/', $link);
			$count += 1;
			$array[$count] =  $link;
			# SETS THE LINK VARIABLE INTO AN ARRAY TO BE ABLE TO PASS TO THE LAYOUT
			if($feed_total > $videolimit) {
				if($videolimit <=  $count) {
					$array[count] = $videolimit;
					return $array;
				}
			}
		}
		
		return $array;
	
	}
}