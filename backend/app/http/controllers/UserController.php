<?php

namespace app\http\controllers;

use app\http\requests\users\CreateRequest;
use app\vendor\databases\DB;
use app\vendor\databases\QueryBuilder;
use app\vendor\http\Response;

class UserController extends BaseController
{

    public static function create(){
        $params = self::request()->all();
        $validate = self::validate(new CreateRequest($params));
        if($validate === true){
            return Response::json([
                'user' => [
                    'id' => 1,
                    'username' => $params->username,
                    'email' => $params->email,
                    'github' => $params->github,
                ]
            ], 201);
        }

        return $validate;
    }

    public static function index(){
        $query = new QueryBuilder('teste');
        $user = $query->where(['name' => 'TY', 'age' => 23])->orWhere(['name' => 'Oliver', 'age' => 25])->orWhere(['name' => 'Roberta', 'age' => 39])->get();
        $query = new QueryBuilder('teste');
        $all = $query->get();
        return Response::json(['filter' => $user, 'all' => $all]);
    }

}