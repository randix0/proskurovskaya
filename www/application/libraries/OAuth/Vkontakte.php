<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


require_once dirname(__FILE__).'/Abstract.php'; 


class Vkontakte extends OAuthAbstract {
	
	private $config = NULL;
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	public function __construct() {
		$this->config = $config	 = &get_config();
		
		$this->app_id		= $config['vkontakte_app_id'];
		$this->app_secret	= $config['vkontakte_app_secret'];
		
		if(!$this->app_id || !$this->app_secret) {
			throw new Exception('Application ID not set', APP_ID_OR_SECRET_NOT_SET);
		}
		
	}
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	public function getAccessToken($code, $reason = '') {
		
		$token_url = 'https://api.vk.com/oauth/access_token?client_id='.$this->app_id.'&client_secret='.$this->app_secret.'&code='.$code.'&redirect_uri='. urlencode($this->config['base_url'].'auth/step1/vkontakte/'.$reason);
		
		$response = NULL;
		
		if($contents = @file_get_contents($token_url)) {
			$response = json_decode($contents);
		} else {
			throw new Exception('Connection error', CONNECTION_ERROR);
		}
		
		if($response && isset($response->user_id) && $response->user_id > 0) {
			$this->oa_access_token	= $response->access_token;
			$this->oa_valid_till	= time() + $response->expires_in;
			$this->oa_user_id		= $response->user_id;
			
			return true;
		}
		
		return false;
	}
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	 protected function &_connectAndGrabUserData() {
		if(!$this->user_data_response) {
			
			if(!$this->oa_access_token || !$this->oa_user_id) {
				throw new Exception('Token not valid', TOKEN_NOT_VALID);
			}
			
			if($this->oa_valid_till < time()) {
				throw new Exception('Token expired', TOKEN_EXPIRED);
			}
			
			$response = NULL;
			
			if($contents = @file_get_contents('https://api.vk.com/method/getProfiles?uid='.$this->oa_user_id.'&access_token='.$this->oa_access_token
														.'&fields=first_name,last_name,screen_name,sex,bdate,photo_big,timezone')) {
				
				$response = json_decode($contents, true);
				
				if(isset($response['response'][0])) {
					$this->user_data_response = $response['response'][0];
				} else {
					throw new Exception('Get user data failed', CONNECTION_ERROR);
				}
			} else {
				throw new Exception('Connection error', CONNECTION_ERROR);
			}
			
		}

		return $this->user_data_response;
	 }
	 
	 
	 
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	public function getUserID() {
		if($this->oa_user_id)
			return $this->oa_user_id;
		
		$response = $this->_connectAndGrabUserData();
		
		if($response) {
			$this->oa_user_id = $response['uid'];
			
			return $this->oa_user_id;
		}
		
		return false;
	}
	 
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	public function getUserData() {
		$response = $this->_connectAndGrabUserData();
		
		if($response) {
			return array(
												'first_name'		=> $response['first_name'],
												'last_name'			=> $response['last_name'],
												'url_friendly_name'	=> (isset($response['screen_name']) && !preg_match('/^id[0-9]+$/i',$response['screen_name']))?$response['screen_name']:'',
												/*'email'  => $response['email'],*/
												'timezone'			=> $response['timezone'],
												'gender'			=> $response['sex']?$response['sex']:0,
												'vkontakte_id'		=> $response['uid']
											);
		}
		
		return false;
	}
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	public function getUserPhoto() {
		$response = $this->_connectAndGrabUserData();
		
		if($response && isset($response['photo_big']) && $response['photo_big']) {
			return $response['photo_big'];
		}
		
		return false;
	}
}
?>