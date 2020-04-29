<?php
require "inc/autoload.php";
$db = App::getDatabase();

if ($_GET["tagID"] > 0 ){
    // $posts = $db->query("Select * from posts where id_tags = :tag order by id_posts limit 8",["tag" => $_GET["tagID"]])->fetchAll();
    $posts = $db->query(
    "SELECT posts.*, 
    (SELECT COUNT(*) FROM commentaires WHERE id_posts = posts.id_posts) AS nbComments, 
    (SELECT COUNT(*) FROM likes WHERE id_posts = posts.id_posts) AS nbLikes 
    FROM posts WHERE posts.id_tags = :id ORDER BY posts.id_posts DESC LIMIT 8", ["id"=>$_GET["tagID"]]
    )->fetchAll();
} else {
    // $posts = $db->query("Select * from posts order by nbVue_posts, nbLike_posts, id_posts limit 2")->fetchAll();
    $posts = $db->query(
    "SELECT posts.*, 
    (SELECT COUNT(*) FROM commentaires WHERE id_posts = posts.id_posts) AS nbComments, 
    (SELECT COUNT(*) FROM likes WHERE id_posts = posts.id_posts) AS nbLikes 
    FROM posts WHERE posts.id_tags = :id ORDER BY posts.id_posts DESC LIMIT 2", ["id"=>$_GET["tagID"]]
    )->fetchAll();
}

echo json_encode($posts);
?>
