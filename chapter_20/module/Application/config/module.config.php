<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\Router\Http\Hostname;
use Zend\Router\Http\Method;
use Zend\Router\Http\Regex;
use Zend\Router\Http\Scheme;
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
            /*'users' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/users',
                    'defaults' => [
                        'controller' => Controller\UsersController::class,
                        'action'     => 'index',
                    ],
                ],
        
                'may_terminate' => true,
                'child_routes' => [
                    'dodaj' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => Controller\UsersController::class,
                                'action' => 'add',
                            ],
                        ],
                        'may_terminate' => true,
                    ]
                ]
            ],*/
            
            'profile_users' => [
                'type' => Hostname::class,
                'options' => [
                    'route' => ':username.users.localhost',
                    'constraints' => [
                        'username' => '[a-zA-Z0-9_-]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\UsersController::class,
                        'action' => 'profile',
                        'custom_var' => 'something_important'
                    ],
                ]
            ],
            'edit_user' => [
                'type' => Method::class,
                'options' => [
                    'verb' => 'put,delete',
                    'defaults' => [
                        'controller' => Controller\UsersController::class,
                        'action' => 'edit'
                    ],
                ]
            ],
            'show_image' => [
                'type' => Regex::class,
                'options' => [
                    'regex' => '/images/(?<id>[a-zA-Z0-9_-]+)(\.(?<format>(jpg|gif|png)))?',
                    'defaults' => [
                        'controller' => ImagesController::class,
                        'action'     => 'view',
                    ],
                    'spec' => '/images/%id%.%format%',
                ],
            ],
            'secure_page' => [
                'type' => Scheme::class,
                'options' => [
                    'scheme' => 'http',
                    'defaults' => [
                        'is_https' => true
                    ]
                ],
            ],
            'users_match' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/users[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller' => Controller\UsersController::class,
                        'action' => 'index',
                    ]
                ]
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
            'comics' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/comics',
                    'defaults' => [
                        'controller' => Controller\ComicsController::class,
                        'action'     => 'index',
                    ],
                ],

                'may_terminate' => true,
                'child_routes' => [
                    'dodaj' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => Controller\ComicsController::class,
                                'action' => 'add',
                            ],
                        ]
                    ],
                    'paginator' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/[page/:page]',
                            'defaults' => [
                                'page' => 1,
                            ],
                        ],
                    ]
                ]
            ],
            'add_comics' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/comics/add',
                    'defaults' => [
                        'controller' => Controller\ComicsController::class,
                        'action'     => 'add',
                    ],
                ],
            ],
            
            'polling' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/polling[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\PollingController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'register' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/register',
                    'defaults' => [
                        'controller' => Controller\RegisterController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'login' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/login[/:action]',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'user' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/user[/:action]',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'forms' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/forms',
                    'defaults' => [
                        'controller' => Controller\FormsController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'sitemap' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/sitemap.xml',
                    'defaults' => [
                        'controller' => Controller\SitemapController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'articles' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/articles[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\ArticlesController::class,
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
                $usersTable = $sm->get('Application\Model\UsersTable');
                $userHobbiesTable = $sm->get('Application\Model\UserHobbiesTable');

                return new Controller\UsersController($usersTable, $userHobbiesTable);
            },
            Controller\NewsController::class => function($sm) {
                $postService = $sm->get('Application\Model\NewsTable');
                
                return new Controller\NewsController($postService);
            },
            Controller\ComicsController::class => function($sm) {
                $postService = $sm->get('Application\Model\ComicsTable');
                
                return new Controller\ComicsController($postService);
            },
            Controller\PollingController::class => function($sm) {
                return new Controller\PollingController($sm->get(\DivixUtils\Polls\Polls::class));
            },
            Controller\LoginController::class => function($sm) {
                return new Controller\LoginController(
                    $sm->get(\DivixUtils\Security\Authentication::class)
                );
            },
            Controller\RegisterController::class => function($sm) {
                return new Controller\RegisterController(
                    $sm->get(Model\UsersTable::class),
                    $sm->get(\DivixUtils\Security\Authentication::class),
                    $sm->get(\DivixUtils\Security\Helper::class)
                );
            },
            Controller\UserController::class => InvokableFactory::class,
            Controller\FormsController::class => InvokableFactory::class,
            Controller\SitemapController::class => function($sm) {
                return new Controller\SitemapController(
                    $sm->get('Zend\Navigation\Default'),
                    $sm->get(Model\Admin\ContentManager::class)
                );
            },
            Controller\ArticlesController::class => function($sm) {
                return new Controller\ArticlesController(
                    $sm->get(Model\Admin\ContentManager::class)
                );
            },
        ],
    ],
                
    'controller_plugins' => [
        'factories' => [
            'DivixUtils\Logs\Debugs' => 'DivixUtils\Logs\DebugsFactory'
        ],
        'aliases' => [
            'debug' => 'DivixUtils\Logs\Debugs'
        ]
    ],
                
    'view_manager' => [
        'display_not_found_reason' => false,
        'display_exceptions'       => false,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml'
        ],
        
        'template_path_stack' => [
            __DIR__ . '/../view',
            __DIR__ . '/../view/application/_shared'
        ],
        'base_path' => '/zend3/public/',
        'base_url' => '/zend3/'
    ],
                
    'view_helpers' => [
        'invokables' => [
            'translate' => \Zend\I18n\View\Helper\Translate::class,
            'currencyFormat' => \Zend\I18n\View\Helper\CurrencyFormat::class,
            'dateFormat' => \Zend\I18n\View\Helper\DateFormat::class,
            'numberFormat' => \Zend\I18n\View\Helper\NumberFormat::class,
            'plural' => \Zend\I18n\View\Helper\Plural::class,
            'bootstrapForm' => \DivixUtils\Zend\View\Helper\BootstrapForm::class,
            'bootstrapFormRow' => \DivixUtils\Zend\View\Helper\BootstrapFormRow::class,
            'bootstrapFormCollection' => \DivixUtils\Zend\View\Helper\BootstrapFormCollection::class,
        ],
        'factories' => [
            \DivixUtils\Zend\View\Helper\BootstrapForm::class => InvokableFactory::class,
            \DivixUtils\Zend\View\Helper\BootstrapFormRow::class => InvokableFactory::class,
            \DivixUtils\Zend\View\Helper\BootstrapFormCollection::class => InvokableFactory::class,
        ]
    ],
                
    'translator' => [
        'locale' => 'pl_PL',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => 'module/Application/lang',
                'pattern'  => '%s.mo',
            ],
        ],
        'cache' => [
            'adapter' => [
                'name' => 'Filesystem',
                'options' => [
                    'cache_dir' => 'data/cache',
                    'ttl' => '86400' //24h
                ]
            ],
            'plugins' => [
                [
                    'name' => 'serializer',
                    'options' => []
                ],
                'exception_handler' => [
                    'throw_exceptions' => true
                ]
            ]
        ],
    ],
];
