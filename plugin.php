<?php
/**
 * @package Simple_ajax_auth
 * @version 1.0
 */
/*
Plugin Name: Simple Ajax Auth
Plugin URI: http://rauta.co
Description: This plugin provides a simple ajax method for logging in/signup/forgot password.
Author: Oskari Rauta
Version: 1.0
Author URI: http://rauta.co
*/

if (class_exists('simple_ajax_auth')) {
    function simpleajaxauth_plugin_exists_notice() {
        echo '<div class="error"><p>One instance of simple ajax auth is already active. Please de-activate it before activating current version.</p></div>';

        deactivate_plugins( plugin_basename( __FILE__ ) );
    }

    add_action('admin_notices', 'simpleajaxauth_plugin_exists_notice');
} else {

	require_once( dirname( __FILE__) . '/inc/custom-ajax-auth.php');

	if ( !class_exists('BF_Admin_Page_Class')) {
		define('ADMINPAGECLASS_URL', plugins_url( '/admin-page-class', __FILE__));
		define('ADMINPAGECLASS_DIR', dirname( __FILE__) . '/admin-page-class');
  	require_once("admin-page-class/admin-page-class.php");
	}

	$config = array(    
  	'menu'           => 'settings',             //sub page to settings page
  	'page_title'     => __('Simple Ajax Auth','simpleajaxauth'),       //The name of this page 
  	'capability'     => 'edit_themes',         // The capability needed to view the page 
  	'option_group'   => 'simpleajaxauth',       //the name of the option to create in the database
  	'id'             => 'admin_page',            // meta box id, unique per page
  	'fields'         => array(),            // list of fields (can be added by field arrays)
  	'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
  	'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);

	$options_panel = new BF_Admin_Page_Class($config);
	$options_panel->OpenTabs_container('');
	
	$options_panel->TabsListing(array(
	  'links' => array(
	    'options_1' =>  __('Login redirection','simpleajaxauth'),
	    'options_2' =>  __('Logout redirection','simpleajaxauth'),
	    'options_3' =>  __('Translations','simpleajaxauth'),
		)
	));

	$options_panel->OpenTab('options_1');

	$options_panel->Title(__("Login redirection","simple_ajax_auth"));
	$options_panel->addRadio('login_redirect', array('current'=>'Current URL', 'home'=>'Home', 'url'=>'Custom URL'), array('name'=> __('Login redirects to:', 'simple_ajax_auth'), 'std'=> array('current'), 'desc' => ''));
	$options_panel->addText('login_url', array('name'=> __('Custom URL: ','simple_ajax_auth'), 'std'=> '', 'desc' => ''));
  
	$options_panel->CloseTab();

	$options_panel->OpenTab('options_2');

	$options_panel->Title(__("Logout redirection","simple_ajax_auth"));	
	$options_panel->addRadio('logout_redirect', array('current'=>'Current URL', 'home'=>'Home', 'default'=>'Default (Login page)', 'url'=>'Custom URL'), array('name'=> __('Logout redirects to:', 'simple_ajax_auth'), 'std'=> array('home'), 'desc' => ''));
	$options_panel->addText('logout_url', array('name'=> __('Custom URL: ', 'simple_ajax_auth'), 'std'=> '', 'desc' => ''));

	$options_panel->CloseTab();

	$options_panel->OpenTab('options_3');

	$options_panel->Title(__("Translations","simple_ajax_auth"));
	$options_panel->addText('login_text', array('name'=> __('Log in ','simple_ajax_auth'), 'std'=> 'Log in', 'desc' => __('Translation for "Log in"','simple_ajax_auth')));
	$options_panel->addText('register_text', array('name'=> __('Register ','simple_ajax_auth'), 'std'=> 'Register', 'desc' => __('Translation for "Register"','simple_ajax_auth')));
	$options_panel->addText('logout_text', array('name'=> __('Logout ','simple_ajax_auth'), 'std'=> 'Log out', 'desc' => __('Translation for "Log out"','simple_ajax_auth')));
	$options_panel->addText('admin_text', array('name'=> __('Site Admin ','simple_ajax_auth'), 'std'=> 'Site Admin', 'desc' => __('Translation for "Site Admin"','simple_ajax_auth')));
	$options_panel->addText('forgot_text', array('name'=> __('Forgot password? ','simple_ajax_auth'), 'std'=> 'Forgot password?', 'desc' => __('Translation for "Forgot password?"','simple_ajax_auth')));
	$options_panel->addText('username_text', array('name'=> __('Username: ','simple_ajax_auth'), 'std'=> 'Username:', 'desc' => __('Translation for "Username:"','simple_ajax_auth')));
	$options_panel->addText('password_text', array('name'=> __('Password: ','simple_ajax_auth'), 'std'=> 'Password:', 'desc' => __('Translation for "Password:"','simple_ajax_auth')));
	$options_panel->addText('confirm_password_text', array('name'=> __('Confirm password: ','simple_ajax_auth'), 'std'=> 'Confirm password:', 'desc' => __('Translation for "Confirm password:"','simple_ajax_auth')));
	$options_panel->addText('email_text', array('name'=> __('E-mail: ','simple_ajax_auth'), 'std'=> 'E-mail:', 'desc' => __('Translation for "E-mail:"','simple_ajax_auth')));
	$options_panel->addText('new_to_site_text', array('name'=> __('New to site? ','simple_ajax_auth'), 'std'=> 'Not registered yet?', 'desc' => __('Translation for "New to site?"','simple_ajax_auth')));
	$options_panel->addText('createaccount_text', array('name'=> __('Create an Account ','simple_ajax_auth'), 'std'=> 'Create an Account', 'desc' => __('Translation for "Create an Account"','simple_ajax_auth')));
	$options_panel->addText('already_registered_text', array('name'=> __('Already registered? ','simple_ajax_auth'), 'std'=> 'Already registered?', 'desc' => __('Translation for "Already registered?"','simple_ajax_auth')));
	$options_panel->addText('sending_text', array('name'=> __('Sending user info, please wait... ','simple_ajax_auth'), 'std'=> 'Sending user info, please wait...', 'desc' => __('Translation for "Sending user info, please wait..."','simple_ajax_auth')));
	$options_panel->addText('duplicate_userid_text', array('name'=> __('This username is already registered. ','simple_ajax_auth'), 'std'=> 'This username is already registered.', 'desc' => __('Translation for "This username is already registered."','simple_ajax_auth')));
	$options_panel->addText('duplicate_email_text', array('name'=> __('This email address is already registered. ','simple_ajax_auth'), 'std'=> 'This email address is already registered.', 'desc' => __('Translation for "This email address is already registered."','simple_ajax_auth')));
	$options_panel->addText('autherror_text', array('name'=> __('Wrong username or password. ','simple_ajax_auth'), 'std'=> 'Wrong username or password.', 'desc' => __('Translation for "Wrong username or password."','simple_ajax_auth')));
	$options_panel->addText('authok_text', array('name'=> __('Wrong username or password. ','simple_ajax_auth'), 'std'=> 'Wrong username or password.', 'desc' => __('Translation for "Wrong username or password."','simple_ajax_auth')));
	$options_panel->addText('registration_text', array('name'=> __('Registration ','simple_ajax_auth'), 'std'=> 'Registration', 'desc' => __('Translation for "Registration" as in "Registration succesfull, redirecting..."','simple_ajax_auth')));
	$options_panel->addText('loggedin_text', array('name'=> __('Login ','simple_ajax_auth'), 'std'=> 'Login', 'desc' => __('Translation for "Login" as in "Login succesfull, redirecting..."','simple_ajax_auth')));
	$options_panel->addText('success_text', array('name'=> __('succesfull, redirecting... ','simple_ajax_auth'), 'std'=> 'succesfull, redirecting...', 'desc' => __('Translation for "succesfull, redirecting..." as in "Login succesfull, redirecting..."','simple_ajax_auth')));
	$options_panel->addText('forgot_question_text', array('name'=> __('Username or E-mail:','simple_ajax_auth'), 'std'=> 'Username or E-mail:', 'desc' => __('Translation for "Username or E-mail:"','simple_ajax_auth')));
	$options_panel->addText('forgot_empty_text', array('name'=> __('Enter an username or e-mail address. ','simple_ajax_auth'), 'std'=> 'Enter an username or e-mail address.', 'desc' => __('Translation for "Enter an username or e-mail address."','simple_ajax_auth')));
	$options_panel->addText('forgot_wrong_mail_text', array('name'=> __('There is no user registered with that email address. ','simple_ajax_auth'), 'std'=> 'There is no user registered with that email address.', 'desc' => __('Translation for "There is no user registered with that email address."','simple_ajax_auth')));
	$options_panel->addText('forgot_wrong_userid_text', array('name'=> __('There is no user registered with that username. ','simple_ajax_auth'), 'std'=> 'There is no user registered with that username.', 'desc' => __('Translation for "There is no user registered with that username."','simple_ajax_auth')));
	$options_panel->addText('forgot_new_pass_subject', array('name'=> __('Your new password ','simple_ajax_auth'), 'std'=> 'Your new password', 'desc' => __('Translation for "Your new password" as in email subject.','simple_ajax_auth')));
	$options_panel->addText('forgot_new_pass_body', array('name'=> __('Your new password is: ','simple_ajax_auth'), 'std'=> 'Your new password is:', 'desc' => __('Translation for "Your new password is:"','simple_ajax_auth')));
	$options_panel->addText('forgot_new_pass_success', array('name'=> __('Check your email address for you new password. ','simple_ajax_auth'), 'std'=> 'Check your email address for you new password.', 'desc' => __('Translation for "Check your email address for you new password."','simple_ajax_auth')));
	$options_panel->addText('forgot_new_pass_err1', array('name'=> __('System is unable to send you mail containg your new password. ','simple_ajax_auth'), 'std'=> 'System is unable to send you mail containg your new password.', 'desc' => __('Translation for "System is unable to send you mail containg your new password."','simple_ajax_auth')));
	$options_panel->addText('forgot_new_pass_err2', array('name'=> __('Oops! Something went wrong while updaing your account. ','simple_ajax_auth'), 'std'=> 'Oops! Something went wrong while updaing your account.', 'desc' => __('Translation for "Oops! Something went wrong while updaing your account."','simple_ajax_auth')));
	$options_panel->addText('forgot_wrong_text', array('name'=> __('Invalid username or e-mail address. ','simple_ajax_auth'), 'std'=> 'Invalid username or e-mail address.', 'desc' => __('Translation for "Invalid username or e-mail address."','simple_ajax_auth')));
	$options_panel->addText('submit_text', array('name'=> __('Submit ','simple_ajax_auth'), 'std'=> 'Submit', 'desc' => __('Translation for "Submit"','simple_ajax_auth')));

	$options_panel->CloseTab();

	if ( !function_exists('isEmpty')) {
		function isEmpty( $str ) {
			return ( !isset($str) || trim($str) === '' ) ? true : false;
		}
	}

	if ( !function_exists('curPageURL')) {
		function curPageURL() {
			$pageURL = 'http' . ( $_SERVER["HTTPS"] == "on" ? 's://' : '://' ) . $_SERVER["SERVER_NAME"];
			$pageURL .= ( $_SERVER["SERVER_PORT"] != "80" ? ( ':' . $_SERVER["SERVER_PORT"] ) : '' );
			$pageURL .= $_SERVER["REQUEST_URI"];
			return $pageURL;
		}
	}

	function login_redirect_url() {
		$setup = get_option('simpleajaxauth');

		if ( $setup['login_redirect'] == 'current' ) {
			$redirect_url = curPageURL();
		} elseif ( $setup['login_redirect'] == 'login' ) {
			$redirect_url = '';
		} elseif (( $setup['login_redirect'] == 'url' ) && ( !isEmpty($setup['login_url']) )) {
			$redirect_url = $setup['login_url'];
		} else {
			$redirect_url = home_url();
		}
		
		return $redirect_url;
	}

	function logout_redirect_url() {
		$setup = get_option('simpleajaxauth');

		if ( $setup['logout_redirect'] == 'current' ) {
			$redirect_url = wp_logout_url(curPageURL());
		} elseif ( $setup['logout_redirect'] == 'default') {
			$redirect_url = wp_logout_url();
		} elseif (( $setup['logout_redirect'] == 'url' ) && ( !isEmpty($setup['logout_url']) )) {
			$redirect_url = wp_logout_url($setup['logout_url']);
		} else {
			$redirect_url = wp_logout_url(home_url());
		}
		
		return $redirect_url;
	}

	function simple_ajax_auth_login_link( $before = '', $after = '' ) {
		$setup = get_option('simpleajaxauth');
		return ( ! is_user_logged_in()) ? ( $before . '<a id="show_login">' . ( isEmpty($setup['login_text']) ? 'Log in' : $setup['login_text'] ) . '</a>' . $after ) : '';
	}

	function simple_ajax_auth_register_link( $before = '', $after = '' ) {
		$setup = get_option('simpleajaxauth');
		return ( ! is_user_logged_in() && get_option( 'users_can_register' )) ? ( $before . '<a id="show_register">' . ( isEmpty($setup['register_text']) ? 'Register' : $setup['login_text'] ) . $after ) : '';
	}

	function simple_ajax_auth_admin_link( $before = '', $after = '' ) {
		$setup = get_option('simpleajaxauth');
		return ( is_user_logged_in() && current_user_can( 'manage_options' )) ? ( $before . '<a id="show_admin" href="' . admin_url() . '">' . ( isEmpty($setup['admin_text']) ? 'Site Admin' : $setup['admin_text'] ) . '</a>' . $after ) : '';
	}

	function simple_ajax_auth_logout_link( $before = '', $after = '' ) {
		$setup = get_option('simpleajaxauth');
		return ( is_user_logged_in()) ? ( $before . '<a id="show_logout" href="' . logout_redirect_url() . '">' . ( isEmpty($setup['logout_text']) ? 'Log out' : $setup['logout_text'] ) . '</a>' . $after ) : '';
	}

	function simple_ajax_auth_css() {
		if ( $theme_template = locate_template( 'css/ajax-auth-style.css' )) {
			wp_register_style('ajax-auth-style', get_stylesheet_directory_uri() . '/css/ajax-auth-style.css');
		} else {
			wp_register_style('ajax-auth-style', plugins_url( '/css/ajax-auth-style.css', __FILE__));
		}
		wp_enqueue_style('ajax-auth-style');
	}

	function ajax_auth_init() {

		$setup = get_option('simpleajaxauth');
	
		wp_register_script('validate-script', plugins_url( '/js/jquery.validate.js', __FILE__), array('jquery') ); 
		wp_enqueue_script('validate-script');

    wp_register_script('ajax-auth-script', plugins_url( '/js/ajax-auth-script.js', __FILE__), array('jquery') ); 
    wp_enqueue_script('ajax-auth-script');

    wp_localize_script( 'ajax-auth-script', 'ajax_auth_object', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'redirecturl' => login_redirect_url(),
			'loadingmessage' => isEmpty( $setup['sending_text'] ) ? 'Sending user info, please wait...' : $setup['sending_text'],
		));

	}

	function load_simple_ajax_auth_template() {
		if ( $theme_template = locate_template( 'ajax-auth.php' )) {
			load_template( $theme_template );
		} else {
			load_template( dirname( __FILE__ ) . '/templates/ajax-auth.php' );
		}
	}

	function simple_ajax_auth_init() {
		// Execute the action only if the user isn't logged in
		if ( is_user_logged_in())
			return;
			
		// after_setup_theme
    add_action('wp_enqueue_scripts', 'simple_ajax_auth_css');
    add_action('wp_enqueue_scripts', 'ajax_auth_init');
    add_action('get_footer', 'load_simple_ajax_auth_template');
    		
    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
		// Enable the user with no privileges to run ajax_register() in AJAX
		add_action( 'wp_ajax_nopriv_ajaxregister', 'ajax_register' );
		// Enable the user with no privileges to run ajax_forgotPassword() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxforgotpassword', 'ajax_forgotPassword' );
	}

	add_action('init', 'simple_ajax_auth_init');

	class simple_ajax_auth extends WP_Widget {
	
		function simple_ajax_auth() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'simple_ajax_auth', 'description' => 'Simple Ajax Auth Widget.' );

			/* Widget control settings. */
			$control_ops = array( 'width' => 400, 'height' => 250, 'id_base' => 'simple_ajax_auth' );

			/* Create the widget. */
			$this->WP_Widget( 'simple_ajax_auth', "Simple Ajax Auth", $widget_ops, $control_ops );
		}

		function form($instance) {
		
			$title = ( isset($instance['title']) ) ? esc_attr( $instance['title'] ) : false;
			$title = apply_filters('widget_title', $title);
			$text = ( isset($instance['text']) ) ? $instance['text'] : false;
	    $suppress_title = (isset($instance['suppress_title'])) ? $instance['suppress_title'] : false;

			?>
			<label for="<?php echo $this->get_field_id('title'); ?>" title="Title above the widget">
				Title:
				<input style="width:400px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
			<br />
			<label for="<?php echo $this->get_field_id('suppress_title'); ?>"  title="Do not output widget title in the front-end">
				Suppress Title Output:
    		<input idx="<?php echo $this->get_field_name('suppress_title'); ?>" name="<?php echo $this->get_field_name('suppress_title'); ?>" type="checkbox" value="1" <?php checked($instance['suppress_title'],'1', true); ?> />
			</label>
			<?php
		}

		function update($new_instance, $old_instance) {
			$instance['title'] = strip_tags(stripslashes($new_instance['title']));
			$instance['text'] = $new_instance['text'];
			$instance['suppress_title'] = $new_instance['suppress_title'];

			return $instance;
		}

		function widget($args, $instance) {
			extract($args);

			if( isset($instance['suppress_title']) && false != $instance['suppress_title']) {
    		unset($instance['title']);
			}

			$title = ( isset($instance['title']) ) ? esc_attr( $instance['title'] ) : false;
			$title = apply_filters( 'simpleajaxauth_widget_title', $title );

			$text = '';
			$text .= simple_ajax_auth_login_link('<li>', '</li>');
			$text .= simple_ajax_auth_register_link('<li>', '</li>');
			$text .= simple_ajax_auth_admin_link('<li>', '</li>');
			$text .= simple_ajax_auth_logout_link('<li>', '</li>');
			
			if ( isEmpty($text))
				return;

			$text = apply_filters( 'simpleajaxauth_widget_content', $text, $instance );

			echo $before_widget;
			echo "<div class='simple_ajax_auth'>";
			$title ? print($before_title . $title . $after_title) : null;
			echo '<ul>' . $text . '</ul>';
			echo "</div>";
			echo $after_widget."\n";

		}
	
	} // End of class simple_ajax_auth
	
	function simple_ajax_auth_register_widget() {
		register_widget( 'simple_ajax_auth' );
	}
	
	add_action('widgets_init', 'simple_ajax_auth_register_widget');
	
} // End of if clause

?>