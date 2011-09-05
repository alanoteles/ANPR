<?php

/**
* GK Tab - content template
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
	$hstyle = ($this->config['moduleWidth'] == 0) ? '' : 'width: '.$this->config['moduleWidth'].';';
}
else
{
	$style = ($this->config['moduleWidth'] == 0) ? 'height: '.$this->config['moduleHeight'].';' : 'height: '.$this->config['moduleHeight'].';width: '.$this->config['moduleWidth'].';';
	$hstyle = ($this->config['moduleWidth'] == 0) ? '' : 'width: '.$this->config['moduleWidth'].';';
}

?>

<?php if($this->config['styleType'] == 0 || $this->config['styleType'] == 1) : ?>

<div class="gk_tab gk_tab-<?php echo $this->config['styleSuffix']; ?> clearfix-tabs" id="<?php echo $this->config['module_id'];?>">
<?php if($this->config['styleType'] == 0) : ?>
	<div class="gk_tab_wrap-<?php echo $this->config['styleSuffix']; ?> clearfix-tabs" style="<?php echo $hstyle; ?>">
<?php endif; ?>			
    <ul class="gk_tab_ul-<?php echo $this->config['styleSuffix']; ?>">
    <?php for($i = 0;$i<count($this->tabsTitles);$i++) : ?>
        <li id="<?php echo $this->config['module_id'];?>_tab_<?php echo $i+1; ?>"><span><?php echo $this->tabsTitles[$i]; ?></span></li>
    <?php endfor; ?>
    </ul>
                
	<div class="gk_tab_container0-<?php echo $this->config['styleSuffix']; ?>" style="<?php echo $style; ?>">
        <div class="gk_tab_container1-<?php echo $this->config['styleSuffix']; ?> clearfix-tabs" style="<?php echo $style; ?>">
            <div class="gk_tab_container2-<?php echo $this->config['styleSuffix']; ?> clearfix-tabs">
                <?php GKTabHelper::moduleRender(); ?>
            </div>
        </div>
    </div>
      
<?php if($this->config['styleType'] == 0) : ?>
	</div>
<?php endif; ?>	
		
<?php if($this->config['buttons'] == 1) : ?>
	<div class="gk_tab_button_next-<?php echo $this->config['styleSuffix']; ?>"></div>
	<div class="gk_tab_button_prev-<?php echo $this->config['styleSuffix']; ?>"></div>
<?php endif; ?>
</div>
<div class="clearfix-tabs"></div>

<?php endif; ?>

<?php if($this->config['styleType'] == 2) : ?>
<div class="gk_tab gk_accordion gk_tab-<?php echo $this->config['styleSuffix']; ?>" id="<?php echo $this->config['module_id'];?>">
	<?php for($i = 0;$i<count($this->tabsTitles);$i++) : ?>
        <h3 style="<?php echo $style; ?>">
		<span><?php echo $this->tabsTitles[$i]; ?></span></li>
		</h3>
  
  		<div class="gk_tab_container-<?php echo $this->config['styleSuffix']; ?>">
    		<?php GKTabHelper::moduleRenderAccordion($i); ?>
      	</div>
	<?php endfor; ?>
</div>
<?php endif; ?>