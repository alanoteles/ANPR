<?php
/**
 * @package      ITPrism Modules
 * @subpackage   ITPFacebookLikeBox
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ITPFacebookLikeBox is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined( "_JEXEC" ) or die;?>
<div id="itp-fblike-box<?php echo $params->get('moduleclass_sfx');?>">

<?php if(!$params->get("fbRendering",0)){ // iframe?>
<iframe 
src="http://www.facebook.com/plugins/likebox.php?href=<?php echo $params->get("fbPageLink");?>&amp;locale=<?php echo $locale;?>&amp;width=<?php echo $params->get("fbWidth");?>&amp;colorscheme=<?php echo $params->get("fbColour");?>&amp;show_faces=<?php echo (!$params->get("fbFaces")) ? "false" : "true";?>&amp;stream=<?php echo (!$params->get("fbStream")) ? "false" : "true";?>&amp;header=<?php echo (!$params->get("fbHeader")) ? "false" : "true";?>&amp;height=<?php echo $params->get("fbHeight");?>"
scrolling="no" 
frameborder="0" 
style="border:none; overflow:hidden; width:<?php echo $params->get("fbWidth");?>px; height:<?php echo $params->get("fbHeight");?>px;" 
allowTransparency="true"></iframe>
<?php } else { // XFBML ?>
<?php if($params->get("fbLoadJsLib", 1)) {?>
<script src="http://connect.facebook.net/<?php echo $locale;?>/all.js#xfbml=1"></script>
<?php }?>
<fb:like-box 
href="<?php echo $params->get("fbPageLink");?>" 
width="<?php echo $params->get("fbWidth");?>"
height="<?php echo $params->get("fbHeight");?>"
colorscheme="<?php echo $params->get("fbColour");?>" 
show_faces="<?php echo (!$params->get("fbFaces")) ? "false" : "true";?>" 
stream="<?php echo (!$params->get("fbStream")) ? "false" : "true";?>" 
header="<?php echo (!$params->get("fbHeader")) ? "false" : "true";?>"></fb:like-box>
<?php }?>
</div>