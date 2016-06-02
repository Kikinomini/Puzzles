<?php

return array(
	'navigation' => array(
		'default' => array(),
		'mainNavigation' => array(

			array(
				'label' => 'Fahrräder',
				'route' => 'bikelist',
				'order' => -900,
				'resource' => 'default',
			),
			array(
				'label' => 'Zubehör',
				'route' => 'Bikepart',
				'order' => -800,
				'resource' => 'default',
			),
		),
	),
);

