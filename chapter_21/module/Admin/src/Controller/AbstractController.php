<?php
namespace Admin\Controller;

use Zend\Mvc\MvcEvent;
use Zend\Session;

class AbstractController extends \Zend\Mvc\Controller\AbstractActionController
{
   protected $sessionUser;
   protected $baseUrl;

   protected $cmsObject;
   
   public function __construct($cmsModel) {
       $this->cmsObject = $cmsModel;
   }
   
   public function onDispatch(MvcEvent $e) {
        $this->baseUrl = $this->getRequest()->getBasePath();
        $this->sessionUser = new Session\Container('user');
        $action = $e->getRouteMatch()->getParam('action', 'index');
        $e->getTarget()->layout()->action = $action;
        
        $e->getViewModel()->setVariable('footerContent', $this->cmsObject->getStaticContentByPageName('Footer'));

        return parent::onDispatch($e);
    }

}