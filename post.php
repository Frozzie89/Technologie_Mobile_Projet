<?php
require "inc/header.php";
require "inc/nav.php";

$post = $db->query("Select * from posts where id_posts = :id", ["id"=>$_GET['id']])->fetch();
$commentaires = $db->query("Select * from commentaires where id_posts like :idPost", ["idPost"=> $_GET['id']])->fetchAll();
if (isset($_SESSION['auth']->pseudo_membres)){
    $membre = $db->query("Select * from membres where login_membres like :login", ["login"=>$_SESSION['auth']->login_membres])->fetch();
    $ad = isAdmin($db, $membre->id_membres);
}
function isAdmin($db, $idMembre){
    $admin = $db->query("Select * from administrateurs where id_membres like :id", ["id"=> $idMembre])->fetch();
    if (empty($admin)){
        return false;
    }
    return true;
}

?>
<!-- Main Quill library -->
<script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- JS, jquery and stuff -->
<script src="assets/js/jquery-3.4.1.js"></script>
<script>window.jQuery || document.write('<script src="assets/js/jquery-3.4.1.js"><\/script>')</script>
<script src="assets/js/bootstrap.bundle.js"></script>
<script src="assets/js/script.js"></script>


<div class="container">
    <div class="row">
        <div class="col-lg-9 article">
            <h1 class="title-page">
                <?= $post->titre_posts ?>
            </h1>
            <p class="lead text-muted autheur">Ecrit par <?= $post->autheur_posts ?></p>
            <?= $post->texte_posts ?>
            <div class="reaction-banner float-right">
                <span class="comments"><i class="fas fa-comments"></i> Commentaires </span>
                <span class="share"><i class="fas fa-share"></i> Partager </span>
                <span class="like"><i class="fas fa-caret-up"></i> </span>
                <span class="dislike"><i class="fas fa-caret-down"></i></span>
            </div>
        </div>
        <div class="col-lg-3 links">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9 commentaires">
            <h3 style="margin-bottom: 30px;">Commentaires</h3><br>
            <!--<hr style="margin-top: -10px; width: 100%;"><br>-->

                <?php if (!empty($commentaires)) : ?>
                    <?php foreach ($commentaires as $key => $com) : ?>
                    <?php $membre = $db->query("Select * from membres where id_membres = :id", ["id"=>$com->id_membres])->fetch(); ?>
                    <div class="col-lg-12 coms">
                        <span class="pseudo-utilisateur text-secondary" style="margin-top: -20px;"><?= $membre->pseudo_membres ?></span><br>
                        <p class="comment"><?= $com->texte_commentaires ?></p>
                    </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="no-comment"> Aucun commentaire </div>
                <?php endif; ?>

            <?php if (isset($_SESSION['auth'])) : ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <textarea class="form-control" id="newComment" name="newComment" rows="3" style="resize: vertical;"></textarea>
                </div>
                <div class="form-group" style="float: right;">
                    <button type="submit" class="btn btn-dark" id="submitNewComment" name="submitNewComment">Ajouter un nouveau post</button>
                </div>
            </form>
            <?php else : ?>
                <h5 class="login-to-comment">Rejoignez la communauté pour commenter</h5>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    let idPost = <?= $_GET["id"] ?>;
    let idMembre = <?= $membre->id_membres ?>;
    let pseudoMembre = "<?= $membre->pseudo_membres ?>";
    $(document).ready(function () {
        $("#newComment").val("");
    })
    $("#submitNewComment").on("click", function (event) {
        event.preventDefault();
        let textCommentaire = $("#newComment").val();
        console.log(idPost);
        console.log(idMembre);
        console.log(textCommentaire);
        $("#newComment").removeClass('comment-success');
        $("#newComment").removeClass('comment-error');
        //$("#newComment").addClass('border-comment');
        if (textCommentaire !== ""){
            $("#newComment").addClass('comment-success');
            setTimeout(function() {
                $("#newComment").removeClass('comment-success');
            }, 4000);
            $.ajax({
                url: "addComment.php",
                method: "POST",
                data: {
                    postID: idPost,
                    membreID : idMembre,
                    textComment : textCommentaire
                },
                dataType: "json",
                success: function (comment) {
                    $("#newComment").val("");
                    console.log(comment);
                    $("<span class='pseudo-utilisateur text-secondary' style='margin-top: -20px;'>" + pseudoMembre + "</span><br>" +
                        "<p class='comment'>" + comment.texte_commentaires + "</p>").appendTo($(".coms"));
                }
            });
        } else {
            $("#newComment").addClass('comment-error');
            setTimeout(function() {
                $("#newComment").removeClass('comment-error');
            }, 4000);
        }
    })
</script>


<?php
include "modals.php";
require "inc/footer.php";
?>

