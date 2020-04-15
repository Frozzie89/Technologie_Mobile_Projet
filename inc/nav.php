<?php
/* Affiche erreurs */
/* Classe à INITIALISER ! */
require "inc/autoload.php";
$db = App::getDatabase();
$auth = App::getAuth();

// Instancie les sessions
$session = Session::getInstance();
$tags = $db->query("SELECT * FROM tags")->fetchAll();

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
    }
    else $RegisterError = true;
}

// authentification
if (!empty($_POST['LoginEmail']) && !empty($_POST['LoginMDP']))
    $connexion = $auth->login($db, $_POST['LoginEmail'], $_POST['LoginMDP']);

$UserData = (array)$_SESSION['auth'];

empty($_POST);

?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="../index.php"><i>The Good News</i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
        aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">

        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <!-- <a class="nav-link" href="#">Home </a> -->
            </li>
            <?php foreach ($tags as $key => $tag) : ?>
            <li class="nav-item">
                <a class="nav-link" href="#"><?= $tag->affichage_tags ;?></a>
            </li>
            <?php endforeach;?>
        </ul>

        <!-- affiche les boutons si pas authentifié, sinon, afficher pseudo et bouton de déconnexion -->

        <form>
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-light" type="button" data-toggle="modal"
                        data-target="#loginModal">S'authentifier</button>
                </div><span aria-hidden="true">&nbsp;</span>
                <div class="input-group-append">
                    <button class="btn btn-outline-light" type="button" data-toggle="modal"
                        data-target="#registerModal">S'enregistrer</button>
                </div>
            </div>
        </form>

        <!-- <from>
            <h4 style="color: white;">John Doe - <input type="submit"
                    style="border: none;background-color: inherit;cursor: pointer;display: inline-block; color: teal;"
                    value="Déconnexion"></h4>
        </from> -->
        

    </div>


    <!-- la barre de recherhe qui doit bouger de place 
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
     -->
</nav>