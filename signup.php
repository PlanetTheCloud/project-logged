<?php

define('ROOT', realpath($_SERVER["DOCUMENT_ROOT"]));
define('APP', dirname(__FILE__).'/sys-auth');
require ROOT.'/sys-auth/app/config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
	session_start();
	require ROOT.'/sys-auth/app/csrf.class.php';
	$csrf = new Csrf;

	function kick(Bool $addMsg=false){
		if($addMsg){
			$_SESSION['gMsg'][] = [
				'type' => 'warning',
				'msg' => 'Something went wrong.. Please try again.'
			];
		}
		header("Location: {$final['base']}/signup.php");
		die;
	}

	$required = ['username','email','password','password_confirm','id','number','token'];
	foreach ($required as $key => $value) {
		if(!isset($_POST[$value])){
			kick(true);
		}
		if(!is_string($_POST[$value])){
			kick(true);
		}
		if(empty(trim($_POST[$value]))){
			kick(true);
		}
		if($_POST['password'] !== $_POST['password_confirm']){
			$_SESSION['gMsg'][] = [
				'type' => 'danger',
				'msg' => 'Password does not match!'
			];	
			kick();
		}
		$_POST[$value] = htmlspecialchars($_POST[$value]);
	}
	if(!$csrf->verifyToken('register', $_POST['token'])){
		kick(true);
	}
}else{
	header("Location: {$final['base']}/signup.php");
	die;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?=$final['title']['creating_account'];?> - <?=$final['company_name'];?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link href="/auth/assets/style.css" rel="stylesheet">
    </head>
    <body class="login-page">
        <div class="login-box">
            <a href="<?=$final['main_site'];?>">
                <p style="text-align:center">
                	<img src="<?=$final['logo'];?>" alt="<?=$final['company_name'];?> logo"/>
                </p>
            </a>
            <div class="card">
                <div class="body">
                    <div class="msg"><?=$final['msg']['creating_account'];?></div>
                    <form action="<?=$final['submit']['signup'];?>" method="post">
						<input type="hidden" name="username" value="<?=$_POST['username'];?>">
						<input type="hidden" name="email" value="<?=$_POST['email'];?>">
						<input type="hidden" name="password" value="<?=$_POST['password'];?>">
						<input type="hidden" name="password_confirm" value="<?=$_POST['password_confirm'];?>">
						<input type="hidden" name="id" value="<?=$_POST['id'];?>">
						<input type="hidden" name="number" value="<?=$_POST['number'];?>">
						<input type="hidden" name="submit" value="Register">
						<div>
							<button type="submit" class="btn btn-success waves-effect btn-block" id="signup">Click here if nothing happens</button>
						</div>
					</form>
					<script type="text/javascript">document.getElementById('signup').click();</script>
                </div>
            </div>
        </div>
    </body>
</html>