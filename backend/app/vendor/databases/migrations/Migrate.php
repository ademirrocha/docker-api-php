<?php

namespace app\vendor\databases\migrations;

use app\vendor\databases\DB;
use app\vendor\databases\QueryBuilder;
use app\vendor\databases\Table;
use PDOException;

class Migrate
{

    protected  $migrations;

    /**
     * @var db DB
     */
    protected DB $db;

    public function up(){

        $stmt = $this->db->pdo->query("SELECT * FROM migrations");
        if($stmt) {
            $this->migrations = $stmt->fetchAll();
        } else {
            $table = new Table('migrations', $this->db);
            $table->create([
                'id' => ['primaryKey'],
                'migrate' => ['string'],
                'version' => ['integer', 'size' => 4]
            ]);
            $this->migrations = $stmt->fetchAll();

        }
    }

    private function lastVersion(){
        $stmt = $this->db->pdo->query("SELECT version FROM migrations MAX version limit 1");
        if($stmt){
            return (object) $stmt->fetch();
        }
        return null;
    }

    private function exists($migration){
        return current(array_filter($this->migrations, function ($m) use ($migration) {
            $migrate = (object) $m;
            return $migrate->migrate == $migration;
        }));
    }

    public function execUp(){
        $this->db = new DB();
        self::up();
        $dir    = 'app/databases/migrations';
        $files = scandir($dir, 1);
        $lastVersion = self::lastVersion();
        $lastVersion =  $lastVersion ? $lastVersion->version : 0;
        foreach ($files as $file){
            try {
                if ($file != '.' && $file != '..') {
                    $className = explode('.php', $file)[0];
                    $class = "\app\databases\migrations\\$className" ;
                    $classDb = "/app/databases/migrations/$className";
                    if(!self::exists($classDb)){
                        echo "Executando $classDb \n";
                        call_user_func("$class::up");
                        $query = new QueryBuilder('migrations', $this->db);
                        $query->insert([
                            'migrate' => $classDb,
                            'version' => $lastVersion + 1
                        ]);
                    }
                }
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
        }
    }


}