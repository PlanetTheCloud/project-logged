<?php

require __DIR__ . '/../app/bootstrap.php';

if (!config('system.development_mode', false)) {
    die('NO ACCESS');
}

die(json_encode(dns_get_record($_GET['domain'], DNS_NS)));