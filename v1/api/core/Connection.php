<?php

class Connection
{
    private $connection;
    private $host;
    private $user;
    private $password;
    private $database;
    private $port;
    private $service;
    private $pdoString;

    public function __construct($typeConnection = 'mysql')
    {
        if ($typeConnection == 'mysql') {
            $this->connection = 'mysql';
            $this->host = MYSQL_DB_HOST;
            $this->user = MYSQL_DB_USER;
            $this->password = MYSQL_DB_PASS;
            $this->database = MYSQL_DB_NAME;
            $this->port = MYSQL_DB_PORT;
            $this->pdoString = "{$this->connection}:host={$this->host};dbname={$this->database};charset=utf8;";
        }else if($typeConnection == 'oci'){
            $this->connection = 'oci';
            $this->host = OCI_DB_HOST;
            $this->user = OCI_DB_USER;
            $this->password = OCI_DB_PASS;
            $this->database = OCI_DB_NAME;
            $this->port = OCI_DB_PORT;
            $this->service = OCI_DB_SERVICE;
            $tns = "(DESCRIPTION =
                (ADDRESS_LIST =
                    (ADDRESS = (PROTOCOL = TCP)(HOST = {$this->host})(PORT = {$this->port}))
                )
                (CONNECT_DATA =
                    (SERVICE_NAME = {$this->service})
                )
            )";
            $this->pdoString = "{$this->connection}:dbname={$tns};";
        }
    }

    public function connect()
    {
        try {
            $db = new PDO($this->pdoString, $this->user, $this->password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            return "¡Error!: " . $e->getMessage() . "<br/>";
        }
    }
}
