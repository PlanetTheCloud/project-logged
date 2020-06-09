<?php

# Check if file was accessed directly
if (!defined('APP')) {
    die(header("HTTP/1.1 403 Forbidden"));
}

/**
 * Arr Class (Modified)
 * Created by tightenco (https://github.com/tightenco/collect)
 * Modified by PlanetCloud (https://www.byet.net/index.php?/profile/528767-planetcloud/)
 * ---
 * Modified to suit the needs of Project LOGGED v1.8
 */
class Arr
{

    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param  array  $array
     * @param  string  $prepend
     * @return array
     */
    public static function dot(array $array, String $prepend = ''): array
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

    /**
     * Encode an array into a string
     * Comma-separated, key:value pair.
     *
     * @param Array $array
     * @return string
     */
    public static function encode(array $array): string
    {
        ksort($array);
        $result = '';
        foreach ($array as $key => $value) {
            $result .= $key . ":" . $value . ",";
        }
        return rtrim($result, ",");
    }
}
