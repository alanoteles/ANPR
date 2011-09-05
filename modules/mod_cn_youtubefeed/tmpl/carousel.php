<?php

/**
 * @version		2.0
 * @package		mod_cn_youtubefeed
 * @author    	Caleb Nance
 * @copyright	Copyright (c) 2009 - 2010 CalebNance.com. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 *
 * @file		carousel.php
 */ 
 
#SET BREAK VARIABLE 
$br   		= '<br />';
$base 		= JURI::base();
$image_path	= $base .'modules/mod_cn_youtubefeed/images/';

#GET PARAM VARIABLE
$videolimit = $params->get('videolimit', '10');
$modWidth = $params->get('modwidth', '200');
$modHeight = $params->get('modheight', '300');
$imgslideshow = $params->get('imgslideshow', 'none');
$navlinkcolor = $params->get('navlinkcolor', '000');
$bordercolor = $params->get('bordercolor', '999999');
$arrows = $params->get('arrows');
$equal = round($modWidth / 3) - 1;

# SET VIDEO COUNT OF RSS FEED
$video_count = count($videos);
if($video_count == '0'){ $video_count = '20';}
if($video_count > '20'){ $video_count = '20';}
if($video_count < '20'){ $video_count = $video_count - 2;}

# SET HEADER
echo $header;
?>
<script type="text/javascript">
	window.onload=autorot;
	var maxstor = <?php echo $video_count - 1; ?>; 
	var counter = 0;
	function pause_video_click(){
		document.play_image.src = '<?php echo $image_path; ?>play_btn.png'; counter = 1; stoprot();
	}
	function pause_click(){
		if(counter == 0){ document.play_image.src = '<?php echo $image_path; ?>play_btn.png'; counter = 1; stoprot(); return;} 
		if(counter == 1){  document.play_image.src = '<?php echo $image_path; ?>pause_btn.png'; counter = 0;  autorot(); }
	}
	function setPlay(){ document.play_image.src = '<?php echo $image_path; ?>play_btn.png'; counter = 1; }
</script>

<?php 
echo '<style> #youtubeContainer { width: '.$modWidth.'px; height: '.$modHeight.'px; } #nav_new { font-size:15px; text-align: center; } #nav_new a:link{ color:#'.$navlinkcolor.'; text-decoration: none; }';
echo '.none { padding: 0px 1px; }';
echo '#sb-loading-inner span{background:url('.$image_path.'loading.gif) no-repeat;padding-left:34px;display:inline-block;}';
echo '#sb-nav-close{background-image:url('.$image_path.'close.png);}';
echo '#sb-nav-next{background-image:url('.$image_path.'next.png);}';
echo '#sb-nav-previous{background-image:url('.$image_path.'previous.png);}';
echo '#sb-nav-play{background-image:url('.$image_path.'play.png);}';
echo '#sb-nav-pause{background-image:url('.$image_path.'pause.png);}';
echo '#nav_mod_control, #nav_new { width: '.$modWidth.'px; }';
echo '#nav_mod_control .width_button { width: '.$equal.'px; float: left; }';
echo '#clear_float { clear: both;}';
if($imgslideshow == 'mag_glass.png'){ ?>
.highlightStory { background:url( <?php echo $image_path . $imgslideshow; ?>) no-repeat top center; height: 100px; width: 40px; padding: 12px 15px 25px 16px; font-size: 20px; }<?php } ?>
<?php if($imgslideshow == 'none'){ ?>.highlightStory { border:2px solid #<?php echo $bordercolor; ?>; padding: 1px; }<?php } ?>
</style>


<div id="youtubeContainer">
<?php

for ( $counter = 0; $counter < $video_count; $counter += 1) {
	$storyNum = $counter + 1;
	echo '<div id="story'. $storyNum .'" class="storydiv">';
	echo '<span class="storyBlock">';
	echo $videos[$counter];
	echo '</span>';
	echo '</div>';
};
?>
</div>
<div id="nav_new">
<?php
for ( $nav_count = 1; $nav_count <= $video_count; $nav_count += 1) {
	echo '<span id="nav'.$nav_count.'"><a href="javascript:showYouTube'.$nav_count.'()" onClick="pause_video_click()">'.$nav_count.'</a></span>';
	if($nav_count == '10'){echo '<br />';}
};
echo $br.$br;
?>
<div id="nav_mod_control">
<div class="width_button" ><a href="javascript:showPrev(); setPlay()" onClick="stoprot()"><img src="<?php echo $image_path; ?>back_btn.png" alt="Prev" /></a></div>
<div class="width_button" ><a href="javascript:pause_click()"><img id="play_image" src="<?php echo $image_path; ?>pause_btn.png" alt="Pause/Play" /></a></div>
<div class="width_button" ><a href="javascript:showNext(); setPlay()" onClick="stoprot()"><img src="<?php echo $image_path; ?>forward_btn.png" alt="Next"/></a></div>
</div>
</div>
<div id="clear_float"></div>