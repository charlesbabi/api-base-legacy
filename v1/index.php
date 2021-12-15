<?php
//function to enalbe the use of cors
function cors()
{
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
}
cors();
include_once __DIR__ . '/config/config.php';
include_once __DIR__ . '/config/routes.php';
include_once __DIR__ . '/config/statusCode.php';

include_once __DIR__ . '/config/response.php';
$response = new Response();

$url = $_GET['url'];
$explodeUrl = explode("/", $_GET['url']);

$json = file_get_contents('php://input');
$dataJson = json_decode($json);

try{
    $data = findRoute($url, $dataJson);
    $response->send($data[0], $http_status_codes[$data[0]], $data[1], (!empty($data[2]) ? $data[2] : ''));
}catch(Exception $ex){
    $response->send(400, $http_status_codes[400], $ex->getMessage());
}
