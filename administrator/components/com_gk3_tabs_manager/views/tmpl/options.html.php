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
<link rel="stylesheet" type="text/css" href="<?php echo $uri->root(); ?>administrator/components/com_gk3_tabs_manager/interface/css/settings.css" media="all" />	
<?php endif; ?>

<?php if($modal_news == 0) : ?>	
<div id="wrapper">
<?php endif; ?>

	<?php if($modal_news == 0) : ?>	
	<?php ViewNavigation::generate(array( JText::_("SETTINGS") => 'option=com_gk3_tabs_manager&c=option')); ?>
	<?php endif; ?>
	
	<div id="info">
		<form action="index.php" method="post" name="adminForm">
			<table class="adminlist">
				<thead>
					<tr>
						<th width="50%" class="title" align="center"><?php echo JText::_('OPTION'); ?></th>
						<th width="50%" class="title" align="center"><?php echo JText::_('STATUS'); ?></th>
					</tr>
				</thead>
				<tfoot>
						<tr>
							<td colspan="3"><?php echo JText::_('OPTION_FOOT_INFO'); ?></td>
						</tr>
				</tfoot>
				<tbody>
					<tr>
						<td align="center"><?php echo JText::_('MODAL_NEWS'); ?></td>
						<td align="center">
							<select name="modal_news">
								<option value="0" <?php echo ($rows['modal_news']["value"] == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('DISABLED'); ?></option>
								<option value="1" <?php echo ($rows['modal_news']["value"] == 1) ? 'selected="selected"' : ''; ?>><?php echo JText::_('ENABLED'); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="center"><?php echo JText::_('MODAL_SETTINGS'); ?></td>
						<td align="center">
							<select name="modal_settings">
								<option value="0" <?php echo ($rows['modal_settings']["value"] == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('DISABLED'); ?></option>
								<option value="1" <?php echo ($rows['modal_settings']["value"] == 1) ? 'selected="selected"' : ''; ?>><?php echo JText::_('ENABLED'); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="center"><?php echo JText::_('GROUP_SHORTCUTS'); ?></td>
						<td align="center">
							<select name="group_shortcuts">
								<option value="0" <?php echo ($rows['group_shortcuts']["value"] == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('DISABLED'); ?></option>
								<option value="1" <?php echo ($rows['group_shortcuts']["value"] == 1) ? 'selected="selected"' : ''; ?>><?php echo JText::_('ENABLED'); ?></option>
							</select>						
						</td>
					</tr>
					<tr>
						<td align="center"><?php echo JText::_('TAB_SHORTCUTS'); ?></td>
						<td align="center">
							<select name="tab_shortcuts">
								<option value="0" <?php echo ($rows['tab_shortcuts']["value"] == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('DISABLED'); ?></option>
								<option value="1" <?php echo ($rows['tab_shortcuts']["value"] == 1) ? 'selected="selected"' : ''; ?>><?php echo JText::_('ENABLED'); ?></option>
							</select>						
						</td>
					</tr>
					<tr>
						<td align="center"><?php echo JText::_('TAB_WYSIWYG'); ?></td>
						<td align="center">
							<select name="wysiwyg">
								<option value="0" <?php echo ($rows['wysiwyg']["value"] == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('DISABLED'); ?></option>
								<option value="1" <?php echo ($rows['wysiwyg']["value"] == 1) ? 'selected="selected"' : ''; ?>><?php echo JText::_('ENABLED'); ?></option>
							</select>						
						</td>
					</tr>
					<tr>
						<td align="center"><?php echo JText::_('SHOW_GAVICK_NEWS'); ?></td>
						<td align="center">
							<select name="gavick_news">
								<option value="0" <?php echo ($rows['gavick_news']["value"] == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('DISABLED'); ?></option>
								<option value="1" <?php echo ($rows['gavick_news']["value"] == 1) ? 'selected="selected"' : ''; ?>><?php echo JText::_('ENABLED'); ?></option>
							</select>						
						</td>
					</tr>
					<tr>
						<td align="center"><?php echo JText::_('ARTICLE_ID'); ?></td>
						<td align="center">
							<select name="article_id">
								<option value="0" <?php echo ($rows['article_id']["value"] == 0) ? 'selected="selected"' : ''; ?>><?php echo JText::_('DISABLED'); ?></option>
								<option value="1" <?php echo ($rows['article_id']["value"] == 1) ? 'selected="selected"' : ''; ?>><?php echo JText::_('ENABLED'); ?></option>
							</select>						
						</td>
					</tr>
				</tbody>
			</table>
			
			<?php if($modal_news == 1) : ?>
			<button id="save_settings"><?php echo JText::_('SAVE_SETTINGS'); ?></button>
			<script type="text/javascript">
				window.addEvent("domready", function(){
					$("save_settings").onclick = function(e){
			    		new Event(e).stop();
						submitbutton('save');
					}
				});
			</script>			
			<?php endif; ?>
			<input type="hidden" name="option" value="com_gk3_tabs_manager" />
			<input type="hidden" name="client" value="<?php echo $client->id;?>" />
			<input type="hidden" name="task" value="" />
			<?php if($modal_news == 1) : ?><input type="hidden" name="tmpl" value="component" /><?php endif; ?>
			<input type="hidden" name="c" value="option" />
			<input type="hidden" name="boxchecked" value="0" />
		</form>	
	</div>
	
<?php if($modal_news == 0) : ?>		
</div>

<?php endif; ?>