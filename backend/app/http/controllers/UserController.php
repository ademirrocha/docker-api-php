<?php

namespace app\http\controllers;

use app\http\requests\users\CreateRequest;
use app\vendor\http\Response;

class UserController extends BaseController
{

    public static function create(){
        $params = self::request()->all();

        $validate = new CreateRequest($params);
        $validator = $validate->validator();
        if(count($validator) > 0){
            return Response::json($validator, 422);
        }
        return Response::json([
            'user' => [
                'id' => 1,
                'username' => $params->username,
                'email' => $params->email,
                'github' => $params->github,
            ]
        ], 201);
    }

}