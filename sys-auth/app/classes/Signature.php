<?php

# Prevent direct file access
if (!defined('APP')) {
    die(header("HTTP/1.1 403 Forbidden"));
}

/**
 * Signature class
 * Created by PlanetCloud (https://www.byet.net/index.php?/profile/528767-planetcloud/)
 * ---
 * Made for Project LOGGED v1.8
 */
class Signature
{

    /**
     * Create a signature
     *
     * @param mixed $data
     * @param string $key
     * @param string $algo
     * 
     * @return string
     */
    public static function create($data, string $key, string $algo = 'sha256'): string
    {
        if (is_array($data)) {
            $data = Arr::encode($data);
        }
        return hash_hmac($algo, base64_encode($data), $key);
    }

    /**
     * Verify if the signature is correct
     *
     * @param string $known
     * @param string $againts
     * 
     * @throws InvalidSignatureException
     * 
     * @return bool
     */
    public static function verify(string $known, string $againts): bool
    {
        if (empty(trim($known))) {
            throw new InvalidSignatureException();
        }
        return hash_equals($known, $againts);
    }
}
