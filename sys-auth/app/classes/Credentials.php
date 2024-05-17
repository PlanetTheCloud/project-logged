<?php

# Prevent direct file access
if (!defined('APP')) {
    die(header("HTTP/1.1 403 Forbidden"));
}

/**
 * Credentials class
 * Created by PlanetCloud (https://www.byet.net/index.php?/profile/528767-planetcloud/)
 * ---
 * Made for Project LOGGED v2.5
 */
class Credentials
{
    /**
     * @var array
     */
    protected static $credentials = [];

    /**
     * Load all credentials
     * 
     * @return void
     */
    public static function initialize(): void
    {
        $network = require SYSTEM . '/config/network.php';
        foreach ($network['credentials'] as $credential) {
            self::$credentials[$credential['domain']] = $credential;
        }
    }

    /**
     * Get private key for a given domain
     * 
     * @param string $domain
     * 
     * @return string
     */
    public static function getPrivateKey(string $domain): ?string
    {
        if (!self::$credentials) {
            self::initialize();
        }
        return self::$credentials[$domain]['private_key'] ?? null;
    }

}