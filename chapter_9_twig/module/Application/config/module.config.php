<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'users' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/users[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\UsersController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'news' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/news[/:action]',
                    'defaults' => [
                        'controller' => Controller\NewsController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\IndexController::class => function($sm) {
                $postService = $sm->get('Application\Model\UsersTable');

                return new Controller\IndexController($postService);
            },
            Controller\UsersController::class => function($sm) {
                $postService = $sm->get('Application\Model\UsersTable');

                return new Controller\UsersController($postService);
            },
            Controller\NewsController::class => function($sm) {
                $postService = $sm->get('Application\Model\NewsTable');
                
                return new Controller\NewsController($postService);
            }
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => false,
        'display_exceptions'       => false,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        /*'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],*/
        'template_map' => [
            'layout/layout' => __DIR__.'/../view/layout/layout.twig',
            'application/index/index' => __DIR__.'/../view/application/index/index.twig',
            'error/404' => __DIR__.'/../view/error/404.twig',
            'error/index' => __DIR__.'/../view/error/index.twig',
        ],
        /*'strategies' => [
            'Smarty\View\Strategy'
        ],*/
        
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'base_path' => '/zend3/public/'
    ],
];
