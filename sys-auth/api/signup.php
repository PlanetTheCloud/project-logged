<?php

// Javascript request will come to this file. CSRF MUST be verified before processing

require __DIR__ . '/../app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //header("Location: /auth/signup");
    echo __('Taking you to our signup page... If the page doesn\'t refresh automatically, <a href="/auth/signup">click here.</a>');
    die;
}

$required = ['username', 'email', 'password', 'password_confirm', 'id', 'number', 'token', 'action'];
