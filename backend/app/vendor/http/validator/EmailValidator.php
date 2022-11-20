<?php

namespace app\vendor\http\validator;

class EmailValidator
{

    public static function isValidate($attribute, $parameters){
        return filter_var($parameters[$attribute], FILTER_VALIDATE_EMAIL);
    }

}