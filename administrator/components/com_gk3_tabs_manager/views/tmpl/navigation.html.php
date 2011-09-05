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
 * Navigation html.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

?>		
	
<div id="gk_navigation">
	
		<strong><?php echo JText::_('YOU_ARE_HERE'); ?>:</strong> <a href="<?php echo $uri->root().'administrator/index.php?option=com_gk3_tabs_manager'; ?>">Tabs Manager GK3</a>  
		<?php foreach(array_keys($navigation_array) as $item) : ?>
		&raquo; <a href="<?php echo $uri->root().'administrator/index.php?'.$navigation_array[$item] ; ?>"><?php echo $item; ?></a>
		<?php endforeach; ?>
	
</div>