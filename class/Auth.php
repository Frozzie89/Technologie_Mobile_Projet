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
            //$this->session->setFlash('danger',"<i class=\"fas fa-exclamation-circle\" style=\"margin-right: 5px;\"></i> " . $this->options['droit_msg']);
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
        $utilisateur = $db->query('SELECT id_membres, pseudo_membres, login_membres, motDePasse_membres FROM membres WHERE login_membres = :login AND motDePasse_membres = :mdp', ["login" => $mail, "mdp" => $password])->fetch();

        if ($utilisateur != "*")
        {
            $this->connect($utilisateur);
            //$this->session->setFlash('success', "Vous êtes maintenant connecté");
            return $utilisateur;
        }
        $this->session->setFlash('danger', "Une erreur est survenue");
        return false;
    }

        public function loginAdmin($db, $mail, $password){
        $utilisateur = "*";
        $utilisateur = $db->query('SELECT id_membres, pseudo_membres, login_membres, motDePasse_membres FROM membres WHERE id_membres = (SELECT id_membres FROM administrateurs) AND login_membres = :EmailAdmin AND motDePasse_membres = :MdpAdmin', ["EmailAdmin" => $mail, "MdpAdmin" => $password])->fetch();

        if ($utilisateur != "*")
        {
            $this->connect($utilisateur);
            //$this->session->setFlash('success', "Vous êtes maintenant connecté");
            return $utilisateur;
        }
        $this->session->setFlash('danger', "Une erreur est survenue");
        return false;
    }

    // Déconnecte l'utilisateur
    public function logout($url){
        $this->session->delete('auth');
        header("Location: $url");
        exit();
    }
}