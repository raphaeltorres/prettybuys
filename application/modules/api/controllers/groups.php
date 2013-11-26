<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller {
/**
  * API Controller for Users
  * What: It's controles all Users API Functions
  * When: created  14-SEP-2013 
  * 	  modified 19-SEP-2013 
  * 	  modified 08-OCT-2013 
  * Who : created by Raphael Torres
  *		
  *		
 **/

	public function __construct() {
		parent::__construct();
		$this -> load -> model('common_model');	

		$this->authKey	= ( $this->uri->segment(3) ) ? $this->uri->segment(3) : '';
		$this->groupId 	= ( $this->uri->segment(4) ) ? $this->uri->segment(4) : '';
	}

	public function rest()
	{
		$method = $_SERVER['REQUEST_METHOD'];	
		$this->$method();
	}
	
	public function index()
	{		
		$this->output->set_status_header(404, 'Not Found');
		show_404('ai', false);
		$data['abc']= 'Testing API';
		$this -> load -> library('parser');
		$this -> parser -> parse("index.tpl", $data);
	}
	
	/**
	 ** @Param: Auth Key / User ID
	 ** for getting user list or user info 
	 **/
	public function get()
	{
		$is_valid_auth 	= $this->common_model->validate_auth_key($this->authKey);
		
		//auth key is valid
		if ( $is_valid_auth['rc'] == 0 ){
			$this->load->model('groups_model');
			
			if ( $this->groupId != '' ){
				//get user info
				$response = $this->groups_model->getGroup($this->groupId);
			}
			else{
				//get user list
				$response = $this->groups_model->getAllGroup();
			}
		}
		else{
			$response['rc']			= $is_valid_auth['rc'];
			$response['success']	= $is_valid_auth['success'];
			$response['message'][]	= $is_valid_auth['message'];
		}

		//api logs
		$log_data = array(
			'log_client_id' => $this->authKey,
			'log_method' 	=> 'GROUPLIST - '.$_SERVER['REQUEST_METHOD'],
			'log_url' 		=> $this->uri->uri_string(),
			'log_request' 	=> json_encode($this->input->post()),
			'log_response' 	=> json_encode($response),
			#'log_query' 	=> $response['log_query'],
		);
		$this->apilog_model->apiLog($log_data); //db logs
		$this->api_functions->apiLog(json_encode($log_data),'GET_GROUP'); //text logs
		
		//display Jason
		$this->output
			 ->set_content_type('application/json')
			 ->set_output(json_encode($response));
		
		$this->load->library('parser');
		$this->parser->parse('index.tpl');
	}
	// end of get users
	
	
	/**
	 ** @Param: Auth Key
	 ** for creating user
	 **/
	public function post()
	{	
		$is_valid_auth 	= $this->common_model->validate_auth_key($this->authKey);
		
		//auth key is valid
		if ( $is_valid_auth['rc'] == 0 ){
			$groupname		= $this->security->xss_clean($this->input->post('groupname'));	
			$groupdesc 		= $this->security->xss_clean($this->input->post('groupdesc'));
			
			$response['success'] = true;
			
			if( $response['success'] ){
				$this->load->model('groups_model');
				
				$arr_data = array(
					'group_name' 		=> $groupname,
					'group_description' => $groupdesc,

				);
				
				$response = $this->groups_model->addGroup($arr_data);	 
			}
			else{
				$response['rc']			= $is_valid_auth['rc'];
				$response['success']	= $is_valid_auth['success'];
				$response['message'][]	= $is_valid_auth['message'];
			}
		}

		//api logs
		$log_data = array(
			'log_client_id' => $this->authKey,
			'log_method' 	=> 'USERS - '.$_SERVER['REQUEST_METHOD'],
			'log_url' 		=> $this->uri->uri_string(),
			'log_request' 	=> json_encode($this->input->post()),
			'log_response' 	=> json_encode($response),
			'log_query' 	=> $response['log_query'],
		);
		$this->apilog_model->apiLog($log_data); //db logs
		$this->api_functions->apiLog(json_encode($log_data),'POST_USERS'); //text logs
		
		//display Jason
		$this->output
			 ->set_content_type('application/json')
			 ->set_output(json_encode($response));
		
		$this->load->library('parser');
		$this->parser->parse('index.tpl');
	}
	//end post
	
	/**
	 ** @Param: Auth Key / User ID
	 ** for modifying user info
	 **/
	public function put()
	{
		$is_valid_auth 	= $this->common_model->validate_auth_key($this->authKey);
		
		//auth key is valid
		if ( $is_valid_auth['rc'] == 0 ){
		
			//check if user id is present
			if ( $this->groupId != '' ){
				
				$data = json_decode(file_get_contents("php://input"), true);
				
				//get fields to edit
				$arr_data = array();
				foreach ( $data as $key => $val ){
					if ( $val != '' || $val != NULL ){
						$arr_data[$key] = $val;	
					}
				}
				
				//check if params are not empty
				if( !empty($arr_data) ){
					$this->load->model('users_model');
					//edit user info
					$response = $this->users_model->editUser($this->groupId,$arr_data);						
				}
			}
			else{ //user id is missing
				$response['rc']			= 999;
				$response['success']	= false;
				$response['message'][]	= 'User ID is missing.';
			}
		}
		else{ //authentication failed
			$response['rc']			= $is_valid_auth['rc'];
			$response['success']	= $is_valid_auth['success'];
			$response['message'][]	= $is_valid_auth['message'];
		}

		//api logs
		$log_data = array(
			'log_client_id' => $this->authKey,
			'log_method' 	=> 'USERS - '.$_SERVER['REQUEST_METHOD'],
			'log_url' 		=> $this->uri->uri_string(),
			'log_request' 	=> json_encode($this->input->post()),
			'log_response' 	=> json_encode($response),
			'log_query' 	=> $response['log_query'],
		);
		$this->apilog_model->apiLog($log_data); //db logs
		$this->api_functions->apiLog(json_encode($log_data),'PUT_USERS'); //text logs
		
		//display Jason
		$this->output
			 ->set_content_type('application/json')
			 ->set_output(json_encode($response));
		
		$this->load->library('parser');
		$this->parser->parse('index.tpl');
	}
	
	/**
	 ** @Param: Auth Key / User ID
	 ** for deleting user
	 **/
	public function delete()
	{
		$is_valid_auth 	= $this->common_model->validate_auth_key($this->authKey);
		
		//auth key is valid
		if ( $is_valid_auth['rc'] == 0 ){
		
			//check if user id is present
			if ( $this->groupId != '' ){
				//if authorized delete call made with all segments			
				$this->load->model('users_model');
				$return = $this->users_model->delUser($this->groupId);					
			}
			else{ //user id is missing
				$response['rc']			= 999;
				$response['success']	= false;
				$response['message'][]	= 'A User ID must be supplied, to carry out this operation';
			}
		}
		else{ //authentication failed
			$response['rc']			= $is_valid_auth['rc'];
			$response['success']	= $is_valid_auth['success'];
			$response['message'][]	= $is_valid_auth['message'];
		}

		//api logs
		$log_data = array(
			'log_client_id' => $this->authKey,
			'log_method' 	=> 'USERS - '.$_SERVER['REQUEST_METHOD'],
			'log_url' 		=> $this->uri->uri_string(),
			'log_request' 	=> json_encode($this->input->post()),
			'log_response' 	=> json_encode($response),
			'log_query' 	=> $response['log_query'],
		);
		$this->apilog_model->apiLog($log_data); //db logs
		$this->api_functions->apiLog(json_encode($log_data),'DELETE_USERS'); //text logs
		
		//display Jason
		$this->output
			 ->set_content_type('application/json')
			 ->set_output(json_encode($response));
		
		$this->load->library('parser');
		$this->parser->parse('index.tpl');
		
	}
	//end of delete user
	
	public function accesslogs()
	{
		$auth_key 		= ( $this->uri->segment(5) ) ? $this->uri->segment(5) : '';
		$is_valid_auth 	= $this->common_model->validate_auth_key($auth_key);
		
		//auth key is valid
		if ( $is_valid_auth['rc'] == 0 ){
			$log_id = ( $this->uri->segment(6) ) ? $this->uri->segment(6) : '';
			$this->load->model('users_model');
			
			if ( $log_id != '' ){
				//get user info
				$response = $this->users_model->getaLog($log_id);
			}
			else{
				//get user list
				$response = $this->users_model->getaccessLogs();
			}
		}
		else{
			$response['rc']			= $is_valid_auth['rc'];
			$response['success']	= $is_valid_auth['success'];
			$response['message'][]	= $is_valid_auth['message'];
		}
		
		//display Jason
		$this->output
			 ->set_content_type('application/json')
			 ->set_output(json_encode($response));
		
		$this->load->library('parser');
		$this->parser->parse('index.tpl');
	}
	// end of get users
	
	public function test()
	{
		$return['message'] = $_SERVER['REQUEST_METHOD'];
	
		//display Jason
		$this->output
			 ->set_content_type('application/json')
			 ->set_output(json_encode($return));
		
		$this->load->library('parser');
		$this->parser->parse("index.tpl");
	}
}

/* End of file users.php/ Api Users Controller */
