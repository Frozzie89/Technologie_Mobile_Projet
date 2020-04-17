<?php
/* Affiche erreurs */
/* Classe à INITIALISER ! */
require "../inc/autoload.php";
$db = App::getDatabase();
$auth = App::getAuth();

// Instancie les sessions
$session = Session::getInstance();
$tags = $db->query("SELECT * FROM tags")->fetchAll();


// Si l'utilisateur est déjà authentifié, vérifier qu'il est admin
if (!empty($_SESSION['auth']->login_membres))
{
    $connexion = $auth->loginAdmin($db, $_SESSION['auth']->login_membres, $_SESSION['auth']->motDePasse_membres);
    if (!$connexion) $auth->logout("login.php");
}
    

// authentification
if (!empty($_POST['LoginEmailAdmin']) && !empty($_POST['LoginMDPAdmin'])){
    $connexion = $auth->loginAdmin($db, $_POST['LoginEmailAdmin'], $_POST['LoginMDPAdmin']);
    if ($connexion){
        //header('Location: ../index.php');    
        $session->setFlash('success', "Vous êtes maintenant connecté");
    }
}

// déconnexion
if (isset($_POST['btnDecoAdmin']))
{
    $session->setFlash('danger', "Vous êtes maintenant déconnecté");
    $auth->logout("../index.php");
}

?>

<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
    <a class="navbar-brand" href="../index.php"><i>The Good News</i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
        aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">

        <!-- Boutons à afficher si authentifié -->
        <?php if (!empty($_SESSION['auth']->pseudo_membres)) : ?>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="addPost.php">Ajouter un post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Supprimer un post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Modifier un post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Gestion des utilisateurs</a>
            </li>
        </ul>

        <!-- Bouton déconnexion à afficher si authentifié -->
        <form method="POST">
            <div class="">
                <label for="btnDecoAdmin" style="color: white; margin-right: 20px;">Connecté en tant que
                    <strong><?php echo $_SESSION['auth']->pseudo_membres;?></strong>
                </label>
                <button name="btnDecoAdmin" class="btn btn-outline-light" type="submit">Se déconnecter</button>
        </form>
        <?php endif; ?>



</nav>