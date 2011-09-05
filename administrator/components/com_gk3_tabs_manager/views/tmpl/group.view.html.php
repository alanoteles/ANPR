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

if (!function_exists('htmlspecialchars_decode')) {
        function htmlspecialchars_decode($str, $options="") {
                $trans = get_html_translation_table(HTML_SPECIALCHARS, $options);

                $decode = ARRAY();
                foreach ($trans AS $char=>$entity) {
                        $decode[$entity] = $char;
                }

                $str = strtr($str, $decode);

                return $str;
        }
}

?>

<link rel="stylesheet" type="text/css" href="<?php echo $uri->root(); ?>administrator/components/com_gk3_tabs_manager/interface/css/group.view.css" media="all" />

<div id="wrapper">

	<?php ViewNavigation::generate(array( JText::_("GROUPS") => 'option=com_gk3_tabs_manager&c=group')); ?>

	<div id="group">
		<form action="index.php" method="get" name="adminForm">
			<table class="adminlist">
				<thead>
					<tr>
						<th width="3%" class="title" align="center">#</th>
						<th width="3%" class="title" align="center">ID</th>
						<th width="3%" class="title" align="center"><input type="checkbox" onclick="checkAll(<?php echo count($rows); ?>);" value="" name="toggle"/></th>
						<th width="<?php echo ($tab_shortcuts == 1) ? '23%' : '28%' ?>" class="title" align="center"><?php echo JText::_( 'NAME' ); ?></th>
						
						<?php if($tab_shortcuts == 1) : ?>
						<th width="10%" class="title" align="center"><?php echo JText::_( 'REMOVE' ); ?></th>
						<?php endif; ?>
						
						<th width="<?php echo ($tab_shortcuts == 1) ? '23%' : '28%' ?>" align="center" align="center"><?php echo JText::_( 'TYPE' ); ?></th>
						<th width="10%" class="title" align="center"><?php echo JText::_( 'PUBLISHED' ); ?></th>
						<th width="10%" class="title" align="center"><?php echo JText::_( 'ACCESS' ); ?></th>
						<th width="10%" class="title" align="center"><?php echo JText::_('ORDER'); ?><?php echo JHTML::_('grid.order',  $rows );?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="<?php echo ($tab_shortcuts == 1) ? '9' : '8' ?>"><?php echo JText::_('VIEW_GROUP_FOOT_INFO'); ?></td>
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
						<td width="<?php echo ($tab_shortcuts == 1) ? '23%' : '28%' ?>" align="left">
							<span style="text-decoration: underline;cursor: pointer;" onclick="javascript:$$('.inputs').removeProperty('checked');$('cb<?php echo $i ?>').checked='checked';isChecked($('cb<?php echo $i ?>').checked);submitbutton('edit');" title="<?php echo JText::_( 'CLICK_TO_EDIT' ); ?>">
								<?php echo htmlspecialchars_decode($row->name);?>
							</span>
						</td>
						
						<?php if($tab_shortcuts == 1) : ?>
						<td width="10%" align="center"><img src="components/com_gk3_tabs_manager/interface/images/remove.png" style="text-decoration: underline;cursor: pointer;" onclick="javascript:$$('.inputs').removeProperty('checked');$('cb<?php echo $i ?>').checked='checked';isChecked($('cb<?php echo $i ?>').checked);submitbutton('delete_tab');" title="<?php echo JText::_( 'CLICK_TO_REMOVE' ); ?>" /></td>
						<?php endif; ?>
						
						<td width="<?php echo ($tab_shortcuts == 1) ? '23%' : '28%' ?>" align="center"><?php echo $row->type; ?></td>
						<td width="10%" align="center"><?php 
						
						 if($row->published == 0)
						 {
				 			echo '<img style="cursor:pointer" src="components/com_gk3_tabs_manager/interface/images/unpublish.png" onclick="javascript:$$(\'.inputs\').removeProperty(\'checked\'); $(\'cb'.$i.'\').checked=\'checked\';isChecked($(\'cb'.$i.'\').checked);submitbutton(\'publish_tab\');" title="'.JText::_( 'PUBLISH' ).'">';
						 } 
						 else
						 {
				 			echo '<img style="cursor:pointer" src="components/com_gk3_tabs_manager/interface/images/publish.png" onclick="javascript:$$(\'.inputs\').removeProperty(\'checked\'); $(\'cb'.$i.'\').checked=\'checked\';isChecked($(\'cb'.$i.'\').checked);submitbutton(\'unpublish_tab\');" title="'.JText::_( 'UNPUBLISH' ).'">';						 	
						 }
						
						?></td>
						<td width="10%" align="center"><?php 
							
							if($row->access == 0)
							{
					  			echo '<span style="text-decoration: underline;cursor: pointer;color: green;" onclick="javascript:$(\'level\').value=1;$$(\'.inputs\').removeProperty(\'checked\');$(\'cb'.$i.'\').checked=\'checked\';isChecked($(\'cb'.$i.'\').checked);submitbutton(\'access_tab\');" title="'.JText::_( 'CHANGE_TO_REGISTERED' ).'">'.JText::_( 'PUBLIC' ).'</span>';
							}
							else if($row->access == 1)
							{
					  			echo '<span style="text-decoration: underline;cursor: pointer;color: red;" onclick="javascript:$(\'level\').value=2;$$(\'.inputs\').removeProperty(\'checked\');$(\'cb'.$i.'\').checked=\'checked\';isChecked($(\'cb'.$i.'\').checked);submitbutton(\'access_tab\');" title="'.JText::_( 'CHANGE_TO_SPECIAL' ).'">'.JText::_( 'REGISTERED' ).'</span>';								
							}
							else if($row->access == 2)
							{
					  			echo '<span style="text-decoration: underline;cursor: pointer;color: black;" onclick="javascript:$(\'level\').value=0;$$(\'.inputs\').removeProperty(\'checked\');$(\'cb'.$i.'\').checked=\'checked\';isChecked($(\'cb'.$i.'\').checked);submitbutton(\'access_tab\');" title="'.JText::_( 'CHANGE_TO_PUBLIC' ).'">'.JText::_( 'SPECIAL' ).'</span>';								
							}
							 
							
						?></td>
						<td width="10%" align="center"><input type="text" name="order[]" size="5" value="<?php echo $row->order;?>" class="text_area" style="text-align: center" /></td>
					</tr>		
				<?php }}else{ // gdy brak grup do załadowania ?>
					<tr>
						<td width="100%" align="center" colspan="<?php echo ($tab_shortcuts == 1) ? '9' : '8' ?>"><?php echo JText::_( 'ANY_TABS_TO_SHOW' ); ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			
			<input type="hidden" name="option" value="com_gk3_tabs_manager" />
			<input type="hidden" name="client" value="<?php echo $client->id;?>" />
			<input type="hidden" name="c" value="tab" />
			<input type="hidden" name="level" id="level" value="" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="gid" value="<?php echo $cid[0]; ?>" />
			<input type="hidden" name="boxchecked" value="0" />
		</form>	
	</div>
</div>