<?php
namespace ApplicationApi\V1\Rpc\Encryption;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class EncryptionController extends AbstractActionController
{
    public function encryptionAction()
    {
        $event = $this->getEvent();
        $inputFilter = $event->getParam('ZF\ContentValidation\InputFilter');
        $input = $inputFilter->getValue('input');
        
        return new ViewModel([
            $input => sha1($input)
        ]);
    }
}
