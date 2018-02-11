<?php

namespace Application\Model\Rowset;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;
use Zend\Validator;

class User extends AbstractModel implements InputFilterAwareInterface
{
    public $username;
    public $password;
    public $email;
    
    public $gender;
    public $education;
     
    private $inputFilter;

public function exchangeArray($row)
{
    $this->id = (!empty($row['id'])) ? $row['id'] : null;
    $this->username = (!empty($row['username'])) ? $row['username'] : null;
    $this->password = (!empty($row['password'])) ? $row['password'] : null;
    $this->email = (!empty($row['email'])) ? $row['email'] : null;
    $this->gender = (!empty($row['gender'])) ? $row['gender'] : null;
    $this->education = (!empty($row['education'])) ? $row['education'] : null;
}
     
    public function getId() {
        return $this->id;
    }
    public function setId($value) {
        $this->id = $value;
    }
     
    public function getUsername() {
        return $this->username;
    }
     
    public function getPassword() {
        return $this->password;
    }
     
    public function getEmail() {
        return $this->email;
    }
    
    public function getGender() {
        return $this->gender;
    }
    
    public function getEducation() {
        return $this->education;
    }
     
    /* Add the following methods: */
    public function getArrayCopy()
    {
       return [
           'id' => $this->getId(),
           'username' => $this->getUsername(),
           'email' => $this->getEmail(),
           'gender' => $this->getGender(),
           'education' => $this->getEducation()
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
       $inputFilter->add([
           'name' => 'email',
           'required' => true,
           'filters' => [
               ['name' => StringTrim::class]
           ],
           'validators' => [
               ['name' => Validator\EmailAddress::class]
           ],
       ]);

       $this->inputFilter = $inputFilter;
       return $this->inputFilter;
    }
}
