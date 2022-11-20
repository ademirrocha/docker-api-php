<?php

namespace app\vendor\databases;

use PDO;
use PDOException;

class DB
{

    public static function connect(){
        //Criar as constantes com as credencias de acesso ao banco de dados
        define('HOST', 'mydb');
        define('USER', 'root');
        define('PASS', 'root');
        define('DBNAME', 'api_backend_db');
        define('PORT', '3306');

        //Criar a conexão com banco de dados usando o PDO e a porta do banco de dados
        //Utilizar o Try/Catch para verificar a conexão.
        try {
            $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASS);
            //echo "Conexão com banco de dados realizada com sucesso.";
            return $conn;
        } catch (PDOException $e) {
            echo "Erro: Conexão com banco de dados não foi realizada com sucesso. Erro gerado " . $e->getMessage();
        }
        return false;
    }

    public static function close(){
        return null;
    }

}