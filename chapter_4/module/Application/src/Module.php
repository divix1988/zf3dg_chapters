<?php

namespace Application;

use Application\Model\User;
use Application\Model\UsersTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    const VERSION = '3.0.2dev';

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
                     $resultSetPrototype->setArrayObjectPrototype(new User());
                     return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                }, 
                'Application\Model\UsersTable' =>  function($sm) {
                     $tableGateway = $sm->get('UsersTableGateway');
                     $table = new UsersTable($tableGateway);
                         
                     return $table;
                 }    
            )
        );
    }
}
