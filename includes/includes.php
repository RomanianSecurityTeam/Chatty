<?php

function preg_get($pattern, $string, $position = 1) {
    preg_match($pattern, $string, $result);

    return $result[$position];
}