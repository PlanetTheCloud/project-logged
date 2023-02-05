<?php

require __DIR__ . '/../app/bootstrap.php';

if (!config('system.development_mode', false)) {
    die('NO ACCESS');
}
$id = md5(rand(6000, PHP_INT_MAX));
echo '<img src="http://order.cafewebhost.co.uk/image.php?id=' . $id . '"><br>' . $id;
