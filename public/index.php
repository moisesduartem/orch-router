<?php

/**
 * Require the COMPOSER PSR-4 AUTOLOAD
 */
require __DIR__ . '/../vendor/autoload.php';

$env = parse_ini_file(__DIR__ . '/../.env');
foreach ($env as $key => $value) {
    define($key, $value);
}

$router = new \Bootstrap\Router(BASE_URL);

$router->get('test/{name}', [ 'className' => 'Test', 'method' => 'test1' ]);

$router->get('test2', [ 'className' => 'Test', 'method' => 'test2' ]);

$router->run();