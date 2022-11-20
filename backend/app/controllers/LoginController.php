<?php

namespace app\controllers;

use app\views\View;

class LoginController extends BaseController
{

    public static function login(){
        new View('login', self::request()->all());
    }

}