<?php

/**
 * Project LOGGED v1.8 Error Page
 * ---
 * No modifications is necessary in this file.
 */

define('THIS_DIR', dirname(__FILE__));
require THIS_DIR . '/sys-auth/app/app.php';

session_start();
$message = (isset($_SESSION['errorMessage'])) ? $_SESSION['errorMessage'] : 'Something went wrong.';
$_SESSION['errorMessage'] = null;

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= config('page.titles.error') . ' - ' . config('company.name'); ?></title>

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
                <div class="msg">
                    <h2>Error!</h2>
                    <?php
                    echo $message;
                    if (config('sys.enable_login_form')) {
                        $color = config('sys.color_scheme');
                        echo "<br><br><a href=\"/auth/login\" class=\"btn btn-block bg-{$color} waves-effect\">Back to Login Page</a>";
                    } else {
                        echo "<br><br>Login has been disabled on this site.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/auth/assets/material.js"></script>
</body>

</html>