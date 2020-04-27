<?php
require "inc/autoload.php";
$db = App::getDatabase();

$db->query("INSERT INTO likes (like_likes, id_posts, id_membres) VALUES 
(:l, :id_posts, :id_membres)", ["l" => 1, "id_posts" => $_POST["postID"], "id_membres" => $_POST["membreID"]]);

?>
