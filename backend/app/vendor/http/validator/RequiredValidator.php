<?php

namespace app\vendor\http\validator;

class RequiredValidator
{

    public static function isValidate($attribute, $parameters){
        return isset($parameters[$attribute]) && !empty($parameters[$attribute]);
    }

}