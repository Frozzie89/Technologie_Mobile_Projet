<?php
require "../inc/autoload.php";
$db = App::getDatabase();

$photo = $db->query("Select nom_photos from photos where id_posts = :post",["post" => $_GET["postID"]])->fetch();

echo json_encode($photo);
?>
