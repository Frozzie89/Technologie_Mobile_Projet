<?php
require "inc/autoload.php";
$db = App::getDatabase();

$db->query("INSERT INTO commentaires (texte_commentaires, id_posts, id_membres) VALUES 
(:texte, :idPost, :idMembre)", ["texte" => $_POST["textComment"], "idPost" => $_POST["postID"], "idMembre" => $_POST["membreID"]]);

$commentaire = $db->query("Select * from commentaires where id_commentaires =:idCommentaire", ["idCommentaire" => $db->lastInsertID()])->fetch();
echo json_encode($commentaire);
?>