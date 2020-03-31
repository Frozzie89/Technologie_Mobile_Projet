<?php
spl_autoload_register('app_autoload');

$main_url = "http://localhost:".$_SERVER["SERVER_PORT"]."/BTI/FAA/";
$extranet_url = "http://localhost:".$_SERVER["SERVER_PORT"]."/BTI/FAA/extranet/";
$current_url = "localhost:".$_SERVER["SERVER_PORT"]."/".$_SERVER["REQUEST_URI"];

function app_autoload($class){
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root\\TI\\Technologie_Mobile_Projet\\class\\$class.php";
}

ini_set('display_errors',1);
error_reporting(E_ALL);