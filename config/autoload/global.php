<?php
return array(
	'db' => array(
		'driver' => 'Pdo',
		'driver_options' => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
		),
	),
	'service_manager' => array(
		'factories' => array(
			'Zend\Db\Adapter\Adapter'
			=> 'Zend\Db\Adapter\AdapterServiceFactory',
			//'navigation' => 'Application\Factory\NavigationFactory',
			'Zend\View\Helper\Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
			'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
			'acl' => 'Application\Factory\AclFactory',
//			'database' => 'Application\Factory\DatabaseFactory',
//			'user' => 'Application\Factory\UserFactory',
			'mail' => 'Application\Factory\MailFactory',
		),
		'services' => array(
			//'Zend\View\Helper\Navigation' => new Zend\Navigation\Service\DefaultNavigationFactory,
		)
	),

	'doctrine' => array(
		'driver' => array(
			'entities' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
			),
		),
	),
	'session' => array(
		'config' => array(
			'class' => 'Zend\Session\Config\SessionConfig',
			'options' => array(
				'name' => 'puzzlesId',
				'cookie_httponly' => true,

			),
		),
		'storage' => 'Zend\Session\Storage\SessionArrayStorage',
		'validators' => array(
			'Zend\Session\Validator\RemoteAddr',
//			'Zend\Session\Validator\HttpUserAgent',
		),
	),
);
