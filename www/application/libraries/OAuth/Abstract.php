<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

abstract class OAuthAbstract {
	protected $app_id			= '';
	protected $app_secret		= '';
	
	public $oa_access_token		= '';
	public $oa_valid_till		= 0;
	public $oa_user_id			= 0;
	
	protected $user_data_response	= NULL;
	
	abstract protected function &_connectAndGrabUserData();
		
	abstract public function getAccessToken($code, $reason = '');
	
	abstract public function getUserID();
	abstract public function getUserData();
	abstract public function getUserPhoto();
	
}
?>