<?php
require "inc/header.php";
require "inc/nav.php";

$tagPage = $db->query("Select * from tags where id_tags = :id", ["id"=>$_GET['id']])->fetch();
?>
<!-- JS, jquery and stuff -->
<script src="assets/js/jquery-3.4.1.js"></script>
<script>window.jQuery || document.write('<script src="assets/js/jquery-3.4.1.js"><\/script>')</script>
<script src="assets/js/bootstrap.bundle.js"></script>
<script src="assets/js/script.js"></script>

<section id="tendance">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="title-page center-text">
                    <?= $tagPage->affichage_tags ?>
                </h1>
            </div>
            <div class="col-lg-8">
                <h2 id="title-tendance">
                    Les plus consultés
                </h2>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row post-tendance">
            <!-- Posts go here -->
        </div>
    </div>
</section>

<hr>

<section id="every-post">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h2 id="title-every-post">
                    <?= $tagPage->affichage_tags ?> : Tous nos articles
                </h2>
            </div>
            <div class="col-lg-4">
                <input id="searchbarPost" class="form-control" type="text" class="form-control" placeholder="Search..">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row post-every-post">
            <!-- Posts go here -->
        </div>
    </div>
</section>

<script>
    $(document).ready(function (){
        const csstendance = 'td';
        const csseverypost = 'evr';
        fetchData(<?= $_GET['id'] ?>, '.post-tendance', csstendance);
        fetchData(<?= $_GET['id'] ?>, '.post-every-post', csseverypost);
        /*
        $(document).on('click', '.btn-block', function(event) {
            event.preventDefault();
            let idPost = this.id;
            if(confirm("Etes vous sur de supprimer ce post ?"))
            {
                $.ajax({
                    url:"deletePost.php",
                    method:"POST",
                    data:{postID:idPost},
                    dataType:"text",
                    success:function(data){
                        $('.col-lg-3').remove();
                        fetchData(data);
                        //flash ou autre
                    }
                });
            }
        })
        */
    });

    function limitTextPost(texte_posts) {
        texte_posts = texte_posts.substring(0,50);
        texte_posts += "...";
        return texte_posts;
    }

    function fetchData(tagValue, selector, cssclass) {
        $.getJSON('fetchPostTendance.php', {tagID: tagValue, tendance : false}, function (posts) {
            //console.log(posts);
            let j = 0;
            $.each(posts, function (i, post) {

                $.getJSON('extranet/getPhotoOfPost.php', {postID: post.id_posts}, function (photo) {
                    let postText = limitTextPost(post.texte_posts);
                    $("<div class='col-lg-3 card-news-max-height "+cssclass+" " + post.id_tags + "'><div class='card card-height card-style'>" +
                        "<img class='card-img-top' src='extranet/" + photo.nom_photos + "' alt='ok'>" +
                        "<div class='card-body card-body-style'>" +
                        "<h5 class='card-title'>" + post.titre_posts + "</h5>" +
                        "<p class='card-text'>" + postText + "</p>" +
                        "<p class='tagPost'>" + post.id_tags + "</p>" +
                        "<a href='post.php?id=" + post.id_posts + "' class='btn btn-primary btn-lg card-btn-block'> Visionner </a>").appendTo($(selector));
                })
            })
        })

    }


    $("#searchbarPost").on("input", function() {
        var search = this.value;
        $('.evr').hide().each(function() {
            var text = $(this).find(".card-title:contains('"+search+"')");
            if (text.length) $(this).show();
        });
    });
</script>


<?php
require "inc/footer.php";
?>

