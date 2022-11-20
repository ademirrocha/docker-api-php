<?php

namespace app\http\controllers;

use app\vendor\databases\DB;
use app\vendor\http\Response;
use app\views\View;

class LoginController extends BaseController
{

    public static function login(){
        new View('login', self::request()->all());
    }

}