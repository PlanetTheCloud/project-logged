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
     * @throws CsrfProtectException
     * 
     * @return void
     */
    function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            throw new CsrfProtectException('Session not started yet');
        }
        if (!isset($_SESSION[$this->session_key])) {
            $this->regenerateKey();
        }
    }

    /**
     * Regenerate token key
     * 
     * @return void
     */
    public function regenerateKey()
    {
        $_SESSION[$this->session_key] = [
            '_key' => bin2hex(openssl_random_pseudo_bytes($this->key_length)),
        ];
    }

    /**
     * Calculate and return token for the given form
     * 
     * @param string $form Form to bind the token to
     * 
     * @throws CsrfProtectException
     * 
     * @return string The token
     */
    public function token(string $form = 'default')
    {
        if (trim($form[0]) == '_') {
            throw new CsrfProtectException('Form name cannot begin with an underscore');
        }
        return $this->calculateToken($form);
    }

    /**
     * Calculates the token
     * 
     * @param string $form
     * 
     * @return string
     */
    private function calculateToken(string $form = 'default')
    {
        return hash_hmac($this->algo, $form, $_SESSION[$this->session_key]['_key']);
    }

    /**
     * Validate given token
     * 
     * @param string $token
     * @param string $form
     * 
     * @throws CsrfProtectTokenMismatchException
     * 
     * @return bool
     */
    public function validate(string $token, string $form = 'default')
    {
        if (!hash_equals($this->calculateToken($form), $token)) {
            throw new CsrfProtectTokenMismatchException();
        }
    }
}
