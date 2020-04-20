<?php
/* Affiche erreurs */
/* Classe à INITIALISER ! */
require "inc/autoload.php";
$db = App::getDatabase();
$auth = App::getAuth();

// Instancie les sessions
$session = Session::getInstance();
$tags = $db->query("SELECT * FROM tags")->fetchAll();

// Vérifie si la page a été refresh
$pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

// enregistrement
if (!empty($_POST['RegisterEmail']) && !empty($_POST['RegisterMdp']) && !empty($_POST['RegisterPseudo']))
{
    // vérifie si le mail existe déjà
    $RegisterMailExists = $db->query("select login_membres from membres where login_membres=:RegisterMail", ["RegisterMail" => $_POST['RegisterEmail']])->fetch();

    // si les mdp correspondent, inscription et connexion
    if ($_POST['RegisterMdp'] == $_POST['RegisterMdpVerif'] && empty($RegisterMailExists))
    {
        $db->query('insert into membres(login_membres, motDePasse_membres, pseudo_membres) values (:RegisterEmail, :RegisterMdp, :RegisterPseudo)', ["RegisterEmail" => $_POST['RegisterEmail'], "RegisterMdp" =>$_POST['RegisterMdp'] , "RegisterPseudo" =>$_POST['RegisterPseudo']]);

        $connexion = $auth->login($db, $_POST['RegisterEmail'], $_POST['RegisterMdp']);
        if ($connexion){
            $session->setFlash('success', "Vous êtes maintenant enregistré");
        }
    }
    else $RegisterError = true;
}

// authentification
if (!empty($_POST['LoginEmail']) && !empty($_POST['LoginMDP'])){
    $connexion = $auth->login($db, $_POST['LoginEmail'], $_POST['LoginMDP']);
    if ($connexion){
        $session->setFlash('success', "Vous êtes maintenant connecté");
    }

}

// déconnexion
if (isset($_POST['btnDeco'])){
    $session->setFlash('danger', "Vous êtes maintenant déconnecté");
    $auth->logout("index.php");
}

// à executer si la page a été refreshed
if ($pageRefreshed)
{
    unset($connexion, $RegisterError, $RegisterMailExists);
} 
?>

<nav class="navbar navbar-dark bg-primary navbar-fixed-top">
    <div class="navbar-header navbar-left pull-left">
        <a href="index.php"><img src="assets/Logo.svg" alt="The Good News" width="200px"
                style="padding-right: 5px; margin-bottom: 5px;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div class="navbar-header navbar-right pull-right">
        <ul class="nav navbar-nav navbar-right">
            <form method="POST">
                <div class="input-group">
                    <?php if (empty($_SESSION['auth']->pseudo_membres)) : ?>
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-light" type="button" data-toggle="modal"
                            data-target="#loginModal">S'authentifier</button>
                    </div><span aria-hidden="true">&nbsp;</span>
                    <div class="input-group-append">
                        <button class="btn btn-outline-light" type="button" data-toggle="modal"
                            data-target="#registerModal">S'enregistrer</button>
                    </div>
                    <?php else : ?>
                    <div class="">
                        <label for="btnDeco" style="color: white; margin-right: 20px;">Connecté en tant que
                            <strong><?php echo $_SESSION['auth']->pseudo_membres;?></strong>
                        </label>
                        <button name="btnDeco" class="btn btn-outline-light" type="submit">Se
                            déconnecter</button>
                    </div>
                    <?php endif ;?>
                </div>
            </form>
        </ul>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-left">
            <?php foreach ($tags as $key => $tag) : ?>
            <li class="nav-item">
                <a class="nav-link" href="#"><?= $tag->affichage_tags ;?></a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</nav>