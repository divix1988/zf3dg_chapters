<?php
return array(
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=zend3;host=localhost',
        'driver_options' => array(
            1002 => 'SET NAMES \'UTF8\'',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\\Db\\Adapter\\Adapter' => 'Zend\\Db\\Adapter\\AdapterServiceFactory',
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
