<?php

require __DIR__ . '/../app/bootstrap.php';

if (!config('system.development_mode', false)) {
    die('NO ACCESS');
}

$data = $_POST;

$account = HostingAccount::create($data);
die($account['raw']);