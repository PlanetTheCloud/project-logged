<?php

/**
 * Project LOGGED v1.9 Multisite Configuration File
 * @author PlanetCloud (https://www.byet.net/index.php?/profile/528767-planetcloud/)
 * ---
 * PLEASE Read the documentation for more information.
 */

// Define a network here
return [
    'secret_key' => 'KEY',
    'members' => [
        [
            'domain' => 'DOM',
            'protocol' => 'https',
            'roles' => ['sender', 'receiver'],
            'allow_direct_signup' => false,
            'allow_direct_login' => false,
        ],
        [
            'domain' => 'hello.com',
            'protocol' => 'https',
            'roles' => ['sender', 'receiver'],
            'allow_direct_signup' => false,
            'allow_direct_login' => false,
        ],
        [
            'domain' => 'bello.com',
            'protocol' => 'https',
            'roles' => ['sender', 'receiver'],
            'allow_direct_signup' => false,
            'allow_direct_login' => false,
        ],
    ]
];