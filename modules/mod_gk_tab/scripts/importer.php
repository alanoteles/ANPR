<?php

/**
* GK Tab - importer file
* @package Joomla!
* @Copyright (C) 2009 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.0 $
**/

// access restriction for this file haven't any sense

/*
	This file generate configuration JSON data for specified in $_GET variables module
*/
	
// set document type as text/javascript	

header("Content-Type: text/javascript");
	
?>

try {$Gavick;}catch(e){$Gavick = {};};

$Gavick["gk_tab<?php echo $_GET['modid'];?>"] = {
		"activator" : <?php echo (($_GET['activator'] == 'click') ? 0:1);?>,
		"autoAnimation" : <?php echo $_GET['animation'];?>,
		"animationTransition" : <?php echo $_GET['animationFun'];?>,
		"animationType" : <?php echo $_GET['animationType'];?>,
		"animationSpeed" : <?php echo $_GET['animationSpeed'];?>,
		"animationInterval" : <?php echo $_GET['animationInterval'];?>,
		"styleType": <?php echo $_GET['styleType'];?>,
		"styleSuffix": "<?php echo $_GET['styleSuffix'];?>",
		"fixedHeight": <?php echo $_GET['fixedHeight'];?>,
		"fixedHeightValue": <?php echo $_GET['fixedHeightValue'];?>,
		"alwaysHide": <?php echo $_GET['alwaysHide'];?>
};