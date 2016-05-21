<?php
return array(
    'console' => array(
        'router' => array(
            'routes' => array(
                'index' => array(
                    'options' => array(
                        'route' => '',
                        'defaults' => array(
                            'controller' => 'Application\Controller\Console',
                            'action' => 'index',
                            'resource' => 'default',
                        ),
                    ),
                ),
                'addForm' => array(
                    'options' => array(
                        'route' => 'addForm <module> <entity>',
                        'defaults' => array(
                            'controller' => 'Application\Controller\Console',
                            'action' => 'addForm',
                            'resource' => 'default',
                        ),
                    ),
                ),
            ),
        ),
    ),
);