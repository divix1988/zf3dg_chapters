<?php

namespace DivixUtils\Security;

class Authentication extends \Zend\Authentication\AuthenticationService {

    protected $adapter;
    protected $dbAdapter;

    public function __construct($dbAdapter, $authAdapter) {
        $this->dbAdapter = $dbAdapter;
        $this->adapter = $authAdapter;
    }

    public function auth($email, $password) {
        if (empty($email) || empty($password)) {
            return false;
        }

        $this->adapter->setIdentity($email);
        $this->adapter->setCredential($password);
        
        $result = $this->adapter->authenticate();
        $this->authenticate($this->adapter);
        
        return $result;
    }
    
    public function getIdentityArray()
    {
        return json_decode(json_encode($this->adapter->getResultRowObject()), true);
    }

    public function getAdapter() {
        return $this->adapter;
    }

}
