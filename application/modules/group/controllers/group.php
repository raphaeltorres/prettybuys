<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends CI_Controller 
{
	public function __construct() {
		parent::__construct();
		
		$this->globalTpl = $this->config->item('globalTpl');
		
		$this->msgClass = ( $this->session->flashdata('msgClass') ) ? $this->session->flashdata('msgClass') : '';
		$this->msgInfo  = ( $this->session->flashdata('msgInfo') ) ? $this->session->flashdata('msgInfo') : '';
	}

	public function index()
	{
		$this->grouplist();
	}
	
	
	function grouplist()
	{		
		$userId = $this->session->userdata('userid');
		
		$data['mainContent'] = 'grouplist.tpl';
		
		$access	  = $this->group_model->useraccess($userId);
		$userList = $this->group_model->GroupList();
			
		$data['data'] = array(
			'baseUrl'	=> base_url(),
			'title'   	=> 'GroupList',
			'firstname' => $this->session->userdata('fname'),
			'lastname'  => $this->session->userdata('lname'),
			'access'	=> $access->data->moduleaccess,
			'grouplist'  => $userList->data->grouplist,
			'msgClass'  => $this->msgClass,
			'msgInfo'   => $this->msgInfo,
		);
		
		$this->load->view($this->globalTpl, $data);	
	}
	
	function groupadd()
	{
	
		$this->hero_session->is_active_session();

		$this->load->library('form_validation');

		// field name, error message, validation rules
		$this->form_validation->set_rules('groupname', 'groupname', 'xss_clean|trim|required');
		$this->form_validation->set_rules('groupdesc', 'groupdesc', 'xss_clean|trim|required');

		if($this->form_validation->run() == FALSE)
		{
			$userId = $this->session->userdata('userid');

			$access	= $this->group_model->useraccess($userId);

			$data['mainContent'] = 'groupadd.tpl';

			$form_open 		= form_open('',array('class' => 'form-horizontal', 'method' => 'post'));
			$form_close  	= form_close();

			$data['data'] = array(
			'baseUrl'	=> base_url(),
			'title'   	=> 'Group Add',
			'firstname' => $this->session->userdata('fname'),
			'lastname'  => $this->session->userdata('lname'),
			'access'	=> $access->data->moduleaccess,
			'msgClass'  => $this->msgClass,
			'form_open' => $form_open,
			'form_close' => $form_close,
			'msgInfo'   => $this->msgInfo,
			);

			$this->load->view($this->globalTpl, $data);
		}
		else {
			
			$insert_data = array(
				'groupname'			=> $this->input->post('groupname'),
				'groupdesc' 		=> $this->input->post('groupdesc'),
			);
			
			
			$result = $this->group_model->groupAdd($insert_data);
			
			if($result->rc == 0)
			{
				$msgClass = 'alert alert-success';
				$msgInfo  = ( $result->message[0] ) ? $result->message[0] : 'Group has been added.';
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
			
			redirect('group/grouplist/');
		}	
			
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */