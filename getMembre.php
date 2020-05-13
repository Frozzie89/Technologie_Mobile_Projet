<?php
require "inc/autoload.php";
$db = App::getDatabase();

$membre = $db->query("SELECT * FROM membres WHERE login_membres like :login", ["login"=>$_GET["membreLogin"]])->fetch();

echo json_encode($membre);

?>
