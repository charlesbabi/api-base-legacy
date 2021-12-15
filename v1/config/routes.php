<?php
//para autocargar los controladores
spl_autoload_register(function ($nombre_clase) {
    $folders = array(
        '/api/core/',
        '/api/controllers/',
        '/api/models/'
    );
    foreach ($folders as $folder) {
        if (file_exists(dirname(__DIR__) . $folder . $nombre_clase . '.php')) {
            include_once dirname(__DIR__) . $folder . $nombre_clase . '.php';
        }
    }
});

/**
 * Routes for usuarios
 */
$routes = array();
//$routes['route_name'] = array(need_validation, 'Controller.method');
$routes['GET /usuario/:id'] = array(true, 'Usuarios.findUsuario');
$routes['GET /usuarios'] = array(true, 'Usuarios.getUsuarios');
$routes['POST /usuarios'] = array(true, 'Usuarios.saveUsuario');
$routes['POST /usuarios/login'] = array(false, 'Usuarios.login');
$routes['PUT /usuarios'] = array(true, 'Usuarios.updateUsuario');
$routes['DELETE /usuario/:id'] = array(true, 'Usuarios.deleteUsuario');

function findRoute($url, $dataJson)
{
    global $routes;
    $headers = apache_request_headers();

    $method = $_SERVER['REQUEST_METHOD'];

    $exp = $method . " ";
    $arr_url = explode("/", $url);
    foreach ($arr_url as $data) {
        $exp .= "/";
        if (is_numeric($data)) {
            $exp .= ":id";
        } else {
            $exp .= $data;
        }
    }

    if (!empty($routes[$exp])) {
        if ($routes[$exp][0]) {
            //if is true needs to get Authorization token
            $dataAuthorization = explode(" ", $headers['Authorization']);
            $tokenText = !empty($dataAuthorization[1]) ? $dataAuthorization[1] : '';
            if (empty($tokenText)) {
                return array(401, "No se encontro el token de autorizacion");
            }
            $token = new JWToken();            
            $data = $token->verifyToken($tokenText);
            if ($data === false) {
                return array(401, "Token invalido");
            }
            $dataJson['token_data'] = $data;
        }
        $parsingData = explode(".", $routes[$exp][1]);
        ${$parsingData[0]} = new $parsingData[0]();
        return array(200, ${$parsingData[0]}->{$parsingData[1]}($dataJson));
    } else {
        return array(400, "Function not allowed", $exp);
    }
}
