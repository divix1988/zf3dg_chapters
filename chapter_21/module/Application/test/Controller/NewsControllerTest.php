<?php
namespace ApplicationTest\Controller;

use Application\Controller\NewsController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class NewsControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    
    public function setUp()
    {
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/news', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(NewsController::class);
        $this->assertControllerClass('NewsController');
        $this->assertMatchedRouteName('news');
    }

    public function testIndexActionViewModelTemplateRenderedWithinLayout()
    {
        $this->dispatch('/news', 'GET');
        $selector = '.jumbotron .zf-green';
        
        $this->assertQuery($selector);
        $this->assertQueryCount($selector, 1);
        $this->assertQueryContentContains($selector, 'Articles');
        
        //xpath
        $this->assertXpathQuery("//span[@class='zf-green']");
    }

    public function testInvalidRouteDoesNotCrash()
    {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }
}
