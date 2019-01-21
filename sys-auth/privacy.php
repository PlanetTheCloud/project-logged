<?php

define('APP', dirname(__FILE__));
require APP.'/app/config.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?=$final['title']['privacy'];?> - <?=$final['company_name'];?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link href="/auth/assets/style.css" rel="stylesheet">
    </head>
    <body class="login-page" style="max-width: 750px!important;">
        <div class="login-box">
            <a href="<?=$final['main_site'];?>">
                <p style="text-align:center">
                	<img src="<?=$final['logo'];?>" alt="<?=$final['company_name'];?> logo"/>
                </p>
            </a>
            <div class="card">
                <div class="body">
                    <div class="msg"><?="{$final['company_name']} {$final['msg']['privacy']}";?></div>

						<?php

	                    echo str_ireplace(['{$c}', '{$c_caps}', '{$email_contact}', '{$privacy_url}', '{$terms_url}'], [$final['company_name'], strtoupper($final['company_name']), $final['email']['contact'], "{$x[4]}{$final['links']['privacy']}", "{$x[4]}{$final['links']['terms']}"], file_get_contents(APP.'/app/content/privacy.content'));

	                    ?>

                    <script src="/auth/assets/material.js"></script>
                </div>
            </div>
        </div>
    </body>
</html>