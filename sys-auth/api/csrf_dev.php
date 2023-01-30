<?php

require __DIR__ . '/../app/bootstrap.php';

if (!config('system.development_mode', false)) {
    die('NO ACCESS');
}

$csrf = new CsrfProtect();
$token = $csrf->token('signup');
echo $token;