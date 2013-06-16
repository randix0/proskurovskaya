<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

define('COULD_NOT_INIT_HANDLER', 0);
define('AG_CODE_NOT_SET', 1);
define('GET_TOKEN_FAILED', 2);
define('TOKEN_NOT_VALID', 3);
define('TOKEN_EXPIRED', 4);

define('APP_ID_OR_SECRET_NOT_SET', 100);
define('CONNECTION_ERROR', 101);


class OAuth {
	private $handler_type = '';
	private $handler = NULL;
	
	
	private $CI = NULL;
		
		
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	function __construct($params = array()) {
		
		$this->CI = &get_instance();
		
		$this->CI->config->load('oauth');
		$handlers = $this->CI->config->item('oauth_handlers');
		
		foreach($params as $k => $v) {
			$this->$k = $v;
		}
		
		
		$this->handler_type = strtolower($this->handler_type);
		
		
		if(!$this->handler_type || !is_array($handlers) || !in_array($this->handler_type, $handlers)) {
			show_404();
		}
		

		$file = dirname(__FILE__).'/OAuth/'.ucfirst($this->handler_type).'.php';
        //echo $file;
		//if(!file_exists($file)) {
		//	throw new Exception('Could not load handler', COULD_NOT_INIT_HANDLER);
		//}
		
		
		require_once($file);
		//$this->handler_type = $params['handler_type'];
		$this->handler = new $this->handler_type;
		
		
		$this->handler->oa_access_token	= $this->CI->session->userdata('oa_access_token');
		$this->handler->oa_valid_till	= $this->CI->session->userdata('oa_valid_till');
		$this->handler->oa_user_id		= $this->CI->session->userdata('oa_user_id');
	}	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	public function unsetCookieData() {
		return $this->CI->session->unset_userdata(array('oa_access_token' => '', 'oa_valid_till' => '', 'oa_user_id' => ''));
	}
	
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	/*public function __set($name, $value) {
		$this->handler->$name = $value;
	}*/
	
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	public function __get($variable) {
		return $this->handler->$variable;
	}
	
	
	public function getHandlerType() {
		return $this->handler_type;
	}
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	public function __call($name, $arguments) {
		return call_user_func_array(array(&$this->handler, $name), $arguments);
	}
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	/*public function step1() {
		
		$code = $this->CI->input->get('code');
		
		if(!$code) {
			throw new Exception('Authorization grant code not set', AG_CODE_NOT_SET);
		}
		
		$response = $this->getAccessToken($code);
		
		if($response) {
			$result = array(
				'oa_access_token'	=> $this->handler->oa_access_token,
				'oa_valid_till'		=> $this->handler->oa_valid_till,
				'oa_user_id'		=> $this->handler->oa_user_id
			);
			
			
			$this->CI->session->set_userdata($result);
			
			return true;
		}
		
		throw new Exception('Get token operation failed', GET_TOKEN_FAILED);
	}*/
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	/*public function step2() {
		$this->handler->oa_access_token	= $this->CI->session->userdata('oa_access_token');
		$this->handler->oa_valid_till	= $this->CI->session->userdata('oa_valid_till');
		$this->handler->oa_user_id		= $this->CI->session->userdata('oa_user_id');
		
		if(!$this->handler->oa_access_token) {
			throw new Exception('Token not valid', TOKEN_NOT_VALID);
		}
		
		if($this->handler->oa_valid_till < time()) {
			throw new Exception('Token expired', TOKEN_EXPIRED);
		}
		
		$this->CI->load->model('usersmodel');
		
		//Check user exists in DB
		$user = $this->CI->usersmodel->getBySocialID($this->handler_type, $this->handler->oa_user_id);
		
		//if user exists login her
		if($user) {
			$this->CI->session->set_userdata(array('user_id' => $user['id']));
		} else {
			
			//Get user data from social network
			if($user = $this->handler->getUserData($this->handler->oa_user_id, $this->handler->oa_access_token)) {
				
				if($this->CI->config->item('full_account_creation_needed')) {
					
					//TODO: accaunt creation routines
					
				} else {
					
					$id = $this->CI->usersmodel->create($user);
					
					if($id) {
						$data = $this->CI->usersmodel->get($id);
						
						$photo = $this->handler->getUserPhoto($this->handler->oa_user_id, $this->handler->oa_access_token);
						
						if($photo) {
							$this->CI->load->library('avatars');
							$this->CI->avatars->upload($data['site_id'], $id, $photo);
						}
							
						$this->CI->session->set_userdata(array('user_id' => $id));
					}
				}
			}
		}
		
		$this->CI->session->unset_userdata(array('oa_access_token', 'oa_valid_till', 'oa_user_id'));
		
		
		//$user = $this->usersmodel->getByVKid($this->session->userdata('oa_user_id'));
	}*/
}
?>