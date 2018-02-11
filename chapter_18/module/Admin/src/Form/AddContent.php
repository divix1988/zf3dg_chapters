<?php

namespace Admin\Form;

use Zend\Form\Element;

class AddContent extends \Zend\Form\Form implements \Zend\InputFilter\InputFilterProviderInterface
{    
    const ELEMENT_NAME = 'name';
   
    public function __construct() {
        parent::__construct('add_content');
        $this->setAttribute('class', 'styledForm');

        $this->add([
            'name' => self::ELEMENT_NAME,
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'required' => true
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Add',
                'class' => 'btn btn-primary'
            ]
        ]);

        $this->completeMessage = 'form.addContent.success';
    }
    
    public function getInputFilterSpecification()
    {
        return [
            [
                'name' => self::ELEMENT_NAME,
                'filters' => [
                    ['name' => \Zend\Filter\StringTrim::class]
                ],
                'validators' => [
                    [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 2,
                            'messages' => [
                                \Zend\Validator\StringLength::TOO_SHORT => 'The minimum length is: %min%'
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }

}