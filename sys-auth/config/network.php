<?php

/**
 * Network Configuration
 * ---
 * Read the documentation for explainations.
 */

return [
    'main_auth' => [
        'full_url' => 'http://hosting.com' // No trailing slash
    ],
    'signature_lifetime' => 120, // In seconds
    'credentials' => [
        // Please read the docs!
        [
            'protocol' => 'https://',
            'domain' => 'example.com',
            'private_key' => 'you_are_at_risk_of_attack_by_not_reading_the_docs!'
        ],
    ]
];