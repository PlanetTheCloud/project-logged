<?php

/**
 * System Configuration
 * ---
 * Read the documentation for explainations.
 */

return [
    'installation_url' => '',

    'stub_mode' => true,

    'development_mode' => true,
    'maintenance_mode' => false,
    'maintenance_key' => 'MAINTENANCE_KEY',
    'lockdown_mode' => false,

    'language' => 'en',
    'use_https' => false,

    'cpanel_url' => '',
    'domain_selection' => [
        'example.com'
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
        ],
        'signup' => [
            'use_own_domain' => false,
        ]
    ],
];
