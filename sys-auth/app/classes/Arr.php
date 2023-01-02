<?php

# Prevent direct file access
if (!defined('APP')) {
    die(header("HTTP/1.1 403 Forbidden"));
}

/**
 * Arr Class (Modified)
 * @author tightenco (https://github.com/tightenco/collect)
 * @author PlanetCloud (https://www.byet.net/index.php?/profile/528767-planetcloud/)
 * ---
 * Modified by PlanetCloud to suit the needs of Project LOGGED v1.9
 */
class Arr
{
    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param  iterable  $array
     * @param  string  $prepend
     * @return array
     */
    public static function dot($array, $prepend = '')
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
    }
}
