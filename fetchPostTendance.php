<?php
require "inc/autoload.php";
$db = App::getDatabase();

if ($_GET["tagID"] > 0 ){
    $posts = $db->query("Select * from posts where id_tags = :tag order by id_posts limit 2",["tag" => $_GET["tagID"]])->fetchAll();
} else {
    $posts = $db->query("Select * from posts order by nbVue_posts, nbLike_posts, id_posts limit 2")->fetchAll();
}

echo json_encode($posts);
?>
