<?php defined('_JEXEC') or die; ?>
<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>

<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"> <?php echo $this->escape($this->params->get('page_title')); ?> </div>
<?php endif; ?>
<div class="article-text-indent">
    <div class="clear">
        <form action="<?php echo JRoute::_( 'index.php?option=com_user&task=requestreset' ); ?>" method="post" class="josForm form-validate">
            <dl class="contentpane">
                <dt> <?php echo JText::_('RESET_PASSWORD_REQUEST_DESCRIPTION'); ?> </dt>
                <dd>
                    <table style="width:auto">
                        <tr>
                            <td class="description"><label for="email" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_EMAIL_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_EMAIL_TIP_TEXT'); ?>"><?php echo JText::_('Email Address'); ?>:</label>
                            </td>
                            <td class="input-field"><input id="email" name="email" type="text" class="required validate-email" />
                            </td>
                            <td class="button-field"><button type="submit" class="validate png"><?php echo JText::_('Submit'); ?></button></td>
                        </tr>
                    </table>
                </dd>
            </dl>
            <?php echo JHTML::_( 'form.token' ); ?>
        </form>
    </div>
</div>
