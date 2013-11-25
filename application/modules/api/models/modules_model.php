<?php
class Modules_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$utctimestamp = $this->db->query("SELECT UTC_TIMESTAMP() as utctimestamp");
		$this->utctimestamp = $utctimestamp->row()->utctimestamp;
		$dbPrefix	= $this->config->item('db_prefix');
	}

	public function getAllModules() {
		$this->db->from('tbl_module');
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
	
	public function getUserModule($userId) {
		$this->db->select('module_id,module_name,module_description,module_function')
			->from('tbl_group')
			->join('tbl_group_member','tbl_group.group_id = tbl_group_member.gm_group_id','left')
			->join('tbl_account','tbl_account.user_id = tbl_group_member.gm_user_id','inner')
			->join('tbl_group_access','tbl_group_access.ga_group_id = tbl_group.group_id','inner')
			->join('tbl_module','tbl_module.module_id = tbl_group_access.ga_module_id','inner')
			->where('gm_user_id', $userId)
			->order_by('module_id','asc');
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['usermodule'] = $query->result();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Company Info: No Records Found.';
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