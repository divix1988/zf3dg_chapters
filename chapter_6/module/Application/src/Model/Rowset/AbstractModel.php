<?php
namespace Application\Model\Rowset;

class AbstractModel
{
    protected $baseUrl;
    
    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    

}