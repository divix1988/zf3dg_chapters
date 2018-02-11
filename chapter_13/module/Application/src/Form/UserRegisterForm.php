<?php
namespace Application\Form;

use Zend\Form\Element;

class UserRegisterForm extends UserForm
{
    public function __construct($name = 'register_user')
    {
        parent::__construct($name);

        $this->add([
            'name' => 'password',
            'type' => Element\Password::class,
            'options' => [
                'label' => 'Password'
            ],
            'attributes' => array(
                 'required' => 'required'
             )
        ]);
    }
}