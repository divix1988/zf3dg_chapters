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
    
    
);
