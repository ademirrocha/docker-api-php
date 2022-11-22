<?php

namespace app\http\controllers;

use app\http\requests\users\CreateRequest;
use app\models\user\User;
use app\vendor\http\controllers\Controller;
use app\vendor\http\Response;

class UserController extends Controller
{

    public static function create(){
        $params = self::request()->all();
        $validate = self::validate(new CreateRequest($params));
        if($validate === true){
            $user = new User();

            $user = $user->create([
                'name' => $params->name,
                'email' => $params->email,
                'github' => $params->github,
            ]);

            return Response::json([
                'user' => $user
            ], 201);
        }

        return $validate;
    }

    public static function index(){
        $query = new User();
        $user = $query->where(['name' => 'TY', 'age' => 23])->orWhere(['name' => 'Oliver', 'age' => 25])->orWhere(['name' => 'Roberta', 'age' => 39])->get();
        $query = new User();
        $all = $query->get();
        return Response::json(['filter' => $user, 'all' => $all]);
    }

}