<?php

namespace app\vendor\http\validator;

use app\vendor\databases\QueryBuilder;

class UniqueValidator
{

    public static function isValidate($attribute, $parameters, $table, $oldAttr){
        $query = new QueryBuilder($table);
        $query->where($attribute, $parameters[$attribute]);
        if(isset($parameters[$oldAttr])){
            $query->not($oldAttr, $parameters[$oldAttr]);
        }
        return ! $query->exists();
    }

}