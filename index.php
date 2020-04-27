<!-- Canvas d'une page web, -->
<?php
require "inc/header.php";
require "inc/nav.php";

function printPost($col, $post, $db) {
    if (isset($post))
    {
        $nbComments = $db->query("SELECT COUNT(*) AS val FROM commentaires WHERE id_posts = :id", ["id"=>$post->id_posts])->fetch();
        $img = $db->query("SELECT nom_photos AS img FROM photos WHERE id_posts = :id", ["id"=>$post->id_posts])->fetch();

        if (strlen($post->texte_posts)<= 230)
            $shortText = $post->texte_posts;
        else
            $shortText = substr($post->texte_posts,0,230) . ' ...';

        echo "<div class=\"". $col . " indexPostCard\">
            <div class=\"card border-secondary\">
                <img class=\"card-img-top border-bottom border-secondary\"
                    src=\"extranet/". $img->img ."\"
                    alt=\"Card image cap\">
                <div class=\"card-body\">
                    <h4 class=\"card-title\">" .$post->titre_posts . "</h4>
                    <p class=\"card-text\">". $shortText ."</p>
                    <div class=\"bottom-card-index\">
                        <i class=\"fas fa-eye fa-2x\"></i>
                        <h3>". $post->nbVue_posts ."</h3>

                        <i class=\"far fa-arrow-alt-circle-up fa-2x\" style=\"margin-left:15px\"></i>
                        <h3>". $post->nbLike_posts ."</h3>

                        <h3 style=\"float: right; margin-left:5px\">". $nbComments->val ."</h3>
                        <i class=\"far fa-comments fa-2x\" style=\"float: right;\"></i>
                    </div>
                </div>
            </div>
        </div>";
    }
}
?>

<section id="homePage">
    <div class="container">
        <div class="col-lg-12">
            <img src="assets/Logo.svg" alt="The Good News" class="title-page indexLogo center">
            <h1 class="title-page center-text">Les dernières publications</h1>
        </div>
    </div>
</section>


<!-- Carousel -->
<div class="container">
    <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">
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
                    <div class="col">
                        <!--Boutons de contrôle TOP -->
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text btn-floating" id="basic-addon1" href="#multi-item-example"
                                    data-slide="prev"><i class="fa fa-chevron-left"></i></span>
                            </div>

                            <input type="text" class="form-control" value="<?= $tag->affichage_tags ?>"
                                aria-label="Username" disabled aria-describedby="basic-addon1">

                            <div class="input-group-append btn-floating">
                                <span class="input-group-text" id="basic-addon1" href="#multi-item-example"
                                    data-slide="next"><i class="fa fa-chevron-right"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

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
                <div class="row">
                    <div class="col">
                        <!--Boutons de contrôle BOTTOM -->
                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text btn-floating" id="basic-addon1" href="#multi-item-example"
                                    data-slide="prev"><i class="fa fa-chevron-left"></i></span>
                            </div>

                            <input type="text" class="form-control" value="<?= $tag->affichage_tags ?>"
                                aria-label="Username" disabled aria-describedby="basic-addon1">

                            <div class="input-group-append btn-floating">
                                <span class="input-group-text" id="basic-addon1" href="#multi-item-example"
                                    data-slide="next"><i class="fa fa-chevron-right"></i></span>
                            </div>
                        </div>
                    </div>
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