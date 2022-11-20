<?php

namespace app\vendor\http\validator;

class UrlValidator
{

    public static function isValidate($attribute, $parameters){
        return filter_var($parameters[$attribute], FILTER_VALIDATE_URL);
    }

}