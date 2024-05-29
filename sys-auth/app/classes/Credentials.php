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
     * @var string
     */
    protected static $algo = 'sha256';

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
     * Get details for a given domain
     * 
     * @param string $domain
     * 
     * @throws CredentialErrorException
     * 
     * @return array
     */
    public static function getDetails(string $domain): array
    {
        if (!self::$credentials) {
            self::initialize();
        }
        if (!isset(self::$credentials[$domain])) {
            throw new CredentialErrorException('No credentials found for the given domain');
        }
        return self::$credentials[$domain];
    }

    /**
     * Creates a signature
     * 
     * @param string $domain
     * @param mixed $data
     * 
     * @throws CredentialErrorException
     * 
     * @return string
     */
    public static function createSignature(string $domain, mixed $data): string
    {
        $key = self::getDetails($domain)['private_key'];
        $data = (is_array($data)) ? Arr::encodeToString($data) : $data;
        return hash_hmac(self::$algo, base64_encode($data), $key);
    }

    /**
     * Verify the given signature
     * 
     * @param string $domain
     * @param mixed $data
     * @param string $givenSignature
     * 
     * @throws CredentialErrorException
     * 
     * @return bool
     */
    public static function verifySignature(string $domain, mixed $data, string $givenSignature): bool
    {
        return hash_equals(self::createSignature($domain, $data), $givenSignature);
    }
}