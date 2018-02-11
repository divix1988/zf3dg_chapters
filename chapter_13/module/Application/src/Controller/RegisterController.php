<?php
namespace Application\Controller;
use Application\Form;
 
class RegisterController extends AbstractController {
    protected $usersModel;
    
    public function __construct($usersModel)
    {
        $this->usersModel = $usersModel;
    }

    public function indexAction() {
        //$this->view->title = $this->lang->translate('title.register');
        
        $this->flashMessenger()->addMessage('You are now logged in.');
        $form = new Form\UserRegisterForm();
        $viewParams = [
            'userForm' => $form
        ];

		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->params()->fromPost())) {
                try {
                    $this->usersModel->add($form);
                    
                    //logging user
                    /*$this->userDetails = new Security_Authentication(new Model_Users());
                    $this->userDetails->authenticate(
                        array(
                            'login' => $form->getElement($form::ELEMENT_EMAIL)->getValue(),
                            'pass' => $form->getElement($form::ELEMENT_PASSWORD)->getValue()
                        )
                    );*/
                    
                    //session creation
                    //@TODO move this to the Security package
                    /*$sessionUser = new Zend_Session_Namespace('user');
                    $sessionUser->details = $this->userDetails->getIdentity()->toArray();*/
                    $this->getResponse()->setRedirect($this->_request->getBaseUrl().'/login/progressuser', 302);
                } catch (\Exception $e) {
                    if ($e->getMessage() == 'Email exists') {
                        $viewParams['messages'] = Flash_Messages::display($this->lang->_('form.error.accountExists'), 'danger');
                    }
                }
			}
		}
        
        return $viewParams;
    }

}