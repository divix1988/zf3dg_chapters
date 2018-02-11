<?php

namespace Admin;

use Zend\Loader;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\V2RouteMatch;
use Zend\Router\RouteMatch as V3RouteMatch;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

class Module
{

    public function getAutoloaderConfig()
    {
        return [
            Loader\AutoloaderFactory::STANDARD_AUTOLOADER => [
                Loader\StandardAutoloader::LOAD_NS => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    public function getConfig()
    {
        $provider = new ConfigProvider();
        return [
            'service_manager' => $provider->getDependencyConfig(),
            'view_manager' => $provider->getViewManagerConfig(),
            'admin' => $provider->getModuleConfig(),
            'controllers' => [
                'factories' => [
                    Controller\AdminController::class => function($sm) {
                        return new Controller\AdminController($sm->get(\Application\Model\Admin\ContentManager::class));
                    },
                    Controller\ArticlesController::class => function($sm) {
                        return new Controller\ArticlesController($sm->get(\Application\Model\Admin\ContentManager::class));
                    },
                ],
            ],
            
            'navigation' => array(
                'admin' => array(
                    'home' => array(
                        'label' => 'Home Page',
                        'route' => 'admin',
                    ),
                    'articles' => array(
                        'label' => 'Articles',
                        'route' => 'admin/articles',
                    ),
                    'logout' => array(
                        'label' => 'Logout',
                        'route' => 'logout',
                    ),
                ),
            ),
            
            'router' => [
                'routes' => [
                    'admin' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/admin',
                            'defaults' => [
                                'controller' => Controller\AdminController::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'articles' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/articles[/:action][/:id][/:content_id]',
                                    'defaults' => [
                                        'controller' => Controller\ArticlesController::class,
                                        'action' => 'index',
                                    ],
                                ]
                            ],
                        ]
                    ],
                    
                    'logout' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/login/logout',
                            'defaults' => [
                                'controller' => \Application\Controller\LoginController::class,
                                'action' => 'logout',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
        ];
    }

    public function onBootstrap(EventInterface $e)
    {
        $app = $e->getParam('application');
        $em  = $app->getEventManager();
        $em->attach(MvcEvent::EVENT_DISPATCH, [$this, 'selectLayoutBasedOnRoute']);
    }

    public function selectLayoutBasedOnRoute(MvcEvent $e)
    {
        $app    = $e->getParam('application');
        $sm     = $app->getServiceManager();
        $config = $sm->get('config');
        
        if ($config['admin']['use_admin_layout'] === false) {
            return;
        }
        $match      = $e->getRouteMatch();
        $controller = $e->getTarget();
        
        if (!($match instanceof V2RouteMatch || $match instanceof V3RouteMatch)
            || 0 !== strpos($match->getMatchedRouteName(), 'admin')
            || $controller->getEvent()->getResult()->terminate()
        ) {
            return;
        }
        $layout = $config['admin']['admin_layout_template'];
        $controller->layout($layout);
    }
}