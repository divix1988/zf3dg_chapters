<?php

namespace Application;

use Application\Model\Rowset;
use Application\Model\UsersTable;
use Application\Model\UserHobbiesTable;
use Application\Model\NewsTable;
use Zend\Db\ResultSet\ResultSet;
use DivixUtils\Zend\Db\TableGateway\TableGateway;
use Application\Model\ComicsTable;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Session;
use Zend\Validator;

class Module
{
    const VERSION = '3.0.0dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'UsersTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get(\Zend\Db\Adapter\Adapter::class);
                     
                     $resultSetPrototype = new ResultSet();
                     $config = $sm->get('Config');
                     $baseUrl = $config['view_manager']['base_url'];
                     $userRowset = new Rowset\User($baseUrl);
                     $resultSetPrototype->setArrayObjectPrototype($userRowset);
                     return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                 }, 
                'Application\Model\UsersTable' =>  function($sm) {
                    $tableGateway = $sm->get('UsersTableGateway');
                    $table = new UsersTable($tableGateway);

                    return $table;
                },
                 
                'UserHobbiesTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Rowset\UserHobby());
                    return new TableGateway('user_hobbies', $dbAdapter, null, $resultSetPrototype);
                 }, 
                'Application\Model\UserHobbiesTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserHobbiesTableGateway');
                    $table = new UserHobbiesTable($tableGateway);

                    return $table;
                 },
                     
                'NewsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

                    $resultSetPrototype = new ResultSet();
                    //$resultSetPrototype->setArrayObjectPrototype(new User());
                    return new TableGateway('news', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\NewsTable' =>  function($sm) {
                     $tableGateway = $sm->get('NewsTableGateway');
                     $table = new NewsTable($tableGateway);
                     
                     return $table;
                 },
                     
                 'ComicsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

                    $config = $sm->get('Config');
                    $baseUrl = $config['view_manager']['base_url'];
                    $resultSetPrototype = new ResultSet();
                    $identity = new Rowset\Comics($baseUrl);
                    $resultSetPrototype->setArrayObjectPrototype($identity);

                    return new TableGateway('comics', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Application\Model\ComicsTable' =>  function($sm) {
                    $tableGateway = $sm->get('ComicsTableGateway');
                    $table = new ComicsTable($tableGateway);

                    return $table;
                 },
                 \DivixUtils\Polls\Polls::class => InvokableFactory::class,
                 \DivixUtils\Security\Authentication::class =>  function($sm) {
                    $auth = new \DivixUtils\Security\Authentication(
                        $sm->get(\Zend\Db\Adapter\Adapter::class),
                        $sm->get(\DivixUtils\Security\Adapter::class)
                    );

                    return $auth;
                 },
                 \DivixUtils\Security\Helper::class => InvokableFactory::class,
                 SessionManager::class => function ($container) {
                    $config = $container->get('config');
                    $session = $config['session'];

                    $sessionConfig = new $session['config']['class']();
                    $sessionConfig->setOptions($session['config']['options']);

                    $sessionManager = new Session\SessionManager(
                        $sessionConfig,
                        new $session['storage'](),
                        null
                    );
                    \Zend\Session\Container::setDefaultManager($sessionManager);

                    return $sessionManager;
                },
                Model\Admin\ContentManager::class => function($sm) {
                    return new Model\Admin\ContentManager($sm->get(\Zend\Db\Adapter\Adapter::class));
                },
             )
        );
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'DivixUtils' => __DIR__ . '/../../vendor/divixutils'
                )
            ),
        );
    }
    
    public function onBootstrap($e)
    {
        $this->bootstrapSession($e);
        
        $translator = $e->getApplication()->getServiceManager()->get('MvcTranslator');
        //$translator->setLocale('pl_PL');
        //echo $translator->getLocale();
    }
    
    public function bootstrapSession($e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $session = $serviceManager->get(SessionManager::class);
        $session->start();

        $container = new Session\Container('initialized');

        //check if our session isn't already created (for guest or user)
        if (isset($container->init)) {
            return;
        }

        //initialize new session
        $request = $serviceManager->get('Request');
        $session->regenerateId(true);
        $container->init = 1;
        $container->remoteAddr    = $request->getServer()->get('REMOTE_ADDR');
        $container->httpUserAgent = $request->getServer()->get('HTTP_USER_AGENT');

        $config = $serviceManager->get('Config');
        $sessionConfig = $config['session'];
        $chain   = $session->getValidatorChain();

        foreach ($sessionConfig['validators'] as $validator) {
            switch ($validator) {
            case Validator\HttpUserAgent::class:
                    $validator = new $validator($container->httpUserAgent);
                    break;
                    case Validator\RemoteAddr::class:
                    $validator  = new $validator($container->remoteAddr);
                    break;
                default:
                    $validator = new $validator();
            }

            $chain->attach('session.validate', array($validator, 'isValid'));
        }
    }

}
