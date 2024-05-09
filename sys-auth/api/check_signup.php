<?php

require __DIR__ . '/../app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /auth/signup");
    echo __('Taking you to our signup page... If the page doesn\'t refresh automatically,') . ' <a href="/auth/signup">' . __('click here.') . '</a>';
    die;
}

