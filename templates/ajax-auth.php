<?php
	$setup = get_option('simpleajaxauth');

	if ( !function_exists('isEmpty')) {
		function isEmpty( $str ) {
			return ( !isset($str) || trim($str) === '' ) ? true : false;
		}
	}
?>

<form id="login" class="ajax-auth" action="login" method="post">
	<?php if ( get_option('users_can_register') ) : ?>
	<h3><?php echo ( isEmpty($setup['new_to_site_text']) ? 'New to site?' : $setup['new_to_site_text'] ); ?> <a id="pop_signup" href=""><?php echo ( isEmpty($setup['createaccount_text']) ? 'Create an Account' : $setup['createaccount_text'] ); ?></a></h3>
	<hr />
	<?php endif; ?>    
	<h1><?php echo ( isEmpty($setup['login_text']) ? 'Log in' : $setup['login_text'] ); ?></h1>
	<p class="status"></p>
	<?php wp_nonce_field('ajax-login-nonce', 'security'); ?>  
	<label for="username"><?php echo ( isEmpty($setup['username_text']) ? 'Username:' : $setup['username_text'] ); ?></label>
	<input id="username" type="text" class="required" name="username">
	<label for="password"><?php echo ( isEmpty($setup['password_text']) ? 'Password:' : $setup['password_text'] ); ?></label>
	<input id="password" type="password" class="required" name="password">
	<a id="pop_forgot" class="text-link" href="<?php echo wp_lostpassword_url(); ?>"><?php echo ( isEmpty($setup['forgot_text']) ? 'Forgot password?' : $setup['forgot_text'] ); ?></a>
  <input class="submit_button" type="submit" value="<?php echo ( isEmpty($setup['login_text']) ? 'Log in' : $setup['login_text'] ); ?>">
	<a class="close" href=""></a>    
</form>

<form id="register" class="ajax-auth"  action="register" method="post">
	<h3><?php echo ( isEmpty($setup['already_registered_text']) ? 'Already registered?' : $setup['already_registered_text'] ); ?> <a id="pop_login"  href=""><?php echo ( isEmpty($setup['login_text']) ? 'Log in' : $setup['login_text'] ); ?></a></h3>
	<hr />
	<h1><?php echo ( isEmpty($setup['register_text']) ? 'Register' : $setup['register_text'] ); ?></h1>
	<p class="status"></p>
	<?php wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>         
	<label for="signonname"><?php echo ( isEmpty($setup['username_text']) ? 'Username:' : $setup['username_text'] ); ?></label>
	<input id="signonname" type="text" name="signonname" class="required">
	<label for="email"><?php echo ( isEmpty($setup['email_text']) ? 'E-mail::' : $setup['email_text'] ); ?></label>
	<input id="email" type="text" class="required email" name="email">
	<label for="signonpassword"><?php echo ( isEmpty($setup['password_text']) ? 'Password:' : $setup['passwordd_text'] ); ?></label>
	<input id="signonpassword" type="password" class="required" name="signonpassword" >
	<label for="password2"><?php echo ( isEmpty($setup['confirm_password_text']) ? 'Confirm password:' : $setup['confirm_password_text'] ); ?></label>
	<input type="password" id="password2" class="required" name="password2">
	<input class="submit_button" type="submit" value="<?php echo ( isEmpty($setup['register_text']) ? 'Register' : $setup['register_text'] ); ?>">
	<a class="close" href=""></a>    
</form>

<form id="forgot_password" class="ajax-auth" action="forgot_password" method="post">    
	<h1><?php echo ( isEmpty($setup['forgot_text']) ? 'Forgot password?' : $setup['forgot_text'] ); ?></h1>
	<p class="status"></p>  
	<?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?>  
	<label for="user_login"><?php echo ( isEmpty($setup['forgot_question_text']) ? 'Username or E-mail:' : $setup['forgot_question_text'] ); ?></label>
	<input id="user_login" type="text" class="required" name="user_login">
	<input class="submit_button" type="submit" value="<?php echo ( isEmpty($setup['submit_text']) ? 'Submit' : $setup['submit_text'] ); ?>">
	<a class="close" href=""></a>    
</form>