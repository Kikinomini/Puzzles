<?php

$config = array();
foreach (glob(__DIR__ . '/routes/routes.*.php') as $filename) {
    $config = array_merge_recursive($config, include($filename));
}
return $config;