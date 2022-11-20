<?php

namespace app\http\controllers;

use app\vendor\http\Request;

class BaseController
{

    public static function request(){
        return new Request();
    }

}