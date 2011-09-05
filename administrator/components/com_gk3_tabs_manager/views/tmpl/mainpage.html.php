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
 * Mainpage view html.
 * 
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// loading Modal Box
JHTML::_( 'behavior.modal' );
// getting client variable
$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

?>

<div id="wrapper">
      <?php ViewNavigation::generate(array( JText::_("MAINPAGE") => 'option=com_gk3_tabs_manager')); ?>
      <table style="width: 924px;" class="adminform">
            <tbody>
                  <tr align="top">
                        <td width="60%"><div id="cpanel">
                                    <h3><?php echo JText::_('WHAT_DO_YOU_WANT_TO_DO'); ?></h3>
                                    <div style="float: left; margin-left: 5px;">
                                          <div class="icon">
                                                <a href="<?php echo $uri->root().'administrator/index.php?option=com_gk3_tabs_manager&c=group'; ?>">
                                                <img src="<?php echo $uri->root().'administrator/components/com_gk3_tabs_manager/interface/images/icon-48-section.png'; ?>" alt="<?php echo JText::_('MANAGE_GROUPS'); ?>" /><br/>
                                                <span><?php echo JText::_('MANAGE_GROUPS'); ?></span>
                                                </a>
                                          </div>
                                    </div>
                                    <div style="float: left; margin-left: 5px;" id="quick_group_manage_button">
                                          <div class="icon">
                                                <a href="#">
                                                <img src="<?php echo $uri->root().'administrator/components/com_gk3_tabs_manager/interface/images/icon-48-category.png'; ?>" alt="<?php echo JText::_('MANAGE_TABS'); ?>" /><br/>
                                                <span><?php echo JText::_('MANAGE_TABS'); ?></span>
                                                </a>
                                          </div>
                                    </div>
                                    <div style="float: left; margin-left: 5px;" id="quick_group_add_button">
                                          <div class="icon">
                                                <a href="#">
                                                <img src="<?php echo $uri->root().'administrator/components/com_gk3_tabs_manager/interface/images/button_add_group.png'; ?>" alt="<?php echo JText::_('ADD_GROUP'); ?>" /><br/>
                                                <span><?php echo JText::_('ADD_GROUP'); ?></span></a>
                                          </div>
                                    </div>
                                    <div style="float: left; margin-left: 5px;margin-bottom:30px;" id="quick_tab_add_button">
                                          <div class="icon">
                                                <a href="#">
                                                <img src="<?php echo $uri->root().'administrator/components/com_gk3_tabs_manager/interface/images/button_add_tab.png'; ?>" alt="<?php echo JText::_('ADD_TAB'); ?>" /><br/>
                                                <span><?php echo JText::_('ADD_TAB'); ?></span></a>
                                          </div>
                                    </div>
                                    <h3 style="clear: both;"><?php echo JText::_('COMPONENT_OPTIONS'); ?></h3>
                                    <div style="float: left; margin-left: 5px;">
                                          <div class="icon">
                                                <a href="<?php echo $uri->root().'administrator/index.php?option=com_gk3_tabs_manager&c=option'.(($modal_settings) ? '&tmpl=component' : ''); ?>" <?php if($modal_settings) echo ' class="modal"  rel="{handler: \'iframe\', size: {x: 400, y: 400}}"'; ?>>
                                                <img src="<?php echo $uri->root().'administrator/components/com_gk3_tabs_manager/interface/images/icon-48-config.png'; ?>" alt="<?php echo JText::_('SETTINGS'); ?>" />
                                                <br/>
                                                <span><?php echo JText::_('SETTINGS'); ?></span>
                                                </a>
                                          </div>
                                    </div>
                                    <div style="float: left; margin-left: 5px;">
                                          <div class="icon">
                                                <a href="<?php echo $uri->root().'administrator/index.php?option=com_gk3_tabs_manager&c=check_system'.(($modal_settings) ? '&tmpl=component' : ''); ?>" <?php if($modal_settings) echo ' class="modal"  rel="{handler: \'iframe\', size: {x: 800, y: 300}}"'; ?>>
                                                <img src="<?php echo $uri->root().'administrator/components/com_gk3_tabs_manager/interface/images/icon-48-checkin.png'; ?>" alt="<?php echo JText::_('CHECK_SYSTEM'); ?>" />
                                                <br/>
                                                <span><?php echo JText::_('CHECK_SYSTEM'); ?>
                                                </span>
                                                </a>
                                          </div>
                                    </div>
                                    <div style="float: left; margin-left: 5px;">
                                          <div class="icon">
                                                <a href="<?php echo $uri->root().'administrator/index.php?option=com_gk3_tabs_manager&c=news&task=view_news_all'.(($modal_settings) ? '&tmpl=component' : ''); ?>" <?php if($modal_settings) echo ' class="modal"  rel="{handler: \'iframe\', size: {x: 800, y: 400}}"'; ?>>
                                                <img src="<?php echo $uri->root().'administrator/components/com_gk3_tabs_manager/interface/images/icon-48-help_header_news-48.png'; ?>" alt="<?php echo JText::_('GAVICK_NEWS'); ?>" />
                                                <br/>
                                                <span><?php echo JText::_('GAVICK_NEWS'); ?>
                                                </span>
                                                </a>
                                          </div>
                                    </div>
                                    <div style="float: left; margin-left: 5px;margin-bottom: 20px;">
                                          <div class="icon">
                                                <a href="<?php echo $uri->root().'administrator/index.php?option=com_gk3_tabs_manager&c=info&task=info'.(($modal_settings) ? '&tmpl=component' : ''); ?>" <?php if($modal_settings) echo ' class="modal"  rel="{handler: \'iframe\', size: {x: 400, y: 200}}"'; ?>>
                                                <img src="<?php echo $uri->root().'administrator/components/com_gk3_tabs_manager/interface/images/icon-48-help_header.png'; ?>" alt="<?php echo JText::_('INFO_AND_HELP'); ?>" />
                                                <br/>
                                                <span><?php echo JText::_('INFO_AND_HELP'); ?>
                                                </span>
                                                </a>
                                          </div>
                                    </div>
                              </div></td>
                        
                      		  <td width="40%">
								<div id="cpanel">
                                    <div class="gavick_news">
                                          <?php if($gavick_news) : ?>
										  <h3><?php echo JText::_('GAVICKPRO_LATEST_NEWS'); ?></h3>
                                          <ul>
                                                <?php echo ViewMainpage::loadGavickRSS(); ?>
                                          </ul>
                                          <?php else : ?>
                                          <img src="components/com_gk3_tabs_manager/interface/images/logo.png" style="display: block;margin: 0 auto;" alt="GavickPro logo" />
                                          <?php endif; ?>
                                    </div>
                              	</div>
							  </td>
                  </tr>
            </tbody>
      </table>
      <!-- Dynamic forms -->
      <script type="text/javascript">
		window.addEvent("domready", function(){
			if($('quick_group_manage_button')){
				$('quick_group_manage_button').addEvent("click", function(){
					$('quick_group_manage').setStyles({
						'display' : 'block',
						'opacity' : 0,
						'top' : ($('quick_group_manage_button').getPosition().y - $('wrapper').getPosition().y)  + 50,
						'left' : ($('quick_group_manage_button').getPosition().x - $('wrapper').getPosition().x) + 100
					});
					new Fx.Style('quick_group_manage', 'opacity').start(0,1);
				});
			}
			
			if($('quick_tab_add_button')){
				$('quick_tab_add_button').addEvent("click", function(){
					$('quick_tab_add').setStyles({
						'display' : 'block',
						'opacity' : 0,
						'top' : ($('quick_tab_add_button').getPosition().y - $('wrapper').getPosition().y)  + 50,
						'left' : ($('quick_tab_add_button').getPosition().x - $('wrapper').getPosition().x) + 100
					});
					new Fx.Style('quick_tab_add', 'opacity').start(0,1);
				});
			}

			if($('quick_group_add_button')){
				$('quick_group_add_button').addEvent("click", function(){
					$('quick_group_add').setStyles({
						'display' : 'block',
						'opacity' : 0,
						'top' : ($('quick_group_add_button').getPosition().y - $('wrapper').getPosition().y)  + 50,
						'left' : ($('quick_group_add_button').getPosition().x - $('wrapper').getPosition().x) + 100
					});
					new Fx.Style('quick_group_add', 'opacity').start(0,1);
				});
			}
			
			if($("quick_group_add_submit")){
				$("quick_group_add_submit").addEvent("click", function(e){
					new Event(e).stop();
		    		var alert_content = '';
					if($("group_name").getValue() == '') alert_content += '<?php echo JText::_('WRONG_GROUP_NAME').' \n'; ?>';
					if($("group_desc").value == '') alert_content += '<?php echo JText::_('WRONG_GROUP_DESC'); ?>';	
					(alert_content != '') ? alert(alert_content) : $('quick_group_add_form').submit();
				});
			}
			
			if($("quick_group_add_cancel")){
				$("quick_group_add_cancel").addEvent("click", function(e){
					new Event(e).stop();
					$("group_name").value = '';
					$("group_desc").value = '';	
					new Fx.Style('quick_group_add', 'opacity', {onComplete: function(){
						$('quick_group_add').setStyle('display','none');
					}}).start(0);
				});
			}
			
			if($("quick_group_manage_submit")){
				$("quick_group_manage_submit").addEvent("click", function(e){
					new Event(e).stop();
					$('quick_group_manage_form').submit();
				});
			}
			
			if($("quick_group_manage_cancel")){
				$("quick_group_manage_cancel").addEvent("click", function(e){
					new Event(e).stop();
					new Fx.Style('quick_group_manage', 'opacity', {onComplete: function(){
						$('quick_group_manage').setStyle('display','none');
					}}).start(0);
				});
			}
			
			if($("quick_tab_add_submit")){
				$("quick_tab_add_submit").addEvent("click", function(e){
					new Event(e).stop();
					$('quick_tab_add_form').submit();
				});
			}
			
			if($("quick_tab_add_cancel")){
				$("quick_tab_add_cancel").addEvent("click", function(e){
					new Event(e).stop();
					new Fx.Style('quick_tab_add', 'opacity', {onComplete: function(){
						$('quick_tab_add').setStyle('display','none');
					}}).start(0);
				});
			}
		});
	</script>
      <div id="quick_group_add">
            <form action="index.php?option=com_gk3_tabs_manager&c=group&task=add_group" method="post" id="quick_group_add_form">
                  <table class="adminlist">
                        <tbody>
                              <tr>
                                    <td><?php echo JText::_('ADD_GROUP_GROUP_NAME'); ?></td>
                                    <td><input type="text" name="name" value="" id="group_name" maxlength="100" /></td>
                              </tr>
                              <tr>
                                    <td><?php echo JText::_('ADD_GROUP_GROUP_DESCRIPTION'); ?></td>
                                    <td><textarea name="desc" id="group_desc" ></textarea></td>
                              </tr>
                              <tr>
                                    <td colspan="2"><button id="quick_group_add_submit"><?php echo JText::_('ADD_GROUP'); ?></button>
                                          <button id="quick_group_add_cancel"><?php echo JText::_('CANCEL'); ?></button></td>
                              </tr>
                        </tbody>
                  </table>
                  <input type="hidden" name="option" value="com_gk3_tabs_manager" />
                  <input type="hidden" name="client" value="<?php echo $client->id;?>" />
                  <input type="hidden" name="boxchecked" value="0" />
            </form>
      </div>
      <div id="quick_group_manage">
            <form action="index.php?option=com_gk3_tabs_manager&c=group&task=view" method="post" id="quick_group_manage_form">
                  <table class="adminlist">
                        <tbody>
                        <td><select name="cid[]">
                                          <?php echo $group_list; ?>
                                    </select></td>
                              <td><button id="quick_group_manage_submit"><?php echo JText::_('CHOOSE_GROUP'); ?></button>
                                    <button id="quick_group_manage_cancel"><?php echo JText::_('CANCEL'); ?></button></td>
                              </tbody>
                  </table>
                  <input type="hidden" name="option" value="com_gk3_tabs_manager" />
                  <input type="hidden" name="client" value="<?php echo $client->id;?>" />
                  <input type="hidden" name="boxchecked" value="0" />
            </form>
      </div>
      <div id="quick_tab_add">
            <form action="index.php?option=com_gk3_tabs_manager&c=tab&task=add" method="post" id="quick_tab_add_form">
                  <table class="adminlist">
                        <tbody>
                              <tr>
                                    <td><select name="gid">
                                                <?php echo $group_list; ?>
                                          </select></td>
                                    <td><button id="quick_tab_add_submit"><?php echo JText::_('CHOOSE_GROUP'); ?></button>
                                          <button id="quick_tab_add_cancel"><?php echo JText::_('CANCEL'); ?></button></td>
                              </tr>
                        </tbody>
                  </table>
                  <input type="hidden" name="option" value="com_gk3_tabs_manager" />
                  <input type="hidden" name="client" value="<?php echo $client->id;?>" />
                  <input type="hidden" name="boxchecked" value="0" />
            </form>
      </div>
</div>
<form action="index.php" method="get" name="adminForm">
      <input type="hidden" name="option" value="com_gk3_tabs_manager" />
      <input type="hidden" name="client" value="<?php echo $client->id;?>" />
      <input type="hidden" name="task" value="" />
      <input type="hidden" name="c" value="mainpage" />
      <input type="hidden" name="boxchecked" value="0" />
</form>
