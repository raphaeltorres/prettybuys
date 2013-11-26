<?php
class Users_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$utctimestamp = $this->db->query("SELECT UTC_TIMESTAMP() as utctimestamp");
		$this->utctimestamp = $utctimestamp->row()->utctimestamp;
		
	}

	public function getAllUsers() {
		$this->db->from('account');
		$this->db->order_by('user_id', 'asc');
		$query = $this->db->get();
		 
		//user data exist
		if ($query->num_rows() > 0){
			$response['rc']					= 0;
			$response['success']			= true;
			$response['data']['userlist']	= $query->result();
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

	public function getUser($id) {
		$this->db->where('user_id', $id);
		$query = $this->db->get('account');
		 
		//user data exist
		if ($query->num_rows() > 0){
			$response['rc']					= 0;
			$response['success']			= true;
			$response['data']['userinfo']	= $query->result();
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
	
	
	public function delUser($id) {
		$this->db->where('user_id', $id);
		$query = $this->db->get('account');

		//user data exist
		if ($query->num_rows() > 0){
			$this->db->where('user_id', $id);
			$querys = $this->db->delete('account');

			$return['rc'] 			= 0;
			$return['success'] 		= true;
			$return['message'][]	= 'User '.$id.' Successfully Removed';
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



	public function addUser($data) {
		
		//check if user already exist.
		$this->db->where('user_login_name',$data['user_login_name']);
		$query = $this->db->get('account');
		
		if ($query->num_rows() > 0){
			$response['rc']				= 999;
			$response['message'][]		= 'Add user failed. User already exist.';
			$response['log_query']		= str_replace('\n',' ',$this->db->last_query());
		}
		else{
			//sanitized data
			$data = $this->security->xss_clean($data);
		
			//insert data
			$query = $this->db->insert('account', $data);
			if ( $this->db->affected_rows() > 0 ){
				$response['rc']			= 0;
				$response['message'][]	= 'User has been successfully added.';
				$response['log_query']	= str_replace('\n',' ',$this->db->last_query());
			}
			else{
				$response['rc']			= 999;
				$response['message'][]	= 'Failed to add user.';
				$response['log_query']	= str_replace('\n',' ',$this->db->last_query());
			}
		}
		return $response;
	}
	
	public function validateUser($username,$password) {
		$arr_data = array(
			'user_login_name' 		=> $username,
			'user_login_password' 	=> $password
		);
		
		$this->db->where($arr_data);
		$query = $this->db->get('account');
		 
		//user data exist
		if ($query->num_rows() > 0){
			//Arrange data for Jason
			$response['rc']					= 0;
			$response['success'] 			= true;
			$response['data']['user'] 		= $query->row();
			$response['log_query']			= str_replace('\n',' ',$this->db->last_query());
		//userdata don't exist	   			 
		}
		else{
			//Arrange data for Jason
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= 'User does not exist.';
			$response['log_query']	= str_replace('\n',' ',$this->db->last_query());
		}
		return $response;
	
	}
	
	public function editUser($id,$data)
	{	
		//sanitized data
		$data = $this->security->xss_clean($data);
		$data['user_login_password'] = md5($data['password']);
		$this->db->where('user_id', $id);
		$this->db->update('account', $data); 
		
		if ( $this->db->affected_rows() > 0 ){
			$response['rc']			= 0;
			$response['success']	= true;
			$response['message'][]	= 'User has been successfully modified.';
			$response['message'][]	= $data;
			$response['log_query']	= str_replace('\n',' ',$this->db->last_query());
		}
		else{
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= 'Failed to edit user.';
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