<?php

define('APP', dirname(__FILE__));
require APP.'/app/config.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?=$final['title']['signup'];?> - <?=$final['company_name'];?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link href="/auth/assets/style.css" rel="stylesheet">
    </head>
    <script type="text/javascript">const LOGGED_DOM = '<?=$final['placeholders']['signup']['subdomain'];?>';</script>
    <body class="login-page">
        <div class="login-box">
            <a href="<?=$final['main_site'];?>">
                <p style="text-align:center">
                	<img src="<?=$final['logo'];?>" alt="<?=$final['company_name'];?> logo"/>
                </p>
            </a>
            <div class="card">
                <div class="body">
                    <div class="msg"><?=$final['msg']['signup'];?></div>
                    <form action="<?=$final['submit']['signup'];?>" onsubmit="return submitHandler()" method="post">
                    	<div class="input-group">
						    <span class="input-group-addon">
						    <i class="material-icons">person</i>
						    </span>
						    <div class="form-line">
						    	<input type="text" name="username" class="form-control" placeholder="your-name.<?=$final['placeholders']['signup']['subdomain'];?>" onkeyup="domainInfo(this.value)" onblur="domainInfo(this.value, true)" id="lg-username" autocomplete="off">
						    </div>
						    <small class="col-blue i8bEK" id="sub_info">{{MESSAGE}}</small>
						    <small class="col-pink i8bEK" id="warn_username">{{WARNING}}</small>
						</div>
						<div class="input-group">
						    <span class="input-group-addon">
						    <i class="material-icons">email</i>
						    </span>
						    <div class="form-line">
						        <input type="email" name="email" class="form-control" placeholder="Email address" id="lg-email">
						    </div>
						    <small class="col-pink i8bEK" id="warn_email">{{WARNING}}</small>
						</div>
						<div class="input-group">
						    <span class="input-group-addon">
						    <i class="material-icons">lock</i>
						    </span>
						    <div class="form-line">
						        <input type="password" name="password" class="form-control" placeholder="Password" id="lg-password">
						    </div>
						    <small class="col-pink i8bEK" id="warn_password">{{WARNING}}</small>
						</div>
						<div class="input-group">
						    <span class="input-group-addon">
						    <i class="material-icons">lock</i>
						    </span>
						    <div class="form-line">
						        <input type="password" name="password_confirm" class="form-control" placeholder="Confirm password" id="lg-password-confirm">
						    </div>
						    <small class="col-pink i8bEK" id="warn_password_confirm">{{WARNING}}</small>
						</div>
						<div class="form-line">
						    <input type="hidden" name="id" value="<?=$x[1];?>">
						    <div>
						    	<img width="320px" height="90px" src="https://securesignup.net/image.php?id=<?=$x[1];?>">
						    </div>
						    <br/>
						    <div class="input-group">
						        <span class="input-group-addon">
						        <i class="material-icons">lock</i>
						        </span> 
						        <div class="form-line">
						        	<input type="text" class="form-control" name="number" placeholder="Captcha" id="lg-captcha">
						        </div>
						        <small class="col-pink i8bEK" id="warn_captcha">{{WARNING}}</small>
						    </div>
						</div>
						<p>By signing up, you accept and agree to our <a href="<?=$final['links']['terms'];?>">terms of service</a> and <a href="<?=$final['links']['privacy'];?>">privacy policies</a>.</p>
						<input type="hidden" name="submit" value="Register">
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-block bg-<?=$final['color'];?> waves-effect"><?=$final['btn']['register'];?></button>
                            </div>
                            <div class="m-t-25 m-b--5 align-center">
							    <a href="<?=$final['base'];?>/login.php">Registered User? Click here to Login!</a>
							</div>
                        </div>
                        <script src="/auth/assets/material.js"></script>
                        <script src="/auth/assets/signup.js"></script>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>