<?php
require "inc/autoload.php";
$db = App::getDatabase();

$db->query("UPDATE commentaires SET texte_commentaires =:texte where id_commentaires =:id", ["texte" => $_POST["textComment"], "id" => $_POST["commentID"]]);

$commentaire = $db->query("Select * from commentaires where id_commentaires =:idCommentaire", ["idCommentaire" => $_POST["commentID"]])->fetch();
echo json_encode($commentaire);
?>
