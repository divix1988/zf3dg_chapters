<?php

namespace DivixUtils\Security;

class Authentication {

    /**
     * @var Helper_User
     */
    protected $_userModel;

    /**
     * @var Zend_Auth
     */
    protected $_auth;
    
    protected $adapter;
    protected $dbAdapter;

    /**
     * Construct 
     * 
     * @param null|Model_User $userModel 
     */
    public function __construct($dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        
        $this->adapter = new Adapter(
            $this->dbAdapter,
            'users',
            'email',
            'password',
            'SHA2(CONCAT(password_salt, "'.Helper::SALT_KEY.'", ?), 512)'
            //'SHA2(?, 512)'
        );
    }

    /**
     * Authenticate a user
     *
     * @param  array $credentials Matched pair array containing email/passwd
     * @return boolean
     */
    public function authenticate($email, $password) {
        if (empty($email) || empty($password)) {
            return false;
        }

        $this->adapter->setIdentity($email);
        $this->adapter->setCredential($password);
        
        $result = $this->adapter->authenticate();
//var_dump($result->getIdentity());
//print_r(json_decode(json_encode($this->adapter->getResultRowObject()), true));
        
        return true;
    }
    
    /**
     * Returns the user's identity object
     */
    public function getIdentity() {
        return $this->getAdapter()->getResultRowObject();
    }
    
    public function getIdentityArray()
    {
        return json_decode(json_encode($this->adapter->getResultRowObject()), true);
    }

    public function getAdapter() {
        return $this->adapter;
    }
}
