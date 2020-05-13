<?php
require "header.php";
require "nav.php";
$auth->restrict("login.php");
if(isset($_GET)){
    $id = $_GET['id'];
    $post = $db->query("Select * from posts where id_posts =:id",["id"=>$id])->fetch();
    $photo = $db->query("Select * from photos where id_posts =:id",["id" =>$id])->fetch();
    $current_tag = $db->query("Select * from tags where id_tags =:idtag",["idtag"=>$post->id_tags])->fetch();

    if(isset($_POST['submitContent'])) {
        // check si au moins un des champs a été changé
        $update = 0;
        if ($_POST['postTitle'] != $post->titre_posts) {
            $update = 1;
        }
        if ($_POST['postText'] != $post->texte_posts) {
            $update = 1;
        }
        if (isset($_POST['postTag']) && $_POST['postTag'] != $post->id_tags) {
            $update = 1;
        }
        if ($update > 0) {

            $titre = $_POST['postTitle'];
            $texte = $_POST['postText'];
            if (isset($_POST['postTag'])) {
                $tagPost = $_POST['postTag'];
            } else {
                $tagPost = $post->id_tags;
            }

            $db->query("UPDATE posts SET titre_posts =:title, texte_posts =:texte, id_tags =:idTag where id_posts =:id", ["title" => $titre, "texte" => $texte, "idTag" => $tagPost, "id" => $id]);
            $session->setFlash('success', "Post modifié avec succès !");
        } else {
            $session->setFlash('danger', "Modifier au moins un champ.");
        }
    }
    if(isset($_POST['submitPicture'])) {
        if(is_uploaded_file($_FILES['postFile']['tmp_name'])) {
            $fichier = $_FILES['postFile'];
            $data_fichier = pathinfo($fichier['name']);
            $ext_fichier = $data_fichier['extension'];
            $ext_autorisees = array('png', 'jpg', 'jpeg');

            // vérifications du fichier
            if ($fichier['size'] <= 8000000 && in_array($ext_fichier, $ext_autorisees))
            {
                // upload du fichier
                $target = "upload/images/".basename($fichier['name']);
                // nouvelle image dans la db
                $db->query("UPDATE photos SET nom_photos =:nom where id_posts =:id", ["nom" => $target, "id" => $id]);
                $session->setFlash('success', "Image modifiée avec succès !");
                // sauvegarde de l'image dans $target
                move_uploaded_file($fichier['tmp_name'], $target);
                $PostDone = true;
            } else {
                $session->setFlash('warning', "Une erreur est survenue lors du téléchargement de l'image.");
            }
        } else {
            $session->setFlash('danger', "Veuillez uploader une image.");
        }
    }
    unset($_POST);
}

?>
<!-- Main Quill library -->
<script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="container" style="width: 800px;">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="title-page center-text">Modifier le contenu</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="postTitle" class="text-right">Titre de la publication</label>
                    <input type="text" name="postTitle" class="form-control" aria-describedby="helpId" value="<?= $post->titre_posts ?>">
                </div>
                <div class="form-group">
                    <label for="postText" class="text-right">Corps de texte</label>
                    <div id="editor">
                        <?= $post->texte_posts ?>
                    </div>
                    <textarea class="form-control edit" name="postText" rows="3" style="opacity: 0;visibility: hidden;height: 0;overflow: hidden;"><?= $post->texte_posts ?></textarea>
                </div>
                <div class="form-group" style="float: right;">
                    <button type="submit" class="btn btn-dark" name="submitContent">Modifier un post</button>
                </div>

                <select class="form-control form-control-sm" style="width: 120px;" name="postTag">
                    <option value="<?= $post->id_tags ?>" selected disabled hidden><?= $current_tag->affichage_tags ?></option>
                    <?php foreach ($tags as $key => $tag) : ?>
                        <?php if($post->id_tags != $tag->id_tags ) : ?>
                            <option class="dropdown-item" href="#" value="<?= $tag->id_tags ;?>"><?= $tag->affichage_tags ;?>
                            </option>
                        <?php endif;?>
                    <?php endforeach;?>
                </select>
            </form>
        </div>

        <hr>
        <div class="col-lg-12">
            <form method="post" id="formPhoto" name="formPhoto" enctype="multipart/form-data">
                <h2 class="secondary-title center-text">Modifier la photo</h2>
                <img class="rounded img-update" src="<?= $photo->nom_photos ;?>" alt="ok" height="100%" width="100%">
                <div class="form-group" style="margin-top: 20px;">
                    <label for="file-upload" class="custom-file-upload">
                        <input type="file" id="file-upload" name="postFile">Uploader une image
                    </label>
                    <small class="text-muted" style="float: right; margin-top: 9px;">.png ou .jpeg - 8 Mo max</small>
                    <span id="file-selected"></span>
                </div>
                <div class="form-group" style="float: right;">
                    <button type="submit" class="btn btn-dark" name="submitPicture">Remplacer la photo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var Delta = Quill.import('delta');
    var quill = new Quill('#editor', {
        theme: 'snow'
    });
/*
    function removeStuff(value) {
        //console.log(value.substr(1, value.length - 2));
    }
*/
    quill.on('text-change', function(delta) {
        var about = document.querySelector('textarea[name=postText]');
        about.value = quill.root.innerHTML;
        //console.log(about.value);
    });
</script>

<?php
require "footer.php";
?>
