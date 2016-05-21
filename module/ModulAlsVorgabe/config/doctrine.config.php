<?php

return array(
	'doctrine' => array(
		'connection' => array(
			'BikeStore' => array(
				'wrapperClass' => 'Application\Connections\MyConnection',
				'params' => array(
				)
			)
		),
		'driver' => array(
			'orm_default' => array(
				'drivers' => array(
					'BikeStore\Model' => 'entities_data-builder'),
			),
			'entities_data-builder' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(
					__DIR__ . '/../src/ModulAlsVorgabe/Model',
				)
			)
		),
		'entitymanager' => array(
			'BikeStore' => array(
				'connection' => 'BikeStore',
			)
		)
	),
);

