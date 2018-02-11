<?php
namespace Application\Model\Rowset;

class AbstractModel
{
    protected $baseUrl;
    
    public function __construct($baseUrl = null)
    {
        $this->baseUrl = $baseUrl;
    }

    

}