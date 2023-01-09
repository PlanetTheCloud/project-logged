<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= __(Page::param('title')) ?> | <?= config('branding.name') ?></title>
    <link rel="icon" href="<?= config('branding.favicon') ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="assets/style.css" rel="stylesheet">
    <link href="assets/colors.css" rel="stylesheet">
    <style>
        .overlay {
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            position: fixed;
            background: #222;
        }

        .overlay__inner {
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            position: absolute;
        }

        .overlay__content {
            left: 50%;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .spinner {
            width: 75px;
            height: 75px;
            display: inline-block;
            border-width: 2px;
            border-color: rgba(255, 255, 255, 0.05);
            border-top-color: #fff;
            animation: spin 1s infinite linear;
            border-radius: 100%;
            border-style: solid;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="login-page pg_bg-<?= config('branding.background_color') ?>" <?= (Page::param('file', null, true) === 'signup.php') ? ' style="max-width: 490px"' : '' ?>>
    <div class="overlay">
        <div class="overlay__inner">
            <div class="overlay__content"><span class="spinner"></span></div>
        </div>
    </div>
    <div class="login-box">
        <div class="logo">
            <?= (config('branding.logo_type') == 'text')
                ? '<a style="font-weight:800;" href="' . config('branding.main_website') . '">' . config('branding.name') . '</a>'
                : '<p style="text-align:center;"><img src="' . config('branding.logo') . '" alt="' . config('branding.name') . ' logo"/></p>' ?>
            <small><?= config('branding.slogan') ?></small>
        </div>
        <div class="card">
            <?php
            require Page::param('file');
            ?>
        </div>
    </div>
    <script src="assets/material.js"></script>
    <?php
    $scripts = Page::getScripts();
    foreach ($scripts as $script) {
        echo '<script src="assets/' . $script . '"></script>' . PHP_EOL;
    }
    unset($scripts);
    ?>
    <script>
        <?php
        echo 'var translations = ' . json_encode(Page::getTranslations()) . ';' . PHP_EOL;
        ?>
    </script>
</body>

</html>