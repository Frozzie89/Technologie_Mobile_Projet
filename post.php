<?php
require "inc/header.php";
require "inc/nav.php";

$post = $db->query("Select * from posts where id_posts = :id", ["id"=>$_GET['id']])->fetch();
$photo = $db->query("Select nom_photos from photos where id_posts = :post",["post" => $_GET["id"]])->fetch();
$commentaires = $db->query("Select * from commentaires where id_posts = :idPost", ["idPost"=> $_GET['id']])->fetchAll();
$likes = $db->query("Select * from likes where id_posts like :idPost", ["idPost"=> $_GET['id']])->fetchAll();

if (isset($_SESSION['auth']->pseudo_membres)){
    $membre = $db->query("Select * from membres where login_membres like :login", ["login"=>$_SESSION['auth']->login_membres])->fetch();
    $liked = $db->query("Select like_likes from likes where id_posts = :idPost and id_membres =:id_membres", ["idPost"=> $_GET['id'], "id_membres" => $membre->id_membres])->fetchAll();
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
            <img class="post-image" src="extranet/<?= $photo->nom_photos ?>" alt="ok">
            <?= $post->texte_posts ?>
            <div class="reaction-banner float-right" style="font-size: 20px;">
                <span class="comments"><i class="fas fa-comments"></i></span>
                <span id="nbComment"> <?= count($commentaires) ?> </span>
                <span class="like x-icon icon-button <?php if (!empty($liked)) echo "liked" ?>"><i class="fas fa-thumbs-up"></i></span>
                <span id="nbLike">  <?= count($likes) ?>  </span>
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
                    <div class="col-lg-12 coms">
                    <?php foreach ($commentaires as $key => $com) : ?>
                    <div class="single-com" id="<?= $com->id_commentaires ?>">
                    <?php $membre = $db->query("Select * from membres where id_membres = :id", ["id"=>$com->id_membres])->fetch(); ?>
                        <span class="pseudo-utilisateur text-secondary" style="margin-top: -20px;"><?= $membre->pseudo_membres ?></span>
                        <div class="comment-content" id="<?= $com->id_commentaires ?>">
                            <?php if ($ad) : ?>
                            <span class="ban icon-button float-right" id="<?= $com->id_commentaires ?>"> <i class="fas fa-ban"></i> </span>
                            <?php endif; ?>
                            <p class="comment" id="<?= $com->id_commentaires ?>"><?= $com->texte_commentaires ?></p>
                            <div class="edit-banner" id="<?= $com->id_commentaires ?>">
                                <span class="reply icon-button " id="<?= $com->id_commentaires ?>"><i class="fas fa-reply"></i> </span>
                                <?php if ($_SESSION['auth']->login_membres == $membre->login_membres) : ?>
                                <span class="edit x-icon icon-button " id="<?= $com->id_commentaires ?>"> <i class="fas fa-pen"></i> </span>
                                <span class="delete x-icon icon-button " id="<?= $com->id_commentaires ?>"> <i class="fas fa-trash-alt"></i> </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    </div>
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
    let editing = -1;
    $(document).ready(function () {
        $("#newComment").val("");
    });

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
                    plusComment();
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
    });

    function plusComment(){
        console.log($("#nbComment").text());
        let nbComment = parseInt($("#nbComment").text(), 10);
        $("#nbComment").text(++nbComment);
    }

    function minusComment(){
        console.log($("#nbComment").text());
        let nbComment = parseInt($("#nbComment").text(), 10);
        $("#nbComment").text(--nbComment);
    }

    $(".like").on("click", function (event) {
        console.log($("#nbLike").text());
        let nbLike = parseInt($("#nbLike").text(), 10);
        if ($(this).hasClass("liked")){
            $(this).removeClass("liked");
            --nbLike;
            $("#nbLike").text(nbLike);
            $.ajax({
                url: "deleteLike.php",
                method: "POST",
                data: {
                    postID : <?= $_GET['id'] ?>,
                    membreID : idMembre
                },
                dataType: "text",
                success: function () {
                    console.log("Don't like it");
                }
            });
        } else {
            $(this).addClass("liked");
            ++nbLike;
            $("#nbLike").text(nbLike);
            $.ajax({
                url: "addLike.php",
                method: "POST",
                data: {
                    postID : <?= $_GET['id'] ?>,
                    membreID : idMembre
                },
                dataType: "text",
                success: function () {
                    console.log("Like it");
                }
            });
        }
    });

    $(".ban").on("click", function (event) {
        let idOfComment = $(this).attr('id');
        if (confirm("Êtes-vous sûr de supprimer ce commentaire ?")) {
            $.ajax({
                url: "deleteComment.php",
                method: "POST",
                data: { commentID : idOfComment },
                dataType: "text",
                success: function () {
                    minusComment()
                    $('.coms div[id=' + idOfComment +']').remove();
                }
            });
        }
    });

    $(".reply").on("click", function (event) {
        console.log("click");
    });


    $(".edit").on("click", function (event) {
        console.log($(this).attr('id'));
        let idOfComment = $(this).attr('id');
        let currentDiv = $('.coms div[id=' + idOfComment +'] .comment-content');
        let currentComment = $('p[id=' + idOfComment +']');
        let editableComment = $("<textarea class='form-control' id='"+ idOfComment +"' rows='1' style='margin-bottom: 5px;'/>");
        //let updateButton = $("<button type='submit' class='btn btn-dark' id='updateComment' name='updateComment'>Modifier</button>");
        let updateDiv = $("<div class='update-div' id='"+idOfComment+"'></div>");
        updateDiv.append(editableComment);
        //updateDiv.append(updateButton);
        editableComment.val(currentComment.text());
        currentDiv.replaceWith(updateDiv);
        editableComment.focus();
        /** Need some work, focus out can bug (from top to bottom) */
        editableComment.on("focusout", function (event) {
            updateDiv.replaceWith(currentDiv);
            $(document).remove(updateDiv);
        });

        editableComment.on("keyup", function (event) {
            if (event.key == "Escape") {
                updateDiv.replaceWith(currentDiv);
                $(document).remove(updateDiv);
            }
            if (event.keyCode == 13 && event.shiftKey) {

            } else if (event.keyCode == 13){
                if (editableComment.val() !== ""){
                    $.ajax({
                        url: "editComment.php",
                        method: "POST",
                        data: {
                            commentID : idOfComment,
                            textComment : editableComment.val()
                        },
                        dataType: "json",
                        success: function (comment) {
                            console.log(comment);
                            updateDiv.replaceWith(currentDiv);
                            $(document).remove(updateDiv);
                            $('p[id=' + idOfComment +']').text(comment.texte_commentaires);
                        }
                    });
                }
            }
        });
    });

    $(".delete").on("click", function (event) {
        let idOfComment = $(this).attr('id');
        if (confirm("Êtes-vous sûr de supprimer ce commentaire ?")) {
            $.ajax({
                url: "deleteComment.php",
                method: "POST",
                data: { commentID : idOfComment },
                dataType: "text",
                success: function () {
                    minusComment();
                    $('.coms div[id=' + idOfComment +']').remove();
                }
            });
        }
    });


</script>


<?php
include "modals.php";
require "inc/footer.php";
?>

