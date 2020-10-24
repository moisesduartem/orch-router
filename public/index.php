<?php

/**
 * Require the COMPOSER PSR-4 AUTOLOAD
 */
require __DIR__ . '/../vendor/autoload.php';

$env = parse_ini_file(__DIR__ . '/../.env');
foreach ($env as $key => $value) {
    define($key, $value);
}

require __DIR__ . '/../routes.php';