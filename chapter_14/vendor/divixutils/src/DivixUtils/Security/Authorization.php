<?php

namespace DivixUtils\Security;

class Authorization {
    
    protected $prefix;
    protected $db;
	
	public function __construct() {
		$this->prefix = 'zp_';
		$this->db = Zend_Db_Table::getDefaultAdapter();
	}
	
	/**
	* Returns all available roles.
	*
	* @return array
	*/
	public function getRoles(){
	    $select = $this->db->select()
		    ->from( 
			    array($this->prefix.'permissions')
			    );

	    return $this->db->fetchAll($select);
	}
	
	/**
	 * Add new role
	 * @param string $permission unique key for permission
	 * @param string $description description for permission
	 * @return true if added
	 * 
	*/
	public function addRole($permission,$description){
		if(!$this->isRoleExist($permission)){
			$data = array(
				'name' => Validate_Validator::sanitizeHTML($permission ),
				'description' => Validate_Validator::sanitizeHTML( $description)		
			);
			//print_r($data);
			if($this->db->insert($this->prefix.'permissions', $data))return true;
			else return false;	
		}else{
			return false;
		}
	}
	
	/**
	 * Update a permission
	 * @param string $permission unique key for permission
	 * @param string $description description for permission
	 * @return true if updated
	 * 
	*/
	public function updateRole($permission,$description){
			$data = array(
				'permission' => Validate_Validator::sanitizeHTML( $permission ),
				'description' => Validate_Validator::sanitizeHTML( $description)
			);
			if($this->db->update($this->prefix.'permissions', $data,'permission=\''.$this->validator->clear_all( $permission ).'\''))return true;
			else return false;	
	}
	
	/**
	 * Check role is exist
	 * @param $permission permission to check
	 * @return true if $permission exist in database
	*/
	public function isRoleExist($permission){
		$sql = "SELECT COUNT(DISTINCT id) AS count FROM ".$this->prefix.'permissions'." WHERE name=? LIMIT 1";
		$result = $this->db->fetchAll($sql,Validate_Validator::sanitizeHTML($permission));
		if($result[0]['count']>0)return true;
		else return false;
	}
	
	/**
	 * Check level is exist
	 * @param $level leveln to check
	 * @return true if $level exist in database
	*/
	public function isResourceExists($level){
		$sql = "SELECT COUNT(DISTINCT id) AS count FROM ".$this->prefix.'resources'." WHERE name=? LIMIT 1";
		$result = $this->db->fetchAll($sql,$this->validator->clear_all($level));
		if($result[0]['count']>0)return true;
		else return false;
	}
	
	
	/**
	 * Get permissions
	 * @param $id if given return only permission corresponding this id
	 * @return array with permissions
	*/
	public function get_permission($id=NULL){
		if($id){
			$id = (int)$id;
			$select = $this->db->select()
					->from( $this->prefix.'permissions' )
					->where('id = ?', $id);
		}else{
			$select = $this->db->select()
					->from( $this->prefix.'permissions' );
		}
		return $this->db->fetchAll($select);
	}
	
	/**
	 * Removes role
	 * @param $id 
	 * @return true if removed
	*/
	public function removeRole($id){
		$id = (int)$id;
		$this->db->delete($this->prefix.'permission_to_resource', "permission_id = $id");
		return $this->db->delete($this->prefix.'permissions', "id = $id");	
	}
	
	/**
	 * Add new role level
	 * @param string $name unique name for permission level
	 * @param string $description description for permission level
	 * @return true if added
	 * 
	*/
	public function addLevel($name,$description){
		if(!$this->level_exist($name)){
			$data = array(
					'name' => $this->validator->clear_all( $name ),
					'description' => $this->validator->clear_all( $description )		
			);
			if($this->db->insert($this->prefix.'resources', $data))return true;
			else return false;
		}else{
			return false;
		}	
	}
	
	/**
	 * Get resources
	 * @param $id if given return only resource corresponding this id
	 * @return array with resources
	*/
	public function getResources($id=NULL){
		if($id){
			$id = (int)$id;
			$select = $this->db->select()
					->from( $this->prefix.'resources' )
					->where('id = ?', $id);
		}else{
			$select = $this->db->select()
					->from( $this->prefix.'resources' );
		}
		return $this->db->fetchAll($select);
	}
	
	/**
	 * Returns available resources for the given role
	 * 
	 * @param $permissionID if given return only resource corresponding this id
	 * @param $permissionName if given return only resource corresponding this name
	 * @param $simpleArray determines if the array should be index based
	 * 
	 * @return array with resources
	*/
	public function getResourcesForPermission($permissionID=NULL, $permissionName=NULL, $simpleArray=false){
		if(isset($permissionName)) {
		    $selectPermission = $this->db->select()
					->from($this->prefix.'permissions')
					->where('name = ?', $permissionName);
		    $thisPermission = $this->db->fetchOne($selectPermission);
		    $permissionID = $thisPermission.id;
		} else if(isset($permissionID)) {
		    $permissionID = $permissionID;
		}
		//echo $permissionID;
		$select = $this->db->select()
				->from(array('p2r' => $this->prefix.'permission_to_resource'),
				       array('permission_id', 'resource_id'))
				->join(array('r' => $this->prefix.'resources'),
				    'r.id = p2r.resource_id')
				->where('permission_id = ?', $permissionID);
				
		if($simpleArray) {
		    $initArray = $this->db->fetchAll($select);
		    $result = array();
		    foreach($initArray as $item) {
			array_push($result, $item['name']);
		    }
		} else {
		    $result = $this->db->fetchAll($select);
		}
		return $result;
	}
	
	
	
	/**
	 * Allocate permission to level
	 * @param int $level
	 * @param array $permission
	*/
	public function allocatePermissionToResource($permissionID, $resources){
		$permissionID = (int)$permissionID;
		$this->db->delete($this->prefix.'permission_to_resource', "permission_id = $permissionID");
		if(is_array($resources)){
			foreach ($resources as $resource){
				$data = array(
					'permission_id' => Validate_Validator::sanitizeHTML( $permissionID ),
					'resource_id' => Validate_Validator::sanitizeHTML( $resource )		
				);
				$this->db->insert($this->prefix.'permission_to_resource', $data);	
			}//end loop	
		}	
	}
	
	/**
	 * Get level's permission
	 * @param int $level
	 * @return array
	*/
	public function getLevelPermission($level){
		$level = (int)$level;
		$select = $this->db->select()
			->from( 
				array($this->prefix.'permission_to_resource'),
				array('permission_id')
				)
			->where('level_id = ?', $level);
		$array_tmp = $this->db->fetchAll($select);
		foreach ($array_tmp as $val){
			$array[] = $val['permission_id'];
		}
		return $array;
	}
	
	/**
	 * Main method, check user permission
	 * 
	 * @param string $resourceName
	 * @return true if user have this resource
	*/
	public function checkPermission($resourceName){
		if(in_array($resourceName, $_SESSION['user']['availableResources']))return true;
		else return false;		
	}
}
