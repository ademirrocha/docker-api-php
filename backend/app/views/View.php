<?php

namespace app\views;

class View
{

    public function __construct($file)
    {
        include(__DIR__ . '/' . $file . '.php');
    }

}