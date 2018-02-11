<?php
namespace Application\Form;

use Zend\Form\Element;

class UserForm extends \Zend\Form\Form
{
    const ELEMENT_USERNAME = 'username';
    
    public function __construct($name = 'user')
    {
        parent::__construct($name);
        $this->setAttribute('class', 'styledForm');

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        $this->add([
            'name' => self::ELEMENT_USERNAME,
            'type' => 'text',
            'options' => [
                'label' => 'Username'
            ]
        ]);
        $this->add([
            'name' => 'email',
            'type' => Element\Email::class,
            'options' => [
                'label' => 'Email address'
            ],
            'attributes' => array(
                 'required' => 'required'
             )
        ]);
        $this->add([
            'type' => UserInfoFieldset::class,
            'name' => 'user_info'
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
                'id'    => 'saveUserForm'
            ]
        ]);
        //by default it is also POST
        $this->setAttribute('method', 'POST');
    }
}