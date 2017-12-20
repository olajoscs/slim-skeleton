<?php

$displayErrors = true;
$reportLevel   = E_ALL;

// Including my helper function collection
require ROOT . '/src/bootstrap/helper.php';

// Including Composer autoload to have Dotenv
require ROOT . '/vendor/autoload.php';

// Reading .env file
$dotenv = new \Dotenv\Dotenv(ROOT);
$dotenv->load();

// Creating config based on .env file
$config = require ROOT . '/src/config/config.php';

// Changing most important php.ini values
if (evaluate($config['error']['display']) !== true) {
    $displayErrors = false;
    $reportLevel   = 0;
}

// Setting most important php.ini values
ini_set('display_errors', $displayErrors);
ini_set('error_reporting', $reportLevel);
ini_set('display_startup_errors', $displayErrors);

// Creating the Slim app
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => $displayErrors
    ]
]);

// Including dependencies
require ROOT . '/src/bootstrap/dependencies.php';

// Including the routes
require ROOT . '/src/bootstrap/routes.php';

// Fire
$app->run();
