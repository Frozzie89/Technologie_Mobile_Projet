<?php
require "inc/header.php";
require "inc/nav.php";
?>

<section id="homePage">
    <div class="container">
        <div class="col-lg-12">
            <h1 style="margin-top: 100px; text-align:center">Inscrivez-vous et rejoignez la communauté de <br> <i>The Good News</i></h1>
        </div>
    </div>
</section><br>
<?php
var_dump($_POST);
$db = new Database("root","","localhost","projettm");
$db->query('insert into membres(login_membres, motDePasse_membres, pseudo_membres) values (:email, :mdp, :pseudo)', array(email => $_POST['email'], mdp =>$_POST['mdp'] , pseudo =>$_POST['pseudo']))
?>
 
    <div class="container" style="width: 500px;">
        <form method="post">
            <div class="form-group">
                <label for="InscriptionMail">Adresse Email</label>
                <input type="email" class="form-control" id="InscriptionMail" placeholder="" name="email">
            </div>

            <div class="form-group">
                <label for="InscriptionMail">Pseudonyme</label>
                <input type="text" class="form-control" id="InscriptionMail" placeholder="" name="pseudo">
            </div>

            <div class="form-group">
                <label for="InscriptionMDP">Mot de passe</label>
                <input type="password" class="form-control" id="InscriptionMDP" placeholder="" name="mdp">
            </div>

            <div class="form-group">
                <label for="InscriptionMDPverif">Verification du mot de passe</label>
                <input type="password" class="form-control" id="InscriptionMDPverif" placeholder="" name="mdpVerif">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="submit">Inscrivez-vous</button>
            </div>
        </form>
    </div>


    
<?php
require "inc/footer.php";
?>
