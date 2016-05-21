<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 21.05.16
 * Time: 20:14
 */

return array(
	'router' => array(
		'routes' => array(
			'home' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'Portal\Controller\Index',
						'action' => 'index',
						'resource' => 'default',
					),
				),
			),
			'showImprint' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/imprint',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'Portal\Controller\Index',
						'action' => 'showImprint',
						'resource' => 'default',
					),
				),
			),
			'showPrivacyPolicy' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/privacyPolicy',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'Portal\Controller\Index',
						'action' => 'showPrivacyPolicy',
						'resource' => 'default',
					),
				),
			),
			'showAgb' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/AGB',
					'constraints' => array(),
					'defaults' => array(
						'controller' => 'Portal\Controller\Index',
						'action' => 'showAgb',
						'resource' => 'default',
					),
				),
			),
		),
	),
);