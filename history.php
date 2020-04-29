<?php
require "inc/header.php";
require "inc/nav.php";

$totPostLike = $db->query("SELECT COUNT(*) AS val FROM likes WHERE id_membres = :idUser", ["idUser"=>$_SESSION['auth']->id_membres])->fetch();

$totPostCommented = $db->query("SELECT COUNT(*) AS val FROM likes WHERE id_membres = :idUser", ["idUser"=>$_SESSION['auth']->id_membres])->fetch();
?>

<section id="homePage">
    <div class="container">
        <div class="col-lg-12">
            <h1 class="title-page center-text">Historique</h1>
        </div>
    </div>
</section>

<div class="form-group container">
    <div class="accordion md-accordion accordion-blocks" role="tablist" aria-multiselectable="true"
        id="accordionExample">
        <div class="row">
            <div class="card col">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne">
                            Publications likées <?= "(".$totPostLike->val.")" ?>
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body fixHead">
                        <table class="table">
                            <?php
                            foreach($db->query("SELECT id_posts FROM likes WHERE id_membres = :idUser ORDER BY id_likes DESC", ["idUser"=>$_SESSION['auth']->id_membres])->fetchAll() as $key=>$like)
                            {
                                $post = $db->query("SELECT id_posts, titre_posts FROM posts WHERE id_posts = :idPost", ["idPost"=>$like->id_posts])->fetch();
                                $totalPostLikes = $db->query("SELECT COUNT(*) AS val FROM likes WHERE id_posts like :idPost", ["idPost"=> $post->id_posts])->fetch();
                                $totalPostComments = $db->query("SELECT COUNT(*) AS val FROM commentaires WHERE id_posts = :id", ["id"=>$post->id_posts])->fetch();

                                $shortPostTitre = (strlen($post->titre_posts)<= 65) ? $post->titre_posts : substr($post->titre_posts,0,65) . ' ...';

                                echo "
                                <tr>
                                    <td><a href=\"post.php?id=". $post->id_posts.  "\"><b>". $shortPostTitre . "</b></a></td>
                                    <td><h3>" . $totalPostLikes->val . "</h3><i class=\"far fa-arrow-alt-circle-up fa-2x\"></i></td>
                                    <td><h3>". $totalPostComments->val . "</h3><i class=\"far fa-comments fa-2x\"></i></td>
                                </tr>
                                ";
                            }
                        ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card col">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Publications commentées <?= "(".$totPostCommented->val.")" ?>
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body fixHead">
                        <table class="table tableFixHead">
                            <?php
                            foreach($db->query("SELECT id_posts, texte_commentaires FROM commentaires WHERE id_membres = :idUser ORDER BY id_commentaires DESC", ["idUser"=>$_SESSION['auth']->id_membres])->fetchAll() as $key=>$comment)
                            {
                                $post = $db->query("SELECT id_posts, titre_posts FROM posts WHERE id_posts = :idPost", ["idPost"=>$comment->id_posts])->fetch();
                                $totalPostLikes = $db->query("SELECT COUNT(*) AS val FROM likes WHERE id_posts like :idPost", ["idPost"=> $post->id_posts])->fetch();
                                $totalPostComments = $db->query("SELECT COUNT(*) AS val FROM commentaires WHERE id_posts = :id", ["id"=>$post->id_posts])->fetch();

                                $shortPostTitre = (strlen($post->titre_posts)<= 65) ? $post->titre_posts : substr($post->titre_posts,0,65) . ' ...';

                                $shortCommentaire = (strlen($comment->texte_commentaires)<= 40) ? $comment->texte_commentaires : substr($comment->texte_commentaires,0,40) . ' ...';

                                echo "
                                <tr>
                                    <td><a href=\"post.php?id=". $post->id_posts.  "\"><b>". $shortPostTitre . "</b></a></td>
                                    <td>" . $shortCommentaire . "</td>
                                    <td><h3>" . $totalPostLikes->val . "</h3><i class=\"far fa-arrow-alt-circle-up fa-2x\"></i></td>
                                    <td><h3>". $totalPostComments->val . "</h3><i class=\"far fa-comments fa-2x\"></i></td>
                                </tr>
                                ";
                            }
                        ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include "modals.php";
require "inc/footer.php";
?>