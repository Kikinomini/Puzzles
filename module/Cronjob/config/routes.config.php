<?php

return array(
    'router' => array(
        'routes' => array(
            'cronjob' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/Cronjob',
                    'constraints' => array(),
                    'defaults' => array(
                        'controller' => 'Cronjob\Controller\Cronjob',
                        'action' => 'index',
                        'resource' => 'admin',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'doCronjob' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/doCronjob',
                            'constraints' => array(),
                            'defaults' => array(
                                'controller' => 'Cronjob\Controller\Cronjob',
                                'action' => 'doCronjob',
                                'resource' => 'default',
                            ),
                        ),
                    ),
                    'doSingleCronjob' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/[:cronjobId]',
                            'constraints' => array(
                                'cronjobId' => "[0-9]+",
                            ),
                            'defaults' => array(
                                'controller' => 'Cronjob\Controller\Cronjob',
                                'action' => 'doSingleCronjob',
                                'resource' => 'default',
                                'cronjobId' => -1,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);

