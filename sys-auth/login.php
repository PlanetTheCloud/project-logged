<?php

define('APP', dirname(__FILE__));
require APP.'/app/config.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?=$final['title']['login'];?> - <?=$final['company_name'];?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
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
                    <div class="msg"><?=$final['msg']['login'];?></div>
                    <form action="<?=$final['submit']['login'];?>" onsubmit="return submitHandler()" method="post">
                        <div class="input-group form-float">
                            <span class="input-group-addon">
                            <i class="material-icons">person</i>
                            </span>
                            <div class="form-line">
                                <input type="text" name="uname" class="form-control" placeholder="Username" id="lg-username">
                            </div>
                            <small class="col-pink i8bEK" id="warn_username">{{WARNING}}</small>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                            </span>
                            <div class="form-line">
                                <input type="password" name="passwd" class="form-control" placeholder="Password" id="lg-password">
                            </div>
                            <small class="col-pink i8bEK" id="warn_password">{{WARNING}}</small>
                        </div>
                        <div id="lang_select" class="form-group">
                        	<p>Language</p>
                        	<select class="form-control" data-live-search="true" size="1" name="language">
                                <option value="English" selected="selected">English</option>
                                <option>Afrikaans</option>
                                <option>Albanian</option>
                                <option>Amharic</option>
                                <option>Arabic</option>
                                <option>Armenian</option>
                                <option>Azeerbaijani</option>
                                <option>Basque</option>
                                <option>Belarusian</option>
                                <option>Bengali</option>
                                <option>Bosnian</option>
                                <option>Bulgarian</option>
                                <option>Burmese</option>
                                <option>Catalan</option>
                                <option>Cebuano</option>
                                <option>Chichewa</option>
                                <option>Chinese_simplified</option>
                                <option>Chinese_traditional</option>
                                <option>Corsican</option>
                                <option>Croatian</option>
                                <option>Czech</option>
                                <option>Danish</option>
                                <option>Dutch</option>
                                <option>English</option>
                                <option>Esperanto</option>
                                <option>Estonian</option>
                                <option>Farsi</option>
                                <option>Filipino</option>
                                <option>Finnish</option>
                                <option>French</option>
                                <option>Frisian</option>
                                <option>Galician</option>
                                <option>Georgian</option>
                                <option>German</option>
                                <option>Greek</option>
                                <option>Gujarati</option>
                                <option>Haitian Creole</option>
                                <option>Hausa</option>
                                <option>Hawaiian</option>
                                <option>Hebrew</option>
                                <option>Hindi</option>
                                <option>Hmong</option>
                                <option>Hungarian</option>
                                <option>Icelandic</option>
                                <option>Igbo</option>
                                <option>Indonesian</option>
                                <option>Irish</option>
                                <option>Italian</option>
                                <option>Japanese</option>
                                <option>Javanese</option>
                                <option>Kannada</option>
                                <option>Kazakh</option>
                                <option>Khmer</option>
                                <option>Korean</option>
                                <option>Kurdish</option>
                                <option>Kyrgyz</option>
                                <option>Lao</option>
                                <option>Latin</option>
                                <option>Latvian</option>
                                <option>Lithuanian</option>
                                <option>Luxembourgish</option>
                                <option>Macedonian</option>
                                <option>Malagasy</option>
                                <option>Malay</option>
                                <option>Malayalam</option>
                                <option>Maltese</option>
                                <option>Maori</option>
                                <option>Marathi</option>
                                <option>Mongolian</option>
                                <option>Nepali</option>
                                <option>Norwegian</option>
                                <option>Pashto</option>
                                <option>Persian</option>
                                <option>Polish</option>
                                <option>Portuguese</option>
                                <option>Punjabi</option>
                                <option>Romanian</option>
                                <option>Russian</option>
                                <option>Samoan</option>
                                <option>Scots Gaelic</option>
                                <option>Serbian</option>
                                <option>Sesotho</option>
                                <option>Shona</option>
                                <option>Sindhi</option>
                                <option>Sinhala</option>
                                <option>Slovak</option>
                                <option>Slovenian</option>
                                <option>Somali</option>
                                <option>Spanish</option>
                                <option>Sundanese</option>
                                <option>Swahili</option>
                                <option>Swedish</option>
                                <option>Tajik</option>
                                <option>Tamil</option>
                                <option>Telugu</option>
                                <option>Thai</option>
                                <option>Turkish</option>
                                <option>Ukrainian</option>
                                <option>Urdu</option>
                                <option>Uzbek</option>
                                <option>Vietnamese</option>
                                <option>Welsh</option>
                                <option>Xhosa</option>
                                <option>Yiddish</option>
                                <option>Yoruba</option>
                                <option>Zulu</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-block bg-<?=$final['color'];?> waves-effect"><?=$final['btn']['login'];?></button>
                            </div>
                        </div>
                        <div class="row m-t-15 m-b--20">
                            <div class="col-xs-6">
                                <a href="<?=$final['base'].'/signup.php';?>">Register Now!</a>
                            </div>
                            <div class="col-xs-6 align-right">
                                <a href="<?=$final['links']['reset_pwd'];?>">Forgot Password?</a>
                            </div>
                        </div>
                        <script src="/auth/assets/material.js"></script>
                        <script src="/auth/assets/login.js"></script>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>