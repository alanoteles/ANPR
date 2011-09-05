<?php

/**
* GK Tab - content (X)HTML template
* @package Joomla!
* @Copyright (C) 2009 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.0 $
**/

// access restriction
defined('_JEXEC') or die('Restricted access');

if($this->config['moduleHeight'] == 0 || $this->config['styleType'] == 2)
{
	$style = ($this->config['moduleWidth'] == 0) ? '' : 'width: '.$this->config['moduleWidth'].';';
}
else
{
	$style = ($this->config['moduleWidth'] == 0) ? 'height: '.$this->config['moduleHeight'].';' : 'height: '.$this->config['moduleHeight'].';width: '.$this->config['moduleWidth'].';';
}

?>

<div class="gk_tab_item-<?php echo $this->config['styleSuffix']; ?>" style="<?php echo $style; ?>">
	<div class="gk_tab_item_space">
	<?php echo stripslashes(htmlspecialchars_decode($this->tabsContent[$i])); ?>
	</div>
</div>