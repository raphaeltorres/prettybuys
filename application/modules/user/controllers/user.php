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

	}
	
	
	function adduser()
	{
	
		$this->hero_session->is_active_session();
		
		$userId = $this->session->userdata('userid');
		
		$data['mainContent'] = 'dashboard.tpl';
		
		$access	= $this->user_model->useraccess($userId);
			
		$data['data'] = array(
			'baseUrl'	=> base_url(),
			'title'   	=> 'Add User',
			'firstname' => $this->session->userdata('fname'),
			'lastname'  => $this->session->userdata('lname'),
			'access'	=> $access->data->moduleaccess,
			'msgClass'  => $this->msgClass,
			'msgInfo'   => $this->msgInfo,
		);
		
		$this->load->view($this->globalTpl, $data);		
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