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
     * For SELECT query
     * @var $selectQuery string
     */
    public $selectQuery;

    /**
     * Final query
     * @var string $query
     */
    public $query;

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
        $this->maxQuery = "MAX $value ";
    }

    private function makeSharedQuery(){
        $this->query .= $this->whereQuery ?? '';
        $this->query .= $this->andWhereQuery ?? '';
        $this->query .= $this->orWhereQuery ?? '';
        $this->query .= $this->maxQuery ?? '';
        $this->query .= $this->limitQuery ?? '';
        $this->query .= ';';
    }

    private function executeQyery(){
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

        $stmt = $this->executeQyery();
        if($stmt){
            return $stmt->fetchAll();
        }
        return [];
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


    public function insert($values){

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
            return $this->executeQyery();
        }
        return  false;
    }

}