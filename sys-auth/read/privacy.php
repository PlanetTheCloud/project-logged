<?php

/**
 * Project LOGGED v1.8 Terms of Service
 * ---
 * No modifications is necessary in this file.
 */


# Initialize
define('THIS_DIR', dirname(__FILE__));
require THIS_DIR . '/../app/app.php';

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= config('page.titles.privacy') . ' - ' . config('company.name'); ?></title>

    <link rel="icon" href="<?= config('company.favicon'); ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="/auth/assets/style.css" rel="stylesheet">
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <?php
            if (config('company.logo_type') == 'text') {
                echo '<a href="' . config('company.main_domain') . '">' . config('company.name') . '</a>';
            } else {
                echo '<p style="text-align:center"><img src="' . config('company.logo') . '" alt="' . config('company.name') . ' logo"/></p>';
            }
            ?>
            <small><?= config('company.slogan'); ?></small>
        </div>
        <div class="card">
            <div class="body">
                <?php
                $file = file_get_contents(THIS_DIR . '/contents/privacy.txt');
                echo str_replace([
                    '{$c}',
                    '{$c_caps}',
                    '{$email_contact}',
                    '{$privacy_url}',
                    '{$terms_url}'
                ], [
                    config('company.name'),
                    strtoupper(config('company.name')),
                    config('company.contact_email'),
                    'http://' . config('sys.current_domain') . '/auth/read/privacy',
                    'http://' . config('sys.current_domain') . '/auth/read/tos'
                ], $file);
                ?>
                <div>
                    <a href="/auth/signup" class="btn btn-block bg-<?= config('sys.color_scheme'); ?> waves-effect">Create an account</a>
                </div>
            </div>
        </div>
    </div>
    <script src="/auth/assets/material.js"></script>
</body>