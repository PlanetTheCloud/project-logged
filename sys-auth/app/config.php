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
 * Please keep the comments as it might come in handy later down the road.
 */



/**
 * CONFIG FILE
 * File name : config.php
 * File path : {INSTALL_DIR}/app/config.php
 * - - - - - - - - - - - - - -- - - - - - -
 * You may edit the $config variable array.
 * Do not change the data type (e.g. String to Bool, String to Array, Array to String, etc.)
 * Read the comments for instruction! They're there for a reason!
 * Confused? Ask the community on the forum here : https://www.byet.net/index.php?/topic/2663-free-professional-custom-signup-and-login-template-project-logged/
 * Note : Official support has been dropped on 1st February 2019.
 *		  But the project will still continue on Privately due to lack of interest.
 */

$config = [

	# Domain-Level Install Path
	# From the URL path (Not folder path), where is the "app" folder located?
	# Do not include the "app" directory and trailing slash. Example : "/auth" OR "/path1/path2"
	'dl_install_path' => '/auth',

	# Enter your company name
	'company_name' => 'Planet Cloud Hosting',
	# Set to "true" if your site has a valid SSL certificate. Use "false" otherwise
	'use_https' => false,
	# Enter your Logo URL. Relative URL is possible
	'logo' => 'https://image.ibb.co/hj4W7G/logo.png',
	# Where to send abuse email?
	'abuse_email' => 'planet.devnetwork@gmail.com',
	# Where to send contact email? NOTE : THIS EMAIL MUST BE ACTIVELY MONITORED ACCORDING TO THE PRIVACY POLICY.
	'contact_email' => 'planet.devnetwork@gmail.com',
	# Main site URL with protocol
	'main_site' => 'http://planetcloudhosting.cf',

	# What colors to use for elements like Buttons?
	'site_theme_color' => 'blue',

	# You can define page titles here
	'titles' => [
		'login_page' => 'Login to your account',
		'signup_page' => 'Register an account',
		'terms_page' => 'Terms of Service',
		'privacy_page' => 'Privacy Policy',
		'creating_account_page' => 'Creating your account, Please wait...'
	],

	# You can define page message (Shown below logo) here
	'message' => [
		'login_page' => 'Login to your account',
		'signup_page' => 'Register an account',
		'terms_page' => 'Terms of Service',
		'privacy_page' => 'Privacy Policy',
		'creating_account_page' => 'Creating your account...'
	],

	# You can define text on buttons
	'buttons' => [
		'login_button' => 'SIGN IN',
		'register_button' => 'SIGN UP'
	],

	# This script assumes the cPanel is located on the same domain where this script is installed.
	# The cPanel URL must not include the "cpanel" subdomain. Example : "xyz.com"
    # IMPORTANT : THIS WILL ONLY APPLY TO THE LOGIN PAGE. 
    # SIGNUP MUST BE TO THE SAME DOMAIN WHERE THIS IS INSTALLED (Requirements by MOFH).
	# Please uncomment the line below to define the cPanel URL
	'login_cpanel_url' => 'planetcloudhosting.cf',
];

/**
 * STOP EDITING BELOW THIS LINE
 * - - - - - - - - - - - - - - - - - - - - 
 * Below are the codes that built the site.
 * Modify the code below at your own risk.
 * No support will be provided.
 */
if(!defined('APP') OR explode('/', $_SERVER['REQUEST_URI'])[1] === 'sys-auth'){
	die(header("HTTP/1.1 403 Forbidden"));
}
$x = [
	strtolower(preg_replace('/^www\./' , '' , $_SERVER['HTTP_HOST'])),
	md5(rand(6000, PHP_INT_MAX)),
];
$x[] = (isset($config['login_cpanel_url'])) ? "cpanel.{$config['login_cpanel_url']}" : "cpanel.{$x[0]}";
$x[] = "{$_SERVER['REQUEST_SCHEME']}://{$x[0]}";
$final = [
	'base' => $config['dl_install_path'],
	'company_name' => $config['company_name'],
	'main_site' => $config['main_site'],
	'current_site' => $x[0],
	'placeholders' => [
		'signup' => [
			'subdomain' => $x[0],
		]
	],
	'links' => [
		'reset_pwd' => "https://{$x[2]}/lostpassword.php",
		'privacy' => "{$config['dl_install_path']}/privacy.php",
		'terms' => "{$config['dl_install_path']}/terms.php",
	],
	'submit' => [
		'login' => "https://{$x[2]}/login.php",
		'signup' => ($config['use_https']) ? "https://securesignup.net/register2.php" : "http://order.{$x[0]}/register2.php"
	],
	'logo' => $config['logo'],
	'email' => [
		'contact' => $config['contact_email'],
		'abuse' => $config['abuse_email']
	],
	'title' => [
		'login' => $config['titles']['login_page'],
		'signup' => $config['titles']['signup_page'],
		'terms' => $config['titles']['terms_page'],
		'privacy' => $config['titles']['privacy_page'],
		'creating_account' => $config['titles']['creating_account_page']
	],
	'msg' => [
		'login' => $config['message']['login_page'],
		'signup' => $config['message']['signup_page'],
		'terms' => $config['message']['terms_page'],
		'privacy' => $config['message']['privacy_page'],
		'creating_account' => $config['message']['creating_account_page']
	],
	'btn' => [
		'login' => $config['buttons']['login_button'],
		'register' => $config['buttons']['register_button'],
	],
	'color' => $config['site_theme_color']
];
if(defined('LOGGED_LANGUAGE_PACK')){
	$lang = new Language;
	$lang->loadLangFromObj(LOGGED_LANGUAGE_PACK);
	$lang->mount('all');
}
