<?php

/**
 * Bootstrap the application
 * ---
 * No modification is needed.
 * Read the documentation.
 */

# Prevent direct file access
if (strpos($_SERVER['REQUEST_URI'], 'sys-auth') !== false) {
    die(header('HTTP/1.1 403 Forbidden'));
}

# Definitions
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('SYSTEM', ROOT . '/sys-auth');
define('PAGES', SYSTEM . '/pages');
define('APP', SYSTEM . '/app');

# Custom Error Handler
function handleProblems($no, $str, $file, $line, $context) {
    var_dump($no, $str, $line, $file, $context);
}
set_error_handler('handleProblems');

throw new Exception('test');

# Load classes
foreach (glob(SYSTEM . "/app/classes/*.php") as $class) {
    require $class;
}
unset($class);

# Load System config
define('SYSTEM_CONFIG', Arr::dot(require SYSTEM . '/config/system.php'));

# Prevents entry during maintenance
if (SYSTEM_CONFIG['maintenance_mode']) {
    if (!isset($_REQUEST[SYSTEM_CONFIG['maintenance_key']])) {
        require PAGES . '/maintenance.php';
        die;
    }
    echo '<!-- MAINTENANCE MODE IS ACTIVE! REMEMBER TO DISABLE IT -->' . PHP_EOL;
}

# Load configurations
$config = (SYSTEM_CONFIG['development_mode'])
    ? define('CONFIG', Arr::dot(require SYSTEM . '/config/system.php'))
    : json_decode(file_get_contents(SYSTEM . '/app/cache/config.json'), true);
if (!$config) {
    require 'config_parser.php';
    throw new Exception('Something went wrong');
}

# Start session
session_start([
    'cookie_httponly' => true,
    //'cookie_secure' => true,
    'use_trans_sid' => false,
    'gc_maxlifetime' => 7200
]);

// Add session timeout


# Parse config
die('x');


# Setup config related functions

$cfg = Arr::dot($config);
$cfg['sys.domain_selection'] = $config['sys']['domain_selection'];

function config(String $key)
{
    global $cfg;

    if (isset($cfg[$key])) {
        return $cfg[$key];
    }
    return null;
}

function error($msg = false)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!$msg) {
        $_SESSION['errorMessage'] = 'Something went wrong.';
    } else {
        $_SESSION['errorMessage'] = $msg;
    }
    die(header("Location: /error"));
}
