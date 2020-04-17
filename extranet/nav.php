<?php
/* Affiche erreurs */
/* Classe à INITIALISER ! */
require "../inc/autoload.php";
$db = App::getDatabase();
$auth = App::getAuth();

// Instancie les sessions
$session = Session::getInstance();
$tags = $db->query("SELECT * FROM tags")->fetchAll();
?>

<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
    <a class="navbar-brand"><i>The Good News</i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
        aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">

        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <!-- <a class="nav-link" href="#">Home </a> -->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">test</a>
            </li>
        </ul>
</nav>