<?php
//error_reporting(E_ERROR | E_PARSE);
include "init_autoloader.php";
include 'module/Application/src/Application/Connections/MyConnection.php';
$config = include 'config/autoload/dev.local.php';
\Application\Connections\MyConnection::setDefaults($config["dbDefault"]);
include 'vendor/doctrine/doctrine-module/bin/doctrine-module';
