<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\UsersTable;
use Application\Model\Rowset\User;
use Application\Form\UserForm;

class UsersController extends AbstractActionController
{
    private $usersTable = null;
    
    public function __construct(UsersTable $usersTable)
    {
         $this->usersTable = $usersTable;
    }

    public function indexAction()
    {
        $view = new ViewModel();
        $rows = $this->usersTable->getBy();
        
        $view->setVariable('userRows', $rows);
        
        return $view;
    }
    
    public function addAction()
    {
        $request = $this->getRequest();
        $userForm = new UserForm();
        $userForm->get('submit')->setValue('Add');

        if (!$request->isPost()) {
            return ['userForm' => $userForm];
        }

        $userModel = new User();
        $userForm->setInputFilter($userModel->getInputFilter());
        $userForm->setData($request->getPost());

        if (!$userForm->isValid()) {
            return ['userForm' => $userForm];
        }

        $userModel->exchangeArray($userForm->getData());
        $this->usersTable->save($userModel);
        return $this->redirect()->toRoute('users');
    }
    
    public function editAction()
    {
        $view = new ViewModel();
        $userId = (int) $this->params()->fromRoute('id');
        $view->setVariable('userId', $userId);

        if (0 == $userId) {
            return $this->redirect()->toRoute('users', ['action' => 'add']);
        }
        // Retrieve the user with the specified id. Doing so raises
        // an exception if the user is not found, which should result
        // in redirecting to the landing page.
        try {
            $userRow = $this->usersTable->getById($userId);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('users', ['action' => 'index']);
        }

        $userForm = new UserForm();
        $userForm->bind($userRow);
        $userForm->get('submit')->setAttribute('value', 'Save');

        $request = $this->getRequest();
        $view->setVariable('userForm', $userForm);

        if (!$request->isPost()) {
            return $view;
        }
        $userForm->setInputFilter($userRow->getInputFilter());
        $userForm->setData($request->getPost());

        if (!$userForm->isValid()) {
            return $view;
        }
        $this->usersTable->save($userRow);

        // Redirect to users list
        return $this->redirect()->toRoute('users', ['action' => 'index']);
    }
    
    public function deleteAction()
    {
        $userId = (int) $this->params()->fromRoute('id');
        
        if (empty($userId)) {
            return $this->redirect()->toRoute('users');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Cancel');

            if ($del == 'Delete') {
                $userId = (int) $request->getPost('id');
                $this->usersTable->delete($userId);
            }
            // Redirect to list of users
            return $this->redirect()->toRoute('users');
        }

        return [
            'id' => $userId,
            'user' => $this->usersTable->getById($userId),
        ];
    }
}
