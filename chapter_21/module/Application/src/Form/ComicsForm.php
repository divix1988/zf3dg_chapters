<?php
namespace Application\Form;

use Zend\Form\Element;

class ComicsForm extends \Zend\Form\Form
{
    
    public function __construct($name = 'comics')
    {
        parent::__construct($name);

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Username'
            ]
        ]);
        $this->add([
            'name' => 'thumb',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'File'
            ],
            'attributes' => array(
                'required' => 'required'
            )
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
            ]
        ]);
    }
}