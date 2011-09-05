<?php
/**
 * $Id: default.php 11917 2009-05-29 19:37:05Z ian $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

$cparams = JComponentHelper::getParams ('com_media');
?>
<?php if ( $this->params->get( 'show_page_title', 1 ) && !$this->contact->params->get( 'popup' ) && $this->params->get('page_title') != $this->contact->name ) : ?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"> <?php echo $this->params->get( 'page_title' ); ?> </div>
<?php endif; ?>
<div class="article-text-indent">
    <div class="clear">
        <div id="component-contact">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="contentpaneopen<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
                <?php if ( $this->params->get( 'show_contact_list' ) && count( $this->contacts ) > 1) : ?>
                <tr>
                    <td colspan="2" align="center"><br />
                        <form action="<?php echo JRoute::_('index.php') ?>" method="post" name="selectForm" id="selectForm">
                            <?php echo JText::_( 'Select Contact' ); ?>: <br />
                            <?php echo JHTML::_('select.genericlist',  $this->contacts, 'contact_id', 'class="inputbox" onchange="this.form.submit()"', 'id', 'name', $this->contact->id);?>
                            <input type="hidden" name="option" value="com_contact" />
                        </form></td>
                </tr>
                <?php endif; ?>
                <?php if ( $this->contact->name && $this->contact->params->get( 'show_name' ) ) : ?>
                <tr>
                    <td width="100%" class="contentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><?php echo $this->escape($this->contact->name); ?> </td>
                </tr>
                <?php endif; ?>
                <?php if ( $this->contact->con_position && $this->contact->params->get( 'show_position' ) ) : ?>
                <tr>
                    <td colspan="2"><?php echo $this->escape($this->contact->con_position); ?> <br />
                    </td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td><table border="0" width="100%">
                     		<tr>
                                <td><?php echo $this->loadTemplate('address'); ?> </td>

                            <td><div id="map"><iframe width="300" height="180" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Brooklyn,+New+York,+NY,+United+States&amp;aq=0&amp;sll=37.0625,-95.677068&amp;sspn=61.282355,146.513672&amp;ie=UTF8&amp;hq=&amp;hnear=Brooklyn,+Kings,+New+York&amp;ll=40.649974,-73.950005&amp;spn=0.01628,0.025663&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
</div></td>
                            </tr>
                           
                        </table>
                        
                        </td>
                    <td>&nbsp;</td>
                </tr>
                <?php if ( $this->contact->params->get( 'allow_vcard' ) ) : ?>
                <tr>
                    <td colspan="2"><?php echo JText::_( 'Download information as a' );?> <a href="<?php echo JURI::base(); ?>index.php?option=com_contact&amp;task=vcard&amp;contact_id=<?php echo $this->contact->id; ?>&amp;format=raw&amp;tmpl=component"> <?php echo JText::_( 'VCard' );?></a> </td>
                </tr>
                <?php endif;
if ( $this->contact->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id))
	echo $this->loadTemplate('form');
?>
            </table>
    </div>
</div>
