<?php
return array(
    'db' => array(
        'driver' => 'Pdo',
        'platform' => 'Mysql',
        'dsn' => 'mysql:dbname=zend3;host=localhost',
        'driver_options' => array(
            1002 => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            \Zend\Authentication\AuthenticationService::class => function($sm) {
                return $sm->get(\DivixUtils\Security\Authentication::class);
            },
            \DivixUtils\Security\Adapter::class => function($sm) {
                return new \DivixUtils\Security\Adapter(
                    $sm->get(\Zend\Db\Adapter\Adapter::class),
                    'users',
                    'email',
                    'password',
                    'SHA2(CONCAT(password_salt, "'.\DivixUtils\Security\Helper::SALT_KEY.'", ?), 512)'
                );
            }
        ),
        'abstract_factories' => [
            Zend\Navigation\Service\NavigationAbstractServiceFactory::class,
        ],
    ),
    'zf-mvc-auth' => array(
        'authentication' => array(
            'map' => array(
                'ApplicationApi\\V1' => 'comics',
            ),
        ),
    ),
    'session' => [
        'config' => [
            'class' => \Zend\Session\Config\SessionConfig::class,
            'options' => [
                'name' => 'session name',
            ],
        ],
        'storage' => \Zend\Session\Storage\SessionArrayStorage::class,
        'validators' => [
            \Zend\Session\Validator\RemoteAddr::class,
            \Zend\Session\Validator\HttpUserAgent::class,
        ],
    ],
    
    'navigation' => [
        'default' => [
            [
                'label' => 'Home Page',
                'route' => 'home',
                'priority' => '1.0'
            ],
            [
                'label' => 'Users',
                'route' => 'users',
                'pages' => [
                    [
                        'label' => 'Add User',
                        'controller' => 'users',
                        'action' => 'add'
                    ]
                ],
                'priority' => '0.5'
            ],
            [
                'label' => 'Articles',
                'route' => 'news',
                'priority' => '0.5'
            ],
            [
                'label' => 'Comics',
                'route' => 'comics',
                'priority' => '0.5'
            ],
            [
                'label' => 'Poll',
                'route' => 'polling',
                'pages' => [
                    [
                        'label' => 'Manage polls',
                        'route' => 'polling',
                        'action' => 'manage',
                        'pages' => [
                            [
                                'label' => 'Active poll',
                                'route' => 'polling',
                                'action' => 'view',
                            ]
                        ]
                    ]
                ]
            ],
            [
                'label' => 'Registration',
                'route' => 'register'
            ],
            [
                'label' => 'Logging',
                'route' => 'login'
            ],
            [
                'label' => 'My Account',
                'route' => 'user'
            ],
            [
                'label' => 'Logout',
                'route' => 'login',
                'action' => 'logout'
            ],
            [
                'label' => 'Forms',
                'route' => 'forms'
            ],
        ]
    ]
);
