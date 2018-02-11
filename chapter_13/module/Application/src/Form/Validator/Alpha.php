<?php

namespace Application\Form\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Validator\Regex;

class Alpha extends AbstractValidator
{
    const STRING_EMPTY = 'alphaStringEmpty';
    const INVALID      = 'alphaInvalid';
    
    /**
     * Static Regex class instance, avoids creation of multiple objects of the same class
     * 
     * @var Zend\Validator\Regex
     */
    protected static $regexValidator;
    
    /**
     * Messages about errors
     *
     * @var array
     */
    protected $messageTemplates = [
        self::STRING_EMPTY => "The input is an empty string",
        self::INVALID => "Invalid type given, only aplha characters allowed",
    ];

    /**
     * Returns true if the $value is made only from a-z characters
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->error(self::INVALID);
            echo 'val: '.$value;
            return false;
        }

        $this->setValue((string) $value);

        if (empty($this->getValue())) {
            $this->error(self::STRING_EMPTY);
            return false;
        }
        
        if (static::$regexValidator == null) {
            static::$regexValidator = new Regex(['pattern' => "/^[a-z]+$/"]);
        }

        if (!static::$regexValidator->isValid($this->getValue())) {
            $this->error(self::INVALID);
            echo 'val: '.$value;
            return false;
        }

        return true;
    }
}
