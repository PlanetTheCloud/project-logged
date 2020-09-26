<?php

/**
 * Project LOGGED v1.8 Login Page
 * ---
 * No modifications is necessary in this file.
 */

define('THIS_DIR', dirname(__FILE__));
require THIS_DIR.'/app/app.php';

if(!config('sys.enable_login_form')){
    error('Login has been disabled');
    die;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?=config('page.titles.login').' - '.config('company.name');?></title>

    <link rel="icon" href="<?=config('company.favicon');?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
        type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="assets/style.css" rel="stylesheet">
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <?php
                if(config('company.logo_type') == 'text'){
                    echo '<a href="'.config('company.main_domain').'">'.config('company.name').'</a>';
                }else{
                    echo '<p style="text-align:center"><img src="'.config('company.logo').'" alt="'.config('company.name').' logo"/></p>';
                }
            ?>
            <small><?=config('company.slogan');?></small>
        </div>
        <div class="card">
            <div class="body">
                <div class="msg"><?=config('page.messages.login');?></div>
                <form method="post" action="<?=config('sys.form_target.login');?>" onsubmit="return handleSubmit();">
                    <div class="input-group form-float">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input id="input_username" type="text" name="uname" class="form-control" placeholder="Username" required>
                        </div>
                        <small class="col-pink hidden" id="warn_username">{{WARNING}}</small>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input id="input_password" type="password" name="passwd" class="form-control" placeholder="Password" required>
                        </div>
                        <small class="col-pink hidden" id="warn_password">{{WARNING}}</small>
                    </div>
                    <?php
                        if(config('sys.feature.language_selector')){
                            include 'components/language_selector.login.tpl';
                        }
                    ?>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <?php
                                if(config('sys.feature.remember_username')){
                                    include 'components/remember_me.login.tpl';
                                }
                            ?>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-<?=config('sys.color_scheme');?> waves-effect">SIGN IN</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            <a href="signup">Register Now</a>
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="http://cpanel.<?=config('sys.cpanel_url');?>/lostpassword.php">Forgot Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/material.js"></script>
    <script src="assets/login.js"></script>
</body>

</html>
