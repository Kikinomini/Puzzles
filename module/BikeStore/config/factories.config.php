<?php

return array(
	'service_manager' => array(
		'factories' => array(
			'doctrine.entitymanager.BikeStore' => new \DoctrineORMModule\Service\EntityManagerFactory('BikeStore'),
			'doctrine.connection.BikeStore' => new \DoctrineORMModule\Service\DBALConnectionFactory('BikeStore'),
//		'doctrine.configuration.BikeStore' => new \DoctrineORMModule\Service\ConfigurationFactory('BikeStore'),
		),
	)
);

