<?php // @version $Id: default.php 9830 2008-01-03 01:09:39Z eddieajau $
defined('_JEXEC') or die('Restricted access');
?>
<?php
$return = base64_encode(base64_decode($return).'#content');

if ($type == 'logout') : ?>

<form action="index.php" method="post" name="login" id="form-main1" class="log">
    <div class="logo-title">
        <?php if ($params->get('greeting')) : echo JText::sprintf('HINAME', $user->get('name')); endif; ?>
    </div>
    <div>
       <!-- <input type="submit" name="Submit" class="button png" value="<?php echo JText::_('BUTTON_LOGOUT'); ?>" />-->
        <a class="button png"  href="#" onClick="document.getElementById('form-main1').submit()"><?php echo JText::_('BUTTON_LOGOUT'); ?></a>
    </div>
    <input type="hidden" name="option" value="com_user" />
    <input type="hidden" name="task" value="logout" />
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
</form>
<?php else : ?>
<form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-main" class="form-login">
    <?php if ($params->get('pretext')) : ?>
    <p> <?php echo $params->get('pretext'); ?> </p>
    <?php endif; ?>
    <div class="left-side">
        <div class="username form-height">
           <input name="username" id="mod_login_username" type="text" class="inputbox"  value="username" onBlur="if(this.value=='') this.value='username'" onFocus="if(this.value =='username' ) this.value=''"/>
        </div>
        <div class="password  form-height">
            <input type="password" id="mod_login_password" name="passwd" class="inputbox"  alt="<?php echo JText::_('Password'); ?>" value="admin" onBlur="if(this.value=='') this.value='admin'" onFocus="if(this.value =='admin' ) this.value=''"/>
            <br />
        </div>
        <a class="button-login"  href="#" onClick="document.getElementById('form-main').submit()"><?php echo JText::_('LOGIN'); ?></a>
         <div id="inputs">
                        <input type="checkbox" name="remember" id="mod_login_remember" class="checkbox" value="yes" alt="<?php echo JText::_('Remember me'); ?>" />
                        <label for="mod_login_remember" class="remember"> <?php echo JText::_('Remember me'); ?> </label>
                </div>
             
        <!--<input type="submit" name="Submit" class="button-login" value="<?php echo JText::_('LOGIN'); ?>" />-->
      
    </div>
    
    <div id="form-login-remember"> <a href="<?php echo JRoute::_('index.php?option=com_user&view=reset#content'); ?>"> <?php echo JText::_('Forgot you password?'); ?></a>
      <a href="<?php echo JRoute::_('index.php?option=com_user&view=remind#content'); ?>"> <?php echo JText::_('Forgot your username? '); ?></a>
        <?php $usersConfig =& JComponentHelper::getParams('com_users');
	if ($usersConfig->get('allowUserRegistration')) : ?>
        <div class="form-indent-top">
        	  <!--<span class="login-text-1"><?php echo JText::_('Create an account'); ?></span>--> 
            <a class="reg" href="<?php echo JRoute::_('index.php?option=com_user&task=register#content'); ?>"> <?php echo JText::_('Create an account'); ?></a>
            
        </div>
        <?php endif; ?>
    </div>
    
    <?php 
	echo $params->get('posttext'); ?>
    <input type="hidden" name="option" value="com_user" />
    <input type="hidden" name="task" value="login" />
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php endif;
