<?php

namespace app\vendor\models;

use app\vendor\databases\QueryBuilder;

class Model extends QueryBuilder
{

    public function __construct($tableName, $db = null)
    {
        parent::__construct($tableName, $db);
    }

    public function create($values){
        return $this->insert($values);
    }

}