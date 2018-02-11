<?php

namespace Application\Controller;
use DivixUtils\Security;
use Application\Model\UsersTable;

class LoginController extends AbstractController
{
    private $usersTable;
    private $dbAdapter;
    
    public function __construct($usersTable, $dbAdapter)
    {
        $this->usersTable = $usersTable;
        $this->dbAdapter = $dbAdapter;
    }
    
    public function indexAction()
    {
        //$hash = $this->sha2('test_pass');
        //print_r($hash);
        //exit();
    
        $this->userDetails = new Security\Adapter(
            $this->dbAdapter,
            'users',
            'email',
            'password',
            'SHA2(CONCAT(password_salt, "FG%7h62CXhi9@zq", ?), 512)'
            //'SHA2(?, 512)'
        );

        $this->userDetails->setIdentity($this->params()->fromPost('email'));
        $this->userDetails->setCredential($this->params()->fromPost('password'));
        
        $result = $this->userDetails->authenticate();
//var_dump($result->getIdentity());
print_r($this->userDetails->getResultRowObject());
        if ($this->userDetails->getResultRowObject()) {
            $valid = 'success';
            $messages = 'Logged correctly';
            //$this->progressLoggedUser();
        } else {
            $valid = 'danger';
            $messages = '<strong>Error</strong> Provided email address or password is incorrect.';
        }
        
        exit('<b>'.$valid.'</b>');
    }
    
    /**
    * Generates a sha512 based password with given salt.
    *
    * @param string $phrase plain password
    * @param string $salt optional salt
    *
    * @return string
    */
    public function sha2($phrase, $salt = null) {
        $result = array();
        $key = 'FG%7h62CXhi9@zq';
        
        if ($salt == null) {
            $salt = $this->generatePassword(8);
        }
            
        $result['salt'] = $salt;
        $result['hash'] = hash('sha512', ($salt).$key.$phrase);
        
        //Debugs_Debug::dump(array('var' => hash('sha512', ($salt).$key.'admin')));
  
        return $result;
    }
    
    /**
    * Creates new password
    *
    * @param int $maximumLength maximum length of the password
    *
    * @return string
    */
    public function generatePassword($maximumLength=14) {
        $chars = 'qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM';
        $shuffle = str_shuffle($chars);
        
        return substr($shuffle, 0, rand(4, $maximumLength));
    }
    
    function progressLoggedUser($getUserDetails = true)
    {
        $sessionUser = new Zend_Session_Namespace('user');
        if ($getUserDetails) {
            $sessionUser->details = $this->userDetails->getIdentity()->toArray();
        }
        /*if ($sessionUser->details['first_login'] == 0) {
            //update login flag
            $usersModel = new Model_Users();
            $usersModel->update(array('first_login' => 1), 'id = '.$sessionUser->details['id']);
        }*/
        
        $authObject = new Security\Authorization();
        $sessionUser->availableResources = $authObject->getResourcesForPermission(NULL, $sessionUser->details['role'], true);
        
        
        if (!empty($sessionUser->addRemovalDetails)) {
            $this->getResponse()->setRedirect($this->_request->getBaseUrl().'/ogloszenie/confirm', 302);
            return;
        }

        if ($_SERVER['HTTP_REFERER'] !== 'http://localhost/zaplanuj_przeprowadzke/website/' &&
            $_SERVER['HTTP_REFERER'] !== 'http://zaplanujtransport.pl/' &&
            $_SERVER['HTTP_REFERER'] !== 'http://localhost/zaplanuj_przeprowadzke/website/register' &&
            $_SERVER['HTTP_REFERER'] !== 'http://zaplanujtransport.pl/register' &&
            $_SERVER['HTTP_REFERER'] !== 'http://localhost/zaplanuj_przeprowadzke/website/login' &&
            $_SERVER['HTTP_REFERER'] !== 'http://zaplanujtransport.pl/login') {
            $this->getResponse()->setRedirect($_SERVER['HTTP_REFERER'], 302);
            return;
        }
        
        if ($sessionUser->details['role'] == 'Admin') {
            $this->getResponse()->setRedirect($this->_request->getBaseUrl().'/admin/index', 302);
        } else if($sessionUser->details['role'] == 'User') {
            $this->getResponse()->setRedirect($this->_request->getBaseUrl().'/user/myaccount', 302);
        }
    }
}
