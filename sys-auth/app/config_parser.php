<?php

namespace ConfigParser;

use Arr;
use InvalidConfigException;

ini_set('xdebug.var_display_max_depth', 99);

/**
 * NOTE TO SELF: Should check if the sensitive config still use default values and lock the system
 */
$config = [];

# Handle Branding Config
$branding = require SYSTEM . '/config/branding.php';
$required = ['name', 'logo', 'slogan', 'main_website', 'favicon', 'accent_color', 'background_color', 'language', 'contact_email', 'report_abuse_email'];
foreach ($required as $key) {
    if (!isset($branding[$key])) {
        throw new InvalidConfigException("Missing '{$key}' field in 'branding' config.");
    }
}
$config['branding'] = $branding;
unset($branding, $required, $key);

# Handle Multisite Config
$multisite = require SYSTEM . '/config/multisite.php';
$required = ['secret_key', 'members'];
foreach ($required as $key) {
    if (!isset($multisite[$key])) {
        throw new InvalidConfigException("Missing '{$key}' field in 'multisite' config.");
    }
}

$required = ['domain', 'protocol', 'roles', 'allow_direct_signup', 'allow_direct_login'];
$domains = $index_id = [];
foreach ($multisite['members'] as $i => $member) {
    foreach ($required as $key) {
        if (!isset($multisite['members'][$i][$key])) {
            throw new InvalidConfigException("Missing '{$key}' field in 'multisite' member '{$i}' config.");
        }
    }
    $domains[] = $member['domain'];
    $md5_id = md5(json_encode($member));
    $multisite['members'][$i]['identifier'] = $md5_id;
    $index_id[$md5_id] = $multisite['members'][$i];
}
$config['multisite'] = array_merge($multisite, [
    'index_domains' => $domains,
    'members' => $index_id
]);
unset($multisite, $member, $key, $md5_id, $domains, $index_id);

# Handle System Config
$system = require SYSTEM . '/config/system.php';
$config['system'] = $system;
$config['cached_on'] = time();

# Save to file
file_put_contents(SYSTEM . '/app/cache/config.json', json_encode($config));