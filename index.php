<!-- Canvas d'une page web, -->
<?php
require "inc/header.php";
require "inc/nav.php";

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



<div class="container">

    <!--Carousel Wrapper-->
    <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

        <!--Controls-->
        <div class="controls-top">
            <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
            <a class="btn-floating" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>
        </div>
        <!--/.Controls-->

        <!--Slides-->
        <div class="carousel-inner" role="listbox">

            <!--First slide-->
            <div class="carousel-item active my-auto">

                <div class="row">
                    <div class="col">
                        <div class="card border-secondary">
                            <img class="card-img-top border-bottom border-secondary"
                                src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(34).jpg"
                                alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the
                                    card's content.</p>
                                <i class="fas fa-eye fa-2x"></i>
                                <h3>0</h3>

                                <i class="far fa-arrow-alt-circle-up fa-2x" style="margin-left:15px"></i>
                                <h3>0</h3>

                                <h3 style="float: right; margin-left:5px">0</h3>
                                <i class="far fa-comments fa-2x" style="float: right;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card lg-2 border-secondary">
                            <img class="card-img-top border-bottom border-secondary"
                                src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(34).jpg"
                                alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the
                                    card's content.</p>
                                <i class="fas fa-eye fa-2x"></i>
                                <h3>0</h3>

                                <i class="far fa-arrow-alt-circle-up fa-2x" style="margin-left:15px"></i>
                                <h3>0</h3>

                                <h3 style="float: right; margin-left:5px">0</h3>
                                <i class="far fa-comments fa-2x" style="float: right;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card lg-2 border-secondary">
                            <img class="card-img-top border-bottom border-secondary"
                                src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(34).jpg"
                                alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the
                                    card's content.</p>
                                <i class="fas fa-eye fa-2x"></i>
                                <h3>0</h3>

                                <i class="far fa-arrow-alt-circle-up fa-2x" style="margin-left:15px"></i>
                                <h3>0</h3>

                                <h3 style="float: right; margin-left:5px">0</h3>
                                <i class="far fa-comments fa-2x" style="float: right;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card lg-2 border-secondary">
                            <img class="card-img-top border-bottom border-secondary"
                                src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(34).jpg"
                                alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the
                                    card's content.</p>
                                <i class="fas fa-eye fa-2x"></i>
                                <h3>0</h3>

                                <i class="far fa-arrow-alt-circle-up fa-2x" style="margin-left:15px"></i>
                                <h3>0</h3>

                                <h3 style="float: right; margin-left:5px">0</h3>
                                <i class="far fa-comments fa-2x" style="float: right;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card lg-2 border-secondary">
                            <img class="card-img-top border-bottom border-secondary"
                                src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(34).jpg"
                                alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the
                                    card's content.</p>
                                <i class="fas fa-eye fa-2x"></i>
                                <h3>0</h3>

                                <i class="far fa-arrow-alt-circle-up fa-2x" style="margin-left:15px"></i>
                                <h3>0</h3>

                                <h3 style="float: right; margin-left:5px">0</h3>
                                <i class="far fa-comments fa-2x" style="float: right;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card lg-2 border-secondary">
                            <img class="card-img-top border-bottom border-secondary"
                                src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(34).jpg"
                                alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the
                                    card's content.</p>
                                <i class="fas fa-eye fa-2x"></i>
                                <h3>0</h3>

                                <i class="far fa-arrow-alt-circle-up fa-2x" style="margin-left:15px"></i>
                                <h3>0</h3>

                                <h3 style="float: right; margin-left:5px">0</h3>
                                <i class="far fa-comments fa-2x" style="float: right;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card lg-2 border-secondary">
                            <img class="card-img-top border-bottom border-secondary"
                                src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(34).jpg"
                                alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the
                                    card's content.</p>
                                <i class="fas fa-eye fa-2x"></i>
                                <h3>0</h3>

                                <i class="far fa-arrow-alt-circle-up fa-2x" style="margin-left:15px"></i>
                                <h3>0</h3>

                                <h3 style="float: right; margin-left:5px">0</h3>
                                <i class="far fa-comments fa-2x" style="float: right;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card lg-2 border-secondary">
                            <img class="card-img-top border-bottom border-secondary"
                                src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(34).jpg"
                                alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the
                                    card's content.</p>
                                <i class="fas fa-eye fa-2x"></i>
                                <h3>0</h3>

                                <i class="far fa-arrow-alt-circle-up fa-2x" style="margin-left:15px"></i>
                                <h3>0</h3>

                                <h3 style="float: right; margin-left:5px">0</h3>
                                <i class="far fa-comments fa-2x" style="float: right;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--/.First slide-->

        <!--Second slide-->

        <!--/.Second slide-->

        <!--Third slide-->


    </div>
    <!--/.Third slide-->


</div>
<!--/.Slides-->

</div>
<!--/.Carousel Wrapper-->


</div>
<!-- 
<?php
foreach($db->query("SELECT * FROM posts ORDER BY id_posts DESC")->fetchAll() as $key => $post) :
    $img = $db->query("SELECT * FROM photos WHERE id_posts = :id", ["id"=>$post->id_posts])->fetch();

    $nbComments = $db->query("SELECT COUNT(*) AS nbComments FROM commentaires WHERE id_posts = :id",["id"=>$post->id_posts])->fetch();

    $nbVotes =$db->query("SELECT COUNT(*) AS nbVotes FROM likes WHERE id_posts = :id",["id"=>$post->id_posts])->fetch();
?>
<div class="card border-secondary" id="indexPost">
    <img class="card-img-top border-bottom border-secondary" src=<?= "extranet/" . $img->nom_photos ?>>
    <div class="card-body">
        <h5 class="card-title"><b><?= $post->titre_posts ?></b></h5>
        <p class="card-text">
            <?php
            if (strlen($post->texte_posts)<= 230)
                $shortText = $post->texte_posts;
            else
                $shortText = substr($post->texte_posts,0,230) . '...';
            echo $shortText;
            ?></p>

        <i class="fas fa-eye fa-2x"></i>
        <h3><?= $post->nbVue_posts ?></h3>

        <i class="far fa-arrow-alt-circle-up fa-2x" style="margin-left:15px"></i>
        <h3><?= $nbVotes->nbVotes ?></h3>


        <h3 style="float: right; margin-left:5px"><?= $nbComments->nbComments ?></h3>
        <i class="far fa-comments fa-2x" style="float: right;"></i>

    </div>
</div>

<?php endforeach; ?> -->


<?php
include "modals.php";
require "inc/footer.php";
?>