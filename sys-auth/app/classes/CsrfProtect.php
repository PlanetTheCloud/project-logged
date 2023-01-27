<?php

# Prevent direct file access
if (!defined('APP')) {
    die(header("HTTP/1.1 403 Forbidden"));
}

/**
 * CsrfProtect Class
 * ---
 * @author PlanetTheCloud (https://github.com/PlanetTheCloud)
 * @link https://stackoverflow.com/a/31683058
 */
class CsrfProtect
{

    /**
     * @var int $key_length
     */
    private $key_length = 32;

    /**
     * @var string $algo
     */
    private $algo = 'sha256';

    /**
     * @var string $session_key
     */
    private $session_key = '_csrf';

    /**
     * Construct the class
     * 
     * @return void
     */
    function __construct()
    {
        if (!isset($_SESSION[$this->session_key])) {
            $_SESSION[$this->session_key] = [
                '_key' => bin2hex(openssl_random_pseudo_bytes($this->key_length)),
            ];
        }
    }

    /**
     * Creates a new token and bind to form
     * OR returns an existing token
     * 
     * @param string $form Form to bind the token to
     * 
     * @return string The token
     */
    public function token(string $form = 'default')
    {
        if (trim($form[0]) == '_') {
            throw new CsrfProtectException('Form name cannot begin with an underscore (_)');
        }
        return hash_hmac($this->algo, $form, $_SESSION[$this->session_key]['_key']);
    }

    /**
     * Validate given token
     * 
     * @param string $token
     * @param string $form
     * 
     * @return bool
     */
    public function validate(string $token, string $form = null)
    {
        // if form is null then just match the token
        // else, must use hmac
    }


    public function invalidate(string $form = null)
    {
        // invalidates the token
    }
}
