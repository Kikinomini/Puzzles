<?php

return array(
	'service_manager' => array(
		'factories' => array(
			'doctrine.entitymanager.BikeStore' => new \DoctrineORMModule\Service\EntityManagerFactory('BikeStore'),
			'doctrine.connection.BikeStore' => new \DoctrineORMModule\Service\DBALConnectionFactory('BikeStore'),

			'BikeStore.articleManager' => 'BikeStore\Factory\Model\Manager\ArticleManagerFactory',
			'BikeStore.bicycleManager' => 'BikeStore\Factory\Model\Manager\BicycleManagerFactory',
			'BikeStore.eBikeManager' => 'BikeStore\Factory\Model\Manager\EBikeManagerFactory',
			'BikeStore.equipmentManager' => 'BikeStore\Factory\Model\Manager\EquipmentManagerFactory',
			'BikeStore.paymentInfoManager' => 'BikeStore\Factory\Model\Manager\PaymentInfoManagerFactory',
			'BikeStore.equipment.SaddleManager' => 'BikeStore\Factory\Model\Manager\Equipment\SaddleManagerFactory',
		),
	)
);