<?php


class Session
{
    static $instance;

    // Vérifie l'instance de session. Si elle n'existe pas, crée-la
    static function getInstance(){
        if(!self::$instance){
            self::$instance = new Session();
        }
        return self::$instance;
    }

    // Démarre l'utilisation des sessions
    public function __construct(){
        session_start();
    }

    // Crée une nouvelle session flash
    public function setFlash($key, $msg){
        $_SESSION['flash'] = $msg;
        echo "<div class='container-fluid msg-flash alert alert-$key alert-dismissible fade show' role='alert'>". $_SESSION['flash'] ."</div>";
    }

    // Vérifie si la session flash existe
    public function hasFlashes(){
        return isset($_SESSION['flash']);
    }

    // Récupère la session pour l'afficher, puis supprime-la
    public function getFashes(){
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);

        return $flash;
    }

    // Ecrit une nouvelle session. Avec une clé et une valeur
    public function write($key, $value){
        $_SESSION[$key] = $value;
    }

    // Lit la session et vérifie si elle existe. Sinon renvoi null
    public function read($key){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    // Met à jour une session en changeant 1 ou plusieurs paramètres
    public function update($key, $key_value, $new_value){
        $_SESSION[$key]->$key_value = $new_value;
    }

    // Supprime la session
    public function delete($key){
        unset($_SESSION[$key]);
    }
}