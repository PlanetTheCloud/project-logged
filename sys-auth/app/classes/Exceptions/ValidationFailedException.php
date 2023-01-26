<?php

# Prevent direct file access
if (!defined('APP')) {
    die(header("HTTP/1.1 403 Forbidden"));
}

class ValidationFailedException extends Exception
{
    protected $field;

    public function __construct($message, $field = null, $code = 0, Throwable $previous = null)
    {
        $this->field = $field;
        parent::__construct($message, $code, $previous);
    }

    public function getField()
    {
        return $this->field;
    }
}
