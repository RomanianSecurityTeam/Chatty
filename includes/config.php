<?php

set_time_limit(0);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/includes.php';

(new josegonzalez\Dotenv\Loader(dirname(__DIR__) . '/.env'))->parse()->toEnv();

function env($key, $default = null) {
    return $_ENV[$key] ?: $default;
}