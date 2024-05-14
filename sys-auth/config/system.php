<?php

/**
 * System Configuration
 * ---
 * Read the documentation for explainations.
 */

return [
    'installation_url' => '',

    'allow_external_request' => true,
    'stub_mode' => false, // Only accepts signup request and redirects back the rest

    'development_mode' => false,
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
