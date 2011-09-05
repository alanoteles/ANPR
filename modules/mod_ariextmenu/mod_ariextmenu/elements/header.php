<?php
/*
 * ARI Framework Lite
 *
 * @package		ARI Framework Lite
 * @version		1.0.0
 * @author		ARI Soft
 * @copyright	Copyright (c) 2009 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */
defined('_JEXEC') or die ('Restricted access');

class JElementHeader extends JElement
{
	var	$_name = 'Header';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$color = $node->attributes('color') != null ? $node->attributes('color') : '#FFF';
		$bgColor =  $node->attributes('bgcolor') != null ? $node->attributes('bgcolor') : '#7CC4FF';
		
		return sprintf('<div style="font-weight: bold; font-size: 120%%; color: %1$s; background-color: %2$s; padding: 2px 0; text-align: center;">' . JText::_($value) . '</div>',
			$color,
			$bgColor);
	}
}
?>