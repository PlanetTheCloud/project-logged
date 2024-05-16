<?php

namespace ConfigParser;

use Arr;
use InvalidConfigException;

function checkRequiredParameters(array $config, array $required, string $name)
{
    foreach ($required as $key) {
        if (!isset($config[$key])) {
            throw new InvalidConfigException("Missing '{$key}' field in '{$name}' config.");
        }
    }
}

$config = [];

# Handle Branding Config
$branding = require SYSTEM . '/config/branding.php';
$required = ['name', 'logo', 'slogan', 'main_website', 'favicon', 'accent_color', 'background_color', 'contact_email', 'report_abuse_email'];
checkRequiredParameters($branding, $required, 'branding');
$config['branding'] = $branding;
unset($branding, $required);

# Handle System Config
$system = require SYSTEM . '/config/system.php';
$required = ['installation_url', 'development_mode', 'maintenance_mode', 'maintenance_key', 'lockdown_mode', 'language', 'use_https', 'cpanel_url', 'domain_selection', 'blacklisted_tld', 'default_plan', 'features'];
checkRequiredParameters($system, $required, 'system');
if (!isset($system['stub_mode'])) {
    // To ensure compatibility with LOGGED v2.1 config
    $system['stub_mode'] = false;
}
$config['system'] = $system;
unset($system, $required);

# Handle Network Config
$network = require SYSTEM . '/config/network.php';
$required = ['main_auth', 'credentials'];
checkRequiredParameters($network, $required, 'network');
$config['network'] = Arr::only($network, ['main_auth']);
// Ensure all selectable domains have their matching credentials
$domains = [];
foreach ($network['credentials'] as $credential) {
    checkRequiredParameters($credential, ['protocol', 'domain', 'private_key'], 'network.credentials');
    $domains[] = $credential['domain'];
}
foreach ($config['system']['domain_selection'] as $domain) {
    if (!in_array($domain, $domains)) {
        throw new InvalidConfigException("Domain in selectable domains must have credentials attached");
    }
}
unset($network, $required, $domains);

# Add timestamp
$config['cached_on'] = time();

# Save to file
file_put_contents(SYSTEM . '/app/cache/config.json', json_encode($config));
