<?php
require "header.php";
require "nav.php";
?>

<section id="homePage">
    <div class="container">
        <div class="col-lg-12">
            <h1 style="margin-top: 100px; margin-bottom: 50px; text-align: center;">
            Authentifiez-vous en tant qu'administrateur</h1>
        </div>
    </div>
</section>

<div class="container" style="width: 500px;">
    <form method="post">
        <div class="form-group">
            <label for="LoginEmailAdmin">Adresse Email</label>
            <input type="email" name="LoginEmailAdmin" class="form-control">
        </div>
        <div class="form-group">
            <label for="LoginMDPAdmin">Mot de passe</label>
            <input type="password" name="LoginMDPAdmin" class="form-control">
        </div><br>
        <?php if (isset($connexion) && $connexion == false)
            echo "<span id=\"WrongLoginAdmin\" style=\"color: red;\">
            L'adresse email ou le mot de passe est erroné</span>";
        ?>
        <div class="form-group" style="float: right;">
            <button type="submit" class="btn btn-primary" name="LoginSubmitAdmin">S'authentifier</button>
        </div>
    </form>
</div>

<?php
require "footer.php";
?>