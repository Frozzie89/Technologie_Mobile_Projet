<?php
require "header.php";
require "nav.php";

$error_missingInfo = false;
$error_wrongFile = false;

// si bouton cliqué
if(isset($_POST['submitNewPost']))
{
    // si tout est bien rempli :
    if (!empty($_POST['newPostTitle']) && !empty($_POST['newPostText']) && !empty($_FILES['newPostFile']) && !empty($_POST['newPostTag']))
    {
        $titre = $_POST['newPostTitle'];
        $corps = $_POST['newPostText'];
        $tagPost = $_POST['newPostTag'];

        $fichier = $_FILES['newPostFile'];
        $data_fichier = pathinfo($fichier['name']);
        $ext_fichier = $data_fichier['extension'];
        $ext_autorisees = array('png', 'jpg', 'jpeg');

        // vérifications du fichier
        if ($fichier['size'] <= 8000000 && in_array($ext_fichier, $ext_autorisees))
        {
            // upload du fichier
            $target = "upload/images/".basename($fichier['name']);

            // numéro du tag
            foreach ($tags as $key => $tag)
            {
                if ($tagPost == $tag->affichage_tags) $tagPostId = $tag->id_tags;
            }

            // nouveau post dans la db
            $db->query("INSERT INTO posts (titre_posts, texte_posts, autheur_posts, nbVue_posts, nbLike_posts, id_tags) VALUES (:titre, :corps, :auteur, :vues, :likes, :tag)", ["titre"=> $titre, "corps"=> $corps, "auteur"=>$_SESSION['auth']->pseudo_membres, "vues"=> 0, "likes"=> 0 , "tag"=>$tagPostId]);

            // nouvelle image dans la db
            $db->query("INSERT INTO photos (nom_photos, id_posts) VALUES (:imgNom, :idPost)", ["imgNom" => $target, "idPost" => $db->lastInsertID()]);

            // sauvegarde de l'image dans $target
            move_uploaded_file($fichier['tmp_name'], $target);
            $PostDone = true;
        }
        else $error_wrongFile = true;
    }
    else $error_missingInfo = true;
}
unset($_POST);

?>

<section id="homePage">
    <div class="container">
        <div class="col-lg-12">
            <h1 style="margin-top: 100px; margin-bottom: 50px;">
                Ajoutez une nouvelle publication</h1>
        </div>
    </div>
</section>

<div class="container" style="width: 800px;">
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="newPostTitle">Titre de la publication</label>
            <input type="text" name="newPostTitle" class="form-control" aria-describedby="helpId">
        </div>
        <div class="form-group">
            <label for="newPostText">Corps de texte</label>
            <textarea class="form-control" name="newPostText" rows="3" style="resize:none;"></textarea>
        </div>
        <div class="form-group">
            <label for="file-upload" class="custom-file-upload">
                <input type="file" id="file-upload" name="newPostFile">Uploader une image
            </label>
            <small class="text-muted" style="float: right; margin-top: 9px;">.png ou .jpeg - 8 Mo max</small>
            <span id="file-selected"></span>
        </div>
        <div class="form-group" style="float: right;">
            <button type="submit" class="btn btn-dark" name="submitNewPost">Ajouter un nouveau post</button>
        </div>

        <select class="form-control form-control-sm" style="width: 120px;" name="newPostTag">
            <option value="default" selected disabled hidden>Tag</option>
            <?php foreach ($tags as $key => $tag) : ?>
            <option class="dropdown-item" href="#" value="<?= $tag->affichage_tags ;?>"><?= $tag->affichage_tags ;?>
            </option>
            <?php endforeach;?>
        </select>
    </form>
    <br>
    <?php 
    if($error_missingInfo && !$pageRefreshed) 
        echo "<span style=\"color: red;\" id=\"newPostMissingInfo\">Il manque des informations</span><br>";
    if($error_wrongFile && !$pageRefreshed) 
        echo "<span style=\"color: red;\" id=\"newPostWrongFile\">L'image uploadée n'est pas correcte</span>"; 
    if(isset($PostDone)) echo "<span style=\"color : green;\" id=\"newPostDone\">La publication a bien été ajoutée</span>";
    ?>

</div>



<?php
require "footer.php";
?>