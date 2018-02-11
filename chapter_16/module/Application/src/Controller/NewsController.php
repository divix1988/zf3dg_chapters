<?php

namespace Application\Controller;

use Application\Model\NewsTable;

class NewsController extends AbstractController
{
    private $newsTable = null;
    
    public function __construct(NewsTable $newsTable)
    {
         $this->newsTable = $newsTable;
    }

    public function indexAction()
    {

    }
    
    public function addcommentAction()
    {
        $eventManager = $this->newsTable->getEventManager();
        
        $rssUtils = new \DivixUtils\RSS();
        $rssUtils->attachEvents($eventManager);
        $emailUtils = new \DivixUtils\Email();
        $emailUtils->attachEvents($eventManager);
        
        ob_start();
        //wykonanie
        echo 'Scenario 1 <br />---<br />';
        $this->newsTable->addComment('', '');
        
        echo '<br /><br />Scenario 2 <br />---<br />';
        $this->newsTable->addComment('new comment', 2);
        
        $results = ob_get_contents();
        ob_end_clean();
        
        return ['results' => $results];
    }
}
