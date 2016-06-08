<?php
return array(
	'router' => array(
		'routes' => array(
			'insertDeliveryAddress' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/deliveryAddress',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'BikeStore\Controller\Buy',
						'action' => 'checkConfirmedUser',
						'resource' => 'online',
					),
				),
			),
		),
	),
);