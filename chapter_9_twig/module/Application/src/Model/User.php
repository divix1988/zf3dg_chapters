<?php

namespace Application\Model;

// Add the following import statements:
use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class User implements InputFilterAwareInterface
{
    public $id;
    public $username;
    public $password;
     
    private $inputFilter;

    public function exchangeArray($row)
    {
        $this->id     = (!empty($row['id'])) ? $row['id'] : null;
        $this->username = (!empty($row['username'])) ? $row['username'] : null;
        $this->password  = (!empty($row['password'])) ? $row['password'] : null;
    }
     
    public function getId() {
        return $this->id;
    }
     
    public function getUsername() {
        return $this->username;
    }
     
    public function getPassword() {
        return $this->password;
    }
     
     
     
    /* Add the following methods: */
    public function getArrayCopy()
    {
       return [
           'id'     => $this->getId(),
           'username' => $this->getUsername()
       ];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
       throw new DomainException(sprintf(
           '%s does not allow injection of an alternate input filter',
           __CLASS__
       ));
    }

    public function getInputFilter()
    {
       if ($this->inputFilter) {
           return $this->inputFilter;
       }

       $inputFilter = new InputFilter();

       $inputFilter->add([
           'name' => 'id',
           'required' => true,
           'filters' => [
               ['name' => ToInt::class],
           ],
       ]);

       $inputFilter->add([
           'name' => 'username',
           'required' => true,
           'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
           ],
           'validators' => [
               [
                   'name' => StringLength::class,
                   'options' => [
                       'encoding' => 'UTF-8',
                       'min' => 1,
                       'max' => 100,
                   ],
               ],
           ],
       ]);

       $this->inputFilter = $inputFilter;
       return $this->inputFilter;
    }
}
