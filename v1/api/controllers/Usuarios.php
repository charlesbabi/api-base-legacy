<?php

class Usuarios extends Controller
{
    public function index()
    {
        return "Clase usuarios";
    }

    public function getUsuarios($parametros = array())
    {
        $usuarioModel = new UsuarioModel();
        return $usuarioModel->getUsuarios();
    }

    public function findUsuario($parametros = array())
    {
        return $parametros;
    }

    public function saveUsuario($parametros = array())
    {
        return $parametros;
    }

    public function updateUsuario($parametros = array())
    {
        return $parametros;
    }

    public function deleteUsuario($parametros = array())
    {
        return $parametros;
    }

    public function login($parametros = null)
    {
        $usuarioModel = new UsuarioModel();
        $user = $usuarioModel->login($parametros->usuario, $parametros->clave);
        $loginToken = $user;
        if (!empty($user)) {
            $token = new JWToken();
            $loginToken = $token->generateToken($user);
        }
        return $loginToken;
    }
}
