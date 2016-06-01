<?php
/**
 * Created by PhpStorm.
 * User: Kinomi
 * Date: 28.05.2016
 * Time: 22:11
 */
return array(
//	'router' => array(
//		'routes' => array(
//			'insertTestData' => array(
//				'type' => 'segment',
//				'options' => array(
//					'route' => '/insertTestData',
//					'constraints' => array(),
//					'defaults' => array(
//						'controller' => 'BikeStore\Controller\SetUp',
//						'action' => 'insertTestData',
//						'resource' => 'default',
//					),
//				),
//			),
//		),
//	),
	'console' => array(
		'router' => array(
			'routes' => array(
				'index' => array(
					'options' => array(
						'route' => 'insertData',
						'defaults' => array(
							'controller' => 'BikeStore\Controller\SetUp',
							'action' => 'insertTestData',
							'resource' => 'default',
						),
					),
				),
			),
		),
	),
);