=== Simple Ajax Auth ===
Contributors: jake1981
Tags: admin, AJAX, AJAX login, login, multi-site, redirect, registration, sidebar, jquery, popup, dialog, login dialog, login popup, mobile
Requires at least: 4.1
Tested up to: 4.1.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple plugin for providing AJAX login/signup/forgot password popup with redirects.

== Description ==

Simple plugin for providing AJAX login/signup/forgot password popup with redirects.
Also provides a pre-defined widget for displaying links for login/signup/site admin/logout. Theme can customize templates and styles.

Code is partially based on http://fellowtuts.com/wordpress/wordpress-ajax-login-and-register-without-a-plugin/ and http://fellowtuts.com/wordpress/forgot-password-with-ajax-in-wordpress-login-and-register/

Settings provide abilities for customizing translations, and custom login/logout redirection settings.
    
== Installation ==

1. Install the plugin as usual
1. Go to Settings -> Simple Ajax Auth and customize translations and settings
1. Go to Appearance -> Widgets, add Simple Ajax Auth widget

== Frequently Asked Questions ==

= I want to use Advanced Text Widget and provide links =

You can use following php commands to provide links to plugin's actions manually:

* simple_ajax_auth_login_link()
* simple_ajax_auth_register_link()
* simple_ajax_auth_admin_link()
* simple_ajax_auth_logout_link()

These will only return content when needed, for example, simple_ajax_auth_logout_link()
won't return anything, if user is not logged in. Registration link won't show when user
has logged in and/or site's user registration has been disabled.

To display one of these, do the following:
echo simple_ajax_auth_login_link();

You may also use $before and $after, like this:
echo simple_ajax_auth_login_link('<li>', '</li>');

If user has not logged in this would output link in middle of <li> and </li> tags. If link
won't be returned, it's still empty, even when $before and $after are used.

== Screenshots ==

1. Login popup
2. Settings view

== Changelog ==

= 1.0 = 
* Initial version
