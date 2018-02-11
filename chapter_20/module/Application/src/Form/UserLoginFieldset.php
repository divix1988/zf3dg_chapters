<?php
namespace Application\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;

class UserLoginFieldset extends Fieldset implements InputFilterProviderInterface
 {
    const TIMEOUT = 300;
    const ELEMENT_EMAIL = 'email';
    const ELEMENT_PASSWORD = 'password';
    const ELEMENT_CSRF = 'users_csrf';
    
    public function __construct()
    {
        parent::__construct('user_login');
         
        $this->add([
            'type' => Element\Email::class,
            'name' => self::ELEMENT_EMAIL,
            'attributes' => [
                'required' => true,
            ],
            'options' => [
                'label' => 'Email'
            ]
        ]);
        
        $this->add([
            'name' => self::ELEMENT_PASSWORD,
            'type' => Element\Password::class,
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'required' => true
            ],
        ]);
        
        $this->add([
            'name' => self::ELEMENT_CSRF,
            'type' => Element\Csrf::class,
            'options' => [
                'salt' => 'unique',
                'timeout' => self::TIMEOUT
            ],
            'attributes' => [
                'id' => self::ELEMENT_CSRF
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {      
        $validators = [
            [
                'name' => self::ELEMENT_EMAIL,
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
                    ],
                    [
                        'name' => 'EmailAddress',
                        'options' => array( 
                            'messages' => array(
                                \Zend\Validator\EmailAddress::INVALID_FORMAT => 'validator.email.format',
                                \Zend\Validator\EmailAddress::INVALID => 'validator.email.general',
                                \Zend\Validator\EmailAddress::INVALID_HOSTNAME => 'validator.email.hostname',
                                \Zend\Validator\EmailAddress::INVALID_LOCAL_PART => 'validator.email.local',
                                \Zend\Validator\Hostname::UNKNOWN_TLD => 'validator.email.unknown_domain',
                                \Zend\Validator\Hostname::LOCAL_NAME_NOT_ALLOWED => 'validator.email.name_not_allowed'
                            )
                        )
                    ]
                ]
            ],
            [
                'name' => self::ELEMENT_PASSWORD,
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
        ];
        
        //let's add extra DB validator to the register form, bypassing login form
        if (!empty($this->getOption('dbAdapter'))) {
            $validators[0]['validators'][] = [
                'name' => \Zend\Validator\Db\NoRecordExists::class,
                'options' => array(
                    'adapter' => $this->getOption('dbAdapter'),
                    'table' => 'users',
                    'field' => 'email',
                    'messages' => array(
                        \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'Provided email address already exists in database'
                    )
                )
            ];
        }
        
        return $validators;
    }
 }