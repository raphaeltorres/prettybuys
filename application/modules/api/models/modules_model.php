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

	function getModulesAccess($userId='')
	{
		$this->db->select('module_id,module_name,module_function,module_description,module_icon')
			->from('module')
			->join('group_access','module.module_id = group_access.ga_module_id','inner')
			->join('account','account.user_group_id = group_access.ga_group_id','left')
			->where('user_id', $userId)
			->order_by('module_id', 'asc');
		$module = $this->db->get();
		
		$this->db->select('node_id,node_module_id,node_name,node_description,node_function,node_icon')
			->from('node')
			->join('group_access','node.node_id = group_access.ga_node_id','inner')
			->join('account','account.user_group_id = group_access.ga_group_id','left')
			->where('user_id', $userId)
			->not_like('node_description', 'functions')
			->order_by('node_id', 'asc');
		$node = $this->db->get();
			
		//if data exist, return results
		if ($module->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['moduleaccess'] = '';
			$response['data']['nodeaccess']   = '';
			
			foreach ($module->result() as $mod)
			{
				$response['data']['moduleaccess']
						[$mod->module_name] = array(
												'module_id'		  	 => $mod->module_id,
												'module_name'		 => $mod->module_name,
												'module_function' 	 => $mod->module_function,
												'module_description' => $mod->module_description,
												'module_icon' 		 => $mod->module_icon
						);
						
					foreach ($node->result() as $nod)
					{
						if($nod->node_module_id == $mod->module_id)
						{
							$response['data']['moduleaccess']
								[$mod->module_name]['node'][] = array(
													'node_id' 			=> $nod->node_id,
													'node_module_id'	=> $nod->node_module_id,
													'node_name'			=> $nod->node_name,
													'node_description'  => $nod->node_description,
													'node_function'		=> $nod->node_function,
													'node_icon'			=> $nod->node_icon
								);
						}
					}	
			}
			
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'User Access: No Records Found.';
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