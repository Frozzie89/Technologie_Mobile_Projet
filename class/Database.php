<?php


class Database
{
    private $pdo;

    public function __construct($user,$password,$host,$database_name){
        $this->pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
    }

    public function query($query,$params = false){
        if($params){
            $req = $this->pdo->prepare($query);
            $req->execute($params);
        }else{
            $req = $this->pdo->query($query);
        }
        return $req;
    }

    public function lastInsertId($name = NULL) {
        if(!$this->pdo) {
            throw new Exception('ERROR LAST INSERT ID');
        }
        return $this->pdo->lastInsertId($name);
    }
}