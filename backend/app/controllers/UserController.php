<?php

namespace app\controllers;

use app\vendor\http\Response;

class UserController
{

    public static function create(){
        return Response::json([
            'user' => [
                'id' => 1,
                'username' => 'Ademir Rocha Ferreira',
                'email' => 'tiademir.rocha93@gmail.com',
                'github' => 'https://github.com/ademirrocha'
            ]
        ], 201);
    }

}