<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

define('HOST', 'gessointegr_v1.mysql.dbaas.com.br');
define('BANCO', 'gessointegr_v1');
define('USUARIO', 'gessointegr_v1');
define('SENHA', 'Maximiano@2004');

define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__);
define('DIR_PROJETO', 'api-cadastros');

if (file_exists('autoload.php')) {
    include 'autoload.php';
}else{
    echo 'Erro ao incluir bootstrap!'; exit;
}
