<?php

define('MYSQL_DB_HOST', 'host_mysql');
define('MYSQL_DB_USER', 'user_mysql');
define('MYSQL_DB_PASS', 'pass_mysql');
define('MYSQL_DB_NAME', 'dbname_mysql');
define('MYSQL_DB_PORT', 'port_mysql');

define('OCI_DB_HOST', 'host_oracle');
define('OCI_DB_USER', 'user_oracle');
define('OCI_DB_PASS', 'pass_oracle');
define('OCI_DB_NAME', 'dbname_oracle');
define('OCI_DB_PORT', 'port_oracle');
define('OCI_DB_SERVICE', 'service_oracle');

define('SECRET_KEY_JWT', 'miEpicSecretKeyToEncodeJWT');

define('DEBBUGIN', false); //true or false

if (DEBBUGIN) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
