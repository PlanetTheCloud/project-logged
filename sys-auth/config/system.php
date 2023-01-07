<?php

return [
    'development_mode' => true, // WARNING: This will always reload the config changes and show all error
    'maintenance_mode' => false,
    'maintenance_key' => 'MAINTENANCE_KEY',
    'lockdown_mode' => false, // Disables all API functionality

    'language' => 'en',
    'use_https' => false,

    'features' => [
        'login' => [
            'language_selector' => true,
            'remember_me' => true,
        ]
    ],

    'cpanel_url' => 'rf.gd',
    'domain_selection' => [
        'a.com',
        'b.com'
    ], // List of domains available for selection
    'captcha_provider' => 'byet', // Some common captcha provider
];
