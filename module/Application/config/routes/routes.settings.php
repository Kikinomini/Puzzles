<?php
return array(
    'router' => array(
        'routes' => array(
            'settings' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/settings',
                    'constraints' => array(),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Settings',
                        'action' => 'index',
                        'resource' => 'online',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'changePassword' => array(
                        'type'=> 'segment',
                        'options' => array(
                            'route' => '/changePassword',
                            'constraints' => array(),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Settings',
                                'action' => 'changePasswordSettings',
                                'resource' => 'online',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);