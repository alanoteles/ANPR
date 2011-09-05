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
 * Check system html.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// getting client variable
$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

?>

<?php if($modal_news == 1) : ?>	
<link rel="stylesheet" type="text/css" href="<?php echo $uri->root(); ?>administrator/components/com_gk3_tabs_manager/interface/css/check.system.css" media="all" />
<?php endif; ?>

<?php if($modal_news == 0) : ?>	
<div id="wrapper">
<?php endif; ?>

	<?php if($modal_news == 0) : ?>	
	<?php ViewNavigation::generate(array(JText::_("CHECK_SYSTEM") => 'option=com_gk3_tabs_manager&c=check_system')); ?>
	<?php endif; ?>
	
	<div id="info">
	
		<p><?php echo JText::_('COMPONENT_VERSION'); ?> <?php echo $systemcheck->version; ?></p>
		
		<h3><?php echo JText::_('CHECK_FOR_UPDATE'); ?> <button id="gk_update"><?php echo JText::_('CHECK_FOR_UPDATE'); ?></button></h3>
		<script type="text/javascript">
window.addEvent("load", function(e){
	new Event(e).stop();
	var update_url = 'http://www.gavick.com/updates.raw?task=json&tmpl=component&query=product&product=com_gk3_tabs_manager';
	var version = "3.1.2";
	
	$('gk_update').addEvent("click", function(){
		$('gk_update').innerHTML = 'Loading updates...';
		
		new Asset.javascript(update_url,{
	   		id: "new_script",
	   		onload: function(){
	   			if($GK_UPDATE.length == 0){
	   				$('gk_update').innerHTML = 'No new updates available for this component';
	   			}else{
	   				if($GK_UPDATE[0].version !== version){
	   					$('gk_update').innerHTML = 'New updates are available (v.'+($GK_UPDATE[0].version)+')';
	   					$('gk_update').removeEvents("click");
	   					$('gk_update').addEvent("click",function(){
	   						window.location = $GK_UPDATE[0].link;
	   					});
	   				}
	   				else
	   				{
	   					$('gk_update').innerHTML = 'No new updates available for this component';
	   				}
	   			}
	   		}
		});
		
		if(window.ie){
			var $timer = (function(){
				if(typeof($GK_UPDATE) != undefined){
					$clear($timer);
					alert('Updates data downloaded');
					if($GK_UPDATE.length == 0){
						$('gk_update').innerHTML = 'No new updates available for this component';
	   				}else{
	   					if($GK_UPDATE[0].version !== version){
	   						$('gk_update').innerHTML = 'New updates are available (v.'+$GK_UPDATE[0].version+')';
	   						$('gk_update').removeEvents("click");
	   						$('gk_update').addEvent("click",function(){
	   							window.location = $GK_UPDATE[0].link;
	   						});
	   					}
	   					else
	   					{
	   						$('gk_update').innerHTML = 'No new updates available for this component';
	   					}
	   				}	
				}
			}).periodical(250);
		}
	});
});
		</script>
		
		<h3><?php echo JText::_('TABLE_STATUS'); ?></h3>	
		
		<table class="adminlist">
			<thead>
				<tr>
					<th width="4%" class="title" align="center">#</th>
					<th width="48%" class="title" align="center"><?php echo JText::_('TABLE'); ?></th>
					<th width="48%" class="title" align="center"><?php echo JText::_('TABLE_EXIST'); ?></th>
				</tr>
			</thead>
			<tfoot>
					<tr>
						<td colspan="3"><?php echo JText::_('CHECK_SYSTEM_FOOT_INFO'); ?></td>
					</tr>
			</tfoot>
			<tbody>
				<tr>
					<td align="center">1</td>
					<td align="center"><?php echo $systemcheck->prefix; ?>gk3_tabs_manager_groups</td>
					<td align="center"><?php $systemcheck->DBTableStatus('gk3_tabs_manager_groups');?></td>
				</tr>
				<tr>
					<td align="center">2</td>
					<td align="center"><?php echo $systemcheck->prefix; ?>gk3_tabs_manager_tabs</td>
					<td align="center"><?php $systemcheck->DBTableStatus('gk3_tabs_manager_tabs');?></td>
				</tr>
				<tr>
					<td align="center">3</td>
					<td align="center"><?php echo $systemcheck->prefix; ?>gk3_tabs_manager_options</td>
					<td align="center"><?php $systemcheck->DBTableStatus('gk3_tabs_manager_options');?></td>
				</tr>
			</tbody>
		</table>


	</div>
	
<?php if($modal_news == 0) : ?>		
</div>

<form action="index.php" method="get" name="adminForm">
	<input type="hidden" name="option" value="com_gk3_tabs_manager" />
	<input type="hidden" name="client" value="<?php echo $client->id;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="c" value="check_system" />
	<input type="hidden" name="boxchecked" value="0" />
</form>	

<?php endif; ?>