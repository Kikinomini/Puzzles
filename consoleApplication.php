<?php
include "init_autoloader.php";
include 'module/Application/src/Application/Connections/MyConnection.php';
$config = include 'config/autoload/dev.local.php';
\Application\Connections\MyConnection::setDefaults($config["dbDefault"]);
chdir("./public");
include "public/index.php";