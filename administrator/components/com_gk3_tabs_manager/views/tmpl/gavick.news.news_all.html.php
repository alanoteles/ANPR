<?php

/**
 * 
 * @version		3.0.0
 * @package		Joomla
 * @subpackage	Tabs Manager GK3
 * @copyright	Copyright (C) 2008 - 2009 GavickPro. All rights reserved.
 * @license		GNU/GPL
 * 
 * ==========================================================================
 * 
 * Gavick News all html.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

?>

<?php if($modal_news == 1) : ?>	
<link rel="stylesheet" type="text/css" href="<?php echo $uri->root(); ?>administrator/components/com_gk3_tabs_manager/interface/css/gavick.news.css" media="all" />	
<?php endif; ?>

<?php if($modal_news == 0) : ?>	
<div id="wrapper">
<?php endif; ?>

	<?php if($modal_news == 0) : ?>	
	<?php ViewNavigation::generate(array(JText::_("GAVICK_NEWS") => 'option=com_gk3_tabs_manager&c=news')); ?>
	<?php endif; ?>
	
	<div id="news">
		<?php echo $content; ?>
	</div>
	
<?php if($modal_news == 0) : ?>		
</div>

<form action="index.php" method="get" name="adminForm">
	<input type="hidden" name="option" value="com_gk3_tabs_manager" />
	<input type="hidden" name="client" value="<?php echo $client->id;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="c" value="news" />
	<input type="hidden" name="boxchecked" value="0" />
</form>	

<?php endif; ?>