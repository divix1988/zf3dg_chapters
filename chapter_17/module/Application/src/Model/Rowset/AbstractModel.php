<?php
namespace Application\Model\Rowset;

class AbstractModel
{
    protected $baseUrl;
    protected $id;
    
    public function __construct($baseUrl = null)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getChangedProperties()
    {
		$fields = array();
		foreach ($this as $key => $value) {
			if (isset($value) && $value != null) {
				$fields[$key] = $value;
			}
		}
		
		return $fields;	
	}
    
    public function getEmptyProperties()
    {
		$fields = array();
		foreach ($this as $key => $value) {
			if ($value === null) {
				$fields[$key] = $value;
			}
		}
		
		return $fields;	
	}
}