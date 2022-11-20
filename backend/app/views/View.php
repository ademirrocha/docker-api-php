<?php

namespace app\views;

class View
{

    public function __construct($file, $params = null)
    {
        $view = include(__DIR__ . '/' . $file . '.php');
    }

}