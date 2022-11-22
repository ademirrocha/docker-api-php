<?php

namespace app\vendor\models;

use app\vendor\databases\QueryBuilder;

class Model extends QueryBuilder
{

    /**
     * @var array
     */
    protected $withQueries = [];

    /**
     * @var Model
     */
    protected $modelUse;

    public function __construct($tableName, $db = null)
    {
        parent::__construct($tableName, $db);
    }

    /**
     * @var array
     */
    protected array $fillable = [];

    private function createProperty($model, $name, $value){
        $model->{$name} = $value;
        return $model;
    }

    private function setModel($model): Model
    {
        $newModel = new static($this->tableName);
        foreach ($this->fillable as $item){
            $newModel = $newModel->createProperty($newModel, $item, $model[$item] ?? null);
        }

        $this->modelUse = $newModel;

        foreach ($this->withQueries as $with){
            $newModel = $newModel->createProperty($newModel, $with, $this->withExec($with));
        }

        return $newModel;
    }


    public function get()
    {
        $models = [];
        foreach (parent::get() as $model){
            $models[] = $this->setModel($model);
        }
        return $models;
    }

    public function create($values){
        return $this->setModel((array) $this->insert($values));
    }

    public function with($function): Model
    {
        $this->withQueries[] = $function;
        return $this;
    }

    private function withExec($function){
        return call_user_func(static::class . "::$function", $this->modelUse);
    }

}