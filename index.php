<!-- Canvas d'une page web, -->
<?php
require "inc/header.php";
require "inc/nav.php";

?>

<section id="homePage">
    <div class="container">
        <div class="col-lg-12">
            <h1 class="title-page center-text">Page d'accueil</h1>
        </div>
    </div>
</section>

<?php foreach($db->query("SELECT * FROM posts ORDER BY id_posts DESC")->fetchAll() as $key => $post) : 
    $img = $db->query("SELECT * FROM photos WHERE id_posts = :id", ["id"=>$post->id_posts])->fetch();

    $nbComments = $db->query("SELECT COUNT(*) AS nbComments FROM commentaires WHERE id_posts = :id",["id"=>$post->id_posts])->fetch();

    $nbVotes =$db->query("SELECT COUNT(*) AS nbVotes FROM likes WHERE id_posts = :id",["id"=>$post->id_posts])->fetch();
?>
<div class="card border-secondary" id="indexPost">
    <img class="card-img-top border-bottom border-secondary" src=<?= "extranet/" . $img->nom_photos ?>>
    <div class="card-body">
        <h5 class="card-title"><b><?= $post->titre_posts ?></b></h5>
        <p class="card-text">
            <?php
            if (strlen($post->texte_posts)<= 230)
                $shortText = $post->texte_posts;
            else
                $shortText = substr($post->texte_posts,0,230) . '...';
            echo $shortText;
            ?></p>

        <i class="fas fa-eye fa-2x"></i>
        <h3><?= $post->nbVue_posts ?></h3>

        <i class="far fa-arrow-alt-circle-up fa-2x" style="margin-left:15px"></i>
        <h3><?= $nbVotes->nbVotes ?></h3>


        <h3 style="float: right; margin-left:5px"><?= $nbComments->nbComments ?></h3>
        <i class="far fa-comments fa-2x" style="float: right;"></i>

    </div>
</div>

<?php endforeach; ?>



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

<?php
require "inc/footer.php";
?>