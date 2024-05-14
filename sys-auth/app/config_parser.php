<?php

namespace ConfigParser;

use InvalidConfigException;

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
unset($branding, $required);

# Handle System Config
$system = require SYSTEM . '/config/system.php';
$required = ['installation_url', 'development_mode', 'maintenance_mode', 'maintenance_key', 'lockdown_mode', 'language', 'use_https', 'cpanel_url', 'domain_selection', 'blacklisted_tld', 'default_plan', 'features'];
foreach ($required as $key) {
    if (!isset($system[$key])) {
        throw new InvalidConfigException("Missing '{$key}' field in 'system' config.");
    }
}
$config['system'] = $system;
unset($system, $required);

# Handle Network Config


# Add timestamp
$config['cached_on'] = time();

# Save to file
file_put_contents(SYSTEM . '/app/cache/config.json', json_encode($config));
