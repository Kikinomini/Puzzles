<?php

return array(
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Login',
				'route' => 'login',
				'resource' => 'offline',
				'class' => 'loginLable',
			),
			array(
				'label' => 'Logout',
				'route' => 'logout',
				'order' => 1100,
				'resource' => 'online',
			),
			array(
				'label' => 'Registrieren',
				'route' => 'registration',
				'resource' => 'offline',
				'class' => 'regLable ',
			),
			array(
				'label' => 'Userverwaltung',
				'route' => 'userList',
				'order' => -900,
				'resource' => 'admin',
			),
		),
		'mainNavigation' => array(
			array(
				'label' => 'Startseite',
				'route' => 'home',
				'order' => -1000,
				'resource' => 'default',
			),
			array(
				'label' => 'Fahrräder',
				'route' => 'bikelist',
				'order' => -900,
				'resource' => 'default',
			),
		),
	),
);