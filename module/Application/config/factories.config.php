<?php
return array(
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(//            'user'
            'userManager' => 'Application\Factory\Model\Manager\UserManagerFactory',
            'codeManager' => 'Application\Factory\Model\Manager\CodeManagerFactory',
            'roleManager' => 'Application\Factory\Model\Manager\RoleManagerFactory',
            'resourceManager' => 'Application\Factory\Model\Manager\ResourceManagerFactory',

            'doctrine.entitymanager.custom' => new \DoctrineORMModule\Service\EntityManagerFactory('custom'),
            'doctrine.connection.custom' => new \DoctrineORMModule\Service\DBALConnectionFactory('custom'),
//			'doctrine.configuration.custom' => new \DoctrineORMModule\Service\ConfigurationFactory('custom'),

			'Zend\Session\SessionManager' => 'Application\Factory\SessionManagerFactory',
        ),
    ),
);