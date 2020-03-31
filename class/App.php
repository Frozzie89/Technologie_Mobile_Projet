<?php


class App
{
    static $db = null;

    static function getDatabase(){
        // Si la connection à la BDD n'est pas initialisée, initialise-la.
        if(!self::$db){
            self::$db = new Database('root','','localhost', 'nomDB');
        }
        return self::$db;
    }

    static function getAuth(){
        return new Auth(Session::getInstance(), ['restriction_msg' => 'Zone interdite']);
    }

    static function getLoged(){
        return new Loged(Session::getInstance());
    }

    static function getErrors(){
        return new Errors(Session::getInstance());
    }

    static function getAdmin(){
        return new Admin(Session::getInstance());
    }

    static function getDocument(){
        return new Document(Session::getInstance());
    }

    static function redirect($page){
        header("Location: $page");
        exit();
    }

    static function debug($value){
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
    }
}