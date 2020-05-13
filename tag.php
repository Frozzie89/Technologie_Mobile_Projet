<?php
require "inc/header.php";
require "inc/nav.php";

$tagPage = $db->query("Select * from tags where id_tags = :id", ["id"=>$_GET['id']])->fetch();
$NB_POST = count($db->query("Select * from posts where id_tags = :id", ["id"=>$_GET['id']])->fetchAll());
$NB_PER_PAGE = 8;
$OFFSET = 0;
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
            <div class="col-lg-12">
                <div class="controls">
                    <button id="previous-arrow" class="btn btn-primary " type="submit"><i class="fa fa-angle-left"></i></button>
                    <button id="next-arrow" class="btn btn-primary " type="submit"><i class="fa fa-angle-right"></i></button>
                </div>
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
    let NB_POST = 0;
    const NB_PER_PAGE = 2;
    let OFFSET = 0;

    $(document).ready(function (){
        $("#next-arrow").prop("disabled", true);
        $("#previous-arrow").prop("disabled", true);
        const csstendance = 'td';
        const csseverypost = 'evr';
        fetchDataTag(<?= $_GET['id'] ?>, '.post-tendance', csstendance);
        //fetchDataTag(<?= $_GET['id'] ?>, '.post-every-post', csseverypost);

    });

    function limitTextPost(texte_posts) {
        texte_posts = texte_posts.substring(0,50);
        texte_posts += "...";
        return texte_posts;
    }

    function noPagination() {
        $.ajax({
            url:"pagination.php",
            method:"GET",
            data:{  tagID : <?= $_GET['id'] ?>,
                nbppage : NB_PER_PAGE,
                offset : OFFSET
            },
            dataType:"json",
            success:function(posts){
                displayPosts(posts);
            }
        });
    }

    function displayPosts(posts) {
        $('.evr').remove();
        $.each(posts, function (i, post) {
            $.getJSON('extranet/getPhotoOfPost.php', {postID: post.id_posts}, function (photo) {
                let postText = limitTextPost(post.texte_posts);
                $("<div class='col-lg-3 card-news-max-height evr " + post.id_tags + "'><div class='card card-height card-style'>" +
                    "<a href='post.php?id=" + post.id_posts + "'><img class='card-img-top' src='extranet/" + photo.nom_photos + "' alt='ok'>" +
                    "<div class='card-body card-body-style'>" +
                    "<h5 class='card-title'>" + post.titre_posts + "</h5>" +
                    "<p class='card-text'>" + postText + "</p>" +
                    "<p class='tagPost'>" + post.id_tags + "</p>" +
                    "<div class='tagLikesComments' style='position:absolute'>"+
                    "<i class='far fa-arrow-alt-circle-up fa-2x'></i>"+
                    "<h3 style='margin-left:5px'>"+ post.nbLikes +"</h3>"+
                    "<i class='far fa-comments fa-2x' style='margin-left:15px'></i>"+
                    "<h3 style='margin-left:5px'>" + post.nbComments +"</h3></div>").appendTo($('.post-every-post'));
            })
        })
    }

    function setUpPagination() {
        $("#next-arrow").prop("disabled", false);
        $.ajax({
            url:"pagination.php",
            method:"GET",
            data:{  tagID : <?= $_GET['id'] ?>,
                    nbppage : NB_PER_PAGE,
                    offset : OFFSET
            },
            dataType:"json",
            success:function(posts){
                displayPosts(posts);
            }
        });
    }

    function fetchDataTag(tagValue, selector, cssclass) {
        $.getJSON('fetchPostTendance.php', {tagID: tagValue, tendance : false}, function (posts) {
            var styleCard = Cookies.get('theme') == 'light' ? ['white', '#e1e3e1'] : ['#1A1A1B', 'black'];
            //console.log(Cookies.get('theme') +' '+styleCard[0]+' '+ styleCard[1]);
            NB_POST = posts.length;
            $.each(posts, function (i, post) {
                $.getJSON('extranet/getPhotoOfPost.php', {postID: post.id_posts}, function (photo) {
                    let postText = limitTextPost(post.texte_posts);
                    $("<div class='col-lg-3 card-news-max-height td " + post.id_tags + "'><div class='card card-height card-style' style='background-color: "+ styleCard[0]+ "; color: "+ styleCard[1]+">" +
                        "<a href='post.php?id=" + post.id_posts + "'><img class='card-img-top' src='extranet/" + photo.nom_photos + "' alt= " + post.titre_posts +" >" +
                        "<div class='card-body card-body-style'>" +
                        "<h5 class='card-title'>" + post.titre_posts + "</h5>" +
                        "<p class='card-text'>" + postText + "</p>" +
                        "<p class='tagPost'>" + post.id_tags + "</p>" +
                        "<div class='tagLikesComments' style='position:absolute'>"+
                        "<i class='far fa-arrow-alt-circle-up fa-2x' ></i>"+
                        "<h3 style='margin-left:5px'>"+ post.nbLikes +"</h3>"+
                        "<i class='far fa-comments fa-2x' style='margin-left:15px'></i>"+
                        "<h3 style='margin-left:5px'>" + post.nbComments+"</h3></div>").appendTo($('.post-tendance'));
                })
            })
            if (NB_POST <= NB_PER_PAGE){
                noPagination();
            } else {
                setUpPagination(NB_POST, NB_PER_PAGE, OFFSET);
            }
        })
    }


    $("#searchbarPost").on("input", function() {
        var search = this.value;
        $('.evr').hide().each(function() {
            var text = $(this).find(".card-title:contains('"+search+"')");
            if (text.length) $(this).show();
        });
    });

    function checkPreviousArrow() {
        if (OFFSET <= 0){
            $("#previous-arrow").prop("disabled", true);
        } else {
            $("#previous-arrow").prop("disabled", false);
        }
    }

    $("#previous-arrow").on("click", function(event) {
        event.preventDefault();
        OFFSET -= NB_PER_PAGE;
        $("#next-arrow").prop("disabled", false);
        $.ajax({
            url:"pagination.php",
            method:"GET",
            data:{  tagID : <?= $_GET['id'] ?>,
                nbppage : NB_PER_PAGE,
                offset : OFFSET
            },
            dataType:"json",
            success:function(posts){
                displayPosts(posts);
                checkPreviousArrow();
            }
        });
    });

    function checkNextArrow() {
        if (OFFSET > NB_POST - 2){
            $("#next-arrow").prop("disabled", true);
        } else {
            $("#next-arrow").prop("disabled", false);
        }
    }

    $("#next-arrow").on("click", function(event) {
        event.preventDefault();
        OFFSET += NB_PER_PAGE;
        $("#previous-arrow").prop("disabled", false);
        $.ajax({
            url:"pagination.php",
            method:"GET",
            data:{  tagID : <?= $_GET['id'] ?>,
                nbppage : NB_PER_PAGE,
                offset : OFFSET
            },
            dataType:"json",
            success:function(posts){
                displayPosts(posts);
                checkNextArrow();
            }
        });
    });


</script>


<?php
include "modals.php";
require "inc/footer.php";
?>

