<?php

/**
 * Autoload necessary application files
 */

require_once __DIR__ . '/bootstrap/autoload.php';


/**
 * Execute the controller, generate response, include view file based on
 * $page variable provided in the request
 */

$page = $_REQUEST['page'] ?? PAGE_HOME;

switch ($page) {
    case PAGE_HOME:
        $response = (new \Controllers\HomeController())->handle();
        include views_path($page);
        break;
    case PAGE_TEST:
        $response = (new \Controllers\TestController())->handle();
        include views_path($page);
        break;
    case PAGE_COMPLETE:
        $response = (new \Controllers\CompleteController())->handle();
        include views_path($page);
        break;
    default:
        include views_path('404');
        break;
}






