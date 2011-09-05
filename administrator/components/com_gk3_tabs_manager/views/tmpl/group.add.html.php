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
 * Group add html
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// getting client variable
$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

?>

<link rel="stylesheet" type="text/css" href="<?php echo $uri->root(); ?>administrator/components/com_gk3_tabs_manager/interface/css/group.add.css" media="all" />
		
<script type="text/javascript">
	window.addEvent("domready", function(){
		$E("#toolbar-save .toolbar").onclick = function(){
    		var alert_content = '';
			if($("group_name").getValue() == '') alert_content += '<?php echo JText::_('WRONG_GROUP_NAME').' \n'; ?>';
			if($("group_desc").value == '') alert_content += '<?php echo JText::_('WRONG_GROUP_DESC'); ?>';	
			(alert_content != '') ? alert(alert_content) : submitbutton('add_group');
		}
	});
</script>

<div id="wrapper">

	<?php 
		ViewNavigation::generate(array(
			JText::_("GROUPS") => 'option=com_gk3_tabs_manager&c=group',
			JText::_("ADD_GROUP") => 'option=com_gk3_tabs_manager&c=group&task=add'
		)); 
	?>
	
	<div id="groups">
		<form action="index.php" method="post" name="adminForm">
			<table class="adminlist">
				<tbody>
					<tr>
						<td align="right"><?php echo JText::_('ADD_GROUP_GROUP_NAME'); ?></td>
						<td><input type="text" name="name" value="" id="group_name" maxlength="100" /></td>
					</tr>
		
					<tr>
						<td align="right"><?php echo JText::_('ADD_GROUP_GROUP_DESCRIPTION'); ?></td>
						<td><textarea name="desc" id="group_desc" ></textarea></td>	
					</tr>
				</tbody>
			</table>
			
			<input type="hidden" name="option" value="com_gk3_tabs_manager" />
			<input type="hidden" name="client" value="<?php echo $client->id;?>" />
			<input type="hidden" name="c" value="group" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
		</form>	
	</div>
</div>