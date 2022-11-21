<?php

namespace app\models\inmetro;

use app\vendor\models\Model;

class Pacs extends Model
{

    protected string $tableName = 'inmetr_pacs';

    public function __construct()
    {
        parent::__construct($this->tableName);
    }

}