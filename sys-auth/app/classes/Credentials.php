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
    protected static $credentials = [];

    public static function getPrivateKey() {

    }

}