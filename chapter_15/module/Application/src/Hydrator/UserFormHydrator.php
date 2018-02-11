<?php

namespace Application\Hydrator;
use Application\Form;

class UserFormHydrator implements \Zend\Hydrator\Strategy\StrategyInterface
{
    protected $securityHelper;
    
    public function __construct($securityHelper)
    {
        $this->securityHelper = $securityHelper;
    }
    
    public function hydrate($form)
    {
        if (!$form instanceof \Application\Form\UserRegisterForm) {
            throw new \Exception('incorrect form object passed to '.__CLASS__);
        }
        $data = $form->getData();
        $hashedPassword = $this->securityHelper->sha512($data[$form::FIELDSET_LOGIN][Form\UserLoginFieldset::ELEMENT_PASSWORD]);

        return [
            'username' => $data[$form::FIELDSET_USERNAME][Form\UsernameFieldset::ELEMENT_USERNAME],
            'email' => $data[$form::FIELDSET_LOGIN][Form\UserLoginFieldset::ELEMENT_EMAIL],
            'password' => $hashedPassword['hash'],
            'password_salt' => $hashedPassword['salt']
        ];
    }

    public function extract($array)
    {
        return $array;
    }

}
