<?php

namespace app\models\user;

use app\vendor\models\Model;

class User extends Model
{

    protected string $tableName = 'users';

    public function __construct()
    {
        parent::__construct($this->tableName);
    }

    protected array $fillable = [
        'id',
        'name',
        'email',
        'github'
    ];

}