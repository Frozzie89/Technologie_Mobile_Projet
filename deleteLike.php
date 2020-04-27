<?php
require "inc/autoload.php";
$db = App::getDatabase();

$db->query("DELETE FROM likes where id_posts =:id and id_membres =:id_membres", ["id" => $_POST["postID"], "id_membres" => $_POST["membreID"]]);

?>
