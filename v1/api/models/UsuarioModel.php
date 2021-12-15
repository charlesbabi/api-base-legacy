<?php
class UsuarioModel extends Connection
{
    private $oracle;

    function __construct()
    {
        parent::__construct('oci');
        $this->oracle = $this->connect();
    }

    function getUsuarios($page = 0, $limit = 25)
    {
        $response = array();
        $init = (($page <= 0 ? 0 : $page) * $limit);
        $end = ($page * $limit) + $limit;
        $r = $this->oracle->prepare("SELECT * FROM usuarios WHERE ROWNUM >= :page AND ROWNUM <= :limit ");
        $r->execute(array(":page" => $init, ":limit" => $end));
        $users = $r->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $user) {
            $response[] = $user;
        }
        return $response;
    }

    function login($usuario, $clave)
    {
        $r = $this->oracle->prepare("SELECT * FROM usuarios WHERE usuario = ? AND clave = ? ");
        $r->execute(array($usuario, $clave));
        return $r->fetch(PDO::FETCH_ASSOC);
    }
}
