<!-- Canvas d'une page web, -->
<?php
require "inc/header.php";
require "inc/nav.php";

function printPost($col, $post, $db) {
    $nbComments = $db->query("SELECT COUNT(*) AS val FROM commentaires WHERE id_posts = :id", ["id"=>$post->id_posts])->fetch();
    $img = $db->query("SELECT nom_photos AS img FROM photos WHERE id_posts = :id", ["id"=>$post->id_posts])->fetch();
    if (strlen($post->texte_posts)<= 230)
        $shortText = $post->texte_posts;
    else
        $shortText = substr($post->texte_posts,0,230) . ' ...';

    echo "<div class=\"". $col . "\">
        <div class=\"card border-secondary\">
            <img class=\"card-img-top border-bottom border-secondary\"
                src=\"extranet/". $img->img ."\"
                alt=\"Card image cap\">
            <div class=\"card-body\">
                <h4 class=\"card-title\">" .$post->titre_posts . "</h4>
                <p class=\"card-text\">". $shortText ."</p>
                <i class=\"fas fa-eye fa-2x\"></i>
                <h3>". $post->nbVue_posts ."</h3>

                <i class=\"far fa-arrow-alt-circle-up fa-2x\" style=\"margin-left:15px\"></i>
                <h3>". $post->nbLike_posts ."</h3>

                <h3 style=\"float: right; margin-left:5px\">". $nbComments->val ."</h3>
                <i class=\"far fa-comments fa-2x\" style=\"float: right;\"></i>
            </div>
        </div>
    </div>";
}
?>

<section id="homePage">
    <div class="container">
        <div class="col-lg-12">
            <h1 class="title-page center-text">Page d'accueil</h1>
        </div>
        <!-- <div class="col-lg-12 center-text">
            <div class="btn-group btn-group-lg " role="group" aria-label="Basic example" id="tagIndexGrp">
                <?php foreach($tags as $key=>$tag) :
                if (empty($idTagButton)) $idTagButton = 0;
                $idTagButton++; ?>
                <button type="button" id="<?= "tagIndex_". $idTagButton?>"
                    class="btn btn-outline-secondary"><?= $tag->affichage_tags ?></button>
                <?php endforeach; ?>
            </div>
        </div> -->
    </div>
</section>


<!-- Carousel -->
<div class="container">
    <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

        <!--Boutons de contrôle-->
        <div class="controls-top">
            <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
            <a class="btn-floating" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>
        </div>

        <!--Slides-->
        <div class="carousel-inner" role="listbox">
            <?php
            $colType = array("col", "col-lg-5", "col-lg-7", "col-log-4, col-lg-4", "col-lg-4", "col-lg-4", "col-lg-7", "col-lg-5");
            $post = array(); 
            foreach($tags as $key=>$tag) : 
        ?>
            <div class="carousel-item <?php if($tag->id_tags == 1) echo "active" ?> my-auto">
                <?php
                $post = $db->query("SELECT * FROM posts WHERE id_tags = :tag ORDER BY id_posts DESC LIMIT 8", ["tag"=>$tag->id_tags])->fetchAll();
                $current = 0;
                ?>
                <div class="row">
                    <h3 style="margin-left : 50px;">
                        <?= $tag->affichage_tags ?>
                    </h3>
                </div>

                <div class="row">
                    <?php printPost($colType[0], $post[0], $db); ?>
                </div>
                <div class="row">
                    <?php 
                    printPost($colType[1], $post[1], $db);
                    printPost($colType[2], $post[2], $db); ?>
                </div>
                <div class="row">
                    <?php printPost($colType[3], $post[3], $db); ?>
                    <?php printPost($colType[4], $post[4], $db); ?>
                    <?php printPost($colType[5], $post[5], $db); ?>
                </div>
                <div class="row">
                    <?php printPost($colType[6], $post[6], $db); ?>
                    <?php printPost($colType[7], $post[7], $db); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</div>


</div>

<?php
include "modals.php";
require "inc/footer.php";
?>