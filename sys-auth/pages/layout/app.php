<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= __($pageInfo['title']) ?> | <?= config('branding.name') ?></title>
    <link rel="icon" href="<?= config('branding.favicon') ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="assets/style.css" rel="stylesheet">
    <link href="assets/colors.css" rel="stylesheet">
</head>

<body class="login-page pg_bg-<?= config('branding.background_color') ?>" <?= ($pageInfo['file'] === 'signup.php') ? ' style="max-width: 490px"' : '' ?>>
    <div class="login-box">
        <div class="logo">
            <?= (config('branding.logo_type') == 'text')
                ? '<a style="font-weight:800;" href="' . config('branding.main_website') . '">' . config('branding.name') . '</a>'
                : '<p style="text-align:center;"><img src="' . config('branding.logo') . '" alt="' . config('branding.name') . ' logo"/></p>' ?>
            <small><?= config('branding.slogan') ?></small>
        </div>
        <div class="card">
            <?php
                require $pageInfo['file'];
            ?>
        </div>
    </div>
    <script src="assets/material.js"></script>
</body>

</html>