<?php
##==================================================
## API Model for Company
## @Author: Pinky Liwanagan
## @Date: 09-OCT-2013 
##==================================================

class Product_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$utctimestamp = $this->db->query("SELECT UTC_TIMESTAMP() as utctimestamp");
		$this->utctimestamp = $utctimestamp->row()->utctimestamp;
		
		$dbPrefix	= $this->config->item('db_prefix');
		
		//load database based on locale
		$this->db	= $this->load->database($dbPrefix,TRUE);
	}

	public function productList() {
		$this->db->select('product_name,product_type,product_id,products.product_type_id,product_price,product_description,featured,products.area_id,product_icon,product_link,status,savings,quantity,expiry_date,(SELECT COUNT(*) FROM products_options po WHERE po.option="Promo" AND po.product_id=products.product_id) as promo,user_first_name,user_last_name,area_name')
			->from('products')
			->join('products_types','products_types.product_type_id = products.product_type_id','inner')
			->join('products_areas','products_areas.area_id = products.area_id','left')
			->join('account','account.user_id = products.merchant_id','left')
			->order_by('product_id', 'asc');
		$query = $this->db->get();
	
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['productlist'] = $query->result();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Product List: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}

	public function productInfo($id='',$merchant='') {
		
		$product = array(
					'product_id' 		=> $id
		);
		
		
		$this->db->select('product_name,product_type,product_id,products.product_type_id,product_price,product_description,featured,products.area_id,product_icon,product_link,status,savings,quantity,expiry_date,(SELECT COUNT(*) FROM products_options po WHERE po.option="Promo" AND po.product_id=products.product_id) as promo,user_first_name,user_last_name,area_name')
			->from('products')
			->join('products_types','products_types.product_type_id = products.product_type_id','inner')
			->join('products_areas','products_areas.area_id = products.area_id','inner')
			->join('account','account.user_id = products.merchant_id','left')
			->where($product)
			->order_by('product_id','asc');

		$query = $this->db->get();
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['productinfo'] = $query->result();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Product Info: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}

	public function merchproductList($merchantId) {
		
		$product = array(
					'merchant_id'		=> $merchantId
		);
		
		$this->db->select('product_name,product_type,product_id,products.product_type_id,product_price,product_description,featured,products.area_id,product_icon,product_link,status,savings,quantity,expiry_date,(SELECT COUNT(*) FROM products_options po WHERE po.option="Promo" AND po.product_id=products.product_id) as promo,user_first_name,user_last_name,area_name')
			->from('products')
			->join('products_types','products_types.product_type_id = products.product_type_id','inner')
			->join('products_areas','products_areas.area_id = products.area_id','left')
			->join('account','account.user_id = products.merchant_id','left')
			->where($product)
			->order_by('product_id', 'asc');
		$query = $this->db->get();
	
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['productlist'] = $query->result();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Product List: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}

	public function merchproductInfo($id='',$merchantId='') {
		
		$product = array(
					'product_id' 		=> $id,
					'merchant_id'		=> $merchantId
		);
		
		
		$this->db->select('product_name,product_type,product_id,products.product_type_id,product_price,product_description,featured,products.area_id,product_icon,product_link,status,savings,quantity,expiry_date,(SELECT COUNT(*) FROM products_options po WHERE po.option="Promo" AND po.product_id=products.product_id) as promo,user_first_name,user_last_name,area_name')
			->from('products')
			->join('products_types','products_types.product_type_id = products.product_type_id','inner')
			->join('products_areas','products_areas.area_id = products.area_id','inner')
			->join('account','account.user_id = products.merchant_id','left')
			->where($product)
			->order_by('product_id','asc');

		$query = $this->db->get();
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['productinfo'] = $query->result();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Product Info: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}	
	
	public function productAdd($data)
	{
		//sanitized data
		$data = $this->security->xss_clean($data);
	
		//insert data
		$query = $this->db->insert('products', $data);
		if ( $this->db->affected_rows() > 0 ){
			$savetextfile  			= $this->savetextfile($data);
			$response['rc']			= 0;
			$response['success']	= true;
			$response['message'][]	= 'Product has been successfully added.';
			$response['productId']  = $this->db->insert_id();
			$response['log_query']	= str_replace('\n',' ',$this->db->last_query());	
		}
		else{
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= 'Failed to add product.';
			$response['log_query']	= str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function productEdit($id,$data)
	{	
		//sanitized data
		$data = $this->security->xss_clean($data);
		
		$this->db->where('product_id', $id);
		$this->db->update('products', $data); 
		
		if ( $this->db->affected_rows() > 0 ){
			$response['rc']			= 0;
			$response['success']	= true;
			$response['message'][]	= 'Product has been successfully modified.';
			$response['message'][]	= $data;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= 'Failed to edit product.';
			$response['message'][]	= $data;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	
	public function savetextfile($data)
	{
		$date_now  = date('Ymd');
		$file_path = 'assets/data/data_'.$date_now.'.txt';
		$file_exist = file_exists($file_path);

		$type = ( $file_exist ) ? 'a' : 'w';

		$data = json_encode($data);

		$file = fopen($file_path, $type) or die("can't open file");
		fwrite($file,$data.PHP_EOL);
		fclose($file);
	}
	
	public function areaList() {
		$this->db->from('products_areas')
			 ->join('countries', 'countries.country_id = products_areas.area_country_id')
			 ->order_by('products_areas.area_id', 'asc');
		$query = $this->db->get();
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['productarealist'] = $query->result();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Product Area List: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function areaInfo($id) {
		$this->db->where('area_id', $id);
		$query = $this->db->get('products_areas');
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['productareainfo'] = $query->result();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Product Area Info: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}	
	
	public function areaAdd($data)
	{
		//sanitized data
		$data = $this->security->xss_clean($data);
	
		//insert data
		$query = $this->db->insert('products_areas', $data);
		if ( $this->db->affected_rows() > 0 ){
			$response['rc']			= 0;
			$response['success']	= true;
			$response['message'][]	= 'Product Area has been successfully added.';
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= 'Failed to add product area.';
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function areaEdit($id,$data)
	{	
		//sanitized data
		$data = $this->security->xss_clean($data);
		
		$this->db->where('area_id', $id);
		$this->db->update('products_areas', $data); 
		
		if ( $this->db->affected_rows() > 0 ){
			$response['rc']			= 0;
			$response['success']	= true;
			$response['message'][]	= 'Product Area has been successfully modified.';
			$response['message'][]	= $data;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= 'Failed to edit product area.';
			$response['message'][]	= $data;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function typesList() {
		$this->db->from('products_types');
		$this->db->order_by('product_type_id', 'asc');
		$query = $this->db->get();
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['producttypelist'] = $query->result();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Product Type List: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function typesInfo($id) {
		$this->db->where('product_type_id', $id);
		$query = $this->db->get('products_types');
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['producttypeinfo'] = $query->result();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Product Type Info: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}	
	
	public function typesAdd($data)
	{
		//sanitized data
		$data = $this->security->xss_clean($data);
	
		//insert data
		$query = $this->db->insert('products_types', $data);
		if ( $this->db->affected_rows() > 0 ){
			$response['rc']				= 0;
			$response['success']		= true;
			$response['message'][]		= 'Product Type has been successfully added.';
			$response['producttypeId']  = $this->db->insert_id();
			#$response['data']		= $data;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= 'Failed to add product type.';
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function typesEdit($id,$data)
	{	
		//sanitized data
		$data = $this->security->xss_clean($data);
		
		$this->db->where('product_type_id', $id);
		$this->db->update('products_types', $data);	
		
		if ( $this->db->affected_rows() > 0 ){
			$response['rc']			= 0;
			$response['success']	= true;
			$response['message'][]	= 'Product Type has been successfully modified.';
			$response['message'][]	= $data;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{
			//check if data has no changes
			if ( $this->db->_error_number() == 0 ){
				$response['rc']			= 0;
				$response['success']	= true;
				$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
			}
			else{
				$response['rc']			= 999;
				$response['success']	= false;
				$response['message'][]	= 'Failed to edit product type.';
				$response['message'][]	= $data;
				$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
			}
		}
		return $response;
	}
	
	public function optionList() {
		$this->db->from('products_options');
		$this->db->order_by('option_id', 'asc');
		$query = $this->db->get();
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['optionlist'] = $query->result();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Option List: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function optionInfo($id) {
		
		$product = array(
					'product_id' 		=> $id
		);
		
		$this->db->where($product);
		$query = $this->db->get('products_options');
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['optioninfo'] = $query->result();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Option Info: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function optionAdd($data)
	{
		//sanitized data
		$data = $this->security->xss_clean($data);
	
		//insert data
		$query = $this->db->insert('products_options', $data);
		if ( $this->db->affected_rows() > 0 ){
			$response['rc']			= 0;
			$response['success']	= true;
			$response['message'][]	= 'product option has been successfully added.';
			$response['productId']  = $this->db->insert_id();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= 'Failed to add product option.';
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function optionEdit($id,$data)
	{	
		//sanitized data
		$data = $this->security->xss_clean($data);
		
		$this->db->where('vertical_optionid', $id);
		$this->db->update('products_options', $data); 
		
		if ( $this->db->affected_rows() > 0 ){
			$response['rc']			= 0;
			$response['success']	= true;
			$response['message'][]	= 'Product Option has been successfully modified.';
			$response['message'][]	= $data;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= 'Failed to edit product option.';
			$response['message'][]	= $data;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	
	public function productcsvUpload($data)
	{
		//sanitized data
		$sql = $this->security->xss_clean($data['sql']);
		
		$query = $this->db->query($sql);
		
		if ( $this->db->affected_rows() > 0 ){
			#$savetextfile  			= $this->savetextfile($data);
			$response['rc']			= 0;
			$response['success']	= true;
			$response['message'][]	= 'csv upload was successful.';
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= 'Failed to Upload.';
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function checkProductType($productType) {
		$this->db->select('product_type_id')
				 ->from('products_types')
				->where(array('LOWER(product_type)' => strtolower(urldecode($productType))));
		
		$query = $this->db->get();
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['product_type_id'] 	 = $query->row()->product_type_id;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message 			= ( $this->db->_error_message() ) ? $this->db->_error_message() : strtolower($productType). ' is not a valid product type';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message']	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function checkArea($area_name,$countryId) {
		
		$data = array(
					'LOWER(area_name)' 	  => strtolower(urldecode($area_name)),
					'area_country_id'	  => $countryId
					
		
		);
		
		$this->db->select('area_id')
				 ->from('products_areas')
				->where($data);
		
		$query = $this->db->get();
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['area_id'] 			 = $query->row()->area_id;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message 			= ( $this->db->_error_message() ) ? $this->db->_error_message() : strtolower($area_name) . ' is not a valid area';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message']	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function checkOptions($option_key,$producttypeId) {
		
		$data = array(
					'LOWER(option_key)' 	  => strtolower(urldecode($option_key)),
					'product_type_id'	 	  => $producttypeId
					
		
		);
		
		$this->db->select('*')
				->from('vertical_options')
				->where($data);
		
		$query = $this->db->get();
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['area_id'] 			 = $query->row();
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message 			= ( $this->db->_error_message() ) ? $this->db->_error_message() : 'error in vertical option.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message']	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function advanceSearch($keyword='', $value='') {
		
		$this->db->select('company_name,area_name,product_type,short_name,product_id,products.product_type_id,products.company_id,product_name,product_description,featured,products.country_id,products.area_id,product_icon,product_link,status')
			->from('products')
			->join('companies','products.company_id = companies.company_id','inner')
			->join('products_types','products_types.product_type_id = products.product_type_id','inner')
			->join('countries','countries.country_id= products.country_id','inner')
			->join('products_areas','products_areas.area_id = products.area_id','inner')
			->or_like($keyword,$value)
			->order_by('product_id','asc');

		$query = $this->db->get();
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			$response['data']['productlist'] = $query->result();
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'No Record Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
		}
		return $response;
	}	
	
	public function countryArea($countryId) {
		
		$data = array(
					'area_country_id'	  => $countryId
					
		);
		
		$this->db->select('*')
				 ->from('products_areas')
				->where($data);
		
		$query = $this->db->get();
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 	 = 0;
			$response['success']				 = true;
			$response['data']['productarealist'] = $query->result();
			$response['log_query']			 	 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message 			= ( $this->db->_error_message() ) ? $this->db->_error_message() : 'No Records found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message']	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	
	public function creditcardList() {
		$this->db->select('company_name,area_name,product_type,short_name,product_id,products.product_type_id,products.company_id,product_name,product_description,featured,products.country_id,products.area_id,product_icon,product_link,status,
							(SELECT COUNT(*) FROM products_options po WHERE po.option="Promo" AND po.product_id=products.product_id) as promo,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "annualFee%" AND po.product_id=products.product_id) AS annualFee,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "badge1%" AND po.product_id=products.product_id) AS badge1,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "badge2%" AND po.product_id=products.product_id) AS badge2,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "badge3%" AND po.product_id=products.product_id) AS badge3,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "badge4%" AND po.product_id=products.product_id) AS badge4,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "balanceTransfer%" AND po.product_id=products.product_id) AS balanceTransfer,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "bankName%" AND po.product_id=products.product_id) AS bankName,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "cardProvider%" AND po.product_id=products.product_id) AS cardProvider,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "cardType%" AND po.product_id=products.product_id) AS cardType,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "currency%" AND po.product_id=products.product_id) AS currency,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "hasAirMiles%" AND po.product_id=products.product_id) AS hasAirMiles,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "hasCashBack%" AND po.product_id=products.product_id) AS hasCashBack,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "hasPetrolRewards%" AND po.product_id=products.product_id) AS hasPetrolRewards,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "hasPoints%" AND po.product_id=products.product_id) AS hasPoints,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "institutionalCard%" AND po.product_id=products.product_id) AS institutionalCard,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "interest%" AND po.product_id=products.product_id) AS interestRate,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "keyBenefit1%" AND po.product_id=products.product_id) AS keyBenefit1,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "keyBenefit2%" AND po.product_id=products.product_id) AS keyBenefit2,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "keyBenefit3%" AND po.product_id=products.product_id) AS keyBenefit3,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "logoAltText%" AND po.product_id=products.product_id) AS logoAltText,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "lowInterestThreshold%" AND po.product_id=products.product_id) AS lowInterestThreshold,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "minMonthlyIncome%" AND po.product_id=products.product_id) AS minMonthlyIncome,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "premium%" AND po.product_id=products.product_id) AS premium,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "cashBackRewards" AND po.product_id=products.product_id) AS cashBackRewardsRetail,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "cashBackRewardsPetrol%" AND po.product_id=products.product_id) AS cashBackRewardsPetrol,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "cashBackRewardsHotels%" AND po.product_id=products.product_id) AS cashBackRewardsHotels,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "milesRewardsEnrichMiles%" AND po.product_id=products.product_id) AS milesRewardsEnrichMiles,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "pointRewardsRetail%" AND po.product_id=products.product_id) AS pointRewardsRetail')
			->from('products')
			->join('companies','products.company_id = companies.company_id','inner')
			->join('products_types','products_types.product_type_id = products.product_type_id','inner')
			->join('countries','countries.country_id= products.country_id','inner')
			->join('products_areas','products_areas.area_id = products.area_id','inner')
			->or_like('product_type' , 'credit')
			->order_by('product_id', 'asc');
		$query = $this->db->get();
	
		//if data exist, return results
		if ($query->num_rows() > 0){
			$response['rc']					 = 0;
			$response['success']			 = true;
			
			$response['compargoGlobalApiResponse'] = '';
			$response['compargoGlobalApiResponse']['lang']					      = 'en';
			$response['compargoGlobalApiResponse']['locale']				      = 'hk';
			$response['compargoGlobalApiResponse']['searchResults']['rowCount']   = $query->num_rows();
			
			$ctr = 0;
			foreach ($query->result() as $row){
			
			$response['compargoGlobalApiResponse']['searchResults']
								['searchResultItems'][$ctr] = array(
												'annualFee' 			=> $row->annualFee,
												'balanceTransfer'   	=> $row->balanceTransfer,
												'bankName' 		  		=> $row->bankName,
												'cardProvider' 			=> $row->cardProvider,
												'currency' 				=> $row->currency,
												'hasAirMiles' 			=> $row->hasAirMiles,
												'hasCashBack' 			=> $row->hasCashBack,
												'hasPetrolRewards' 		=> $row->hasPetrolRewards,
												'hasPoints' 			=> $row->hasPoints,
												'institutionalCard' 	=> $row->institutionalCard,
												'interestRate' 			=> $row->interestRate,
											    'keyBenefits' 			=> array('keyBenefit1' =>  $row->keyBenefit1,'keyBenefit2' =>   $row->keyBenefit2,'keyBenefit3' =>   $row->keyBenefit3),
												'link'					=> $row->product_link,
												'link'					=> $row->product_link,
												'logo'					=> $row->product_icon,
												'logoAltText'			=> $row->logoAltText,
												'lowInterestThreshold'	=> $row->lowInterestThreshold,
												'minMonthlyIncome'	    => $row->minMonthlyIncome,
												'premium'				=> $row->premium,
												'productId'				=> $row->product_id,
												'productName'			=> $row->product_name,	
												'ranking'				=> $row->featured,
												'rewards'				=> array(
																					'cashBackRewards' => array('Retail' => $row->cashBackRewardsRetail, 'Petrol' => $row->cashBackRewardsPetrol, 'Hotels' => $row->cashBackRewardsHotels),
																					'milesRewards' => array('EnrichMiles' => $row->milesRewardsEnrichMiles),
																					'pointRewards' => array('pointRewards' => $row->pointRewardsRetail),
																			)
												
												
								);
				$ctr++;
			}
			
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Credit Card List: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}

	public function creditcardInfo($id) {
		
		$product = array(
					'product_id' 		=> $id
		);
		
		
		$this->db->select('company_name,area_name,product_type,short_name,product_id,products.product_type_id,products.company_id,product_name,product_description,featured,products.country_id,products.area_id,product_icon,product_link,status,
							(SELECT COUNT(*) FROM products_options po WHERE po.option="Promo" AND po.product_id=products.product_id) as promo,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "annualFee%" AND po.product_id=products.product_id) AS annualFee,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "badge1%" AND po.product_id=products.product_id) AS badge1,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "badge2%" AND po.product_id=products.product_id) AS badge2,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "badge3%" AND po.product_id=products.product_id) AS badge3,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "badge4%" AND po.product_id=products.product_id) AS badge4,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "balanceTransfer%" AND po.product_id=products.product_id) AS balanceTransfer,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "bankName%" AND po.product_id=products.product_id) AS bankName,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "cardProvider%" AND po.product_id=products.product_id) AS cardProvider,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "cardType%" AND po.product_id=products.product_id) AS cardType,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "currency%" AND po.product_id=products.product_id) AS currency,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "hasAirMiles%" AND po.product_id=products.product_id) AS hasAirMiles,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "hasCashBack%" AND po.product_id=products.product_id) AS hasCashBack,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "hasPetrolRewards%" AND po.product_id=products.product_id) AS hasPetrolRewards,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "hasPoints%" AND po.product_id=products.product_id) AS hasPoints,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "institutionalCard%" AND po.product_id=products.product_id) AS institutionalCard,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "interest%" AND po.product_id=products.product_id) AS interestRate,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "keyBenefit1%" AND po.product_id=products.product_id) AS keyBenefit1,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "keyBenefit2%" AND po.product_id=products.product_id) AS keyBenefit2,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "keyBenefit3%" AND po.product_id=products.product_id) AS keyBenefit3,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "logoAltText%" AND po.product_id=products.product_id) AS logoAltText,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "lowInterestThreshold%" AND po.product_id=products.product_id) AS lowInterestThreshold,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "minMonthlyIncome%" AND po.product_id=products.product_id) AS minMonthlyIncome,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "premium%" AND po.product_id=products.product_id) AS premium,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "cashBackRewards" AND po.product_id=products.product_id) AS cashBackRewardsRetail,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "cashBackRewards1%" AND po.product_id=products.product_id) AS cashBackRewardsPetrol,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "cashBackRewards2%" AND po.product_id=products.product_id) AS cashBackRewardsHotels,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "milesRewardsEnrichMiles%" AND po.product_id=products.product_id) AS milesRewardsEnrichMiles,
							(SELECT po.option_value FROM products_options po WHERE po.option LIKE "pointRewardsRetail%" AND po.product_id=products.product_id) AS pointRewardsRetail')
			->from('products')
			->join('companies','products.company_id = companies.company_id','inner')
			->join('products_types','products_types.product_type_id = products.product_type_id','inner')
			->join('countries','countries.country_id= products.country_id','inner')
			->join('products_areas','products_areas.area_id = products.area_id','inner')
			->where($product)
			->order_by('product_id','asc');

		$query = $this->db->get();
		 
		//if data exist, return results
		if ($query->num_rows() > 0){
			$row	= $query->row();			
			$response['rc']					 = 0;
			$response['success']			 = true;
						
			$response['compargoGlobalApiResponse'] = '';
			$response['compargoGlobalApiResponse']['lang']					      = 'en';
			$response['compargoGlobalApiResponse']['locale']				      = 'hk';
			$response['compargoGlobalApiResponse']['searchResults']['rowCount']   = $query->num_rows();

			$response['compargoGlobalApiResponse']['searchResults']
								['searchResultItems'][0] = array(
												'annualFee' 			=> $row->annualFee,
												'badges'				=> array(array('imageAltText' => $row->badge1, 'logo' => $row->badge2),array('imageAltText' => $row->badge3, 'logo' => $row->badge4)),
												'balanceTransfer'   	=> $row->balanceTransfer,
												'bankName' 		  		=> $row->bankName,
												'cardProvider' 			=> $row->cardProvider,
												'currency' 				=> $row->currency,
												'hasAirMiles' 			=> $row->hasAirMiles,
												'hasCashBack' 			=> $row->hasCashBack,
												'hasPetrolRewards' 		=> $row->hasPetrolRewards,
												'hasPoints' 			=> $row->hasPoints,
												'institutionalCard' 	=> $row->institutionalCard,
												'interestRate' 			=> $row->interestRate,
											    'keyBenefits' 			=> array(array('keyBenefit1' =>  $row->keyBenefit1),array('keyBenefit2' =>   $row->keyBenefit2),array('keyBenefit3' => $row->keyBenefit3)),
												'link'					=> $row->product_link,
												'link'					=> $row->product_link,
												'logo'					=> $row->product_icon,
												'logoAltText'			=> $row->logoAltText,
												'lowInterestThreshold'	=> $row->lowInterestThreshold,
												'minMonthlyIncome'	    => $row->minMonthlyIncome,
												'premium'				=> $row->premium,
												'productId'				=> $row->product_id,
												'productName'			=> $row->product_name,	
												'ranking'				=> $row->featured,
												'rewards'				=> array(
																					'cashBackRewards' => array(array('Retail' => $row->cashBackRewardsRetail), array('Petrol' => $row->cashBackRewardsPetrol), array('Hotels' => $row->cashBackRewardsHotels)),
																					'milesRewards' => array(array('EnrichMiles' => $row->milesRewardsEnrichMiles)),
																					'pointRewards' => array(array('pointRewards' => $row->pointRewardsRetail)),
																			)
												
												
								);

			
								
			#echo "<pre />";
			#print_r($response['compargoGlobalApiResponse']['searchResults']['searchResultItems']);					
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		else{ //no record found	 
			$err_message = ( $this->db->_error_message() ) ? $this->db->_error_message() : 'Credit Card Info: No Records Found.';
			$response['rc']			= 999;
			$response['success']	= false;
			$response['message'][]	= $err_message;
			$response['log_query']			 = str_replace('\n',' ',$this->db->last_query());	
		}
		return $response;
	}
	

// end of the product model

}
?>