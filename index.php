<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
CONST PROJECT_ROOT_PATH =  __DIR__;
require_once (PROJECT_ROOT_PATH. "\Api\Utils\config.php");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// http://localhost/rest/

if (!isset($uri[4]) || !in_array(strtolower($uri[4]), RECURSOS_VALIDOS)) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
$idrecurso = $uri[5] ?? null;
$controlador = ucfirst(strtolower($uri[4]))."Controller";
require_once(PROJECT_ROOT_PATH."/Api/Controllers/$controlador.php");
use Api\Controllers\{controlador};
$controladorClass = "Api\\Controllers\\".$controlador;

$objetoApi = new $controladorClass;
$respuesta = $objetoApi->posts($idrecurso);
header($respuesta['header']);
echo $respuesta['datos'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Document</title>
</head>
<body>
    
</body>
</html>