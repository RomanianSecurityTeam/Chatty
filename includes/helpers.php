<?php

(new josegonzalez\Dotenv\Loader(dirname(__DIR__) . '/.env'))->parse()->toEnv();

function preg_get($pattern, $string, $position = 1) {
    preg_match($pattern, $string, $result);

    return $result[$position];
}

function env($key, $default = null) {
    return $_ENV[$key] ?: $default;
}

function randarr(array $arr) {
	return $arr[rand(0, count($arr) - 1)];
}