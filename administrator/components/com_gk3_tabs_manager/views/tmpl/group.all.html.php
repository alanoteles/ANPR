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

<link rel="stylesheet" type="text/css" href="<?php echo $uri->root(); ?>administrator/components/com_gk3_tabs_manager/interface/css/groups.view.css" media="all" />

<div id="wrapper">

	<?php ViewNavigation::generate(array( JText::_("GROUPS") => 'option=com_gk3_tabs_manager&c=group')); ?>

	<div id="groups">
		<form action="index.php" method="get" name="adminForm">
			<table class="adminlist">
				<thead>
					<tr>
						<th width="3%" class="title" align="center">#</th>
						<th width="3%" class="title" align="center">ID</th>
						<th width="3%" class="title" align="center"><input type="checkbox" onclick="checkAll(<?php echo count($rows); ?>);" value="" name="toggle"/></th>
						<?php if($group_shortcuts == 1) : ?>
						<th width="10%" class="title" align="center"><?php echo JText::_( 'EDIT' ); ?></th>
						<th width="10%" class="title" align="center"><?php echo JText::_( 'REMOVE' ); ?></th>
						<?php endif; ?>
						<th width="28%" class="title" align="center"><?php echo JText::_( 'NAME' ); ?></th>
						<th width="<?php echo ($group_shortcuts == 1) ? '29%' : '49%' ?>" align="center" align="center"><?php echo JText::_( 'DESC' ); ?></th>
						<th width="14%" class="title" align="center"><?php echo JText::_( 'TABS_AMOUNT' ); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="<?php echo ($group_shortcuts == 1) ? '8' : '6' ?>"><?php echo JText::_('GROUPS_FOOT_INFO'); ?></td>
					</tr>
				</tfoot>
				<tbody>
			
				<?php 	
					// wypisanie wierszy tabeli	
					if($rows){
						for ($i = 0; $i < count($rows); $i++) { 
							$row =& $rows[$i]; 
				?>
					
					<tr class="<?php echo 'row'. $i%2; ?>">
						<td width="3%" align="center"><?php echo $i+1; ?></td>
						<td width="3%" align="center"><?php echo $row->id; ?></td>		
						<td width="3%" align="center">
							<input type="checkbox" class="inputs" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" />
						</td>	
						
						<?php if($group_shortcuts == 1) : ?>
						<td width="10%" align="center"><img src="components/com_gk3_tabs_manager/interface/images/edit.png" style="text-decoration: underline;cursor: pointer;" onclick="javascript:$$('.inputs').removeProperty('checked');$('cb<?php echo $i ?>').checked='checked';isChecked($('cb<?php echo $i ?>').checked);submitbutton('edit');" title="<?php echo JText::_( 'CLICK_TO_EDIT' ); ?>" /></td>
						<td width="10%" align="center"><img src="components/com_gk3_tabs_manager/interface/images/remove.png" style="text-decoration: underline;cursor: pointer;" onclick="javascript:$$('.inputs').removeProperty('checked');$('cb<?php echo $i ?>').checked='checked';isChecked($('cb<?php echo $i ?>').checked);submitbutton('delete_group');" title="<?php echo JText::_( 'CLICK_TO_REMOVE' ); ?>" /></td>
						<?php endif; ?>
						
						<td width="28%" align="left">
							<span style="text-decoration: underline;cursor: pointer;" onclick="javascript:$$('.inputs').removeProperty('checked');$('cb<?php echo $i ?>').checked='checked';isChecked($('cb<?php echo $i ?>').checked);submitbutton('view');" title="<?php echo JText::_( 'CLICK_TO_SHOW' ); ?>">
								<?php echo $row->name;?>
							</span>
						</td>
						<td width="<?php echo ($group_shortcuts == 1) ? '29%' : '49%' ?>" align="center"><?php echo $row->desc; ?></td>
						<td width="14%" align="center"><?php echo $row->amount; ?></td>
					</tr>		
				<?php }}else{ // gdy brak grup do załadowania ?>
					<tr>
						<td width="100%" align="center" colspan="<?php echo ($group_shortcuts == 1) ? '8' : '6' ?>"><?php echo JText::_( 'ANY_GROUPS_TO_SHOW' ); ?></td>
					</tr>
				<?php } ?>
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