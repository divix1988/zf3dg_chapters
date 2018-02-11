<?php

namespace DivixUtils\Security;

class Helper
{
    const SALT_KEY = 'FG%7h62CXhi9@zq';
    
    /**
    * Generates a sha512 based password with given salt.
    *
    * @param string $phrase plain password
    * @param string $salt optional salt
    *
    * @return string
    */
    public function sha512($phrase, $salt = null)
    {
        $result = array();
        
        if ($salt == null) {
            $salt = $this->generatePassword(8);
        }
        $result['salt'] = $salt;
        $result['hash'] = hash('sha512', $salt.self::SALT_KEY.$phrase);
  
        return $result;
    }
    
    /**
    * Creates new password
    *
    * @param int $maximumLength maximum length of the password
    *
    * @return string
    */
    public function generatePassword($maximumLength = 14)
    {
        $chars = 'qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM';
        $shuffle = str_shuffle($chars);
        
        return substr($shuffle, 0, rand(4, $maximumLength));
    }
}
