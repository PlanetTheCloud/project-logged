<?php

# Prevent direct file access
if (!defined('APP')) {
    die(header("HTTP/1.1 403 Forbidden"));
}

/**
 * Account Class
 * for LOGGED v2.x
 * 
 * @author     PlanetTheCloud <github.com/PlanetTheCloud>
 */
class Account
{
    public static function create(array $param)
    {
        // Submit request to iFastNet and parse response
    }
}
