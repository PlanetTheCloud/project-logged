<?php

$global = array(
    
'id' => md5(rand(6000, PHP_INT_MAX)), // Captcha Randomizer
    
'protocol' => 'https://', // Specify your website protocol here. Is it secured with SSL? if yes use "https://" if no, use "http://"
    
'domain' => strtolower(preg_replace('/^www\./' , '' , $_SERVER['HTTP_HOST'])), // Automatic Domain Recognition
    
'domain_def' => 'planetcloudhosting.cf', // In case the Automatic Domain Recognition failed, use this.
    
'title' => 'Planet Cloud Hosting', // Site title
    
'logo' => 'http://planetcloudhosting.cf/images/logo.png', // Logo URL
    
'email' => 'planetcloudhosting@gwhat.com', // Where to send abuse email?
    
'cod_type' => 'UTF-8', // Encoding Type
    
'color' => 'blue', // Change button color. Available color : pink , blue , green , red , purple , yellow , black , white (NOT RECOMENDED) , grey.
    
'submit_def' => 'https://securesignup.net',
    
);
?>