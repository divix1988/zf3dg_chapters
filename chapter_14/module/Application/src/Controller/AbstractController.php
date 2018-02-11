<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\Session;

class AbstractController extends AbstractActionController
{
    protected $baseUrl;
    /*public function onDispatch(MvcEvent $e)
    {
        $controllerClass = $e->getRouteMatch()->getParam('controller', 'index');
        $e->getViewModel()->setVariable('controller', $controllerClass);
        
        return parent::onDispatch($e);
    }*/
    
    public function onDispatch(MvcEvent $e) {
        $this->baseUrl = $this->getRequest()->getBasePath();
        
        return parent::onDispatch($e);
    }
    
    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);

        $events->attach('dispatch', function ($e) {
            $controllerClass = $e->getRouteMatch()->getParam('controller', 'index');
            $e->getViewModel()->setVariable('controller', $controllerClass);
            
            $userSession = new Session\Container('user');
            
            if ($userSession->details) {
                $e->getViewModel()->setVariable('user', $userSession->details);
            }
        }, 100); // a function would be called before the controller's action
    }
}