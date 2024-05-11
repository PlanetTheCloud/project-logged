<?php

/**
 * Project LOGGED v2.0
 * Bootstrap File
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
$classes = glob(SYSTEM . "/app/classes/*.php");
foreach ($classes as $class) {
    require $class;
}
$exception_classes = glob(SYSTEM . "/app/classes/Exceptions/*.php");
foreach ($exception_classes as $class) {
    require $class;
}
unset($classes, $exception_classes);

# Load System config
define('SYSTEM_CONFIG', Arr::dot(require SYSTEM . '/config/system.php'));

# Response function for API requests
/**
 * Return JSON Error Response
 * 
 * @param string $message
 * @param array $data
 * @param bool $merge_data
 * 
 * @return never
 */
function apiErrorResponse(string $message = null, array $data = [], bool $merge_data = false): never
{
    if ($data !== [] && $merge_data) {
        $toMerge = ['details' => $data];
    } else if ($data !== [] && SYSTEM_CONFIG['development_mode']) {
        $toMerge = ['dev_details' => $data];
    }
    $message = (!empty($message)) ? $message : null;
    if (SYSTEM_CONFIG['development_mode']) {
        $toMerge['DEVELOPMENT_MODE'] = true;
    }
    echo json_encode(array_merge([
        'status' => 'error',
        'message' => $message ?? __('Something went wrong, please try again later.')
    ], $toMerge));
    die;
}

# Escalate warnings
/**
 * Handles and escalate error if necessary
 * 
 * @param int $severity
 * @param string $message
 * @param string $file
 * @param int $line
 * 
 * @return void
 */
function loggedErrorHandler(int $severity, string $message, string $file, int $line): void
{
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler("loggedErrorHandler");

# Custom Error Handler
/**
 * Handles exception and returns response based
 * on the request type.
 * 
 * @param Exception $exception
 * 
 * @return never
 */
function loggedExceptionHandler($exception): never
{
    if (IS_API_REQUEST) {
        apiErrorResponse(null, [
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
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
set_exception_handler('loggedExceptionHandler');

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
function config(string $key, $default = null): mixed
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
/**
 * Translate the given string into configured language
 * 
 * @param string $key
 * 
 * @return string
 */
function __(string $key): string
{
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

# Bootstrap Completed!
# Ready to handle request
