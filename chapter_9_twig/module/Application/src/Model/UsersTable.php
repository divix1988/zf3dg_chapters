<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class UsersTable
{
    public function __construct(TableGateway $tableGateway)
    {
         $this->tableGateway = $tableGateway;
    }
    
    public function getById($id)
    {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         
         if (!$row) {
             throw new \Exception('user not found with id: '.$id);
         }
         return $row;
    }
    
    public function getBy(array $params = array())
    {
         $results = $this->tableGateway->select();
         
         return $results;
    }
    
    public function save(User $userModel)
    {
        $data = [
            'username' => $userModel->getUsername()
        ];
        $id = $userModel->getId();

        if ($id == 0) {
            $this->tableGateway->insert($data);
            return;
        }
        if (!$this->getById($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update user with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function delete($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}