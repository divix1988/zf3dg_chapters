<?php

namespace Application;

use Application\Model\Rowset;
use Application\Model\UsersTable;
use Application\Model\UserHobbiesTable;
use Application\Model\NewsTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

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
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     
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
}
