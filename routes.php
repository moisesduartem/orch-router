<?php

$router = new \Bootstrap\Router(BASE_URL);

$router->namespace('App\\Classes\\');

$router->get('test/{name}', [ 'className' => 'Test', 'method' => 'test1' ]);

$router->get('test2', [ 'className' => 'Test', 'method' => 'test2' ]);

$router->run();