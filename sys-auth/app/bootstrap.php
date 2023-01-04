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

# Load classes
foreach (glob(SYSTEM . "/app/classes/*.php") as $class) {
    require $class;
}
unset($class);

# Load System config
define('SYSTEM_CONFIG', Arr::dot(require SYSTEM . '/config/system.php'));

# Custom Error Handler
function loggedErrorHandler($exception)
{
    if (SYSTEM_CONFIG['development_mode']) {
        echo "<b>DEVELOPMENT MODE ACTIVE</b><br><br>";
        echo "<b>Exception:</b> " . $exception->getMessage();
        echo "<br>File: " . $exception->getFile();
        echo "<br>Line: " . $exception->getLine();
        die;
    }
    require PAGES . '/error.php';
    die;
}
set_exception_handler('loggedErrorHandler');

# Prevents entry during maintenance
if (SYSTEM_CONFIG['maintenance_mode']) {
    if (!isset($_REQUEST[SYSTEM_CONFIG['maintenance_key']])) {
        require PAGES . '/maintenance.php';
        die;
    }
    echo '<!-- MAINTENANCE MODE IS ACTIVE! REMEMBER TO DISABLE IT -->' . PHP_EOL;
}

# Load configurations
if (SYSTEM_CONFIG['development_mode']) {
    // Always reparse the config
    require 'config_parser.php';
}
$config = json_decode(file_get_contents(SYSTEM . '/app/cache/config.json'), true);
if (!$config) {
    require 'config_parser.php';
    throw new Exception('Config is not initialized. If error persisted after refresh, config is malformated.');
}
define('CONFIG', Arr::dot($config));
define('CONFIG_RAW', $config);
unset($config);

/**
 * Config Function
 * 
 * @param string $key
 * @param mixed $default
 * 
 * @return mixed
 */
function config(string $key, $default = null)
{
    if (isset(CONFIG[$key])) {
        return CONFIG[$key];
    }
    $explode = explode('.', $key);
    foreach ($explode as $index => $item) {
        if ($index === 0) {
            $current = CONFIG_RAW;
        }
        $current = $current[$item] ?? null;
    }
    if ($current !== null) {
        return $current;
    }
    return $default;
}

# Load Language
define('DICTIONARY', json_decode(file_get_contents(SYSTEM . '/language/' . config('system.language') . '.lang.json'), true));
function __(string $key)
{
    // the most readable ones is __
    // Note debug messages will still be in English
    return DICTIONARY[$key] ?? $key;
}

# Start session
$toMerge = (SYSTEM_CONFIG['use_https']) ? ['cookie_secure' => true] : [];
session_start(array_merge([
    'cookie_httponly' => true,
    'use_trans_sid' => false,
    'gc_maxlifetime' => 7200
], $toMerge));
unset($toMerge);
