<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Merchant extends CI_Controller 
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
	
	
	function productadd()
	{
	
		$this->hero_session->is_active_session();

		$this->load->library('form_validation');

		// field name, error message, validation rules
		$this->form_validation->set_rules('product_type_id', 'Product Type', 'xss_clean|trim|required');
		$this->form_validation->set_rules('product_name', 'Product Name', 'xss_clean|trim|required');
		$this->form_validation->set_rules('product_description', 'Product Description', 'xss_clean|trim|required');
		$this->form_validation->set_rules('featured', 'Featured', 'xss_clean|trim|required');
		$this->form_validation->set_rules('area_id', 'Area', 'xss_clean|trim|required');
		$this->form_validation->set_rules('product_link', 'Product Link', 'xss_clean|trim|required');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required');
		$this->form_validation->set_rules('savings', 'Savings', 'xss_clean|trim|required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'xss_clean|trim|required');
		$this->form_validation->set_rules('expiry', 'Expiry Date', 'xss_clean|trim|required');

		if($this->form_validation->run() == FALSE)
		{
			
			$userId = $this->session->userdata('userid');

			$access	= $this->merchant_model->useraccess($userId);

			$useraccess = ($access->rc == 0) ? $access->data->moduleaccess : array();
			
			$data['mainContent'] = 'productadd.tpl';

			$product_type_list   = $this->merchant_model->productTypeList();
			$area_list    		 = $this->merchant_model->productAreasList();

			$producttypelist	 = ($product_type_list->rc == 0) ? $product_type_list->data->producttypelist : array();
			$areaList  			 = ( $area_list->rc == 0 ) ? $area_list->data->productarealist : array();
			
			
			$producttype_arr[''] = 'Select Category';
			foreach ($producttypelist as $typelist):
			$producttype_arr[$typelist->product_type_id] = $typelist->product_type;
			endforeach;
			
			$arealist[''] = 'Select Area';
			foreach ($areaList as $area):	
			$arealist[$area->area_id] = $area->area_name;
			endforeach;
		
			$form_open 		  = form_open('',array('class' => 'form-horizontal', 'method' => 'post'));
			$form_close  	  = form_close();
			$productTypeList  = form_dropdown('product_type_id', $producttype_arr, '' , 'id="selectError" data-rel="chosen"');
			$areaList     	  = form_dropdown('area_id', $arealist, '', 'id="selectError1" data-rel="chosen"');
			$product_name     = form_input(array('name' => 'product_name', 'class' => 'input-xlarge focused' , 'id' => 'focusedInput', 'placeholder' => 'Product Name'));
			$product_icon     = form_input(array('name' => 'product_icon', 'class' => 'input-xlarge focused' , 'id' => 'focusedInput', 'placeholder' => 'Product Icon'));
			$product_link     = form_input(array('name' => 'product_link', 'class' => 'input-xlarge focused' , 'id' => 'focusedInput', 'placeholder' => 'Product Link'));

			$data['data'] = array(
			'baseUrl'		  => base_url(),
			'title'   		  => 'Product Add',
			'firstname' 	  => $this->session->userdata('fname'),
			'lastname'  	  => $this->session->userdata('lname'),
			'access'		  => $useraccess,
			'msgClass'  	  => $this->msgClass,
			'form_open' 	  => $form_open,
			'form_close' 	  => $form_close,
			'productTypeList' => $productTypeList,
			'areaList'    	  => $areaList,
			'product_name'    => $product_name,
			'product_icon'    => $product_icon,
			'product_link'    => $product_link,
			'msgInfo'   	  => $this->msgInfo,
			);

			$this->load->view($this->globalTpl, $data);
		}
		else {
			
			$date  = date("Y-m-d H:i:s");
			
			$insert_data = array(
				'product_type_id'   	=> $this->input->post('product_type_id'),
				'area_id'   			=> $this->input->post('area_id'),
				'merchant_id'   		=> $this->session->userdata('userid'),
				'product_name'   		=> $this->input->post('product_name'),
				'product_link'   		=> $this->input->post('product_link'),
				'product_description'   => $this->input->post('product_description'),
				'product_price'			=> $this->input->post('product_price'),
				'quantity'   			=> $this->input->post('quantity'),
				'savings'   			=> $this->input->post('savings'),
				'featured'   			=> $this->input->post('featured'),
				'status'   				=> $this->input->post('status'),
				'expiry_date'   		=> $this->add_date($date,$this->input->post('expiry_date'))
			);
			
			
			$result = $this->merchant_model->productAdd($insert_data);
			
			if($result->rc == 0)
			{
				$msgClass = 'alert alert-success';
				$msgInfo  = ( $result->message[0] ) ? $result->message[0] : 'Product has been added.';
			}
			else 
			{	
				$msgClass = 'alert alert-error';
				$msgInfo  = ( $result->message[0] ) ? $result->message[0] : 'Add product failed.';			
			}
			
			//set flash data for error/info message
			$msginfo_arr = array(
				'msgClass' => $msgClass,
				'msgInfo'  => $msgInfo,
			);
			
			$this->session->set_flashdata($msginfo_arr);
			
			redirect('merchant/deals');
		}	
	}
	
	function deals()
	{		
		$userId = $this->session->userdata('userid');
		
		$data['mainContent'] = 'productlist.tpl';
		
		$access	  = $this->merchant_model->useraccess($userId);
		
		$useraccess = ($access->rc == 0) ? $access->data->moduleaccess : array();
			
		$productList = ($this->session->userdata('merchant') == true) ? 
						$this->merchant_model->merchproductList() : $this->merchant_model->productList();
						
		$prodList = ($productList->rc == 0) ? $productList->data->productlist : array();
		
		$data['data'] = array(
			'baseUrl'	=> base_url(),
			'title'   	=> 'Deal List',
			'firstname' => $this->session->userdata('fname'),
			'lastname'  => $this->session->userdata('lname'),
			'access'	=> $useraccess,
			'productlist'  => $prodList,
			'msgClass'  => $this->msgClass,
			'msgInfo'   => $this->msgInfo,
		);
		
		$this->load->view($this->globalTpl, $data);	
	}
	
	function add_date($givendate,$day=0,$mth=0,$yr=0) {
		$cd = strtotime($givendate);
		$newdate = date('Y-m-d h:i:s', mktime(date('h',$cd),
		date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
		date('d',$cd)+$day, date('Y',$cd)+$yr));
		return $newdate;
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */