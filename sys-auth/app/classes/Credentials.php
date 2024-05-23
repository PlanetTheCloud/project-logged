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
     * Get private key for a given domain
     * 
     * @param string $domain
     * 
     * @throws CredentialErrorException
     * 
     * @return string
     */
    public static function getPrivateKey(string $domain): string
    {
        if (!self::$credentials) {
            self::initialize();
        }
        if (!isset(self::$credentials[$domain]['private_key'])) {
            throw new CredentialErrorException('No credentials found for the given domain');
        }
        return self::$credentials[$domain]['private_key'];
    }

    /**
     * Creates a signature
     * 
     * @param string $domain
     * @param mixed $data
     * 
     * @return string
     */
    public static function createSignature(string $domain, mixed $data): string
    {
        $key = self::getPrivateKey($domain);
        $data = (is_array($data)) ? Arr::encodeToString($data) : $data;
        return hash_hmac(self::$algo, base64_encode($data), $key);
    }

    public static function verifySignature(string $domain, mixed $data, string $givenSignature)
    {
        // TODO: Finish this
        // return hash_equals($known, $againts);
    }
}