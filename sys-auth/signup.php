<?php

/**
 * Project LOGGED v1.8 Signup Page
 * ---
 * No modifications is necessary in this file.
 */

define('THIS_DIR', dirname(__FILE__));
require THIS_DIR . '/app/app.php';

if (!config('sys.enable_signup_form')) {
    error('Signup has been disabled');
    die;
}

session_start();
require APP . '/csrf.class.php';
$csrf = new Csrf;
$csrf->createToken('registration');

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= config('page.titles.signup') . ' - ' . config('company.name'); ?></title>

    <link rel="icon" href="<?= config('company.favicon'); ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="assets/style.css" rel="stylesheet">
</head>

<body class="login-page" <?= (config('sys.enable_domain_selector')) ? 'style="max-width: 490px"' : '' ?>>
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
                <div class="msg"><?= config('page.messages.signup'); ?></div>
                <?php
                if (isset($_SESSION['gMsg'])) {
                    if ($_SESSION['gMsg'] && is_array($_SESSION['gMsg'])) {
                        foreach ($_SESSION['gMsg'] as $key => $value) {
                            echo "<div class=\"alert alert-{$value['type']}\">{$value['msg']}</div>" . PHP_EOL;
                        }
                        $_SESSION['gMsg'] = [];
                    }
                }
                ?>
                <form method="post" action="/signup.php" onsubmit="return handleSubmit();">
                    <?php
                    if (config('sys.enable_domain_selector')) {
                        include 'components/signup_with_selector.signup.tpl';
                    } else {
                        include 'components/signup_no_selector.signup.tpl';
                    }
                    ?>
                    <div class="input-group form-float">
                        <span class="input-group-addon">
                            <i class="material-icons">mail</i>
                        </span>
                        <div class="form-line">
                            <input id="input_email" type="email" name="email" class="form-control" placeholder="Email address">
                        </div>
                        <small class="col-pink hidden" id="warn_email">{{WARNING}}</small>
                    </div>
                    <div class="input-group form-float">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input id="input_password" type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="input-group-addon">
                            <label type="checkbox" onclick="showPassword()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </label>
                        </div>
                        <small class="col-pink hidden" id="warn_password">{{WARNING}}</small>
                    </div>
                    <div class="input-group form-float">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input id="input_confirm_password" type="password" name="password_confirm" class="form-control" placeholder="Confirm password">
                        </div>
                        <div class="input-group-addon">
                            <label type="checkbox" onclick="showConfirmPassword()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </label>
                        </div>
                        <small class="col-pink hidden" id="warn_confirm_password">{{WARNING}}</small>
                    </div>
                    <div class="form-line">
                        <input type="hidden" name="id" value="<?= config('sys.captcha_id'); ?>">
                        <div>
                            <img width="100%" src="https://ifastnet.com/image.php?id=<?= config('sys.captcha_id'); ?>">
                        </div>
                        <br />
                        <div class="input-group form-float">
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            <div class="form-line">
                                <input id="input_captcha" type="text" name="number" class="form-control" placeholder="Captcha" autocomplete="off">
                            </div>
                            <small class="col-pink hidden" id="warn_captcha">{{WARNING}}</small>
                        </div>
                    </div>
                    <p>By signing up, you accept and agree to our <a href="/auth/read/tos">terms of service</a> and <a href="/auth/read/privacy">privacy policies</a>.</p>
                    <input type="hidden" name="token" value="<?= $csrf->getToken('registration'); ?>">
                    <input type="hidden" name="action" value="register">
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="btn btn-block bg-<?= config('sys.color_scheme'); ?> waves-effect">REGISTER</button>
                        </div>
                        <div class="m-t-25 m-b--5 align-center">
                            <a href="/auth/login">Registered User? Click here to Login!</a>
                        </div>
                    </div>
                    <script type="text/javascript">
                        function showPassword() {
                            var x = document.getElementById("input_password");
                            if (x.type === "password") {
                                x.type = "text";
                            } else {
                                x.type = "password";
                            }
                        }
                    </script>
                    <script type="text/javascript">
                        function showConfirmPassword() {
                            var x = document.getElementById("input_confirm_password");
                            if (x.type === "password") {
                                x.type = "text";
                            } else {
                                x.type = "password";
                            }
                        }
                    </script>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/material.js"></script>
    <script src="assets/signup.js"></script>
</body>

</html>
