<?php

class home_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->restApiUrl 	= $this->config->item('rest_api_url');
		$this->apiAuthKey 	= $this->config->item('api_auth_key');
	}

	
	// validate user credentials
	function validate($data)
	{
		$url = $this->restApiUrl. 'users/login/'.$this->apiAuthKey.'/';
		// echo $url; exit;
		return json_decode($this->call_rest_post($url,$data));
	}
	
	// logout user
	function logout()
	{
		$userid = $this->session->userdata('userid');
		$logid  = $this->session->userdata('logid');
		$locale = $this->session->userdata('locale');
		$url = $this->restApiUrl. 'users/logout/'.$locale.'/'.$this->apiAuthKey.'/'  . $userid . '/' . $logid;
		echo $url;
		return json_decode($this->call_rest($url,''));
	}	
	
	//call rest API
	function call_rest($url,$data='')
	{
		$result = $this->curl->simple_get($url , $data , array(CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST=> false));
		return $result;
	}
	
	function call_rest_post($url,$data='')
	{
		$result = $this->curl->simple_post($url , $data , array(CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST=> false));
		// echo "<pre />";
		// print_r($result);
		return $result;
	}
	
	
}