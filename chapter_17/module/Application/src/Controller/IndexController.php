<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Application\Model\UsersTable;
use Main_View_Smarty;

class IndexController extends AbstractController
{
    private $usersTable = null;
    
    public function __construct(UsersTable $usersTable)
    {
         $this->usersTable = $usersTable;
    }

    public function indexAction()
    {
        $view = new ViewModel();
        $model = $this->usersTable;
        $row = $model->getById(1);

        $view->setVariable('id', $row->getId());
        $view->setVariable('username', $row->getUsername());
        $view->setVariable('password', $row->getPassword());
        
        \DivixUtils\Logs\Debug::dump('short messages');
        \DivixUtils\Logs\Debug::dump('medium messages', ['desc' => 'medium', 'log' => true]);
        \DivixUtils\Logs\Debug::dump('long messages', ['desc' => 'long']);
        //metoda();
        //
        //$this->getResponse()->setStatusCode(404);

        return $view;
    }
}
