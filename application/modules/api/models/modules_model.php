<?php
class Modules_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$utctimestamp = $this->db->query("SELECT UTC_TIMESTAMP() as utctimestamp");
		$this->utctimestamp = $utctimestamp->row()->utctimestamp;
		$dbPrefix	= $this->config->item('db_prefix');
	}

	public function getAllModules() {
		$this->db->from('module');
		$this->db->order_by('module_id', 'asc');
		$query = $this->db->get();
		 
		//user data exist
		if ($query->num_rows() > 0){
			$response['rc']					= 0;
			$response['success']			= true;
			$response['data']['modulelist']	= $query->result();
			$response['log_query']			= str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message 			= ( $this->db->_error_message() ) ? $this->db->_error_message() : 'No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']	= str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function getModuleinfo($moduleId) {
		$this->db->select('module_id,module_name,module_description,module_function')
			->from('module')
			->where('module_id', $moduleId)
			->order_by('module_id','asc');
		 
		$query = $this->db->get();	
			
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['moduleinfo'] = $query->row();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Module Info: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']	= str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}	

	
		
// end of the users model

}
?>