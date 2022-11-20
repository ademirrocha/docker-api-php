<?php

namespace app\http\controllers;

use app\http\requests\users\CreateRequest;
use app\vendor\databases\DB;
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
        $pdo = DB::connect();
        $stmt = $pdo->query("SELECT * FROM teste ORDER BY id DESC");
        $user = $stmt->fetchAll();
        $pdo = DB::close();
        return Response::json($user);
    }

}