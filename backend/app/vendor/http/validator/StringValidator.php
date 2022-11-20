<?php

namespace app\vendor\http\validator;

class StringValidator
{

    public static function isValidate($attribute, $parameters){
        return is_string($parameters[$attribute]);
    }

}