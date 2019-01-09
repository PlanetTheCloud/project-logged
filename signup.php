<?php

// DO NOT REMOVE THIS LINE!
include 'login-config.php';

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="<?=$global['cod_type'];?>">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>Register Your Account - <?=$global['title'];?></title>
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link href="style-login.css" rel="stylesheet">
</head>
<body class="login-page">
<div class="login-box">
<a href="<?=$global['protocol'];?><?=$global['domain'];?>">
<p style="text-align:center"><img src="<?=$global['logo'];?>" alt="<?=$global['title'];?>" align="center" /></p>
</a>
<div class="card">
<div class="body">
<div class="msg">Sign up for a free account</div>
<form id="updatedetails" name="updatedetails" class="signup" method="post" action="<?=$global['submit_def'];?>/register2.php">
<div class="input-group">
<span class="input-group-addon">
<i class="material-icons">person</i>
</span>
<div class="form-line">
<input class="form-control" type="text" name="username" value="" minlength="4" placeholder="your-name.<?=$global['domain'];?>" maxlength="16" onkeyup="return ismaxlength(this)" required>
</div>
</div>
<div class="input-group">
<span class="input-group-addon">
<i class="material-icons">lock</i>
</span>
<div class="form-line">
<input type="password" class="form-control" name="password" minlength="8" placeholder="Password" required>
</div>
</div>
<div class="input-group">
<span class="input-group-addon">
<i class="material-icons">email</i>
</span>
<div class="form-line">
<input type="email" class="form-control" name="email" placeholder="Email Address" size="30" value="" required>
</div>
</div>
    <div class="form-group">
				<tr><th>Site Category<td><select  class="form-control" size="1" name="website_category">
				<option>Personal</option>
				<option>Business</option>
				<option>Hobby</option>
				<option>Forum</option>
				<option>Adult</option>
				<option>Dating</option>
				<option>Software / Download</option>
				</select>
				</td></tr>
	</div>		
			<div class="form-group">
				<tr><th>Site Language<td>
				<select  class="form-control" size="1" name="website_language">
				<option>English</option>
				<option>Non-English</option>
				</select>
				</td></tr>
			</div>
           <span class="input-group-addon">
           <i class="material-icons">lock</i>
           </span>
            <div class="form-line">
				<input type="hidden" name="id" value="<?=$global['id'];?>">
				<tr><th><td><div ><img width="320px" height="90px" src="<?=$global['submit_def'];?>/image.php?id=<?=$global['id'];?>"></div><td>
				<tr><th>Enter Captcha<td><input class="form-control text-align: center;" type="text" name="number" size="30"><td>
                    </td>
                    </tr>
                    </td>
			</div><br>
<div class="form-group">
<input type="checkbox" name="terms_of_service" id="terms" class="filled-in chk-col-pink" required >
<label for="terms">I've read and agree to the <a href="terms.php">terms of service</a> and <a href="privacy.php">privacy policies</a>.</label>
</div>
<button class="btn btn-block btn-lg bg-<?=$global['color'];?> waves-effect">SIGN UP</button>
<div class="m-t-25 m-b--5 align-center">
<a href="login.php">Registered User? Click here to Login!</a>
</div>
</form>
</div>
</div>
</div>
<script src="material.js"></script>
</body>
</html>