<?php
namespace ApplicationTest\Model\Rowset;

use Application\Model\Rowset\Comics;
use Application\Form\ComicsForm;
use PHPUnit_Framework_TestCase as TestCase;

class ComicsTest extends TestCase
{
    public function setup()
    {
        parent::setup();
    }
    
    public function testInitialComicsValuesAreNull()
    {
        $comics = new Comics();

        $this->assertNull($comics->id, 'initial value id should equals to null');
        $this->assertNull($comics->title, 'initial value title should equals to null');
        $this->assertNull($comics->thumb, 'initial value thumb should equals to null');
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $comics = new Comics();
        $data  = $this->getComicsData();

        //sprawdźmy początkową tablicę
        $comics->exchangeArray($data);

        $this->assertSame(
            $data['id'],
            $comics->getId(),
            'parameter id nie został porpawnie ustawiony'
        );
        $this->assertSame(
            $data['title'],
            $comics->getTitle(),
            'paramer title nie został porpawnie ustawiony'
        );
        $this->assertSame(
            $data['thumb'],
            $comics->getThumb(),
            'parameter thumb nie został porpawnie ustawiony'
        );
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $comics = new Comics();

        $comics->exchangeArray($this->getComicsData());
        $comics->exchangeArray([]);

        $this->assertNull($comics->id, 'initial value id should equals to null');
        $this->assertNull($comics->title, 'initial value title should equals to null');
        $this->assertNull($comics->thumb, 'initial value thumb should equals to null');
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
        $comics = new Comics();
        $data  = $this->getComicsData();

        $comics->exchangeArray($data);
        $copyArray = $comics->getArrayCopy();

        $this->assertSame($data['id'], $copyArray['id'], 'parameter id nie został porpawnie ustawiony');
        $this->assertSame($data['title'], $copyArray['title'], 'parameter title nie został porpawnie ustawiony');
        $this->assertSame($data['thumb'], $copyArray['thumb'], 'parameter thumb nie został porpawnie ustawiony');
    }

    public function testInputFiltersAreSetCorrectly()
    {
        $comics = new Comics();

        $inputFilter = $comics->getInputFilter();

        $this->assertSame(3, $inputFilter->count());
        $this->assertTrue($inputFilter->has('id'));
        $this->assertTrue($inputFilter->has('title'));
        $this->assertTrue($inputFilter->has('thumb'));
    }
    
    /**
     * @dataProvider getInvalidComicsData
     * @group inputFilters
     */
    public function testInputFiltersIncorrect($row)
    {
        $comics = new Comics();

        $comicsForm = new ComicsForm();
        $comicsForm->setInputFilter($comics->getInputFilter());
        $comicsForm->bind($comics);
        $comicsForm->setData($row);
        
        $this->assertFalse($comicsForm->isValid());
        $this->assertTrue(count($comicsForm->getMessages()) > 0);
    }
    
    /**
     * @group inputFilters
     * @author adam.omelak
     */
    public function testInputFiltersSuccess()
    {
        $comics = new Comics();

        $comicsForm = new ComicsForm();
        $comicsForm->setInputFilter($comics->getInputFilter());
        $comicsForm->bind($comics);
        $comicsForm->setData($this->getComicsData());
        
        $this->assertTrue($comicsForm->isValid());
        $this->assertCount(0, $comicsForm->getMessages());
    }
    
    /**
     * @group inputFilters
     */
    public function testInputFiltersFixtureSuccess()
    {
        $fixture = include __DIR__ . '/../../Fixtures/Comics.php';
        $counter = 0;
        
        foreach ($fixture as $comicsData) {
            $comics = new Comics();
            $comicsForm = new ComicsForm();
            
            $comicsForm->setInputFilter($comics->getInputFilter());
            $comicsForm->bind($comics);
            $comicsForm->setData($comicsData);

            $this->assertTrue($comicsForm->isValid());
            $counter++;
        }
        $this->assertEquals(count($fixture), $counter);
    }
    
    
    public function getInvalidComicsData()
    {
        return [
            [
                [
                    'id' => null,
                    'title' => null,
                    'thumb' => null
                ],
                [
                    'id' => '',
                    'title' => 'null',
                    'thumb' => 'null'
                ],
                [
                    'id' => 123,
                    'title' => '',
                    'thumb' => 'file.jpg'
                ]
            ]
        ];
    }
    
    private function getComicsData()
    {
        return [
            'id'     => 123,
            'title'  => 'Testman',
            'thumb' => 'file.jpg'
        ];
    }
}