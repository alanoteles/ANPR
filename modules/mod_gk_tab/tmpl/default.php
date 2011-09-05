<?php

/**
* GK Tab - default template
* @package Joomla!
* @Copyright (C) 2009 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.0 $
**/

// access restriction
defined('_JEXEC') or die('Restricted access');

$uri = JURI::getInstance();

?>

<?php if($this->config['useMoo'] == 1) : ?>
<script type="text/javascript" src="<?php echo $uri->root(); ?>modules/mod_gk_tab/scripts/mootools.js"></script>
<?php endif; ?>

<?php if($this->config['useScript'] == 1) : ?>
<script type="text/javascript" src="<?php echo $uri->root(); ?>modules/mod_gk_tab/scripts/engine<?php echo ($this->config['styleType'] == 2) ? '_accordion' : ''; ?><?php echo (($this->config['compress_js'] == 1) ? '_compress' : ''); ?>.js"></script>
<?php endif; ?>

<?php if($this->config['clean_code'] == 0) : ?>
<script type="text/javascript">
	try{$Gavick;}catch(e){$Gavick = {};}
	$Gavick["gk_tab<?php echo $this->config['module_id'];?>"] = {
		"activator" : <?php echo (($this->config['activator'] == 'click') ? 0:1);?>,
		"autoAnimation" : <?php echo $this->config['animation'];?>,
		"animationTransition" : <?php echo $this->config['animationFun'];?>,
		"animationType" : <?php echo $this->config['animationType'];?>,
		"animationSpeed" : <?php echo $this->config['animationSpeed'];?>,
		"animationInterval" : <?php echo $this->config['animationInterval'];?>,
		"styleType": <?php echo $this->config['styleType'];?>,
		"styleSuffix": "<?php echo $this->config['styleSuffix'];?>",
		"fixedHeight": <?php echo $this->config['fixedHeight'];?>,
		"fixedHeightValue": <?php echo $this->config['fixedHeightValue'];?>,
		"alwaysHide": <?php echo $this->config['alwaysHide'];?>
	};
</script>
<?php endif; ?>