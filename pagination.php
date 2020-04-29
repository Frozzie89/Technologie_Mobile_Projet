<?php
require "inc/autoload.php";
$db = App::getDatabase();
$nbppage = $_GET["nbppage"];
$offset = $_GET["offset"];


// $post_to_display = $db->query("SELECT * FROM posts WHERE id_tags = :id ORDER BY id_posts DESC LIMIT $nbppage OFFSET $offset", ["id"=>$_GET["tagID"]])->fetchAll();

$post_to_display = $db->query(
    "SELECT posts.*, 
    (SELECT COUNT(*) FROM commentaires WHERE id_posts = posts.id_posts) AS nbComments, 
    (SELECT COUNT(*) FROM likes WHERE id_posts = posts.id_posts) AS nbLikes 
    FROM posts WHERE posts.id_tags = :id ORDER BY posts.id_posts DESC LIMIT $nbppage OFFSET $offset", ["id"=>$_GET["tagID"]]
)->fetchAll();


echo json_encode($post_to_display);
?>