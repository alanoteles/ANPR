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
 * Info html.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// getting client variable
$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

?>

<?php if($modal_news == 1) : ?>	
<link rel="stylesheet" type="text/css" href="<?php echo $uri->root(); ?>administrator/components/com_gk3_tabs_manager/interface/css/info.css" media="all" />	
<?php endif; ?>

<?php if($modal_news == 0) : ?>	
<div id="wrapper">
<?php endif; ?>

	<?php if($modal_news == 0) : ?>	
	<?php ViewNavigation::generate(array( JText::_("INFO_AND_HELP") => 'option=com_gk3_tabs_manager&c=info')); ?>
	<?php endif; ?>
	
	<div id="info">
		<?php echo JText::_('INFO_AND_HELP_CONTENT'); ?>
	</div>
	
<?php if($modal_news == 0) : ?>		
</div>

<form action="index.php" method="get" name="adminForm">
	<input type="hidden" name="option" value="com_gk3_tabs_manager" />
	<input type="hidden" name="client" value="<?php echo $client->id;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="c" value="info" />
	<input type="hidden" name="boxchecked" value="0" />
</form>	

<?php endif; ?>