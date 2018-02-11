<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;

class AbstractController extends AbstractActionController
{
    /*public function onDispatch(MvcEvent $e)
    {
        $controllerClass = $e->getRouteMatch()->getParam('controller', 'index');
        $e->getViewModel()->setVariable('controller', $controllerClass);
        
        return parent::onDispatch($e);
    }*/
    
    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);

        $events->attach('dispatch', function ($e) {
            $controllerClass = $e->getRouteMatch()->getParam('controller', 'index');
            $e->getViewModel()->setVariable('controller', $controllerClass);
        }, 100); // a function would be called before the controller's action
    }
}