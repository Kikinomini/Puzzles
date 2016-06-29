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
			'selectPaymentMethod' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/paymentMethod',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'BikeStore\Controller\Buy',
						'action' => 'selectPaymentMethod',
						'resource' => 'online',
					),
				),
			),
			'paymentTransfer' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/paymentTransfer',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'BikeStore\Controller\Buy',
						'action' => 'paymentTransfer',
						'resource' => 'online',
					),
				),
			),
			'paymentBill' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/paymentBill',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'BikeStore\Controller\Buy',
						'action' => 'paymentBill',
						'resource' => 'online',
					),
				),
			),
			'paymentPaypal' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/paymentPaypal',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'BikeStore\Controller\Buy',
						'action' => 'paymentPaypal',
						'resource' => 'online',
					),
				),
			),

		),
	),
);