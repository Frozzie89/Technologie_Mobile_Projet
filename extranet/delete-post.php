<?php
require "header.php";
require "nav.php";

if(isset($_GET)){
    $id = $_GET['id'];
    //App::debug($id);
    $db->query("DELETE FROM photos WHERE id_posts = :id",["id" =>$id]);
    $db->query("DELETE FROM posts WHERE id_posts = :id",["id" =>$id]);

    App::redirect("gestion-post.php");
    $session->setFlash('success', "Post supprimé avec succès !");
}
?>

