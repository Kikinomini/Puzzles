<?php

return array(
	'service_manager' => array(
		'factories' => array(
			'doctrine.entitymanager.Cronjob' => new \DoctrineORMModule\Service\EntityManagerFactory('Cronjob'),
			'doctrine.connection.Cronjob' => new \DoctrineORMModule\Service\DBALConnectionFactory('Cronjob'),
			'Cronjob.cronjobManager' => 'Cronjob\Factory\Model\Manager\CronjobManagerFactory',
		),
	),
);

