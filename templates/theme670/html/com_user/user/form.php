<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
<!--
	Window.onDomReady(function(){
		document.formvalidator.setHandler('passverify', function (value) { return ($('password').value == value); }	);
	});
// -->
</script>

<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="userform" autocomplete="off" class="form-validate">
    <?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
    <div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"> <?php echo $this->escape($this->params->get('page_title')); ?> </div>
    <?php endif; ?>
    <div class="article-text-indent">
        <div class="clear">
            <table cellpadding="5" cellspacing="0" border="0" width="100%">
                <tr>
                    <td style="width:34%; padding-bottom:5px;"><label for="username"> <?php echo JText::_( 'User Name' ); ?>: </label>
                    </td>
                    <td style="padding-left:6px;"><span><?php echo $this->user->get('username');?></span> </td>
                </tr>
                <tr>
                    <td style="padding-bottom:5px;"><label for="name"> <?php echo JText::_( 'Your Name' ); ?>: </label>
                    </td>
                    <td><input class="inputbox required" type="text" id="name" name="name" value="<?php echo $this->escape($this->user->get('name'));?>" size="40" style="margin:0px 0px 0px 6px;" />
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom:5px;"><label for="email"> <?php echo JText::_( 'email' ); ?>: </label>
                    </td>
                    <td><input class="inputbox required validate-email" type="text" id="email" name="email" value="<?php echo $this->escape($this->user->get('email'));?>" size="40" style="margin:0px 0px 0px 6px;" />
                    </td>
                </tr>
                <?php if($this->user->get('password')) : ?>
                <tr>
                    <td style=" padding-bottom:5px;"><label for="password"> <?php echo JText::_( 'Password' ); ?>: </label>
                    </td>
                    <td><input class="inputbox validate-password" type="password" id="password" name="password" value="" size="40" style="margin:0px 0px 0px 6px;" />
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom:5px;"><label for="password2"> <?php echo JText::_( 'Verify Password' ); ?>: </label>
                    </td>
                    <td><input class="inputbox validate-passverify png" type="password" id="password2" name="password2" size="40" style="margin:0px 0px 0px 6px;" />
                    </td>
                </tr>
                <?php endif; ?>
            </table><br  />
            <?php if(isset($this->params)) : echo $this->params->render( 'params' ); endif; ?>
            <button class="button validate png" type="submit" onclick="submitbutton( this.form ); return false;"><?php echo JText::_('Save'); ?></button>
            <input type="hidden" name="username" value="<?php echo $this->user->get('username');?>" />
            <input type="hidden" name="id" value="<?php echo $this->user->get('id');?>" />
            <input type="hidden" name="gid" value="<?php echo $this->user->get('gid');?>" />
            <input type="hidden" name="option" value="com_user" />
            <input type="hidden" name="task" value="save" />
            <?php echo JHTML::_( 'form.token' ); ?> </div>
    </div>
</form>
