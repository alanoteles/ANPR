<?php

/*
 * @version		2.0
 * @package		mod_cn_youtubefeed
 * @author    	Caleb Nance
 * @copyright	Copyright (c) 2009 - 2010 CalebNance.com. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * 
 * @file		default.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

echo $header;
$br = '<br />';
$videolimit = $params->get('videolimit', '10');
$video_count = count($videos);
?><div id="youtubeContainer"><?php
for ( $counter = 0; $counter <= $video_count; $counter += 1) {
	echo $videos[$counter];
	echo $br.$br;
};
?></div>
