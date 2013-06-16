<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User{ 
	private $aUserData = array();
	private	$CI;
	
    function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('m_users');
		
		if($this->CI->session->userdata('user_id') > 0) {			
			$this->aUserData = $this->CI->m_users->get($this->CI->session->userdata('user_id'));
			if(!$this->aUserData) {
				$this->CI->session->sess_destroy();
			} else {
				if(isset($this->aUserData['timezone'])) {
					//var_dump($this->aUserData['timezone']);
					//var_dump($timezone_name = timezone_name_from_abbr(null, (int)$this->aUserData['timezone'], true));
	//$this->aUserData['timezone']++;
	//var_dump($timezone_name = timezone_name_from_abbr(null, (int)$this->aUserData['timezone'] * 3600, false));
					
					//date_default_timezone_set($timezone_name);
				}
			}
		}
    }
	
	function __get($name)
	{
		if(isset($this->aUserData[$name]))
			return $this->aUserData[$name];
		else
			return NULL;
	}
	
	function &getUserData()
	{
		return $this->aUserData;
	}
	
	function uid()
	{
		if($this->id)
			return (int) $this->id;
		else
			return 0;
	}
	
	function logged()
	{
		if($this->id)
			return true;
		else
			return false;
	}
	
	
	function isSiteModerator() {
		$acls = $this->CI->config->item('access_levels');
		if($this->logged() && $acls) {
			if($this->aUserData['access_level'] >= $acls['ACL_EDIT']) {
				return true;
			}
		}
			
		return false;
	}
	
	function isSiteAdmin() {
		$acls = $this->CI->config->item('access_levels');
		if($this->logged() && $acls) {
			if($this->aUserData['access_level'] >= $acls['ACL_ADMIN']) {
				return true;
			}
		}
			
		return false;
	}
}