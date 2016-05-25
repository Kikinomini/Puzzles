<?php

$config = array(
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/login[/:followTarget]',
                    'constraints' => array(
                        'followTarget' => '0|1',
                    ),
                    'defaults' => array(
                        'controller' => 'Portal\Controller\Login',
                        'action' => 'login',
                        'resource' => 'offline',
                        'followTarget' => '0',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/logout',
                    'constraints' => array(),
                    'defaults' => array(
                        'controller' => 'Portal\Controller\Login',
                        'action' => 'logout',
                        'resource' => 'default',
                    ),
                ),
            ),
            'registration' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/registration',
                    'constraints' => array(),
                    'defaults' => array(
                        'controller' => 'Portal\Controller\Login',
                        'action' => 'registration',
                        'resource' => 'offline',
                        'mobile' => 'registration_mobile'
                    ),
                ),
            ),
            'code' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/code/:code',
                    'constraints' => array(
                        'code' => '[a-zA-Z0-9]{50,255}',
                    ),
                    'defaults' => array(
                        'controller' => 'Portal\Controller\Code',
                        'action' => 'code',
                        'resource' => 'default',
                    ),
                ),
            ),
            'newPassword' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/newPassword',
                    'constraints' => array(),
                    'defaults' => array(
                        'controller' => 'Portal\Controller\Login',
                        'action' => 'newPassword',
                        'resource' => 'offline',
                    ),
                ),
            ),
            'changePasswordFromMail' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/changePassword/:code',
                    'constraints' => array(
                        'code' => '[a-zA-Z0-9]{50,255}'
                    ),
                    'defaults' => array(
                        'controller' => 'Portal\Controller\Login',
                        'action' => 'changePasswordFromMail',
                        'resource' => 'default',
                    ),
                ),
            ),
            'userList' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/userList',
                    'constrains' => array(),
                    'defaults' => array(
                        'controller' => 'Portal\Controller\RoleResource',
                        'action' => 'userList',
                        'resource' => 'admin',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'userOverview' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/:userId',
                            'constrains' => array(
                                'userId' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'Portal\Controller\RoleResource',
                                'action' => 'userOverview',
                                'userId' => 0,
                                'resource' => 'admin',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'changeUserRole' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/changeUserRole',
                                    'constrains' => array(
                                        'userId' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Portal\Controller\RoleResource',
                                        'action' => 'changeUserRole',
                                        'resource' => 'admin',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'roleList' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/roleList',
                            'constraints' => array(),
                            'defaults' => array(
                                'controller' => 'Portal\Controller\RoleResource',
                                'action' => 'roleList',
                                'resource' => 'admin',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'changeRoleResource' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/changeRoleResource',
                                    'constrains' => array(),
                                    'defaults' => array(
                                        'controller' => 'Portal\Controller\RoleResource',
                                        'action' => 'changeRoleResource',
                                        'resource' => 'admin',
                                    ),
                                ),
                            ),
                            'modifyRole' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/modifyRole[/:roleId]',
                                    'constrains' => array(
                                        'roleId' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Portal\Controller\RoleResource',
                                        'action' => 'modifyRole',
                                        'resource' => 'admin',
                                    ),
                                ),
                            ),
                            'roleOverview' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/roleOverview/:roleId',
                                    'constrains' => array(
                                        'roleId' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Portal\Controller\RoleResource',
                                        'action' => 'roleOverview',
                                        'resource' => 'admin',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'changeRoleParent' => array(
                                        'type' => 'segment',
                                        'options' => array(
                                            'route' => '/changeRoleParent',
                                            'constrains' => array(
                                            ),
                                            'defaults' => array(
                                                'controller' => 'Portal\Controller\RoleResource',
                                                'action' => 'changeRoleParent',
                                                'resource' => 'admin',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);

foreach (glob(__DIR__ . '/routes/routes.*.php') as $filename) {
    $config = array_merge_recursive($config, include($filename));
}
return $config;