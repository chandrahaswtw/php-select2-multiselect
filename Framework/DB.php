<?php

namespace MS;

use PDO;
use PDOException;

class DB
{

    public $pdo;

    function __construct($config)
    {
        $dsn = sprintf("mysql:host=%s;port=%s;dbname=%s;chatset=utf8", $config["host"], $config["port"], $config["dbname"]);


        try {
            $this->pdo = new PDO($dsn, $config["username"], $config["password"]);

            //Enable error handling
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Convert as 
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Database connection error : {$e->getMessage()}";
        }
    }

    public function query($query, $params = [])
    {

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt;
    }
}
