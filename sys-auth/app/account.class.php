<?php

# Check if file was accessed directly
if (!defined('APP')) {
    die(header("HTTP/1.1 403 Forbidden"));
}

/**
 * Account class
 * Created by PlanetCloud (https://www.byet.net/index.php?/profile/528767-planetcloud/)
 * ---
 * Made for Project LOGGED v1.8
 */
class Account
{
    private static $target;
    private static $parameters;

    /**
     * Create a new account
     *
     * @param array $parameters
     * @return void
     */
    public static function create(array $parameters)
    {
        self::$target = config('sys.form_target.signup');
        self::$parameters = $parameters;
    }

    /**
     * Create a new external account
     *
     * @param string $domain
     * @param array $parameters
     * @param array $credentials
     * @return void
     */
    public static function createExternal(string $domain, array $parameters, array $credentials)
    {
        $parameters['signature'] = Signature::create(
            'sha256',
            base64_encode($credentials['identifier'] . $_POST['username'] . $_POST['email'] . $_POST['password'] . $_POST['id'] . $_POST['number']),
            $credentials['key']
        );
        $parameters['identifier'] = $credentials['identifier'];
        $parameters['password_confirm'] = $parameters['password'];

        self::$target = "{$credentials['protocol']}://{$domain}/signup.php";
        self::$parameters = $parameters;
    }

    /**
     * Get parameters
     *
     * @return array
     */
    public static function getParameters(): array
    {
        return self::$parameters;
    }

    /**
     * Get target URL
     *
     * @return string
     */
    public static function getTarget(): string
    {
        return self::$target;
    }
}
