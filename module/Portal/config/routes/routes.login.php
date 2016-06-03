<?php

return array(
	'router' => array(
		'routes' => array(
			'resendRegistrationEmail' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/resendRegistrationEmail',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'Portal/Controller/Login',
						'action' => 'resendRegistrationCode',
						'resource' => 'online',
					),
				),
			),
		),
	),
);