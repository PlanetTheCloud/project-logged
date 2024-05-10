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
    public static function dot($array, $prepend = ''): array
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
     * Get a subset of the items from the given array.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     */
    public static function only(array $array, $keys): array
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    /**
     * Encode an array into a string
     * semicolon-separated, key:value pair.
     *
     * @param array $array
     * @return string
     */
    public static function encode(array $array): string
    {
        ksort($array);
        $result = '';
        foreach ($array as $key => $value) {
            $result .= $key . ":" . $value . ";";
        }
        return rtrim($result, ";");
    }
}
