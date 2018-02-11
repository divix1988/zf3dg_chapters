<?php

namespace DivixUtils\Security;

class Adapter extends \Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter {

    /**
     * Invoke the authenticate() method in the parent once the details exists in database.
     *
     * @return void
     */
    /*public function authenticate() {
        $saltColumn = $this->getSaltColumn();
        if (!is_null($saltColumn)) {
            $query = "SELECT {$saltColumn} FROM " .
                $this->_tableName . " WHERE {$this->_identityColumn} = ?";
            $salt = $this->_zendDb->fetchOne($query, $this->_identity);

            $result = Validate_Validator::sha2($this->_credential, $salt);
            $this->setCredential($result['hash']);
            Debugs_Debug::dump(array('var' => 'AUTH hash: '.$result['hash'].' credential: '.$this->_credential.' salt: '.$salt));
            return parent::authenticate();
        } else {
            throw new Exception("salt column is not set");
        }

    }*/
}
