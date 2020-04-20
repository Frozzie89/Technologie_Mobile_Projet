<?php
require "header.php";
require "nav.php";
?>

<section id="homePage">
    <div class="container">
        <div class="col-lg-12">
            <h1 style="margin-top: 100px; margin-bottom: 50px;">
                Ajoutez une nouvelle publication</h1>
        </div>
    </div>
</section>

<div class="container" style="width: 800px;" enctype="multipart/form-data">
    <form method="post">
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
                <input type="file" id="file-upload">Uploader une image
            </label>
            <small class="text-muted" style="float: right; margin-top: 9px;">.pdf ou .jpeg</small>
            <span id="file-selected"></span>
        </div>
        <div class="form-group" style="float: right;">
            <button type="submit" class="btn btn-dark" name="submitNewPost">Ajouter un nouveau post</button>
        </div>

    </form>

    <div class="btn-group dropright">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
            id="TagVal" aria-expanded="false">
            Tag
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" id="dropPost">
            <?php foreach ($tags as $key => $tag) : ?>
            <a class="dropdown-item" href="#"><?= $tag->affichage_tags ;?></a>
            <?php endforeach;?>
        </div>
    </div>
</div>



<?php
require "footer.php";
?>