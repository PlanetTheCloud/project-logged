<?php

/**
 * Project LOGGED v1.8 Configuration File
 * by PlanetCloud (https://www.byet.net/index.php?/profile/528767-planetcloud/)
 * ---
 * Read the documentation for more information.
 */

$config = [

    # System Settings
    'sys' => [

        # Site Settings
        'debug_mode' => false,
        'color_scheme' => 'pink',
        'cpanel_url' => 'rf.gd',

        # Form Settings
        'enable_login_form' => true,
        'enable_signup_form' => true,
        'enable_domain_selector' => true,
        'domain_selection' => [
            'hosting1.com',
            'hosting2.com'
        ],
        'accept_request_from_other_logged' => true,

        # Additional Features
        'feature' => [
            'remember_username' => true,
            'language_selector' => true,
        ]
    ],

    # Company Settings
    'company' => [
        'name' => 'Hosting Company',
        'logo' => '',
        'logo_type' => 'text',
        'slogan' => 'Host your websites for free',
        'main_domain' => 'http://hosting.com',
        'favicon' => '',
        'contact_email' => 'hello@hosting.com',
        'report_abuse_email' => 'abuse@hosting.com'
    ],

    # Page settings
    'page' => [

        # Page Titles
        'titles' => [
            'login' => 'Login to your account',
            'signup' => 'Register an account',
            'terms' => 'Terms of Service',
            'privacy' => 'Privacy Policy',
            'creating_account' => 'Creating your account, Please wait...',
            'error' => 'Something went wrong'
        ],

        # Page Messages
        'messages' => [
            'login' => 'Login to your account',
            'signup' => 'Register an account',
            'terms' => 'Terms of Service',
            'privacy' => 'Privacy Policy',
            'creating_account' => 'Creating your account...',
            'creating_account_error' => 'Something went wrong. Please try again later!'
        ]
    ]
];

/**
 * --- DANGER ZONE ---
 * Stop editting below this line.
 */

# Check if file was accessed directly.
if (!defined('APP') or explode('/', $_SERVER['REQUEST_URI'])[1] === 'sys-auth') {
    die(header("HTTP/1.1 403 Forbidden"));
}

# Additional modifications
$config['sys']['captcha_id'] = b4676b8992e5b59d6803bf99a5d58b4f;
$config['sys']['current_domain'] = strtolower(preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']));

if (!empty($config['sys']['cpanel_url'])) {
    $config['sys']['cpanel_url'] = "cpanel.{$config['sys']['cpanel_url']}";
} else {
    $config['sys']['cpanel_url'] = "cpanel.{$config['sys']['current_domain']}";
}

$config['sys']['form_target'] = [
    'login' => "https://{$config['sys']['cpanel_url']}/login.php",
    'signup' => "https://ifastnet.com/register2.php"
];
