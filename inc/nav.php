<?php
/* Affiche erreurs */
/* Classe à INITIALISER ! */
require "inc/autoload.php";
$db = App::getDatabase();
$auth = App::getAuth();

// Instancie les sessions
$session = Session::getInstance();
$tags = $db->query("SELECT * FROM tags")->fetchAll();
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

        <!-- affiche les boutons si pas authentifié, sinon, afficher un message de bienvenue -->
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
    </div>


    <!-- la barre de recherhe qui doit bouger de place 
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
     -->
</nav>