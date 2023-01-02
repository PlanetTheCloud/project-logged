<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>TITLE AND COMPANY</title>

    <link rel="icon" href="FAVICON" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="assets/style.css" rel="stylesheet">
    <link href="assets/colors.css" rel="stylesheet">
</head>

<body class="login-page pg_bg-default" style="max-width: 490px">
    <div class="login-box">
        <div class="logo">
            LOGO
            <small>SLOGAN</small>
        </div>
        <div class="card">
            <div class="body">
                <div class="msg">SIGNUP MESSAGE</div>
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
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="input-group form-float" style="margin-bottom: 0px!important;">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <input id="input_username" type="text" name="username" class="form-control" placeholder="Enter a subdomain name" autocomplete="off">
                                </div>
                                <small class="col-pink hidden" id="warn_username">{{WARNING}}</small>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-line">
                                <select id="input_domain" name="domain" class="form-control">
                                    <option selected="selected">OPTION 1</option>
                                    <option selected="selected">OPTION 2</option>
                                </select>
                            </div>
                            <small class="col-pink hidden" id="warn_domain">{{WARNING}}</small>
                        </div>
                    </div>
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
                        <small class="col-pink hidden" id="warn_password">{{WARNING}}</small>
                        <div class="input-group-addon">
                            <button onclick="toggleVisibility('input_password')" style="padding-top:0px;padding-bottom:0px" type="button" class="btn btn-sm bg-blue waves-effect">
                                <i class="material-icons" id="input_password_icon">visibility</i>
                            </button>
                        </div>
                    </div>
                    <div class="input-group form-float">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input id="input_confirm_password" type="password" name="password_confirm" class="form-control" placeholder="Confirm password">
                        </div>
                        <small class="col-pink hidden" id="warn_confirm_password">{{WARNING}}</small>
                        <div class="input-group-addon">
                            <button onclick="toggleVisibility('input_confirm_password')" style="padding-top:0px;padding-bottom:0px" type="button" class="btn btn-sm bg-blue waves-effect">
                                <i class="material-icons" id="input_confirm_password_icon">visibility</i>
                            </button>
                        </div>
                    </div>
                    <div class="form-line">
                        <input type="hidden" name="id" value="CAPTCHA_ID">
                        <div>
                            <img width="100%" src="https://ifastnet.com/image.php?id=CAPTCHA_ID">
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
                    <input type="hidden" name="token" value="CSRF TOKEN">
                    <input type="hidden" name="action" value="register">
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="btn btn-block bg-blue waves-effect">REGISTER</button>
                        </div>
                        <div class="m-t-25 m-b--5 align-center">
                            <a href="/auth/login">Registered User? Click here to Login!</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function toggleVisibility(e) {
            let x = document.getElementById(e),
                y = document.getElementById(`${e}_icon`),
                show = (x.type === "password");
            (show) ? y.innerText = "visibility_off" : y.innerText = "visibility";
            (show) ? x.type = "text" : x.type = "password";
        }
    </script>
    <script src="assets/material.js"></script>
    <script src="assets/signup.js"></script>
</body>

</html>