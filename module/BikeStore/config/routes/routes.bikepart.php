<?php
/**
 * Created by PhpStorm.
 * User: Marten
 * Date: 01.06.2016
 * Time: 10:52
 */

return array(
	'router' => array(
		'routes' => array(
			'Bikepart' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/Bikepart',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'BikeStore\Controller\BikePart',
						'action' => 'showBikePartList',
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
								'controller' => 'BikeStore\Controller\Bikepart',
								'action' => 'showBikepartDetails',
								'resource' => 'default',
							),
						),
					),
				),
			),
		),
	),
);