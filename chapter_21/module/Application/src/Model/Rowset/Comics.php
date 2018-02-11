<?php

namespace Application\Model\Rowset;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Validator\StringLength;

class Comics extends AbstractModel implements InputFilterAwareInterface
{
    public $title;
    public $thumb;
    public $gaaw;
    protected $inputFilter;

    public function exchangeArray($row)
    {
        $this->id    = (!empty($row['id'])) ? $row['id'] : null;
        $this->title = (!empty($row['title'])) ? $row['title'] : null;
        $this->thumb = (!empty($row['thumb'])) ? $row['thumb'] : null;
    }
     
    public function getId() {
        return $this->id;
    }
    public function setId($value) {
        $this->id = $value;
    }
     
    public function getTitle() {
        return $this->title;
    }
    
    public function getThumb() {
        return $this->thumb;
    }
    
    public function getThumbUrl() {
        return $this->baseUrl.'public/uploads/'.$this->thumb;
    }
     
    public function getArrayCopy()
    {
       return [
           'id' => $this->getId(),
           'title' => $this->getTitle(),
           'thumb' => $this->getThumb()
       ];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
       $this->inputFilters = $inputFilter;
    }

    public function getInputFilter()
    {
       if ($this->inputFilter) {
           return $this->inputFilter;
       }

       $inputFilter = new InputFilter();

       $inputFilter->add([
           'name' => 'id',
           'required' => true,
           'filters' => [
               ['name' => ToInt::class],
           ],
       ]);

       $inputFilter->add([
           'name' => 'title',
           'required' => true,
           'filters' => [
               ['name' => StripTags::class],
               ['name' => StringTrim::class],
           ],
           'validators' => [
               [
                   'name' => StringLength::class,
                   'options' => [
                       'encoding' => 'UTF-8',
                       'min' => 1,
                       'max' => 100,
                   ],
               ],
           ],
       ]);
       $inputFilter->add([
           'name' => 'thumb',
           //'required' => true,
           'filters' => [
               ['name' => StringTrim::class]
           ],
       ]);

       $this->inputFilter = $inputFilter;
       return $this->inputFilter;
    }
}
