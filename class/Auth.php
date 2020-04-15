<?php


class Auth
{
    private $options = [
        'restriction_msg' => "Zone interdite",
        'droit_msg' => "Vous n'avez pas le droit d'accéder à cette page"
    ];

    private $session;

    public function __construct($session, $options = []){
        $this->options = array_merge($this->options,$options);
        $this->session = $session;
    }

    // Restreint l'utilisateur si il n'est pas connecté (si la session auth n'existe pas)
    public function restrict($url){
        if(!$this->session->read('auth')){
            $this->session->setFlash('danger',"<i class=\"fas fa-exclamation-circle\" style=\"margin-right: 5px;\"></i> " . $this->options['droit_msg']);
            header("Location: $url");
            exit();
        }
    }

    // Crée une nouvelle session "auth", qui servira à s'identifier sur toutes les pages
    public function connect($utilisateur){
        // Ecrit une nouvelle session "auth"
        $this->session->write('auth', $utilisateur);
    }

    // Vérifie si l'utilisateur a bien entré ses identifiants lors de la connexion
    public function login($db, $mail, $password){
        $utilisateur = "*";
        $utilisateur = $db->query('select pseudo_membres, login_membres, motDePasse_membres from membres where login_membres = :login and motDePasse_membres = :mdp', ["login" => $mail, "mdp" => $password])->fetch();

        if ($utilisateur != "*")
        {
            $this->connect($utilisateur);
            return $utilisateur;
        }
        else return false;

        // vieux code  : 
        // if(password_verify($password, $utilisateur->Password_Utilisateurs)){
        //     $this->connect($utilisateur);
        //     return $utilisateur;
        // }
        // return false;
    }

    // Déconnecte l'utilisateur
    public function logout($url){
        $this->session->setFlash('success', "<i class=\"fas fa-check-circle\" style=\"margin-right: 5px;\"></i> Vous êtes maintenant déconnecté");
        $this->session->delete('auth');
        header("Location: $url");
        exit();
    }
}