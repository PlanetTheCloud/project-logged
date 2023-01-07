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
define('IS_API_REQUEST', strpos($_SERVER['REQUEST_URI'], '/api/') !== false);


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
    if (IS_API_REQUEST) {
        if (SYSTEM_CONFIG['development_mode']) {
            echo json_encode([
                'status' => 'error',
                'DEVELOPMENT MODE' => true,
                'message' => get_class($exception) . ': ' . $exception->getMessage(),
                'data' => [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine()
                ]
            ]);
            die;
        }
        echo json_encode([
            'status' => 'error',
            'message' => 'Something went wrong, please try again later.'
        ]);
    } else {
        if (SYSTEM_CONFIG['development_mode']) {
            echo "<b>DEVELOPMENT MODE</b><br><br>";
            echo "<b>" . get_class($exception) . ":</b> " . $exception->getMessage();
            echo "<br>File: " . $exception->getFile();
            echo "<br>Line: " . $exception->getLine();
            die;
        }
        require PAGES . '/error.php';
    }
    die;
}
set_exception_handler('loggedErrorHandler');

# Prevents entry during maintenance
if (SYSTEM_CONFIG['maintenance_mode'] && !isset($_REQUEST[SYSTEM_CONFIG['maintenance_key']])) {
    if (IS_API_REQUEST) {
        echo json_encode([
            'status' => 'error',
            'message' => 'System is under maintenance. Please try again later'
        ]);
        die;
    } else {
        require PAGES . '/maintenance.php';
        die;
    }
}

# Block API requests during lockdown
if (SYSTEM_CONFIG['lockdown_mode'] && IS_API_REQUEST) {
    throw new Exception('System under lockdown mode');
    die;
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
    // Any lines that is not present in the language file
    // will be shown in English
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
