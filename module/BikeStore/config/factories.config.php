<?php

return array(
	'service_manager' => array(
		'factories' => array(
			'doctrine.entitymanager.BikeStore' => new \DoctrineORMModule\Service\EntityManagerFactory('BikeStore'),
			'doctrine.connection.BikeStore' => new \DoctrineORMModule\Service\DBALConnectionFactory('BikeStore'),

			'BikeStore.articleManager' => 'BikeStore\Factory\Model\Manager\ArticleManagerFactory',
			'BikeStore.bicycleManager' => 'BikeStore\Factory\Model\Manager\BicycleManagerFactory',
			'BikeStore.cityBikeManager' => 'BikeStore\Factory\Model\Manager\CityBikeManagerFactory',
			'BikeStore.eBikeManager' => 'BikeStore\Factory\Model\Manager\EBikeManagerFactory',
			'BikeStore.mountainBikeManager' => 'BikeStore\Factory\Model\Manager\MountainBikeManagerFactory',
			'BikeStore.trekkingBikeManager' => 'BikeStore\Factory\Model\Manager\TrekkingBikeManagerFactory',
			'BikeStore.equipmentManager' => 'BikeStore\Factory\Model\Manager\EquipmentManagerFactory',
			'BikeStore.paymentInfoManager' => 'BikeStore\Factory\Model\Manager\PaymentInfoManagerFactory',
		),
	)
);