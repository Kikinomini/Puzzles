<?php
return array(
	'router' => array(
		'routes' => array(
			'selectPayMethod' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/selectPayMethod',
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