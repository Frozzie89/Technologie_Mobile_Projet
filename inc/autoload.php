<?php
spl_autoload_register('app_autoload');

$main_url = "http://localhost:".$_SERVER["SERVER_PORT"]."/BTI/FAA/";
$extranet_url = "http://localhost:".$_SERVER["SERVER_PORT"]."/BTI/FAA/extranet/";
$current_url = "localhost:".$_SERVER["SERVER_PORT"]."/".$_SERVER["REQUEST_URI"];

function app_autoload($class){
    $path =  realpath("");
    $p = dirname(__DIR__);

    require "$p\\class\\$class.php";
}

ini_set('display_errors',1);
error_reporting(E_ALL);