<?php
namespace Admin\Form;

use Zend\Form\Element;

class AddLangContent extends \Zend\Form\Form implements \Zend\InputFilter\InputFilterProviderInterface
{
   
    protected $contentID;
    
    const ELEMENT_CONTENT = 'content';
    const ELEMENT_LANGUAGE = 'language';
   
    public function __construct($id, $langOptions) {
        $this->contentID = $id;
        parent::__construct('add_lang_content_form');

        $this->setAttribute('action', '../addlangcontent/'.$this->contentID);
        $this->setAttribute('class', 'styledForm');

        $this->add([
            'name' => self::ELEMENT_CONTENT,
            'type' => Element\Textarea::class,
            'options' => [
                'label' => 'Contents'
            ],
            'attributes' => [
                'required' => true
            ],
        ]);

        foreach($langOptions as $lang) {
           $dropDownElements[$lang['id']] = $lang['name'];
        }

        $this->add([
            'name' => self::ELEMENT_LANGUAGE,
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Language',
                'value_options' => $dropDownElements
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

        $this->completeMsg = 'form.addLangContent.success';
    }
   
    public function getInputFilterSpecification()
    {
        return [
            [
                'name' => self::ELEMENT_CONTENT,
                'filters' => [
                    ['name' => \Zend\Filter\StringTrim::class]
                ]
            ],
            [
                'name' => self::ELEMENT_LANGUAGE,
                'filters' => [
                    ['name' => \DivixUtils\Zend\Filter\FriendlyUrl::class],
                ],
                'validators' => [
                    [
                        'name' => \Zend\Validator\NotEmpty::class,
                    ]
                ]
            ]
        ];
    }

}