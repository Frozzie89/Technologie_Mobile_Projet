<?php
require "inc/autoload.php";
$db = App::getDatabase();

$db->query("DELETE FROM commentaires where id_commentaires =:id", ["id" => $_POST["commentID"]]);

?>