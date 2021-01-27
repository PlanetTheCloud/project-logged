<?php

/**
 * Project LOGGED v1.8 Signup System
 * ---
 * No modifications is necessary in this file.
 */


# Initialize
define('THIS_DIR', dirname(__FILE__));
require THIS_DIR . '/sys-auth/app/app.php';
if (@$_GET['submit'] !== 'Register') {
    header("Location: /auth/signup");
    die;
}
session_start();
require APP . '/signature.class.php';

/**
 * Reject user request and redirects back to signup page
 *
 * @param boolean|string $msg
 * @return void
 */
function reject($msg = false)
{
    if (!$msg) {
        $msg = 'Something went wrong. Please try again.';
    }
    if (config('sys.debug_mode')) {
        echo 'Project LOGGED: Debug Mode.<br>' . $msg;
        var_dump(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1));
        die;
    }
    $_SESSION['gMsg'][] = [
        'type' => 'danger',
        'msg' => $msg
    ];
    header("Location: /auth/signup");
    die;
}

# Validate inputs
$isExternalRequest = (isset($_GET['identifier']) or isset($_GET['signature']) or !isset($_GET['token']))
if ($isExternalRequest) {
    $required = ['username', 'email', 'password', 'password_confirm', 'id', 'number', 'signature', 'identifier'];
} elseif (config('sys.enable_domain_selector')) {
    $required = ['username', 'email', 'domain', 'password', 'password_confirm', 'id', 'number', 'token'];
} else {
    $required = ['username', 'email', 'password', 'password_confirm', 'id', 'number', 'token'];
}
(function () use ($required) {
    foreach ($required as $key => $value) {
        if (!isset($_GET[$value])) {
            return reject();
        }
        if (!is_string($_GET[$value])) {
            return reject();
        }
        if (empty(trim($_GET[$value]))) {
            return reject("{$value} cannot be empty!");
        }
        $_GET[$value] = htmlspecialchars($_GET[$value]);
    }
    if ($_GET['password'] !== $_GET['password_confirm']) {
        return reject('Confirm Password does not match!');
    }
})();

# CSRF Protection
if (!$isExternalRequest) {
    require APP . '/csrf.class.php';
    $csrf = new Csrf;
    if (!$csrf->verifyToken('registration', $_GET['token'])) {
        reject();
    }
}

# Handle Requests
require APP . '/account.class.php';
if ($isExternalRequest) {
    # External Request
    (function () {
        if (!config('sys.accept_request_from_other_logged')) {
            return reject();
        }

        $credentials = require APP . '/api.credentials.php';
        if (!isset($credentials[$_GET['identifier']])) {
            return reject();
        }

        $known = Signature::create(
            'sha256',
            base64_encode($_GET['identifier'] . $_GET['username'] . $_GET['email'] . $_GET['password'] . $_GET['id'] . $_GET['number']),
            $credentials[$_GET['identifier']]['key']
        );
        if (!Signature::verify($known, $_GET['signature'])) {
            return reject();
        }

        return Account::create([
            'username' => $_GET['username'],
            'email' => $_GET['email'],
            'password' => $_GET['password'],
            'id' => $_GET['id'],
            'number' => $_GET['number']
        ]);
    })();
} else {
    # Internal Request
    if (config('sys.enable_domain_selector')) {
        // With target domain
        (function () use ($cfg) {
            if (!isset($_GET['domain'])) {
                return reject();
            }
            if (config('sys.current_domain') === $_GET['domain']) {
                return Account::create([
                    'username' => $_GET['username'],
                    'email' => $_GET['email'],
                    'password' => $_GET['password'],
                    'id' => $_GET['id'],
                    'number' => $_GET['number']
                ]);
            }
            if (array_search($_GET['domain'], $cfg['sys.domain_selection']) === false) {
                return reject();
            }

            $credentials = require APP . '/target.credentials.php';
            if (!isset($credentials[$_GET['domain']])) {
                return reject();
            }

            return Account::createExternal($_GET['domain'], [
                'username' => $_GET['username'],
                'email' => $_GET['email'],
                'password' => $_GET['password'],
                'id' => $_GET['id'],
                'number' => $_GET['number']
            ], $credentials[$_GET['domain']]);
        })();
    } else {
        // Without target domain
        (function () {
            return Account::create([
                'username' => $_GET['username'],
                'email' => $_GET['email'],
                'password' => $_GET['password'],
                'id' => $_GET['id'],
                'number' => $_GET['number']
            ]);
        })();
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= config('page.titles.creating_account') . ' - ' . config('company.name'); ?></title>

    <link rel="icon" href="<?= config('company.favicon'); ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="/auth/assets/style.css" rel="stylesheet">
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <?php
            if (config('company.logo_type') == 'text') {
                echo '<a href="' . config('company.main_domain') . '">' . config('company.name') . '</a>';
            } else {
                echo '<p style="text-align:center"><img src="' . config('company.logo') . '" alt="' . config('company.name') . ' logo"/></p>';
            }
            ?>
            <small><?= config('company.slogan'); ?></small>
        </div>
        <div class="card">
            <div class="body">
                <?php
                require THIS_DIR . '/sys-auth/components/form.signup.tpl';
                ?>
            </div>
        </div>
    </div>
    <script src="/auth/assets/material.js"></script>
</body>

</html>
