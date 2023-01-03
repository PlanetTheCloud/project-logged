<?php

return [
    'development_mode' => true, // WARNING: This will always reload the config changes and show all error
    'maintenance_mode' => true,
    'maintenance_key' => 'MAINTENANCE_KEY',

    'cpanel_url' => null, // null for auto
    'domain_selection' => [
        'a.com',
        'b.com'
    ], // List of domains available for selection
    'captcha_provider' => 'byet', // Some common captcha provider
];
