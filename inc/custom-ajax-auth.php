<?php

if ( !function_exists('isEmpty')) {
	function isEmpty( $str ) {
		return ( !isset($str) || trim($str) === '' ) ? true : false;
	}
}

function ajax_login() {
	$setup = get_option('simpleajaxauth');
	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'ajax-login-nonce', 'security' );

	// Nonce is checked, get the POST data and sign user on
	// Call auth_user_login
	auth_user_login($_POST['username'], $_POST['password'], ( isEmpty($setup['loggedin_text']) ? 'Login' : $setup['loggedin_text'] )); 
	
	die();
}

function ajax_register() {
	$setup = get_option('simpleajaxauth');

	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'ajax-register-nonce', 'security' );
		
	// Nonce is checked, get the POST data and sign user on
	$info = array();
	$info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']) ;
	$info['user_pass'] = sanitize_text_field($_POST['password']);
	$info['user_email'] = sanitize_email( $_POST['email']);
	
	// Register the user
	$user_register = wp_insert_user( $info );
	if ( is_wp_error($user_register) ) {
		$error  = $user_register->get_error_codes()	;
		
		if (in_array('empty_user_login', $error))
			echo json_encode(array('loggedin'=>false, 'message'=>__($user_register->get_error_message('empty_user_login'))));
		elseif (in_array('existing_user_login',$error))
			echo json_encode(array('loggedin'=>false, 'message'=>( isEmpty($setup['duplicate_userid_text']) ? 'This username is already registered.' : $setup['duplicate_userid_text'] )));
		elseif (in_array('existing_user_email',$error))
			echo json_encode(array('loggedin'=>false, 'message'=>( isEmpty($setup['duplicate_email_text']) ? 'This email address is already registered.' : $setup['duplicate_email_text'] )));
		}
   	else
	  	auth_user_login($info['nickname'], $info['user_pass'], ( isEmpty($setup['registration_text']) ? 'Registration' : $setup['registration_text'] ));       

    die();
}

function auth_user_login($user_login, $password, $login) {
	$setup = get_option('simpleajaxauth');

	$info = array();
	$info['user_login'] = $user_login;
	$info['user_password'] = $password;
	$info['remember'] = true;
	
	$user_signon = wp_signon( $info, false );
    
	if ( is_wp_error($user_signon) )
		echo json_encode(array('loggedin'=>false, 'message'=>( isEmpty($setup['autherror_text']) ? 'Wrong username or password.' : $setup['autherror_text'] )));
	else {
		wp_set_current_user($user_signon->ID); 
		echo json_encode(array('loggedin'=>true, 'message'=>__($login . ' ' . ( isEmpty($setup['success_text']) ? 'succesfull, redirecting...' : $setup['success_text'] ))));
	}
	
	die();
}

function ajax_forgotPassword() {

	$setup = get_option('simpleajaxauth');
	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'ajax-forgot-nonce', 'security' );
	
	global $wpdb;
	
	$account = $_POST['user_login'];
	
	if ( empty( $account ) )
		$error = ( isEmpty($setup['forgot_empty_text']) ? 'Enter an username or e-mail address.' : $setup['forgot_empty_text'] );
	else {
		if (is_email( $account )) {
			if ( email_exists($account) ) 
				$get_by = 'email';
			else	
				$error = ( isEmpty($setup['forgot_wrong_mail_text']) ? 'There is no user registered with that email address.' : $setup['forgot_wrong_mail_text'] );
		} else if (validate_username( $account )) {
			if ( username_exists($account) ) 
				$get_by = 'login';
			else
				$error = ( isEmpty($setup['forgot_wrong_userid_text']) ? 'There is no user registered with that username.' : $setup['forgot_wrong_userid_text'] );
		} else
				$error = ( isEmpty($setup['forgot_wrong_text']) ? 'Invalid username or e-mail address.' : $setup['forgot_wrong_text'] );
	}	
	
	if (empty ($error)) {
		// lets generate our new password
		//$random_password = wp_generate_password( 12, false );
		$random_password = wp_generate_password();

			
		// Get user data by field and data, fields are id, slug, email and login
		$user = get_user_by( $get_by, $account );
			
		$update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );
			
		// if  update user return true then lets send user an email containing the new password
		if( $update_user ) {
			
			$from = 'WRITE SENDER EMAIL ADDRESS HERE'; // Set whatever you want like mail@yourdomain.com
			
			if(!(isset($from) && is_email($from))) {		
				$sitename = strtolower( $_SERVER['SERVER_NAME'] );
				if ( substr( $sitename, 0, 4 ) == 'www.' ) {
					$sitename = substr( $sitename, 4 );					
				}
				$from = 'admin@'.$sitename; 
			}
			
			$to = $user->user_email;
			$subject = ( isEmpty($setup['forgot_new_pass_subject']) ? 'Your new password' : $setup['forgot_new_pass_subject'] );
			$sender = 'From: '.get_option('name').' <'.$from.'>' . "\r\n";
			
			$message = ( isEmpty($setup['forgot_new_pass_body']) ? 'Your new password is:' : $setup['forgot_new_pass_body'] ) . ' '  . $random_password;
				
			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers[] = "X-Mailer: PHP \r\n";
			$headers[] = $sender;
				
			$mail = wp_mail( $to, $subject, $message, $headers );
			if( $mail ) 
				$success = ( isEmpty($setup['forgot_new_pass_success']) ? 'Check your email address for you new password.' : $setup['forgot_new_pass_success'] );
			else
				$error = ( isEmpty($setup['forgot_new_pass_err1']) ? 'System is unable to send you mail containg your new password.' : $setup['forgot_new_pass_err1'] );
		} else
			$error = ( isEmpty($setup['forgot_new_pass_err2']) ? 'Oops! Something went wrong while updaing your account.' : $setup['forgot_new_pass_err2'] );
	}
	
	if ( ! empty( $error ) )
		//echo '<div class="error_login"><strong>ERROR:</strong> '. $error .'</div>';
		echo json_encode(array('loggedin'=>false, 'message'=>__($error)));
			
	if ( ! empty( $success ) )
		//echo '<div class="updated"> '. $success .'</div>';
		echo json_encode(array('loggedin'=>false, 'message'=>__($success)));

	die();
}
