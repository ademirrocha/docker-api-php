<?php

namespace app\http\controllers;

use app\http\requests\users\CreateRequest;
use app\vendor\exceptions\ForbiddenException;
use app\vendor\http\Request;
use app\vendor\http\Response;
use app\vendor\http\validator\FormValidator;

class BaseController
{

    public static function request(){
        return new Request();
    }

    /**
     * @param $validate FormValidator
     * @return bool|int
     */
    public static function validate($validate){

        try {
            if(!$validate->authorize()) {
                throw new ForbiddenException();
            }
        }catch (ForbiddenException $e) {
            return Response::error(403, $e->getMessage());
        }

        $validator = $validate->validator();

        if(count($validator) > 0){
            return Response::json($validator, 422);
        }
        return true;
    }

}