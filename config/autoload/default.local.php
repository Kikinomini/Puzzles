<?php

//var_dump("local: dev");

return array(
	'dbDefault' => array(
		'user' => "root",
		'password' => "",
		'host' => '127.0.0.1',
		'dbname' => 'puzzles',
		'driverOptions' => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
		),
	),
	'mailEinstellungen' => array(
		'options' => array(
			'name' => 'Silas.link',
			'host' => 'eltanin.uberspace.de',
			'port' => '587',
			'connection_class' => 'plain', // plain oder login
			'connection_config' => array(
				'username' => 'puzzles@puzzles.silas.link',
				'password' => '159753',
				'ssl' => 'tls',
			),
		),
		'sender' => 'localemail@puzzles.silas.link',
	),

	'systemvariablen' => array(
		'passwordHash' => 'hug2fgh8jk25rzkglg56i4dfj7fjv',
		'serverAdresse' => 'http://localhost/',
		'codeUrl' => 'https://localhost/code',
        'websiteName' => 'local.puzzles.Silas.link',
        'maxAlterVonCodes' => 2 //In Tagen
	),
);
