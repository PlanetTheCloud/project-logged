<?php

return [
    'installation_url' => 'alpha-logged.pdn',

    'development_mode' => true, // WARNING: This will always reload the config changes and show all error
    'maintenance_mode' => false, // WARNING: This will disable all entry
    'maintenance_key' => 'MAINTENANCE_KEY',
    'lockdown_mode' => false, // Disables all state-changing operation

    'language' => 'en',
    'use_https' => false,

    'cpanel_url' => 'rf.gd',
    'domain_selection' => [
        // List of domains available for selection
        'domain_a.com',
        'domain_b.com',
        'rf.gd'
    ],
    'blacklisted_tld' => [
        'tk',
        'de'
    ],
    'default_plan' => 'Starter',

    'features' => [
        'login' => [
            'language_selector' => true,
            'remember_me' => true,
        ]
    ],
];
