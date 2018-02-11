<?php

namespace DivixUtils;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventInterface;

class RSS
{
    private $listeners = [];
    
    public function attachEvents(EventManagerInterface $eventManager)
    {
        $this->listeners[] = $eventManager->attach('news.addcomment', [$this, 'incrementUsersCount'], 1);
    }

    
    public function incrementUsersCount(EventInterface $e)
    {
        echo 'RSS: updating RSS<br />';
    }
}