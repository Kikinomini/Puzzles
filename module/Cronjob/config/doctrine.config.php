<?php

return array(
	'doctrine' => array(
		'connection' => array(
			'Cronjob' => array(
				'wrapperClass' => 'Application\Connections\MyConnection',
				'params' => array(
//					'dbname' => 'silas_Cronjob',
				)
			)
		),
		'driver' => array(
			'orm_default' => array(
				'drivers' => array(
					'Cronjob\Model' => 'entities_cronjob'),
			),
			'entities_cronjob' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(
					__DIR__.'/../src/Cronjob/Model',
				)
			)
		),
		'entitymanager' => array(
			'Cronjob' => array(
				'connection' => 'Cronjob',
			)
		)
	),
);

