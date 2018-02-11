<?php

namespace DivixUtils;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventInterface;

class Email
{
    private $listeners = [];
    
    public function attachEvents(EventManagerInterface $eventManager)
    {
        $this->listeners[] = $eventManager->attach('news.addcomment', [$this, 'send'], 2);
    }
    
    public function send(EventInterface $e)
    {
        $eventParams = $e->getParams();
        
        if (empty($eventParams['user_id']) || empty($eventParams['comment'])) {
            $e->stopPropagation(true);
            echo 'Email: user_id or comment is empty <br />';
        } else {
            echo 'Email: params: '.json_encode($eventParams).'<br />';
            echo 'Email: sending email <br />';
        }
    }
}