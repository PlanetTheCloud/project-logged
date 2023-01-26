<?php

# Prevent direct file access
if (!defined('APP')) {
    die(header("HTTP/1.1 403 Forbidden"));
}

class CsrfProtect
{

    /**
     * @var int $length Length of token
     */
    private $length = 32;

    /**
     * @var int $lifetime Token lifetime before expires
     */
    private $lifetime = 14400;

    /**
     * Construct the class
     * 
     * @return void
     */
    function __construct()
    {
        if (!isset($_SESSION['_tokens'])) {
            $_SESSION['_tokens'] = [
                '_key' => $this->newRandomToken(),
                '_any' => $this->newRandomToken()
            ];
        }
        $session['tokens'] = [
            'form_name' => [
                'token' => 'ACTUAL TOKEN',
                'expires' => 'EXPIRE'
            ]
        ];
    }

    /**
     * Creates a new token and bind to form
     * OR returns an existing token
     * 
     * @param string $form Form to bind the token to
     * 
     * @return string The token
     */
    public function token(string $form = null)
    {
        if (!$form) {
            return $_SESSION['_tokens']['_any'];
        }
        if ($form[0] == '_') {
            throw new CsrfProtectException('Form name cannot begin with an underscore (_)');
        }
        if (!isset($_SESSION['_tokens'][$form])) {
            $_SESSION['_tokens'][$form] = $this->newRandomToken();
        }
        return $_SESSION['_tokens'][$form];
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

    /**
     * Generates a new random token
     * 
     * @return string
     */
    private function newRandomToken()
    {
        return bin2hex(openssl_random_pseudo_bytes($this->length));
    }
}
