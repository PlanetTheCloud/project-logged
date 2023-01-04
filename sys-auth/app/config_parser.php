<?php

namespace ConfigParser;

use InvalidConfigException;

/**
 * NOTE TO SELF: Should check if the sensitive config still use default values and lock the system
 */
$config = [];

# Handle Branding Config
$branding = require SYSTEM . '/config/branding.php';
$required = ['name', 'logo', 'slogan', 'main_website', 'favicon', 'accent_color', 'background_color', 'contact_email', 'report_abuse_email'];
foreach ($required as $key) {
    if (!isset($branding[$key])) {
        throw new InvalidConfigException("Missing '{$key}' field in 'branding' config.");
    }
}
$config['branding'] = $branding;
unset($branding, $required, $key);

# Handle System Config
$system = require SYSTEM . '/config/system.php';
$required = ['development_mode', 'maintenance_mode', 'maintenance_key', 'language', 'use_https', 'cpanel_url', 'domain_selection', 'captcha_provider'];
foreach ($required as $key) {
    if (!isset($system[$key])) {
        throw new InvalidConfigException("Missing '{$key}' field in 'system' config.");
    }
}
$config['system'] = $system;
$config['cached_on'] = time();

# Save to file
file_put_contents(SYSTEM . '/app/cache/config.json', json_encode($config));
