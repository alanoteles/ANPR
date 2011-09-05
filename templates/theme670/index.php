<?php
/**
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

defined('_JEXEC') or die('Restricted access');
$url = clone(JURI::getInstance());
$path = $this->baseurl.'/templates/'.$this->template;
$rel_path = $this->baseurl.'/images/stories/';

$showleftColumn = $this->countModules('left');
$showrightColumn = $this->countModules('right');
$showuser2Column = $this->countModules('user2');
$showuser3Column = $this->countModules('user3');
$showuser5Column = $this->countModules('user5');
$showtopColumn = $this->countModules('top');
$showuser6Column = $this->countModules('user6');
$showuser7Column = $this->countModules('user7');
$showuser1Column = $this->countModules('user1');
$showuser8Column = $this->countModules('user8');


if(JRequest::getCmd('task') != 'edit') $Edit = false; else $Edit = true;
?>
 <?php
   $menus      = &JSite::getMenu();
   $menu      = $menus->getActive();
   $pageclass   = "";
   
   if (is_object( $menu )) : 
   $params = new JParameter( $menu->params );
   $pageclass = $params->get( 'pageclass_sfx' );
   endif; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<meta http-equiv="X-UA-Compatible" content="IE=7"/>
<head>

<jdoc:include type="head" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo $path ?>/scripts/jquery-1.4.2.js"%3E%3C/script%3E'))</script>
<script src="<?php echo $path ?>/scripts/imagepreloader.js" type="text/javascript"></script>
<script src="<?php echo $path ?>/scripts/jquery.faded.js" type="text/javascript"></script>
<script src="<?php echo $path ?>/scripts/jquery-ui-1.8.10.custom.min.js" type="text/javascript"></script>
<script src="<?php echo $path ?>/scripts/jquery.jtweetsanywhere-1.2.1.js" type="text/javascript"></script>
<script src="<?php echo $path ?>/scripts/ui-jguery.js" type="text/javascript"></script>
<script type="text/javascript">
	var $j = jQuery.noConflict();
	preloadImages([
   '<?php echo $rel_path ?>slide-1.jpg',
   '<?php echo $rel_path ?>slide-2.jpg',
   '<?php echo $rel_path ?>slide-3.jpg',
   '<?php echo $path ?>/images/button_bg.gif',
   '<?php echo $path ?>/images/button_h.gif']);

	$j(window).load(function(){
	$j('#jTweetsAnywhereSample').jTweetsAnywhere({
   searchParams: ['q=css3'],
    count: 2,
     showTweetFeed: {
		showTimestamp: false,
		showProfileImages: true,
        showUserScreenNames: true,
        paging: { mode: 'more' }
    },
    onDataRequestHandler: function(stats, options) {
        if (stats.dataRequestCount < 11) {
            return true;
        }
        else {
            stopAutorefresh(options);
            alert("To avoid struggling with Twitter's rate limit, we stop loading data after 10 API calls.");
        }
    }
});
		$j('#tabs').tabs();
		$j(function(){
			$j("#faded").faded({
				speed: 300,
				crossfade: false,			
				sequentialloading: true,
				autoplay: 6000	});
		});
			$j("#faded li img").show();
		
		
		
		$j(".gn_static_1").eq(0).animate({height:105},300);
		$j(".gn_static_1").eq(0).addClass("lineh16");
		$j(".gn_static_1").eq(0).addClass("bg_grey");
		$j(".gn_static_1 .date").click( 
		function(){
		$j(".gn_static_1").removeClass("lineh16");
		$j(".gn_static_1").animate({height:28},300);
		$j(".gn_static_1").removeClass("bg_grey");
		$j(this).parent(".gn_static_1").addClass("lineh16");
		$j(this).parent(".gn_static_1").addClass("bg_grey");
		$j(this).parent(".gn_static_1").animate({height:105},300);
		}
		); 
	});
</script>
    <style>
	 .border, .box-bg, .button, .validate, .search, #faded .pagination, .gn_static_1 .date, .navigation .menu li.parent ul, 
	 .button-rm, .block-business, .moduleButton, .main , .box-articles img, .navigation .menu li a , .navigation .menu li.parent ul li a, #aiContactSafeSendButton, .button-login, .bg, #com-form-login-username .inputbox, #com-form-login-password .inputbox {
		 	behavior:url(<?php echo $path ?>/PIE.php)
		}
	</style>
<!--[if IE 6]><script type="text/javascript" src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script><![endif]-->
<link rel="stylesheet" href="<?php echo $path ?>/css/constant.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $path ?>/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $path ?>/css/jquery-ui-1.8.10.custom.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $path ?>/css/jquery.jtweetsanywhere-1.2.1.css" type="text/css" />

</head>
<?php
	$menu = & JSite::getMenu();
if (($menu->getActive() == $menu->getDefault()) && ($option!="com_search")) {?>
	<body class="first <?php echo $pageclass; ?>">
    
	<?php
	} else {?>
	<body class="all <?php echo $pageclass; ?>">
    
	<?php }
?>


<div class="extra">
<div class="main"> 
  <!--header-->
    <div class="header">
    <div class="head">
    <jdoc:include type="modules" name="user5" />
     <div class="bg-logo"><h1 id="logo"><a href="<?php echo $_SERVER['PHP_SELF']?>" title="PerfectBiz"><img  title="PerfectBiz" src="<?php echo $path ?>/images/logo.png"   alt="PerfectBiz"  /></a></h1>
      <jdoc:include type="modules" name="user4" /></div>
      <div class="navigation"><jdoc:include type="modules" name="user3" style="topmenu" /><jdoc:include type="modules" name="user6" style="topmenu" /></div>
      
    </div>
  </div>
  <div class="left_shadow_repeat">
  <div class="left_shadow">
  <div class="right_shadow_repeat">
  <div class="right_shadow">
  <div class="top_shadow">
  <?php if ($showtopColumn && !$Edit) : ?>
  <jdoc:include type="modules" name="top"  />
  <?php endif;?>
  <div class="wrapper-content content-top ">
    <div class="cont_pad">
      <!--content-->
      <div class="clear">
      <!--right-->
      <?php if ($showrightColumn && !$Edit) : ?>
      <div id="right">
        <jdoc:include type="modules" name="right" style="wrapper_box" />
      </div>
      <?php endif;?>
      <!--left-->
      <?php if ($showleftColumn && !$Edit && $option!="com_search") : ?>
      <div id="left">
        <jdoc:include type="modules" name="left" style="wrapper_box" />
      </div>
      <?php endif;?>
      <!--center-->
      <div id="content">
        <div class="container" >
              <div class="clear">
              <?php if ($showuser1Column && !$Edit && $option!="com_search") : ?>
              <jdoc:include type="modules" name="user1" />
              <?php endif; ?>
                <?php if ($this->getBuffer('message')) : ?>
                <div class="error err-space">
                  <jdoc:include type="message" />
                </div>
                <?php endif; ?>
                <jdoc:include type="component" />
                <?php if ($showuser7Column && !$Edit && $option!="com_search") : ?>
               <div class="wrapper"><jdoc:include type="modules" name="user7" style="wrapper_box" /></div>
               <?php endif; ?>
              </div>
          	</div>
       	 </div>
        </div>
    </div>
    </div>
    <?php if ($showuser8Column && !$Edit && $option!="com_search") : ?>
        <jdoc:include type="modules" name="user8" />
         <?php endif; ?>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="block"></div>
    </div>
    </div>
    <div class="footer">
    <div class="foot">
    <div class="navigation2"><jdoc:include type="modules" name="user3" style="topmenu" /></div>
       <div class="copy"><span><?php echo JText::_('Perfect Biz &copy; 2011') ?> </span><a href="#">Privacy policy</a>    
        <!-- {%FOOTER_LINK} -->
      </div>
    </div>
  </div>
  <!--footer--> 
</div>
</body>
</html>
