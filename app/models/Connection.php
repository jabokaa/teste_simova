<?php

namespace app\models;

use PDO;

class Connection{

    /**
     * Cria a conexão com o banco de dados
     * @return PDO
     */
    public static function connect(){
        $pdo = new PDO("mysql:host=localhost;dbname=simova_teste;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}