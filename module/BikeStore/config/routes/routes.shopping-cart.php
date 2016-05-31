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
			'shoppingCart' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/shoppingCart',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'BikeStore\Controller\ShoppingCart',
						'action' => 'showShoppingCart',
						'resource' => 'default',
					),
				),
			),
		),
	),
);