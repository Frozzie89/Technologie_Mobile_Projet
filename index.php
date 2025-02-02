<?php
require "inc/header.php";
require "inc/nav.php";

function printPost($col, $post) {
    if (isset($post))
    {
        $db = App::getDatabase();
        $nbComments = $db->query("SELECT COUNT(*) AS val FROM commentaires WHERE id_posts = :id", ["id"=>$post->id_posts])->fetch();
        $likes = $db->query("SELECT COUNT(*) AS likes FROM likes WHERE id_posts like :idPost", ["idPost"=> $post->id_posts])->fetch();
        $img = $db->query("SELECT nom_photos AS img FROM photos WHERE id_posts = :id", ["id"=>$post->id_posts])->fetch();

        $shortText = (strlen($post->texte_posts)<= 230) ? $post->texte_posts : substr($post->texte_posts,0,230) . ' ...';

        echo "<div class=\"". $col . " indexPostCard \">
                <div class=\"card border-secondary\">
                <a href='post.php?id=". $post->id_posts. " '>
                    <img class=\"card-img-top border-bottom border-secondary\"
                        src=\"extranet/". $img->img ."\"
                        alt=\"Card image cap\">
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">" .$post->titre_posts . "</h4>
                        <p class=\"card-text\">". $shortText ."</p>
                        <div class=\"bottom-card-index\">
                            <i class=\"far fa-arrow-alt-circle-up fa-2x\"></i>
                            <h3>". $likes->likes ."</h3>

                            <i class=\"far fa-comments fa-2x\" style=\"margin-left:15px\"></i>
                            <h3 style=\"margin-left:5px\">". $nbComments->val ."</h3>
                        </div>
                    </div>  
                    </a>             
                </div>
                </a>
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
        <div class="carousel-inner" role="listbox">
            <?php
            $colType = array("col", "col-lg-5", "col-lg-7", "col-log-4, col-lg-4", "col-lg-4", "col-lg-4", "col-lg-7", "col-lg-5");
            $post = array(); 
            foreach($tags as $key=>$tag) : 
        ?>
            <div class="carousel-item <?php if($tag->id_tags == 1) echo "active" ?> my-auto">
                <?php
                $post = $db->query("SELECT * FROM posts WHERE id_tags = :tag ORDER BY id_posts DESC LIMIT 8", ["tag"=>$tag->id_tags])->fetchAll();
                ?>
                <div class="row">
                    <div class="col">
                        <!--Boutons de contrôle TOP -->
                        <div class="input-group input-group-lg carousel-tag-selector">
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
                <!-- 8 posts par tag -->
                <div class="row">
                    <?php
                for ($i=0; $i < 8; $i++) 
                { 
                    if (in_array($i, array(1, 3, 6))) echo "</div> <div class=\"row\">";
                    if(isset($post[$i])) printPost($colType[$i], $post[$i]);
                }
                ?>
                </div>
                <br><br><br>
                <div class="row">
                    <div class="col" style="position:absolute; bottom:0">
                    <hr>
                        <!--Boutons de contrôle BOTTOM -->
                        <div class="input-group input-group-lg carousel-tag-selector">
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