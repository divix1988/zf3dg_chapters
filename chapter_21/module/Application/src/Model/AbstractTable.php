<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\Rowset\AbstractModel;
use DivixUtils\Zend\Paginator\Paginator as CustomPaginator;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Cache\StorageFactory;

class AbstractTable
{
    protected $tableGateway;
    public static $paginatorCache;
    public static $paginatorCacheEnabled = true;
    
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
         
        if (empty(self::$paginatorCache)) { 
            // we set a cache of local text file in folder data/cache and
            // we apply serializer conversion for storing data
            // our copy will be removed aftre 10 minutes (600 seconds)
            self::$paginatorCache = StorageFactory::factory([
                'adapter' => [
                    'name' => 'filesystem',
                    'options' => [
                        'cache_dir' => 'data/cache',
                        'ttl' => 600
                    ]
                ],
                'plugins' => ['serializer'],
            ]);
            CustomPaginator::setCache(self::$paginatorCache);
        }
    }

    public function saveRow(AbstractModel $userModel, $data = null)
    {
        $id = $userModel->getId();
        
        //if parameter $data is not passed in, then we will update all properties
        if (empty($data)) {
            $data = $userModel->getArrayCopy();
        }
        if (empty($id)) {
            $this->tableGateway->insert($data);
            
            return $this->tableGateway->getLastInsertValue();
        }
        if (!$this->getById($id)) {
            throw new RuntimeException(get_class($userModel) .' with id: '.$id.' not found');
        }

        $this->tableGateway->update($data, ['id' => $id]);
        return $id;
    }
    
    public function deleteRow($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
    
    public function getTableGateway()
    {
        return $this->tableGateway;
    }
    
    protected function fetchAll($select, array $paginateOptions = null)
    {
        if (!empty($paginateOptions)) {
            //create first an adapter, whch we will pass to the Paginator
            $paginatorAdapter = new DbSelect(
                $select,
                $this->tableGateway->getAdapter(),
                $this->tableGateway->getResultSetPrototype()
            );
            $paginator = new CustomPaginator($paginatorAdapter);
            $paginator->setCacheEnabled(self::$paginatorCacheEnabled);
            //set amount of records per one page
            $paginator->setItemCountPerPage($paginateOptions['limit']);
            
            //if page parameter is passed, then we set offset fo results
            if (isset($paginateOptions['page'])) {
                $paginator->setCurrentPageNumber($paginateOptions['page']);
            }
            
            return $paginator;
        }

        return $this->tableGateway->selectWith($select);
    }
    
    protected function fetchRow($passedSelect)
    {
        $row = $this->tableGateway->selectWith($passedSelect);
        
        return $row->current();
    }
    
    public function disableCache()
    {
        self::$paginatorCache = 'disabled';
        self::$paginatorCacheEnabled = false;
    }
}