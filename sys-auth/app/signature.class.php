<?php

# Check if file was accessed directly
if(!defined('APP')){
    die(header("HTTP/1.1 403 Forbidden"));
}

/**
 * Signature class
 * Created by PlanetCloud (https://www.byet.net/index.php?/profile/528767-planetcloud/)
 * ---
 * Made for Project LOGGED v1.8
 */
class Signature{

    /**
     * Create a signature
     *
     * @param String $algo
     * @param mixed $data
     * @param String $key
     * @return String
     */
    public static function create(String $algo, $data, String $key){
        if(is_array($data)){
            $data = Arr::encode($data);
        }
        return hash_hmac($algo, base64_encode($data), $key);
    }

    /**
     * Verify if the signature is correct
     *
     * @param String $known
     * @param String $againts
     * @return String
     */
    public static function verify(String $known, String $againts){
        return hash_equals($known, $againts);
    }

}