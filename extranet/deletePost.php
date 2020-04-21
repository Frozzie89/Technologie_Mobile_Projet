<?php
require "../inc/autoload.php";
$db = App::getDatabase();

$db->query("DELETE FROM photos WHERE id_posts = :id",["id" =>$_POST["postID"]]);
$db->query("DELETE FROM posts WHERE id_posts = :id",["id" =>$_POST["postID"]]);
$tagtag = $db->query("Select * from posts where id_posts =:id", ["id" =>$_POST["postID"]]);

echo $tagtag->id_tags;
?>