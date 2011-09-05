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

<link rel="stylesheet" type="text/css" href="<?php echo $uri->root(); ?>administrator/components/com_gk3_tabs_manager/interface/css/tab.add.css" media="all" />

<script type="text/javascript">
	window.addEvent("domready", function(){
		$('tab_type').addEvent("change", function(){
			switch($('tab_type').value)
			{
				case 'module' : 
					$("form_position").setStyle("display",(!window.ie) ? "table-row" : "block");
					$("form_article").setStyle("display","none");
					$("form_content").setStyle("display","none");
				break;
				case 'article' : 
					$("form_position").setStyle("display","none");
					$("form_article").setStyle("display",(!window.ie) ? "table-row" : "block");
					$("form_content").setStyle("display","none");				
				break;
				case 'xhtml' : 
					$("form_position").setStyle("display","none");
					$("form_article").setStyle("display","none");
					$("form_content").setStyle("display",(!window.ie) ? "table-row" : "block");				
				break;
			}
		});
		
		$E("#toolbar-save .toolbar").onclick = function(){
			try{tinyMCE.execCommand('mceRemoveControl', false, 'content');}catch(e){}
    		var alert_content = '';			
			if($("tab_name").getValue() == '') alert_content += '<?php echo JText::_('WRONG_TAB_NAME'); ?>'; 
			switch($('tab_type').value)
			{
				case 'module' : 
					$("form_article").remove();
					$("form_content").remove();
				break;
				case 'article' : 
					$("form_position").remove();
					$("form_content").remove();				
				break;
				case 'xhtml' : 
					$("form_position").remove();
					$("form_article").remove();				
				break;
			}				
			(alert_content != '') ? alert(alert_content) : submitbutton('add_tab');
		}
	});
</script>

<div id="wrapper">

	<?php 
		ViewNavigation::generate(array(
			JText::_("GROUPS") => 'option=com_gk3_tabs_manager&c=group',
			JText::_("ADD_TAB") => 'option=com_gk3_tabs_manager&c=tab&task=add&gid='.$gid
		)); 
	?>
	
	<div id="groups">
		<form action="index.php" method="post" name="adminForm">
			<table class="adminlist">
				<tbody>
					<tr>
						<td width="30%" align="right"><?php echo JText::_('TAB_NAME'); ?></td>
						<td><input type="text" name="name" value="" id="tab_name" /></td>
					</tr>
							
					<tr>
						<td align="right"><?php echo JText::_('SELECT_TAB_TYPE'); ?></td>
						<td>
							<select name="type" id="tab_type">
								<option value="module" selected="selected"><?php echo JText::_('MODULE'); ?></option>
								<option value="article"><?php echo JText::_('ARTICLE'); ?></option>
								<option value="xhtml"><?php echo JText::_('XHTML'); ?></option>
							</select>
						</td>
					</tr>							
							
					<tr>
						<td align="right"><?php echo JText::_('TAB_ACCESS'); ?></td>
						<td>
							<select name="access">
								<option value="0" selected="selected"><?php echo JText::_('PUBLIC'); ?></option>
								<option value="1"><?php echo JText::_('REGISTERED'); ?></option>
								<option value="2"><?php echo JText::_('SPECIAL'); ?></option>
							</select>
						</td>
					</tr>

					<tr>
						<td align="right"><?php echo JText::_('TAB_PUBLISHED'); ?></td>
						<td>
							<select name="published">
								<option value="0"><?php echo JText::_('UNPUBLISHED'); ?></option>
								<option value="1" selected="selected"><?php echo JText::_('PUBLISHED'); ?></option>
							</select>
						</td>
					</tr>					
							
					<tr id="form_position">
						<td align="right"><?php echo JText::_('TAB_POSITION'); ?></td>
						<td>
										
								<?php 
									$url = & JURI::getInstance();
									$db =& JFactory::getDBO();
									$db->setQuery( "SELECT template FROM #__templates_menu WHERE client_id = 0 LIMIT 1" );
					
									foreach($db->loadObjectList() as $t) $templateDir = $t->template;
														
									$xml = & JFactory::getXMLParser('Simple');
					
									if ($xml->loadFile(JPATH_SITE . DS . 'templates' . DS . $templateDir . DS . 'templateDetails.xml'))
									{
										$element = & $xml->document->positions[0];
										if($element)
										{
											echo '<select name="content" id="tab_position">';
											
											for($i = 0; $element->position[$i]; $i++)
											{
												if($i == 0)
												{
													echo '<option value="'.$element->position[$i]->data().'" selected="selected">'.$element->position[$i]->data().'</option>';	
												}
												else
												{
													echo '<option value="'.$element->position[$i]->data().'">'.$element->position[$i]->data().'</option>';
												}
											}
											
											echo '</select>';
										}
									}
									else
									{
										echo '<input type="text" name="position" id="tab_position" class="input_box" size="70" value="" />'.JText::_('PLEASE_SET_MODULE_POSITION_MANUALLY');
									}
								?>	
							</select>
						</td>
					</tr>
					
					<tr id="form_article" style="display: none;">
						<td align="right"><?php echo JText::_('SELECT_ARTICLE'); ?></td>
						<td>			
							<?php if($article_id == 0) : ?>
							<select name="content" id="tab_article">
								<?php 
									
									$actual_group = '';
									$flag = false; 
									$first = false;
									//
									$db =& JFactory::getDBO();	
									$db->setQuery( 'SELECT a.`id` AS `id` , a.`title` AS `art_title`, k.`title` AS `cat_name` FROM `#__content` AS `a` LEFT JOIN `#__categories` AS `k` ON a.`catid` = k.`id` ORDER BY k.`title` ASC LIMIT 500;' );
									//
									foreach($db->loadObjectList() as $art){
										if($actual_group != $art->cat_name){ 
											if($flag) echo '</optgroup>'; else $flag = true;
											echo '<optgroup label="'.$art->cat_name.'">';
											$actual_group = $art->cat_name;
										}
								
									echo '<option '.(!$first ? 'selected="selected"' : '').' value="'.$art->id.'" /> '.$art->art_title;
									if(!$first) $first = true;
									}
								?>	
							</select>
							<?php else : ?>
							<input type="text" name="content" id="tab_article" />
							<?php endif; ?>
						</td>
					</tr>	
					
					<tr id="form_content" style="display: none;">
						<td align="right"><?php echo JText::_('TAB_CONTENT'); ?></td>
						<td>
							<?php if($wysiwyg == 0) : ?>
							<textarea id="content" name="content" rows="20" cols="50"></textarea>
							<?php else : ?>
							
							<?php
       							$editor =& JFactory::getEditor();
       							echo $editor->display('content', '', '550', '400', '60', '20', true);
       						?>
       						
       						<?php endif; ?>
						</td>
					</tr>
						
				</tbody>
			</table>
			
			<input type="hidden" name="option" value="com_gk3_tabs_manager" />
			<input type="hidden" name="client" value="<?php echo $client->id;?>" />
			<input type="hidden" name="c" value="tab" />
			<input type="hidden" name="gid" value="<?php echo $gid; ?>" />
			<input type="hidden" name="task" value="" />		
			<input type="hidden" name="boxchecked" value="0" />
		</form>	
	</div>
</div>