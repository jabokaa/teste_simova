<?php

namespace app\models;

use PDO;

class Connection{

    /**
     * Cria a conexão com o banco de dados
     * @return PDO
     */
    public static function connect(){
        $dbHost = getenv("DB_HOST");
        $dbPort = getenv("DB_PORT");
        $dbDatabase = getenv("DB_DATABASE");
        $dbUsername = getenv("DB_USERNAME");
        $dbPassword = getenv("DB_PASSWORD");

        $pdo = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbDatabase;charset=utf8", $dbUsername, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}