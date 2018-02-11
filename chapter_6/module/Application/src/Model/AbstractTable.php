<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\Rowset\AbstractModel;

class AbstractTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
         $this->tableGateway = $tableGateway;
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
}