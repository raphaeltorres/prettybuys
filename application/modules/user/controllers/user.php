<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller 
{
	public function __construct() {
		parent::__construct();
		
		$this->globalTpl = $this->config->item('globalTpl');
		
		$this->msgClass = ( $this->session->flashdata('msgClass') ) ? $this->session->flashdata('msgClass') : '';
		$this->msgInfo  = ( $this->session->flashdata('msgInfo') ) ? $this->session->flashdata('msgInfo') : '';
	}

	public function index()
	{
		$this->userlist();
	}
	
	
	function adduser()
	{
	
		$this->hero_session->is_active_session();

		$this->load->library('form_validation');

		// field name, error message, validation rules
		$this->form_validation->set_rules('username', 'username', 'xss_clean|trim|required');
		$this->form_validation->set_rules('password', 'password', 'xss_clean|trim|required|required');
		$this->form_validation->set_rules('firstName', 'firstName', 'xss_clean|trim|required');
		$this->form_validation->set_rules('lastName', 'lastName', 'xss_clean|trim|required');
		$this->form_validation->set_rules('group_id', 'group_id', 'xss_clean|trim|required');
		$this->form_validation->set_rules('email', 'email', 'xss_clean|trim|required|valid_email');

		if($this->form_validation->run() == FALSE)
		{
			$userId = $this->session->userdata('userid');

			$access	= $this->user_model->useraccess($userId);

			$data['mainContent'] = 'useradd.tpl';

			$group_list = $this->user_model->groupList();

			foreach ($group_list->data->grouplist as $group):
			$grouplist[$group->group_id] = $group->group_name;
			endforeach;

			$form_open 		= form_open('',array('class' => 'form-horizontal', 'method' => 'post'));
			$form_close  	= form_close();
			$groupList		= form_dropdown('group_id', $grouplist, '');

			$data['data'] = array(
			'baseUrl'	=> base_url(),
			'title'   	=> 'Add User',
			'firstname' => $this->session->userdata('fname'),
			'lastname'  => $this->session->userdata('lname'),
			'access'	=> $access->data->moduleaccess,
			'msgClass'  => $this->msgClass,
			'form_open' => $form_open,
			'form_close' => $form_close,
			'groupList' => $groupList,
			'msgInfo'   => $this->msgInfo,
			);

			$this->load->view($this->globalTpl, $data);
		}
		else {
			$insert_data = array(
				'username' 				=> $this->input->post('username'),
				'password' 				=> $this->input->post('password'),
				'firstname' 			=> $this->input->post('firstName'),
				'lastname' 				=> $this->input->post('lastName'),
				'email' 				=> $this->input->post('email'),
				'groupid' 				=> $this->input->post('group_id')
			);
			
			
			$result = $this->user_model->userAdd($insert_data);
			
			if($result->rc == 0)
			{
				$msgClass = 'alert alert-success';
				$msgInfo  = ( $result->message[0] ) ? $result->message[0] : 'User has been added.';
			}
			else 
			{	
				$msgClass = 'alert alert-error';
				$msgInfo  = ( $result->message[0] ) ? $result->message[0] : 'Add user failed.';			
			}
			
			//set flash data for error/info message
			$msginfo_arr = array(
				'msgClass' => $msgClass,
				'msgInfo'  => $msgInfo,
			);
			
			$this->session->set_flashdata($msginfo_arr);
			
			redirect('user/userlist/');
		}	
	}
	
	function userlist()
	{		
		$userId = $this->session->userdata('userid');
		
		$data['mainContent'] = 'userlist.tpl';
		
		$access	  = $this->user_model->useraccess($userId);
		$userList = $this->user_model->userList();
			
		$data['data'] = array(
			'baseUrl'	=> base_url(),
			'title'   	=> 'Userlist',
			'firstname' => $this->session->userdata('fname'),
			'lastname'  => $this->session->userdata('lname'),
			'access'	=> $access->data->moduleaccess,
			'userlist'  => $userList->data->userlist,
			'msgClass'  => $this->msgClass,
			'msgInfo'   => $this->msgInfo,
		);
		
		$this->load->view($this->globalTpl, $data);	
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */