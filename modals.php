<?php $pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0'; 
    
?>

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
                        <?php if (isset($connexion) && $connexion == false && !$pageRefreshed && !isset($_POST['RegisterEmail']))
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
                <h4 class="modal-title" id="loginTitle" style="text-align: center;"><strong>Inscrivez-vous et
                        rejoignez
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
                        <?php if (!empty($RegisterMailExists) && !$pageRefreshed) echo "<span id=\"RegisterMailExists\" style=\"color: red;\">Cette adresse mail est déjà prise</span>" ?>
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
                        <span id="mdpNoNum" style="display:none; color: red;">Le mot de passe doit contenir au moins
                            un
                            chiffre</span>
                    </div>

                    <div class="form-group">
                        <label for="RegisterMDPVerif">Verification du mot de passe</label>
                        <input type="password" class="form-control" id="RegisterMDPVerif" placeholder=""
                            name="RegisterMdpVerif">
                        <span id="mdpUnmatch" style="display:none; color: red;">Les mots de passes ne correspondent
                            pas</span>
                        <?php if(isset($RegisterError) && !$pageRefreshed)
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

<!-- Modal customisation  -->
<div class="modal fade" id="changePseudo" tabindex="-1" role="dialog" aria-labelledby="changePseudo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePseudo">Options de personnalisations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  
            <div class="modal-body" style="background-color:rgb(238, 238, 238);">
                <form method="POST" id="ModifyForm">
                    <div class="input-group mb-3">
                        <input type="text" name="newPseudo" id="modalNewPseudo" class="form-control" placeholder="Changer de pseudonyme"
                            aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" id="modalModifyPseudo" name="ModifyPseudo">OK</button>
                        </div>
                    </div>
                </form>
                <label style="margin-right: 5px;">Changer le thème</label>
                <a><i class="fas fa-sun fa-2x" style="vertical-align: middle;"
                        id="changeTheme"></i></a>
            </div>
        </div>
    </div>
</div>