<?php

require_once 'includes/config.php';

class Test
{
    use \Chatty\Traits\Auth;

    public function __construct()
    {
        die(print_r($this->getUserList(true)));
    }
}

new Test;