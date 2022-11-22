<?php

namespace app\http\controllers;

use app\vendor\http\controllers\Controller;
use app\vendor\views\View;

class LoginController extends Controller
{

    public static function login(){
        View::call('login', self::request()->all());
    }

}