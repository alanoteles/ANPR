<?php 
/**
* @version		$Id: default.php 221 2011-06-11 17:30:33Z happy_noodle_boy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2011 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL 2 or later
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
defined( '_WF_EXT' ) or die('RESTRICTED');

?>
<table border="0" cellpadding="3" cellspacing="0">
	<tr>
		<td><label for="widgetkit_lightbox_group" class="hastip" title="<?php echo WFText::_('WF_POPUPS_WIDGETKIT_GROUP_DESC');?>"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_GROUP');?></label></td>
		<td><input id="widgetkit_lightbox_group" type="text" class="text" value="" /></td>
	</tr>
    <tr>
		<td>
        	<label for="widgetkit_lightbox_titlePosition" class="hastip" title="<?php echo WFText::_('WF_POPUPS_WIDGETKIT_TITLEPOSITION_DESC');?>"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_TITLEPOSITION');?></label>
		</td>
		<td>	
			<select id="widgetkit_lightbox_titlePosition">
				<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
                <option value="float"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_FLOAT');?></option>
                <option value="outside"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_OUTSIDE');?></option>
                <option value="inside"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_INSIDE');?></option>
                <option value="over"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_OVER');?></option>                                        
            </select>
        </td>
	</tr>
	<tr>
		<td>
        	<label for="widgetkit_lightbox_overlayShow" class="hastip" title="<?php echo WFText::_('WF_POPUPS_WIDGETKIT_OVERLAYSHOW_DESC');?>"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_OVERLAYSHOW');?></label>
		</td>
		<td>
			<select id="widgetkit_lightbox_overlayShow">
				<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
                <option value="true"><?php echo WFText::_('WF_OPTION_YES');?></option>
                <option value="false"><?php echo WFText::_('WF_OPTION_NO');?></option>                                      
            </select>
        </td>
	</tr>
	<tr>
		<td><label for="width" class="hastip" title="<?php echo WFText::_('WF_LABEL_DIMENSIONS_DESC');?>"><?php echo WFText::_('WF_LABEL_DIMENSIONS');?></label></td>
			<td>
			<table cellpadding="0" cellspacing="0">
	            <tr>
	                <td>
	                	<input type="text" id="widgetkit_lightbox_width" value="" /> x <input type="text" id="widgetkit_lightbox_height" value="" />
	                </td>
	                <td><input id="widgetkit_lightbox_constrain" type="checkbox" class="checkbox" checked="checked" /><label for="widgetkit_lightbox_constrain"><?php echo WFText::_('WF_LABEL_PROPORTIONAL');?></label></td>
	            </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><label for="widgetkit_lightbox_padding" class="hastip" title="<?php echo WFText::_('WF_POPUPS_WIDGETKIT_PADDING_DESC');?>"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_PADDING');?></label></td>
		<td>
			<input type="text" size="5" id="widgetkit_lightbox_padding" />
		</td>
	</tr>
	<tr>
		<td><label for="widgetkit_lightbox_transitionIn" class="hastip" title="<?php echo WFText::_('WF_POPUPS_WIDGETKIT_TRANSITIONIN_DESC');?>"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_TRANSITIONIN');?></label></td>
		<td>
			<select id="widgetkit_lightbox_transitionIn">
				<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
				<option value="fade"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_FADE');?></option>
				<option value="elastic"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_ELASTIC');?></option>
				<option value="none"><?php echo WFText::_('WF_OPTION_NONE');?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="widgetkit_lightbox_transitionOut" class="hastip" title="<?php echo WFText::_('WF_POPUPS_WIDGETKIT_TRANSITIONOUT_DESC');?>"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_TRANSITIONOUT');?></label></td>
		<td>
			<select id="widgetkit_lightbox_transitionOut">
				<option value=""><?php echo WFText::_('WF_OPTION_NOT_SET');?></option>
				<option value="fade"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_FADE');?></option>
				<option value="elastic"><?php echo WFText::_('WF_POPUPS_WIDGETKIT_ELASTIC');?></option>
				<option value="none"><?php echo WFText::_('WF_OPTION_NONE');?></option>
			</select>
		</td>
	</tr>
	
</table>