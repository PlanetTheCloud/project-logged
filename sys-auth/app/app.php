<?php

/**
 * Project LOGGED v1.8 Main Application File
 * by PlanetCloud (https://www.byet.net/index.php?/profile/528767-planetcloud/)
 * ---
 * This file should not be modified. 
 * Read the documentation for more information.
 */

define('APP', dirname(__FILE__));

# Require Arr class
require 'arr.class.php';

# Setup config related functions
require 'config.php';
$cfg = Arr::dot($config);
$cfg['sys.domain_selection'] = $config['sys']['domain_selection'];

function config(String $key)
{
    global $cfg;

    if (isset($cfg[$key])) {
        return $cfg[$key];
    }
    return null;
}

function error($msg = false)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!$msg) {
        $_SESSION['errorMessage'] = 'Something went wrong.';
    } else {
        $_SESSION['errorMessage'] = $msg;
    }
    die(header("Location: /error"));
}
