<?php
class Groups_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$utctimestamp = $this->db->query("SELECT UTC_TIMESTAMP() as utctimestamp");
		$this->utctimestamp = $utctimestamp->row()->utctimestamp;
		
	}

	public function getAllGroup() {
		$this->db->from('groups');
		$this->db->order_by('group_id', 'asc');
		$query = $this->db->get();
		 
		//user data exist
		if ($query->num_rows() > 0){
			$response['rc']					= 0;
			$response['success']			= true;
			$response['data']['grouplist']	= $query->result();
			$response['log_query']			= str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			= str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}

	public function getGroup($id) {
		$this->db->where('group_id', $id);
		$query = $this->db->get('groups');
		 
		//user data exist
		if ($query->num_rows() > 0){
			$response['rc']					= 0;
			$response['success']			= true;
			$response['data']['groupinfo']	= $query->result();
			$response['log_query']			= str_replace('\n',' ',$this->db->last_query());
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			= str_replace('\n',' ',$this->db->last_query());
		}
		return $response;
	}
	
	
	public function delGroup($id) {
		$this->db->where('group_id', $id);
		$query = $this->db->get('groups');

		//user data exist
		if ($query->num_rows() > 0){
			$this->db->where('group_id', $id);
			$querys = $this->db->delete('groups');

			$return['rc'] 			= 0;
			$return['success'] 		= true;
			$return['message'][]	= 'Group '.$id.' Successfully Removed';
			$response['log_query']			= str_replace('\n',' ',$this->db->last_query());
				 
		}
		else{ //userdata don't exist	 

			$return['rc'] 			= 0;
			$return['success'] 		= true;
			$return['message'][]	= 'User '.$id.' does not exist.';
			$response['log_query']	= str_replace('\n',' ',$this->db->last_query());
		}		

		return $return;
	}	



	public function addGroup($data) {
		
		//check if email already exist.
		$this->db->where('group_name',$data['group_name']);
		$query = $this->db->get('grouups');
		
		if ($query->num_rows() > 0){
			$response['rc']				= 999;
			$response['message'][]		= 'Add group failed. Group already exist.';
			$response['log_query']		= str_replace('\n',' ',$this->db->last_query());
		}
		else{
			//sanitized data
			$data = $this->security->xss_clean($data);
		
			//insert data
			$query = $this->db->insert('grouups', $data);
			if ( $this->db->affected_rows() > 0 ){
				$response['rc']			= 0;
				$response['message'][]	= 'Group has been successfully added.';
				$response['log_query']			= str_replace('\n',' ',$this->db->last_query());
			}
			else{
				$response['rc']			= 999;
				$response['message'][]	= 'Failed to add group.';
				$response['log_query']			= str_replace('\n',' ',$this->db->last_query());
			}
		}
		return $response;
	}
	
	
	public function editGroup($id,$data)
	{	
		//sanitized data
		$data = $this->security->xss_clean($data);
		$this->db->where('group_id', $id);
		$this->db->update('groups', $data); 
		
		if ( $this->db->affected_rows() > 0 ){
			$response['rc']			= 0;
			$response['success']	= true;
			$response['message'][]	= 'Group has been successfully modified.';
			$response['message'][]	= $data;
			$response['log_query']	= str_replace('\n',' ',$this->db->last_query());
		}
		else{
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= 'Failed to edit group.';
			$response['message'][]	= $data;
			$response['log_query']	= str_replace('\n',' ',$this->db->last_query());
		}
		return $response;
	}
	
	public function getaccessLogs() {
		$this->db->from('access_logs');
		$this->db->order_by('log_id', 'asc');
		$query = $this->db->get();
		 
		//user data exist
		if ($query->num_rows() > 0){
			$response['rc']					= 0;
			$response['success']			= true;
			$response['data']['loglist']	= $query->result();
			$response['log_query']			= str_replace('\n',' ',$this->db->last_query());
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']	= str_replace('\n',' ',$this->db->last_query());
		}
		return $response;
	}

	public function getaLog($id) {
		$this->db->where('log_id', $id);
		$query = $this->db->get('access_logs');
		 
		//user data exist
		if ($query->num_rows() > 0){
			$response['rc']					= 0;
			$response['success']			= true;
			$response['data']['loginfo']	= $query->result();
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'No Records Found.';
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