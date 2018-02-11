<?php
namespace DivixUtils\Zend\Db\TableGateway;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;

class TableGateway extends \Zend\Db\TableGateway\TableGateway
{
    protected $platform;
    
    public function __construct(
        $table, 
        \Zend\Db\Adapter\AdapterInterface $adapter, 
        $features = null, 
        \Zend\Db\ResultSet\ResultSetInterface $resultSetPrototype = null, 
        \Zend\Db\Sql\Sql $sql = null
    ) {
        parent::__construct($table, $adapter, $features, $resultSetPrototype, $sql);
        
        $this->platform = new \Zend\Db\Adapter\Platform\Mysql($this->adapter->driver);
    }
    
    public function selectWith(Select $select) {
        //$select->getSqlString();
        \DivixUtils\Logs\Debug::dump($select->getSqlString($this->platform));
        return parent::selectWith($select);
    }
    
    protected function executeInsert(Insert $insert) {
        \DivixUtils\Logs\Debug::dump($insert->getSqlString($this->platform), ['log' => true]);
        return parent::executeInsert($insert);
    }

    protected function executeUpdate(Update $update) {
        \DivixUtils\Logs\Debug::dump($update->getSqlString($this->platform), ['log' => true]);
        return parent::executeUpdate($update);
    }
    
    protected function executeDelete(Delete $delete) {
        \DivixUtils\Logs\Debug::dump($delete->getSqlString($this->platform), ['log' => true]);
        return parent::executeDelete($delete);
    }
}
