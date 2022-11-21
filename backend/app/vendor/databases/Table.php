<?php

namespace app\vendor\databases;

class Table
{

    /**
     * @var $db DB
     */
    protected DB $db;

    protected string $tableName;

    public function __construct($tableName, $db = null)
    {
        $this->tableName = $tableName;
        if(is_null($db)){
            $this->db = new DB();
        } else {
            $this->db = $db;
        }
    }

    public function create($columns){

        $query = "CREATE TABLE `$this->tableName` ( \n";
        $primaryKey = null;
        $hasUniqueKey = false;
        $uniqueKeyQuery = '';

        $i=0;
        foreach ($columns as $key => $column){
            $query .= "`$key` ";
            foreach ($column as $attr){
                if($attr === 'primaryKey'){
                    $query .= self::primaryKey();
                    $primaryKey = $key;
                } else if($attr === 'uuid'){
                    $query .= self::primaryKeyUiid();
                    $primaryKey = $key;
                } else if($attr === 'string') {
                    $query .= self::string($column);
                    $query .= self::defaultValue($column);
                    $query .= self::nullable($column);
                } else if($attr === 'integer' || $attr === 'int'){
                    $query .= self::integer($column);
                    $query .= self::defaultValue($column);
                    $query .= self::nullable($column);
                } else if($attr === 'unique') {
                    $hasUniqueKey = true;
                    if($uniqueKeyQuery != ''){
                        $uniqueKeyQuery .= ",\n";
                    }
                    $uniqueKeyQuery .= "UNIQUE KEY `$key` (`$key`)";
                }
            }
            $i++;
            if(!$primaryKey && !$hasUniqueKey && $i < count($columns)){
                $query .= ",\n";
            } else {
                $query .= "\n";
            }
        }

        if($primaryKey){
            $query .= "PRIMARY KEY (`" . $primaryKey . "`)";
            $query .=  $hasUniqueKey ? ",\n" : "\n";
        }

        if($hasUniqueKey){
            $query .=  $uniqueKeyQuery . "\n";
        }

        $query .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;\n";
        var_dump($query);
        $stmt = $this->db->pdo->query($query);
        $stmt->execute();

        return $stmt;
    }

    public function dropIfExists(){
        $query = "DROP IF EXISTS TABLE `$this->tableName`;";
        var_dump($query);
        $stmt = $this->db->pdo->query($query);
        $stmt->execute();

    }


    private function primaryKey(){
        return 'bigint unsigned NOT NULL AUTO_INCREMENT ';
    }

    private function primaryKeyUiid(){
        return 'VARCHAR (64) NOT NULL UNIQUE ';
    }

    private function string($column){

        $varchar = 'VARCHAR ';
        if(isset($column['size'])){
            $varchar .= '(' . $column['size'] . ') ';
        } else {
            $varchar .= '(255) ';
        }
        return $varchar;
    }

    private function integer($column){

        $varchar = 'INT ';
        if(isset($column['size'])){
            $varchar .= '(' . $column['size'] . ') ';
        } else {
            $varchar .= '(11) ';
        }
        return $varchar;
    }

    private function defaultValue($column){
        if(isset($column['default'])){
            return 'DEFAULT ' . $column['default'];
        } else if(isset($column['nullable'])){
            return 'DEFAULT NULL ';
        }
        return ' ';
    }

    private function nullable($column){
        return isset($column['nullable']) ? ' ' : 'NOT NULL ';
    }

}