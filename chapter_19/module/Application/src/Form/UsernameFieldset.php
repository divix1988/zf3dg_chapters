<?php
namespace Application\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;

class UsernameFieldset extends Fieldset implements InputFilterProviderInterface
 {
    const ELEMENT_USERNAME = 'username';
    
    public function __construct()
    {
        parent::__construct('user_username');
         
        $this->add([
            'name' => self::ELEMENT_USERNAME,
            'type' => 'text',
            'options' => [
                'label' => 'Username'
            ],
            'attributes' => [
                'required' => true
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return array(
            [
                'name' => self::ELEMENT_USERNAME,
                'required' => true,
                'filters' => [
                    ['name' => \Zend\Filter\StringTrim::class]
                ],
                'validators' => [
                    [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 5,
                            'messages' => [
                                \Zend\Validator\StringLength::TOO_SHORT => 'The minimum length is: %min%'
                            ]
                        ]
                    ]
                ]
            ]
        );
    }
 }