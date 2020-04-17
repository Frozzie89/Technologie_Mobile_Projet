<!-- Canvas d'une page web, -->
<?php
require "inc/header.php";
require "inc/nav.php";

?>

<section id="homePage">
    <div class="container">
        <div class="col-lg-12">
            <h1 style="margin-top: 100px;">Page d'accueil</h1>
        </div>
    </div>
</section>

<!-- modal login  -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginTitle"><strong>Authentifiez-vous</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color:rgb(238, 238, 238);">
                <form method="POST" id="LoginForm">
                    <div class="form-group">
                        <label for="LoginEmail">Adresse Email</label>
                        <input type="text" class="form-control" id="LoginEmail" placeholder="" name="LoginEmail">
                    </div>

                    <div class="form-group">
                        <label for="LoginMDP">Mot de passe</label>
                        <input type="password" class="form-control" id="LoginMDP" placeholder="" name="LoginMDP">
                        <?php if (isset($connexion) && $connexion == false)
                            echo "<span id=\"WrongLogin\" style=\"color: red;\">
                            L'adresse email ou le mot de passe est erroné</span>";
                        ?>
                    </div>

                    <div class="modal-footer form-group">
                        <button type="submit" class="btn btn-primary" name="loginSubmit">S'authentifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal register  -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="loginTitle" style="text-align: center;"><strong>Inscrivez-vous et rejoignez
                        la communauté de <br> <i>The Good News</i></strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color:rgb(238, 238, 238);">
                <form method="POST" id="RegisterForm">
                    <div class="form-group">
                        <label for="RegisterMail">Adresse Email</label>
                        <input type="email" class="form-control" id="RegisterMail" placeholder="" name="RegisterEmail">
                        <?php if (!empty($RegisterMailExists)) echo "<span id=\"RegisterMailExists\" style=\"color: red;\">Cette adresse mail est déjà prise</span>" ?>
                    </div>

                    <div class="form-group">
                        <label for="RegisterPseudo">Pseudonyme</label>
                        <input type="text" class="form-control" id="RegisterPseudo" placeholder=""
                            name="RegisterPseudo">
                    </div>

                    <div class="form-group">
                        <label for="RegisterMDP">Mot de passe</label>
                        <label for="RegisterMDP" id="strongMDP"></label>
                        <input type="password" class="form-control" id="RegisterMDP"
                            placeholder="Doit contenir au moins un chiffre" name="RegisterMdp">
                        <span id="mdpNoNum" style="display:none; color: red;">Le mot de passe doit contenir au moins un
                            chiffre</span>
                    </div>

                    <div class="form-group">
                        <label for="RegisterMDPVerif">Verification du mot de passe</label>
                        <input type="password" class="form-control" id="RegisterMDPVerif" placeholder=""
                            name="RegisterMdpVerif">
                        <span id="mdpUnmatch" style="display:none; color: red;">Les mots de passes ne correspondent
                            pas</span>
                        <?php if(isset($RegisterError))
                        echo "<span id=\"ErrorMDPRegister\" style=\"color: red;\">Une erreur est survenue, l'inscription n'a pas pu être faite</span>" ?>
                        <br>
                    </div>

                    <div class="modal-footer form-group">
                        <button type="submit" class="btn btn-primary" id="registerSubmit">S'inscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Va être changé en flash :  -->
<!-- Notification : salue l'utilisateur qui vient de s'authentifier -->
<!-- <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
    <div class="toast" data-delay="3000"
        style="position: absolute; top: 0; right: 0;background-color: rgb(60, 196, 60); box-shadow: 7px 6px 5px -1px rgba(186,186,186,0.65); color: white;">
        <div class=" toast-body">
            <h7>Heureux de vous revoir <?php echo $_SESSION['auth']->pseudo_membres;?></h7>
        </div>
    </div>
</div> -->

<?php
require "inc/footer.php";
?>