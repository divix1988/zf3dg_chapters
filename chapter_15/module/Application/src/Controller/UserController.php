<?php
namespace Application\Controller;
use Zend\Session;
 
class UserController extends AbstractController {

    public function indexAction() {
        $userSession = new Session\Container('user');
        
        return [
            'user' => $userSession->details
        ];
    }

}