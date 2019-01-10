<?php

/**
 * Project LOGGED v1.6 R (Release)
 * by PlanetCloud (https://www.byet.net/index.php?/profile/528767-planetcloud/)
 *
 * This is the Release version of 1.6. The previous version (1.6b)
 * had some invalid syntax and some copy-paste errors.
 * This version hopefully fixes all of it.
 */

/**
 * CONFIG FILE
 * File name : config.php
 * File path : {INSTALL_DIR}/app/config.php
 * - - - - - - - - - - - - - -- - - - - - -
 * You may edit the $config variable array.
 * Do not change the data type (e.g. String to Bool, String to Array, Array to String, etc.)
 * Read the comments for instruction! They're there for a reason!
 * Confused? Ask them on the forum here : https://www.byet.net/index.php?/topic/2663-free-professional-custom-signup-and-login-template-project-logged/
 */

$config = [

	# Domain-Level Install Path
	# From the URL path (Not folder path), where is the "app" folder located?
	# Do not include the "app" directory and trailing slash. Example : /auth OR "/path1/path2"
	'dl_install_path' => '/auth',

	# Enter your company name
	'company_name' => 'Your company name',
	# Set to "true" if your site has a valid SSL certificate. Use "false" otherwise
	'use_https' => false,
	# Enter your Logo URL. Relative URL is possible
	'logo' => 'https://image.ibb.co/hj4W7G/logo.png',
	# Where to send abuse email?
	'abuse_email' => 'abuse@email.com',
	# Where to send contact email?
	'contact_email' => 'contact@email.com',
	# Main site URL with protocol
	'main_site' => 'Main Site URL',

	# What colors to use for elements like Buttons?
	'site_theme_color' => 'blue',

	# You can define page titles here
	'titles' => [
		'login_page' => 'Login to your account',
		'signup_page' => 'Register an account'
	],

	# You can define page message (Shown below logo) here
	'message' => [
		'login_page' => 'Login to your account',
		'signup_page' => 'Register an account'
	],

	# This script assumes the cPanel is on the same domain where this script is installed.
	# The cPanel URL must not include the "cpanel" subdomain. Example : xyz.com
	# Please uncomment the line below to define the cPanel URL
	//'cpanel_url' => 'lightspace.cf',
];

/**
 * STOP EDITING BELOW THIS LINE
 * - - - - - - - - - - - - - - - - - - - - 
 * Below are the codes that built the site.
 * Modify the code below at your own risk.
 * No support will be provided.
 */
if(explode('/', $_SERVER['REQUEST_URI'])[1] === 'sys-auth'){
	die(header("HTTP/1.1 403 Forbidden"));
}
$x = [
	strtolower(preg_replace('/^www\./' , '' , $_SERVER['HTTP_HOST'])),
	md5(rand(6000, PHP_INT_MAX)),
];
$x[] = (isset($config['cpanel_url'])) ? "cpanel.{$config['cpanel_url']}" : "cpanel.{$x[0]}";
$x[] = (isset($config['cpanel_url'])) ? "order.{$config['cpanel_url']}" : "order.{$x[0]}";
$final = [
	'base' => $config['dl_install_path'],
	'company_name' => $config['company_name'],
	'main_site' => $config['main_site'],
	'current_site' => $x[0],
	'placeholders' => [
		'signup' => [
			'subdomain' => (isset($config['cpanel_url'])) ? $config['cpanel_url'] : $x[0],
		]
	],
	'links' => [
		'reset_pwd' => "https://{$x[2]}/lostpassword.php",
	],
	'submit' => [
		'login' => "https://{$x[2]}/login.php",
		'signup' => ($config['use_https']) ? "https://securesignup.net/register2.php" : "http://{$x[3]}/register2.php"
	],
	'logo' => $config['logo'],
	'email' => [
		'contact' => $config['contact_email'],
		'abuse' => $config['abuse_email']
	],
	'title' => [
		'login' => $config['titles']['login_page'],
		'signup' => $config['titles']['signup_page'],
	],
	'msg' => [
		'login' => $config['message']['login_page'],
		'signup' => $config['message']['signup_page'],
	],
	'color' => $config['site_theme_color']
];

?>