<?php

namespace app\vendor\databases;

use PDO;

class QueryBuilder
{

    /**
     * For table selected in query
     * @var $tableName string
     */
    protected string $tableName;

    /**
     * PRIMARY KEY Column
     * @var $primaryKey string
     */
    protected $primaryKey = 'id';

    /**
     * For SELECT query
     * @var $selectQuery string
     */
    protected $selectQuery;

    /**
     * Final query
     * @var string $query
     */
    protected $query;

    /**
     * For WHERE query
     * @var $whereQuery string
     */
    protected $whereQuery;

    /**
     * For WHERE ... OR query
     * @var $orWhereQuery string
     */
    protected $orWhereQuery;

    /**
     * For AND WHERE query
     * @var $andWhereQuery string
     */
    protected $andWhereQuery;

    /**
     * For max query result
     * @var $maxQuery string
     */
    protected $maxQuery;


    /**
     * For order query result
     * @var $orderByQuery string
     */
    protected $orderByQuery;

    /**
     * For limit result
     * @var $limitQuery integer
     */
    protected $limitQuery;

    /**
     * For table selected in query
     * @var $bindValues array
     */
    protected array $bindValues = [];

    /**
     * @var $db DB
     */
    protected DB $db;

    public function __construct($tableName, $db = null)
    {
        if(is_null($db)){
            $this->db = new DB();
        } else {
            $this->db = $db;
        }

        $this->tableName = $tableName;
        $this->whereQuery = null;
    }

    /**
     * @param array|null $values
     * @return void
     */
    public function select(array $values = null){
        if(is_null($values)){
            $this->selectQuery = '* ';
        } else {
            $this->selectQuery = ' ';
            foreach ($values as $key => $value){
                $this->selectQuery .= $value;
                if($key < count($values)){
                    $this->selectQuery .= ', ';
                } else {
                    $this->selectQuery .= ' ';
                }
            }
        }
    }

    /**
     * @param $field
     * @param  $value
     * @return $this
     */
    public function not( $field, $value = null): self
    {
        $this->whereQuery =  $this->whereQuery ?? 'WHERE ';
        if(is_array($field)){
            $this->whereQuery .= '( ';
            $i = 0;
            foreach ($field as $key => $item){
                $this->whereQuery .= $i > 0 ? 'AND ' : '';
                $this->not($key, $item);
                $i++;
            }
            $this->whereQuery .= ') ';
        }else{

            $fieldBind = $this->getFieldBind();
            $this->bindValues[] = [$fieldBind, $value];
            if(! strpos(substr($this->whereQuery, -3), '(')){
                $this->whereQuery .= 'AND ';
            }
            $this->whereQuery .= "`$field` != " . $fieldBind . ' ';
        }

        return $this;
    }

    /**
     * @param $field
     * @param  $value
     * @return $this
     */
    public function where( $field, $value = null): self
    {
        $this->whereQuery =  $this->whereQuery ?? 'WHERE ';
        if(is_array($field)){
            $this->whereQuery .= '( ';
            $i = 0;
            foreach ($field as $key => $item){
                $this->whereQuery .= $i > 0 ? 'AND ' : '';
                $this->where($key, $item);
                $i++;
            }
            $this->whereQuery .= ') ';
        }else{

            $fieldBind = $this->getFieldBind();
            $this->bindValues[] = [$fieldBind, $value];
            $this->whereQuery .= "`$field` = " . $fieldBind . ' ';
        }

        return $this;
    }

    /**
     * @param  $field
     * @param  $value
     * @return $this
     */
    public function orWhere( $field, $value = null): self
    {
        $this->orWhereQuery = $this->orWhereQuery ?? '';
        if(is_array($field)){

            $this->orWhereQuery .= 'OR ( ';
            $i = 0;
            foreach ($field as $key => $item){
                $this->orWhere($key, $item);
                $i++;
            }
            $this->orWhereQuery .= ') ';
        }else {
            $fieldBind = $this->getFieldBind();
            $this->bindValues[] = [$fieldBind, $value];
            if(! strpos(substr($this->orWhereQuery, -3), '(')){
                $this->orWhereQuery .= 'OR ';
            }
            $this->orWhereQuery .= "`$field` = " . $fieldBind . ' ';
        }

        return $this;
    }

    /**
     * @param  $field
     * @param  $value
     * @return $this
     */
    public function andWhere( $field,  $value = null): self
    {
        if(is_array($field)){

            $this->andWhereQuery .= 'AND ( ';
            $i = 0;
            foreach ($field as $key => $item){
                $this->andWhere($key, $item);
                $i++;
            }
            $this->andWhereQuery .= ') ';
        }else {
            $this->andWhereQuery = $this->andWhereQuery ?? ' ';
            $fieldBind = $this->getFieldBind();
            $this->bindValues[] = [$fieldBind, $value];
            $this->andWhereQuery .= 'AND ' . "`$field` = " . $fieldBind . ' ';
        }

        return $this;
    }

    /**
     * @param  $field
     * @param  $value
     * @return $this
     */
    public function andOrWhere( $field,  $value = null): self
    {
        if(is_array($field)){

            $this->andWhereQuery .= 'AND ( ';
            $i = 0;
            foreach ($field as $key => $item){
                $this->andOrWhere($key, $item);
                $i++;
            }
            $this->andWhereQuery .= ') ';
        }else {
            $this->andWhereQuery = $this->andWhereQuery ?? 'AND ';
            $fieldBind = $this->getFieldBind();
            $this->bindValues[] = [$fieldBind, $value];
            if(! strpos(substr($this->andWhereQuery, -3), '(')){
                $this->andWhereQuery .= 'OR ';
            }
            $this->andWhereQuery .= "`$field` = " . $fieldBind . ' ';
        }

        return $this;
    }

    private function getFieldBind(){
        return ':filter_' . count($this->bindValues);
    }

    /**
     * @param string $key
     * @return void
     */
    public function max(string $key){
        $this->maxQuery = "MAX $key ";
    }

    /**
     * @param int $value
     * @return void
     */
    public function limit(int $value){
        $this->maxQuery = "LIMIT $value ";
    }

    /**
     * @param string $field
     * @return void
     */
    public function orderBy(string $field){
        $this->orderByQuery = $this->orderByQuery ?? "ORDER BY ";
        $this->orderByQuery .= $field . ' ';
    }

    /**
     * @param string $field
     * @return void
     */
    public function orderByDesc(string $field){
        $this->orderByQuery = $this->orderByQuery ?? "ORDER BY ";
        $this->orderByQuery .= $field . ' DESC ';
    }

    private function makeSharedQuery(){
        $this->query .= $this->whereQuery ?? '';
        $this->query .= $this->andWhereQuery ?? '';
        $this->query .= $this->orWhereQuery ?? '';
        $this->query .= $this->orderByQuery ?? '';
        $this->query .= $this->maxQuery ?? '';
        $this->query .= $this->limitQuery ?? '';
        $this->query .= ';';
    }

    private function executeQuery(){
        $stmt = $this->db->pdo->prepare($this->query);
        foreach ($this->bindValues as  $value) {
            $stmt->bindValue($value[0], $value[1]);
        }

        $stmt->execute();
        return $stmt;
    }

    public function get(){
        $this->query = 'SELECT ';
        if(!$this->selectQuery){
            $this->select();
        }
        $this->query .= $this->selectQuery . 'FROM ' . $this->tableName . ' ';
        $this->makeSharedQuery();

        $stmt = $this->executeQuery();
        if($stmt){
            return $stmt->fetchAll();
        }
        return [];
    }

    public function last(){
        $this->orderByDesc($this->primaryKey);
        $this->limit(1);
        $data = $this->get();
        if(count($data) > 0){
            return current($data);
        }
        return null;
    }

    public function first(){
        $this->orderBy($this->primaryKey);
        $this->limit(1);
        $data = $this->get();
        if(count($data) > 0){
            return current($data);
        }
        return null;
    }

    public function exists(){
        $this->limit(1);
        $data = $this->get();
        if(count($data) > 0){
            return true;
        }
        return false;
    }

    public function sql(): string
    {
        if(!$this->query){
            $this->query = 'SELECT ';
            $this->select();
            $this->query .= $this->selectQuery . 'FROM ' . $this->tableName . ' ';
        }
        $this->makeSharedQuery();

        return $this->query;
    }


    public function insert($values, $lastCondition = null){

        if(count($values) > 0){
            $this->query = "INSERT INTO `$this->tableName` \n (";

            $i = 0;
            foreach ($values as $key => $value){
                $this->query .= "$key";
                $i++;
                if(count($values) == $i){
                    $this->query .= ")\n";
                } else {
                    $this->query .= ",\n";
                }
            }

            $this->query .= "VALUES(";
            $i = 0;
            foreach ($values as  $key => $value){
                $field = ':' . $key;
                $value = (string) $value;
                $this->bindValues[] = [$field, $value];
                $this->query .= $field;
                $i++;
                if(count($values) == $i){
                    $this->query .= ");\n";
                } else {
                    $this->query .= ",\n";
                }
            }
            $execute = $this->executeQuery();
            if($execute){
                $this->query = null;
                $this->bindValues = [];
                $this->select();
                if($lastCondition){
                    $this->where($lastCondition);
                }

                return $this->last();
            }
        }
        return  false;
    }

}