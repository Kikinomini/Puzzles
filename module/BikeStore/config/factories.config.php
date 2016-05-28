<?php

return array(
	'service_manager' => array(
		'factories' => array(
			'doctrine.entitymanager.BikeStore' => new \DoctrineORMModule\Service\EntityManagerFactory('BikeStore'),
			'doctrine.connection.BikeStore' => new \DoctrineORMModule\Service\DBALConnectionFactory('BikeStore'),

			'BikeStore.articleManager' => 'BikeStore\Factory\Model\Manager\ArticleManagerFactory'
		),
	)
);

