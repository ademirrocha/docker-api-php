<?php

namespace app\vendor\databases;

use PDO;
use PDOException;

class DB
{

    /**
     * @var $pdo PDO
     */
    public $pdo;

    public function __construct()
    {
        $this->connect();
    }

    public function connect(){
        //Criar as constantes com as credencias de acesso ao banco de dados

        //Criar a conexão com banco de dados usando o PDO e a porta do banco de dados
        //Utilizar o Try/Catch para verificar a conexão.
        try {
            $this->pdo = new PDO( DB_CONNECTION . ':host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
            //echo "Conexão com banco de dados realizada com sucesso.";
            return $this->pdo;
        } catch (PDOException $e) {
            echo "Erro: Conexão com banco de dados não foi realizada com sucesso. Erro gerado " . $e->getMessage();
        }
        return false;
    }

    public function __destruct(){
        $this->pdo = null;
    }

}