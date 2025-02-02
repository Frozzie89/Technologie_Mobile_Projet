<?php
/* Affiche erreurs */
/* Classe à INITIALISER ! */
require "inc/autoload.php";
$db = App::getDatabase();
$auth = App::getAuth();

// check si la page a été refreshed
$pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

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
        // cryptage
        $cryptedMdp = crypt($_POST['RegisterMdp'], "f1618f7d9205e83636f0a011d5639fa2");

        $db->query('insert into membres(login_membres, motDePasse_membres, pseudo_membres) values (:RegisterEmail, :RegisterMdp, :RegisterPseudo)', ["RegisterEmail" => $_POST['RegisterEmail'], "RegisterMdp" =>$cryptedMdp , "RegisterPseudo" =>$_POST['RegisterPseudo']]);

        $connexion = $auth->login($db, $_POST['RegisterEmail'], $cryptedMdp);
    }
    else $RegisterError = true;
}


// authentification
if (!empty($_POST['LoginEmail']) && !empty($_POST['LoginMDP']))
{
    $connexion = $auth->login($db, $_POST['LoginEmail'], crypt($_POST['LoginMDP'], "f1618f7d9205e83636f0a011d5639fa2"));
}

// déconnexion
if (isset($_POST['btnDeco'])) $auth->logout("index.php");
//unset($_POST);


// update pseudo
if (isset($_POST['newPseudo'])) {
    $login = $_SESSION['auth']->login_membres;
    
    if ($login) {
        $db->query(
            "UPDATE membres SET pseudo_membres=:nPseudo WHERE login_membres=:login",
            ['nPseudo' => $_POST['newPseudo'], 'login' => $login]
        );
        $session->update('auth', 'pseudo_membres', $_POST['newPseudo']);
        $session->setFlash('success', "Votre pseudo a bien été modifié.");
    } 
    else 
        $session->setFlash('danger', "Impossible de modifier votre pseudo");

    unset($_POST['newPseudo']);
}

?>

<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
    <div class="navbar-header navbar-left pull-left">
        <a href="index.php"><img src="assets/Logo.svg" alt="The Good News" width="200px"
                style="padding-right: 5px; margin-bottom: 5px;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="nav navbar-nav navbar-left">
            <?php foreach ($tags as $key => $tag) : ?>
            <li class="nav-item">
                <a class="nav-link" href="tag?id=<?= $tag->id_tags ;?>"><?= $tag->affichage_tags ;?></a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>

    <div class="navbar-header navbar-right pull-right">
        <ul class="nav navbar-nav navbar-right">
            <form method="POST">
                <div class="input-group">
                    <?php if (empty($_SESSION['auth']->pseudo_membres)) : ?>
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-light" type="button" data-toggle="modal"
                            data-target="#loginModal">S'authentifier</button>
                    </div>
                    <span aria-hidden="true">&nbsp;</span>
                    <div class="input-group-append">
                        <button class="btn btn-outline-light" type="button" data-toggle="modal"
                            data-target="#registerModal">S'enregistrer</button>
                    </div>
                    <?php else : ?>
                    <div class="collapse navbar-collapse navRight" id="navbarsExampleDefault">
                        <a href="history.php"><i class="fas fa-history"></i></a>
                        <a data-toggle="modal" data-target="#changePseudo" id="cogCustomUser"><i
                                class="fas fa-cog"></i></a>
                    </div>
                    <label for="btnDeco" style="color: white; margin-right: 20px; margin-top:5px">Connecté
                        en tant que
                        <strong id="currentPseudo"><?php echo $_SESSION['auth']->pseudo_membres;?></strong>
                    </label>
                    <div class="collapse navbar-collapse navRight" id="navbarsExampleDefault">
                        <button name="btnDeco" class="btn btn-outline-light" type="submit">Se
                            déconnecter</button>
                    </div>
                    <?php endif ;?>
                </div>
            </form>
        </ul>
    </div>
</nav>