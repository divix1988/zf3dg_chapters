<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

class NewsTable implements EventManagerAwareInterface
{
    public function __construct(TableGateway $tableGateway)
    {
         $this->tableGateway = $tableGateway;
    }
    
    public function addComment($comment, $userId)
    {
        $params = ['user_id' => $userId, 'comment' => $comment];
        $results = $this->getEventManager()->trigger('news.addcomment', $this, $params);
        
        //if event has been stopped by any of the class, then we do not add a record to db
        if (!$results->stopped()) {
            //add to DB
            echo 'SUCCESS';
            return true;
        }
        echo 'ERROR: Event has been stopped by the listener <br />';
        return false;
    }
    
    protected $events;

    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers([
            __CLASS__,
            get_class($this)
        ]);
        $this->events = $events;
    }

    public function getEventManager()
    {
        if (! $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }
}