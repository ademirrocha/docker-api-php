<?php

namespace app\models\inmetro;

use app\vendor\models\Model;

class Portarias extends Model
{

    protected string $tableName = 'inmetr_portarias';

    public function __construct()
    {
        parent::__construct($this->tableName);
    }

}