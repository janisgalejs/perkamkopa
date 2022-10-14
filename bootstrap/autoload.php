<?php

/**
 * Load configuration files
 */
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';

/**
 * Set debug mode
 */
error_reporting(DEBUG_MODE);

/**
 * Load helper functions
 */
require_once  __DIR__ . '/helpers.php';

/**
 * Autoload files from /app/ directory
 */
spl_autoload_register(function($className)
{
    $file = dirname(__DIR__) . '\\app\\' . $className . '.php';
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);

    if (file_exists($file)) {
        include $file;
    }
});