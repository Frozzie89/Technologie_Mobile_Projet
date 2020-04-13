<?php
require "inc/header.php";
require "inc/nav.php";

$db = new Database("root","","localhost","projettm");
if (!empty($_POST['email']) && !empty($_POST['mdp']) && !empty($_POST['pseudo']))
{
    // vérifie si le mail existe déjà
    $mailExists = $db->query("select login_membres from membres where login_membres=:mail", ["mail" => $_POST['email']])->fetch();

    // si les mdp correspondent, inscription
    if ($_POST['mdp'] == $_POST['mdpVerif'] && empty($mailExists))
    {
        $db->query('insert into membres(login_membres, motDePasse_membres, pseudo_membres) values (:email, :mdp, :pseudo)', ["email" => $_POST['email'], "mdp" =>$_POST['mdp'] , "pseudo" =>$_POST['pseudo']]);
    }
}
empty($_POST);

?>
<section id="homePage">
    <div class="container">
        <div class="col-lg-12">
            <h1 style="margin-top: 100px; text-align:center">Inscrivez-vous et rejoignez la communauté de <br> <i>The
                    Good News</i></h1>
        </div>
    </div>
</section><br>


<div class="container" style="width: 500px;">
    <form method="post" action="register.php" id="registerForm">
        <div class="form-group">
            <label for="InscriptionMail">Adresse Email</label>
            <input type="email" class="form-control" id="InscriptionMail" placeholder="" name="email">
            <?php if (!empty($mailExists)) echo "<span style=\"color: red;\">Cette adresse mail est déjà prise</span>" ?>
        </div>

        <div class="form-group">
            <label for="InscriptionMail">Pseudonyme</label>
            <input type="text" class="form-control" id="InscriptionMail" placeholder="" name="pseudo">
        </div>

        <div class="form-group">
            <label for="InscriptionMDP">Mot de passe</label>
            <label for="InscriptionMDP" id="strongMDP"></label>
            <input type="password" class="form-control" id="InscriptionMDP"
                placeholder="Doit contenir au moins un chiffre" name="mdp">
            <span id="mdpNoNum" style="display:none; color: red;">Le mot de passe doit contenir au moins un
                chiffre</span>
        </div>

        <div class="form-group">
            <label for="InscriptionMDPverif">Verification du mot de passe</label>
            <input type="password" class="form-control" id="InscriptionMDPverif" placeholder="" name="mdpVerif">
            <span id="mdpUnmatch" style="display:none; color: red;">Les mots de passes ne correspondent pas</span><br>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="submit" id="submit">S'inscrire</button>
        </div>
    </form>
</div>

<script src="assets/js/jquery-3.4.1.js"></script>
<script>
    $('#InscriptionMDPverif').on('focusout', function () {
        if ($('#InscriptionMDP').val() != "" && $('#InscriptionMDPVerif').val() != "") {
            if ($('#InscriptionMDP').val() != $('#InscriptionMDPverif').val())
                $('#mdpUnmatch').fadeIn()

            else
                $('#mdpUnmatch').fadeOut()


        }
    });

    $('#InscriptionMDP').on('focusout', function () {
        var regexNumber = new RegExp("[0-9]")

        if ($('#InscriptionMDP').val() == $('#InscriptionMDPVerif').val())
            $('#mdpUnmatch').fadeOut()

        if (!regexNumber.test($('#InscriptionMDP').val()))
            $('#mdpNoNum').fadeIn()
        else
            $('#mdpNoNum').fadeOut()
    });

    $('#InscriptionMDP').on('keyup', function () {
        let mdpLen = $('#InscriptionMDP').val().length
        if (mdpLen == 0) $('#strongMDP').val()
        else if (mdpLen >= 0 && mdpLen < 6) $('#strongMDP').text("- Faible").css("color", "red")
        else if (mdpLen >= 6 && mdpLen < 12) $('#strongMDP').text("- Moyen").css("color", "grey")
        else $('#strongMDP').text("- Fort").css("color", "green")
    });

</script>
<?php
require "inc/footer.php";
?>