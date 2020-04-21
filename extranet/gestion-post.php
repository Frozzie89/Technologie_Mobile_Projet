<?php
require "header.php";
require "nav.php";

?>
<script src="../assets/js/jquery-3.4.1.js"></script>
<script>window.jQuery || document.write('<script src="../assets/js/jquery-3.4.1.js"><\/script>')</script>
<script src="../assets/js/bootstrap.bundle.js"></script>
<script src="../assets/js/script.js"></script>

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

    </div>
</div>

<script>
    function limitTextPost(texte_posts) {
        texte_posts = texte_posts.substring(0,50);
        texte_posts += "...";
        return texte_posts;
    }

    function bindH2ToSelect(nom_tag) {
        $('#titleBindToSelect').text(nom_tag);
    }

    function fetchData(tagValue) {
        $.getJSON('getPostsByTag.php', {tagID: tagValue}, function (posts) {
            //console.log(posts);
            let j = 0;
            $.each(posts, function (i, post) {

                $.getJSON('getPhotoOfPost.php', {postID: post.id_posts}, function (photo) {
                    let postText = limitTextPost(post.texte_posts);
                    console.log(postText);
                    $("<div class='col-lg-3 card-news-max-height " + post.id_tags + "'><div class='card card-height'>" +
                        "<img class='card-img-top' src='" + photo.nom_photos + "' alt='ok'>" +
                        "<div class='card-body'>" +
                        "<h5 class='card-title'>" + post.titre_posts + "</h5>" +
                        "<p class='card-text'>" + postText + "</p>" +
                        "<p class='tagPost'>" + post.id_tags + "</p>" +
                        "<a href='update-post.php?id=" + post.id_posts + "' class='btn btn-primary btn-lg card-btn-left'> Update </a>" +
                        "<a href='https://api.jquery.com/on/' id='" + post.id_posts + "' class='btn btn-primary btn-lg float-right card-btn-right'> Delete </a>").appendTo($(".maindiv"));
                    // changer pour focntionne : delete
                    // "<a href='delete-post.php?id="+post.id_posts+"' class='btn btn-primary btn-lg float-right card-btn-right'> Delete </a>"
                })
            })
        })

    }

    $(document).ready(function (){
        $(".alert").show().delay(3000).fadeOut(500);
        // Load every Posts
        fetchData(0);
        // On change select -> remove all cards and add those whose tags corresponds
        $("#tagSelector").change(function () {
            $("#searchbarPost").val('');
            bindH2ToSelect($(this). children("option:selected").text());
            $('.col-lg-3').remove();
            let tagID = $(this). children("option:selected"). val();
            fetchData(tagID);

        })

        $(document).on('click', '.card-btn-right', function(event) {
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
    });

    $("#searchbarPost").on("input", function() {
        var search = this.value;
        $('.col-lg-3').hide().each(function() {
            var text = $(this).find(".card-title:contains('"+search+"')");
            if (text.length) $(this).show();
        });
    });
</script>


<?php
require "footer.php";
?>
