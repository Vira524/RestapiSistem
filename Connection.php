<?php

class Connection{
    private $db;
    private $stmt;

    public function __construct()
    {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "restapi";
    
        $pdo = new PDO("mysql:host=$host;dbname=$dbname",$user,$pass);
        
        $pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
        $pdo->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );

        $this->db = $pdo;

    }

    public function execute($query, $args){
        $stmt = $this->db->prepare($query);
        $stmt->execute($args);
        $this->stmt = $stmt;
    }

    public function fetch($query, $args){
        $this->execute($query, $args);
        return $this->stmt->fetch();
    }
    public function fetchAll($query, $args){
        $this->execute($query, $args);
        return $this->stmt->fetchAll();
    }
}