<?php

    include 'app-config.php';
    include 'app/vendor/debug/dd.php';

    // set autoload
    spl_autoload_register(function ($class) {
    require_once(str_replace('\\', '/', $class . '.php'));
    });