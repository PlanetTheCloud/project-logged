<?php

# Prevent direct file access
if (!defined('APP')) {
    die(header("HTTP/1.1 403 Forbidden"));
}

class Page
{
    protected $parameters;

    public static function setParameters() 
    {

    }

    public static function addMessage()
    {

    } 

    public static function getParameters()
    {

    }

    public static function getMessage()
    {
        
    }
}