<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller 
{
	public function __construct() {
		parent::__construct();
		
		$this->globalTpl = $this->config->item('globalTpl');
		
		$this->msgClass = ( $this->session->flashdata('msgClass') ) ? $this->session->flashdata('msgClass') : '';
		$this->msgInfo  = ( $this->session->flashdata('msgInfo') ) ? $this->session->flashdata('msgInfo') : '';
	}

	public function index()
	{

	
		if ( $this->session->userdata('userid') ){
			redirect('dashboard/members_area');
			exit;
		}
		
		$this->load->library('form_validation');  
		
		$this->form_validation->set_rules('username', 'Username or Email', 'xss_clean|trim|required');
		$this->form_validation->set_rules('password', 'password', 'xss_clean|trim|required');
		
		if($this->form_validation->run() == FALSE)
		{

			//set forms open, close and inputs
			$form_open	= form_open_multipart('',array('class' => 'form-horizontal', 'method' => 'post'));
			$form_close	= form_close();
			$username	= form_input(array('name' => 'username', 'class' => 'input-large span10' , 'id' => 'focusedInput', 'placeholder' => 'Enter Username'));
			$password	= form_password(array('name' => 'password', 'class' => 'input-large span10' , 'id' => 'focusedInput', 'placeholder' => 'Enter Password'));
			
			$data = array(
					'baseUrl'		=> base_url(),
					'title'			=> 'Home',
					'form_open' 	=> $form_open,
					'form_close' 	=> $form_close,
					'username'		=> $username,
					'password'		=> $password,
					'msgClass'		=> $this->msgClass,
					'msgInfo'		=> $this->msgInfo
			);

			$this->parser->parse('login_form.tpl', $data);

		}
		else {
			$login_data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);	
			
			
			$login = $this->home_model->validate($login_data);
			
			if ( $login->rc == 0 ){
				$data = array(
					'userid' 		=> $login->data->user->user_id,
					'email'	 		=> $login->data->user->user_email_address,
					'fname'	 		=> $login->data->user->user_first_name,
					'lname'			=> $login->data->user->user_last_name,
					'is_logged_in'  => true
				);

				$this->session->set_userdata($data);
				redirect('dashboard/members_area');
			}
				
			else{
				$msgClass = 'alert alert-error';
				$msgInfo  = ( $login->message[0] ) ? $login->message[0] : 'Invalid Username and/or Password.';
					
				//set flash data for error/info message
				$msginfo_arr = array(
				'msgClass' => $msgClass,
				'msgInfo'  => $msgInfo,
				);
				$this->session->set_flashdata($msginfo_arr);

				redirect('home');
			}
		}
		
		#$this->load->view($this->globalTpl, $data);	
	}
	
	// display dashboard upon validating credentials
	function dashboard()
	{
	
		#$this->hero_session->is_active_session();
		$data['mainContent'] = 'dashboard.tpl';
		
		$data['data'] = array(
			'baseUrl'	=> base_url(),
			'title'   	=> 'Dashboard',
			'firstname' => $this->session->userdata('fname'),
			'lastname'  => $this->session->userdata('lname'),
			'msgClass'  => $this->msgClass,
			'msgInfo'   => $this->msgInfo,
		);
		
		$this->load->view($this->globalTpl, $data);		
	}
	
	// logout user from the system, record exit time in the API
	function logout()
	{
		#$this->load->model('admin_model');
		#$logout = $this->admin_model->logout();
		#$this->session->unset_userdata('username');
		#$this->session->unset_userdata('is_logged_in');
		$this->session->sess_destroy();
		redirect('home');
	}	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */