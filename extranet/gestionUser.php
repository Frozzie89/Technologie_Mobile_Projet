<?php
require "header.php";
require "nav.php";

$auth->restrict("login.php");
?>

<section id="affichageUsers">
    <div class="container">
        <div class="col-lg-12">
            <h1 class="title-page center-text">Gestion des utilisateurs</h1>
        </div>
    </div>
</section>

<div class="container">
    <div class="col-lg-12">
        <div class="md-form mt-0">
            <input class="form-control" type="text"
                placeholder="Rechercher un utilisateur par son pseudonyme ou son adresse mail" aria-label="Search"
                id="searchUser">
        </div>
        <br>
        <div class="container border" style="background-color: white;">
            <table class="table">
                <thead id="tableHeader">
                    <tr>
                        <th scope="col">Email</th>
                        <th scope="col">Pseudonyme</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    <?php foreach($db->query("SELECT id_membres, login_membres ,pseudo_membres FROM membres")->fetchall() as $key => $user) :
            
                $isAdmin = $db->query('SELECT id_membres FROM membres where id_membres = (SELECT id_membres from administrateurs) and login_membres = :EmailAdmin', ["EmailAdmin" => $user->login_membres])->fetch();
                ?>

                    <tr>
                        <td id="emailUser" <?php if ($isAdmin != false ) echo "style=\"color:green;\""; ?>>
                            <?= $user->login_membres ?></td>
                        <td id="pseudoUser" <?php if ($isAdmin != false ) echo "style=\"color:green;\""; ?>>
                            <?= $user->pseudo_membres ?></td>
                        <td><?php if (!$isAdmin) echo "<a class=\"deleteUser\" id=\"$user->id_membres\" href=\"#\">supprimer</a>"; ?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require "footer.php";
?>