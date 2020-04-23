<?php
require "header.php";
require "nav.php";

$auth->restrict("login.php");
?>

<section id="affichageNews">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="title-page center-text">
                    Gestion des publications
                </h1>
            </div>
            <div class="col-lg-8">
                <h2 id="titleBindToSelect">
                    Tous les articles
                </h2>
            </div>
            <div class="col-lg-4">
                <select class="form-control" id="tagSelector" name="tagSelector">
                    <option value="0">Tous les articles</option>
                    <?php foreach ($tags as $key => $tag) : ?>
                    <option value="<?= $tag->id_tags?>"><?= $tag->affichage_tags ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-12">
                <input id="searchbarPost" class="form-control" type="text" class="form-control" placeholder="Search..">
            </div>
        </div>

    </div>
</section>

<div class="container">
    <div class="row maindiv">
        <!-- Posts go here -->
    </div>
</div>



<?php
require "footer.php";
?>