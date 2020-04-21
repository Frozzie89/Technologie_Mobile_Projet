<?php
require "inc/autoload.php";

$db = App::getDatabase();
$auth = App::getAuth();
$session = Session::getInstance();

$id_user = $db->query("SELECT id_membres FROM membres WHERE login_membres = :loginMembre", ["loginMembre" => $_SESSION['auth']->login_membres])->fetch();

if ($action == "upvote")
{

}
else if ($action == "downvote")
{

}

?>