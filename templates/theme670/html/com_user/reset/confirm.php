<?php defined('_JEXEC') or die; ?>

<div class="componentheading"> <?php echo JText::_('Confirm your Account'); ?> </div>
<div class="article-text-indent">
    <div class="clear">
        <form action="<?php echo JRoute::_( 'index.php?option=com_user&task=confirmreset' ); ?>" method="post" class="josForm form-validate">
            <dl class="contentpane">
                <dt> <?php echo JText::_('RESET_PASSWORD_CONFIRM_DESCRIPTION'); ?> </dt>
                <dd>
                    <div class="description">
                        <label for="token" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_TOKEN_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_TOKEN_TIP_TEXT'); ?>"><?php echo JText::_('Token'); ?>:</label>
                    </div>
                    <div class="input-field">
                        <input id="token" name="token" type="text" class="required" />
                    </div>
                    <div class="button-field">
                        <button type="submit" class="validate"><?php echo JText::_('Submit'); ?></button>
                    </div>
                </dd>
            </dl>
            <?php echo JHTML::_( 'form.token' ); ?>
        </form>
    </div>
</div>
