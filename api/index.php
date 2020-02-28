<?php
require '../controller/controller.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//$uri = explode( '/', $_GET["request"]);
//if($_SERVER["REQUEST_URI"]=="/vp/"){
//  include("public/index.html");;
//  exit();
//}

////var_dump($uri);
//var_dump($_GET["request"]);
//
//$requestMethod = $_SERVER["REQUEST_METHOD"];
//return var_dump($_SERVER);

// pass the request method and user ID to the PersonController and process the HTTP request:

$data = json_decode((file_get_contents('php://input')));

$controller = new Controller($_SERVER["REQUEST_METHOD"], $_GET["request"], $data);
$controller->processRequest();