<?php
return array(
    'doctrine' => array(
        'driver' => array(
            'entities' => array(
//				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
//				'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Application/Model')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Application\Model' => 'entities'
                )
            ),
        ),
        'entitymanager' => array(
            'custom' => array(
                'connection' => 'custom',
            ),
            'orm_default' => array(
                'connection' => 'custom',
            ),
        ),
        'connection' => array(
            'custom' => array(
                'wrapperClass' => 'Application\Connections\MyConnection',
                'params' => array(
                    'host' => 'localhost',
                ),
            ),
        ),
    ),
);