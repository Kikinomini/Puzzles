<?php
/**
 * Created by PhpStorm.
 * User: Kinomi
 * Date: 28.05.2016
 * Time: 22:11
 */
return array(
	'router' => array(
		'routes' => array(
			'bikelist' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/bike',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'BikeStore\Controller\Bicycle',
						'action' => 'showBicycleList',
						'resource' => 'default',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'details' => array(
						'type' => 'segment',
						'options' => array(
							'route' => '/:id',
							'constraints' => array(
								'id' => '[0-9]{1,}'
							),
							'defaults' => array(
								'controller' => 'BikeStore\Controller\Bicycle',
								'action' => 'showBicycleDetails',
								'resource' => 'default',
							),
						),
					),
				),
			),
		),
	),
);