<?php

class Auth extends CI_Controller {
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	function Auth() {
		parent::__construct();
	}
	
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	function index() {
		$this->load->helper('url');
		
		if($this->user->logged()) {
			redirect('/');
		}
		
			
		
		$goto = $this->input->get('gt');
		if($goto) {
			$goto = urldecode($goto);
			//die($goto);
			$goto = str_replace('http://', '', $goto);
			$goto = str_replace('https://', '', $goto);
			$goto = str_replace('www.', '', $goto);
			
			if(!preg_match('/^'.$this->config->item('domain_name').'/i', $goto))
				$goto = '/';
			else {
				$goto = 'http://'.$goto;
			}
		} else {
			$goto = '';
		}
		
		
		$this->load->helper('cookie');
		$al_key = get_cookie('opt');
		
		if($al_key && preg_match('/^[0-9A-Za-z]{40,40}$/', $al_key) && ($result = $this->m_users->getByAutoLoginKey($al_key))) {
			
			list($expires, $user) = $result;
			
			//renew if expires soon
			if(($expires-864000) < time()) {
				 $this->m_users->deleteAutoLoginKey($al_key);
				 $this->_setAutologinKey($user['id']);
			}
			
			
			$this->session->set_userdata(array('user_id' => $user['id']));

			redirect($goto?$goto:'/');
		} else {
			/*set_cookie(array(
											 'name'		=> 'aec',
											 'value'	=> 1,
											 'expire'	=> '0',
										 ));*/
			delete_cookie('aes');
			delete_cookie('opt');
		}
		
		if($goto) {
			redirect($goto);
		}
		
		$this->mysmarty->view('auth/signin/index.tpl', array());
	}
	
	
	
	
	
	/*function signin()
	{
		$this->load->library('mysmarty');
		$this->lang->load('pages');
		
		if($this->user->logged())
		{
			$this->load->helper('url');
			redirect('/');
		}
		
		$ps = array();
		$ps['goto'] = $this->input->get('goto');

		if($ps['goto']) {
			$ps['goto'] = urldecode($ps['goto']);
			
			$ps['goto'] = str_replace('http://', '', $ps['goto']);
			$ps['goto'] = str_replace('www.', '', $ps['goto']);
			
			if(!preg_match('/^'.$this->config->item('domain_name').'/i', $ps['goto']))
				$ps['goto'] = '';
			else {
				$ps['goto'] = 'http://'.$ps['goto'];
			}
		}
		
		$this->mysmarty->view('global/signin/index.tpl', $ps);
	}*/
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	function ajaxTrySignIn() {
		$this->load->library('json');
		
		if($this->user->logged()) {
			$this->load->helper('url');
			redirect('/');
		}
		
		$result = array('status' => 0);
		
		$this->load->library('form_validation');
			
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[64]|md5');
		
		//todo:			
		if ($this->form_validation->run() == FALSE)
		{
			$result['errors'] = $this->form_validation->getErrorsArray();
		}
		else
		{
			$this->load->model('m_users');
			
			//login
			if($user = $this->m_users->getByEmail($this->input->post('email')))
			{
				if($user['password'] === $this->input->post('password')){
					/*if(($fb_id = $this->session->userdata('fb_user_id'))) {
						$this->m_users->update($user['id'], array('facebook_id' => $fb_id));
					}
					elseif(($vk_id = $this->session->userdata('vk_user_id'))) {
						$this->m_users->update($user['id'], array('vkontakte_id' => $vk_id));
					}
					elseif(($ok_id = $this->session->userdata('ok_user_id'))) {
						$this->m_users->update($user['id'], array('odnoklassniki_id' => $ok_id));
					}
					elseif(($mr_id = $this->session->userdata('mr_user_id'))) {
						$this->m_users->update($user['id'], array('mailru_id' => $mr_id));
					}*/
				
					$this->session->set_userdata(array('user_id' => $user['id']/*, 'fb_user_id' => '', 'vk_user_id' => '', 'ok_user_id' => '', 'mr_user_id' => ''*/));
					$result['status'] = 1;
				}
			}
			//else
				//$result['errors'] = $this->form_validation->getErrorsArray();
		}
		
		$this->json->parse($result);
	}
	
	
	
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	/*function ajaxSaveRegData() {
		if(!$this->config->item('full_account_creation_needed')) {
			return false;
		}
		
		$this->load->library('json');
		
		$result = array('status' => 0);
		
		$this->load->library('form_validation');
			

		$fb_id = $this->session->userdata('fb_user_id');
		$vk_id = 0;
			
		if(!$fb_id && !($vk_id = $this->session->userdata('vk_user_id')) && !($ok_id = $this->session->userdata('ok_user_id')) && !($mr_id = $this->session->userdata('mr_user_id'))) {
			$this->json->parse($result);
			return false; //Only social signup
		}

		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback__is_email_exists');
		$this->form_validation->set_rules('fname', 'First name',
												 'trim|max_length[128]|xss_clean');
		$this->form_validation->set_rules('lname', 'Last name',
												 'trim|max_length[128]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[64]|md5');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
		
					
		if ($this->form_validation->run() == FALSE) {
			
			$result['errors'] = $this->form_validation->getErrorsArray();
		}
		else
		{
		
			$this->load->model('m_users');
			
			$this->session->set_userdata(array('fb_user_id' => '', 'vk_user_id' => '', 'ok_user_id' => '', 'mr_user_id' => ''));
			
			$id = $this->m_users->create(array('first_name'	=> $this->input->post('fname'),
											'last_name'	=> $this->input->post('lname'),
											'email'		=> $this->input->post('email'),
											'password'	=> $this->input->post('password'),
											'facebook_id' => $fb_id,
											'vkontakte_id' => $vk_id,
											'odnoklassniki_id' => $ok_id,
											'mailru_id'	=> $mr_id));
			
			if($id) {
				$this->session->set_userdata(array('user_id' => $id));
				$result['status'] = 1;
			}
		}
		
		$this->json->parse($result);
	}*/
	
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	function logout() {
		if($this->user->logged()) {
			$this->_onLogout();
		}
		
		$this->load->helper('url');
		$this->load->library('user_agent');
			
		if ($this->agent->is_referral()) {
			$referer = $this->agent->referrer();
		} else {
			$referer = '/';
		}
		
		redirect($referer);
	}
	
	
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	function step1($handler = '', $reason = '') {

		if($reason && $reason != 'merge')
			$reason = '';
		
		if($this->user->logged() && $reason != 'merge') {
			setcookie('sl', 1, 0 , '/');
			echo '<script type="text/javascript">window.close();</script>';
			
			return;
		}
		
		if(!$handler || !preg_match('/^[A-Za-z0-9]{3,64}$/i', $handler)) {
			show_404();
		}
		
		
		try {
			
			$code = $this->input->get('code');

			if(!$code) {
				throw new Exception('Authorization grant code not set'/*, AG_CODE_NOT_SET*/);
			}
		
			
			$this->load->library('OAuth', array(
													'handler_type' => $handler));
			
			//TODO: CSRF protection
			
			$response = $this->oauth->getAccessToken($code, $reason);

			if($response) {
				$result = array(
					'oa_access_token'	=> $this->oauth->oa_access_token,
					'oa_valid_till'		=> $this->oauth->oa_valid_till,
					'oa_user_id'		=> $this->oauth->oa_user_id
				);
				
				
				$this->session->set_userdata($result);
			
				setcookie('sl', 1, 0 , '/');
				echo '<script type="text/javascript">window.close();</script>';
			} else {
				throw new Exception('Get token operation failed'/*, GET_TOKEN_FAILED*/);
			}
		} catch(Exception $e) {
			show_error($e->getMessage());
		}
	}
	
	
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	function step2($handler = '', $reason = '') {
		$this->load->library('json');
		
		$result = array();
		$result['status'] = 0;
		
		
		$merge = ($this->user->logged() && $reason == 'merge')?true:false;
		

		if($this->user->logged() && !$merge) {
			$result['status'] = 1;

			return $this->json->parse($result);
		}
		

		try {
			
			if(!$handler || !preg_match('/^[A-Za-z0-9]{3,64}$/i', $handler)) {
				show_404();
			}
		
			$this->load->library('OAuth', array(
													'handler_type'		=> $handler
													));
			
			$this->load->model('m_users');
			
			$user = array();
			//if user_id was set in previous step
			if($this->oauth->oa_user_id) {
				//Check user exists in DB
				$user = $this->m_users->getBySocialID($this->oauth->getHandlerType(), $this->oauth->oa_user_id);
			} else {
				//try to get OAuth user_id
				$oa_user_id = $this->oauth->getUserID();
				if($oa_user_id) {
					$user = $this->m_users->getBySocialID($this->oauth->getHandlerType(), $oa_user_id);
				} else {
					throw new Exception('Get user info operation failed');
				}
			}
			
			//var_dump(date('r', $this->oauth->oa_valid_till));
			
			if(!$merge) {
				//if user exists login her
				if($user) {
					
					$id = $user['id'];
					$this->session->set_userdata(array('user_id' => $user['id']));
					
					$result['status'] = 1;
				} else {
					
					//Get user data from social network
					if($user = $this->oauth->getUserData()) {
						
						if($this->config->item('full_account_creation_needed')) {
							
							//TODO: accaunt creation routines
							
							$result['status']	= 2;
							$result['header']	= '';
							$result['body']		= $this->mysmarty->view('auth/signup/social/index.tpl', array('hItem' => &$user), false, true);
						} else {
							//TODO: if email exists
							if(isset($user['email']) && $user['email'] && $this->m_users->isEmailExists($user['email'])) {
								$result['status']	= 3;
								$result['header']	= '';
								$result['body']		= $this->mysmarty->view('auth/signup/social/email_exists.tpl', array('hItem' => &$user), false, true);
                            } elseif ((!isset($user['email']) || !$user['email']) && $this->config->item('account_email_needed')){
                                $result['status']	= 2;
                                $result['header']	= '';
                                $session = $this->session->all_userdata();
                                $result['body']		= $this->mysmarty->view('auth/signup/social/callback.tpl', array('hItem' => &$user, 'session'=>$session), false, true);
                            } else {
                                $photo = $this->oauth->getUserPhoto();



                                if($photo) {
                                    $this->load->library('imagine');
                                    $avatar = $this->imagine->uploadAvatar($photo);
                                    if ($avatar && isset($avatar['avatar_b']) && $avatar['avatar_b']) {
                                        $user['avatar_b'] = $avatar['avatar_b'];
                                        $user['avatar_m'] = $avatar['avatar_m'];
                                        $user['avatar_s'] = $avatar['avatar_s'];
                                    }
                                }

                                $id = $this->m_users->create($user);

								if($id) {
                                    $this->session->set_userdata(array('user_id' => $id));

									$result['status'] = 1;
								}
							}
						}
					}
				}
			} else {
				if($user) {
					$result['status']	= 3;
					$result['header']	= '';
					$result['body']		= $this->mysmarty->view('auth/signup/social/already_exists.tpl', array('hItem' => &$user), false, true);
				} else {
					if($user = $this->oauth->getUserData()) {
						
						$data = array();
						
						$hItem = $this->user->getUserData();
						foreach($user as $k => $v) {
							if($k == 'email' || $k == 'url_friendly_name') {
								continue;
							}
							
							if(!array_key_exists($k, $hItem) || !$hItem[$k]) {
								$data[$k] = $v;
							}
						}
						
						$this->m_users->update($this->user->uid(), $data);
						
						$result['status'] = 1;
					}
				}
			}
			
			
			if(!$merge && $result['status'] === 1) {

                $user_update = array(
                    $this->oauth->getHandlerType().'_oa_access_token' => $this->oauth->oa_access_token,
                    $this->oauth->getHandlerType().'_oa_valid_till' => $this->oauth->oa_valid_till
                );

                //if (isset($user_photo_update) && $user_photo_update && is_array($user_photo_update))
                    //$user_update = array_merge($user_update,$user_photo_update);

				$this->m_users->update($id, $user_update);
				
				$this->oauth->unsetCookieData();
				$this->_onLogin($id);
			}
            elseif($merge && $result['status'] === 1) {
                $this->m_users->update($this->user->uid(), array(
                    $this->oauth->getHandlerType().'_oa_access_token' => $this->oauth->oa_access_token,
                    $this->oauth->getHandlerType().'_oa_valid_till' => $this->oauth->oa_valid_till
                ));
            }
			
		} catch(Exception $e) {
			$result['error'] = $e->getMessage();
		}
		
		
		

        return $this->json->parse($result);
	}


	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	/*function odnoklassniki() {
		if($this->user->logged()) {
			setcookie('socialLogin', 1, 0 , '/');
			echo '<script type="text/javascript">window.close();</script>';
			
			return;
		}
		
		$code = $this->input->get('code');
		if($code) {
			$token_url = 'http://api.odnoklassniki.ru/oauth/token.do';
	   		
			$ch = NULL;
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $token_url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,
				'code='.$code. '&redirect_uri='. urlencode($this->config->item('base_url').'auth/odnoklassniki').'&grant_type=authorization_code&client_id='.$this->config->item('odnoklassniki_app_id').'&client_secret=' . $this->config->item('odnoklassniki_app_secret')
			);
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		
			$output = curl_exec($ch);
			curl_close($ch);
		
			
			if($output) {
				$params = json_decode($output, true);
				
				if(isset($params['access_token'])) {
					$this->session->set_userdata(array('ok_access_token' => $params['access_token'], 'ok_at_valid_till' => time() + 60*30));
					setcookie('socialLogin', 1, 0 , '/');
				}
				
				echo '<script type="text/javascript">window.close();</script>';
			}
		}
		else {
			echo("The state does not match. You may be a victim of CSRF.");
		}
	}*/



	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	/*function odnoklassniki_step2() {
		$this->load->library('json');
		
		$result = array();
		$result['status'] = 0;
		
		
		if($this->user->logged()) {
			$result['status'] = 1;
			$this->json->parse($result);
			
			return false;
		}
		
		
		if(!$this->session->userdata('ok_access_token') || $this->session->userdata('ok_at_valid_till') < time()) {
			$this->json->parse($result);
			return;
		}
		
		
		if(1) {
			$this->load->library('mysmarty');
			
			$ps = array();
			//$graph_url = "https://graph.facebook.com/me?access_token=".$this->session->userdata('fb_access_token');

			$ok_user = json_decode(file_get_contents('http://api.odnoklassniki.ru/fb.do?access_token=' . $this->session->userdata('ok_access_token') . '&application_key=' . $this->config->item('odnoklassniki_app_public') . '&method=users.getCurrentUser&sig=' . md5('application_key=' . $this->config->item('odnoklassniki_app_public') . 'method=users.getCurrentUser' . md5($this->session->userdata('ok_access_token') . $this->config->item('odnoklassniki_app_secret')))), true);



			if($ok_user && isset($ok_user['uid'])) {				
				$this->load->model('m_users');
				$user = $this->m_users->getByOKid($ok_user['uid']);
				
				if($user) {
					$id = $user['id'];
					
					$this->session->set_userdata(array('user_id' => $user['id'], 'ok_user_id' => ''));
					$result['status'] = 1;
				} else {
					if($this->config->item('full_account_creation_needed')) {
						$this->session->set_userdata(array('ok_user_id' => $ok_user['uid']));
						
						$result['status']	= 2;
						$result['header']	= '';
						$result['body']		= $this->mysmarty->view('auth/signup/social/index.tpl', array('hItem' => $ok_user), false, true);
					} else {
						$id = $this->m_users->create(array(
									'first_name'	 	=> $ok_user['first_name'],
									'last_name' 	 	=> $ok_user['last_name'],
									'url_friendly_name'	=> '',
									'email'				=> '', 
									'timezone'			=> '',
									'gender'			=> $ok_user['gender']?(($ok_user['gender']=='male')?2:1):0,
									'odnoklassniki_id'	=> $ok_user['uid']));
						
						if($id) {
							$data = $this->m_users->get($id);
							
							$this->load->library('avatars');
							$this->avatars->upload($data['site_id'], $id, str_replace('photoType=2','photoType=3',$ok_user['pic_2']));
							
							$this->session->set_userdata(array('user_id' => $id));
							$result['status'] = 1;
						}
					}
				}
			}
		}
		
		
		if($result['status'] === 1) {
			$this->_onLogin($id);
		}
			
		
		$this->json->parse($result);
	}*/
	
	
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	/*function mailru() {
		if($this->user->logged()) {
			setcookie('socialLogin', 1, 0 , '/');
			echo '<script type="text/javascript">window.close();</script>';
			
			return;
		}

		$code = $this->input->get('code');
		if($code) {
			$token_url = 'https://connect.mail.ru/oauth/token';
	   		
			$ch = NULL;
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $token_url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,
				'code='.$code. '&redirect_uri='. urlencode($this->config->item('base_url').'auth/mailru').'&grant_type=authorization_code&client_id='.$this->config->item('mailru_app_id').'&client_secret=' . $this->config->item('mailru_app_secret')
			);
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		
			$output = curl_exec($ch);
			curl_close($ch);
		
			if($output) {
				$params = json_decode($output, true);
				
				if(isset($params['access_token'])) {
					$this->session->set_userdata(array('mr_access_token' => $params['access_token'], 'mr_at_valid_till' => time() + $params['expires_in']));
					setcookie('socialLogin', 1, 0 , '/');
				}
				
				echo '<script type="text/javascript">window.close();</script>';
			}
		}
		else {
			echo("The state does not match. You may be a victim of CSRF.");
		}
	}*/





	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	/*function mailru_step2() {
		$this->load->library('json');
		
		$result = array();
		$result['status'] = 0;
		
		
		if($this->user->logged()) {
			$result['status'] = 1;
			$this->json->parse($result);
			
			return false;
		}
		
		
		if(!$this->session->userdata('mr_access_token') || $this->session->userdata('mr_at_valid_till') < time()) {
			$this->json->parse($result);
			return;
		}
		
		
		if(1) {
			$this->load->library('mysmarty');
			
			$ps = array();
			$url = 'http://www.appsmail.ru/platform/api?';
			
			$params = array('app_id' => $this->config->item('mailru_app_id'),
							'method' => 'users.getInfo',
							'secure' => 1,
							'session_key' => $this->session->userdata('mr_access_token'));
			
			$sig = '';
			foreach($params as $k => $v) {
				$sig .= ($k.'='.$v);
			}
			
			$params['sig'] = md5($sig.$this->config->item('mailru_app_secret'));

			$mr_user = json_decode(file_get_contents($url.http_build_query($params)), true);

			if(isset($mr_user[0])) {
				$mr_user = $mr_user[0];
				
				if(isset($mr_user['uid'])) {				
					$this->load->model('m_users');
					$user = $this->m_users->getByMRid($mr_user['uid']);
					
					if($user) {
						$id = $user['id'];
						
						$this->session->set_userdata(array('user_id' => $user['id'], 'mr_user_id' => ''));
						$result['status'] = 1;
					} else {
						if($this->config->item('full_account_creation_needed')) {
							$this->session->set_userdata(array('mr_user_id' => $mr_user['uid']));
							
							$result['status']	= 2;
							$result['header']	= '';
							$result['body']		= $this->mysmarty->view('auth/signup/social/index.tpl', array('hItem' => $mr_user), false, true);
						} else {
							$id = $this->m_users->create(array(
										'first_name'	 	=> $mr_user['first_name'],
										'last_name' 	 	=> $mr_user['last_name'],
										'url_friendly_name'	=> '',
										'email'				=> (isset($mr_user['email']))?$mr_user['email']:'', 
										'timezone'			=> '',
										'gender'			=> ($mr_user['sex']==0)?2:1,
										'mailru_id'			=> $mr_user['uid']));
							
							if($id) {
								$data = $this->m_users->get($id);
								
								$this->load->library('avatars');
								$this->avatars->upload($data['site_id'], $id, $mr_user['pic_big']);
								
								$this->session->set_userdata(array('user_id' => $id));
								$result['status'] = 1;
							}
						}
					}
				}
			}
		}
		
		
		if($result['status'] === 1) {
			$this->_onLogin($id);
		}
				
		
		$this->json->parse($result);
	}*/
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	function _is_email_exists($email) {
		$this->load->model('m_users');
		
		if($this->m_users->isEmailExists($email))
			return FALSE;
		else
			return TRUE;
	}
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	function _onLogin($user_id) {
		$this->load->helper('cookie');
		//delete_cookie('aec');
		
		$this->_setAutologinKey($user_id);
	}
	
	
	
	
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	function _onLogout() {
		$this->session->sess_destroy();	
			
		$this->load->helper('cookie');
		$al_key = get_cookie('opt');
			
		if(preg_match('/^[0-9A-Za-z]{40,40}$/', $al_key) && $this->m_users->deleteAutoLoginKey($al_key)) {
			//delete autologin key
			delete_cookie('opt');
			delete_cookie('aes');
		}
	}

    public function twitter_step2($reason = '')
    {
        $result = array();
        $this->load->library('json');
        $result['status'] = 0;
        $merge = ($this->user->logged() && $reason == 'merge')?true:false;

        if($this->user->logged() && !$merge) {
            $result['status'] = 1;
            return $this->json->parse($result);
        }

        $session = $this->session->all_userdata();

        if (!$merge){
            $user = array(
                'twitter_id' => $session['twitter_user_id']
            );

            $ps = array(
                'hItem' => &$user,
                'session' => $session
            );
            setcookie('sl', 1, 0 , '/');

            $result['status']	= 2;
            $result['header']	= '';
            $result['body']		= $this->mysmarty->view('auth/signup/social/callback.tpl', $ps, false, true);
        } else {
            $result['status']	= 1;
        }

        return $this->json->parse($result);
    }
	
	
	public function complete_signup()
    {
        $result = array('status' => 'error');
        $this->load->helper('email');
        $this->load->library('json');
        $data = array();

        $session = $this->session->all_userdata();

        $RAW = $this->input->post('item');

        $email = trim($RAW['email']);
        if (valid_email($email)) {
            $this->load->model('m_users');

            $user = $this->m_users->getByEmail($email);
            if ($user && isset($user['id']) && $user['id']){
                if ($RAW['twitter_id'] && $RAW['twitter_id'] > $user['twitter_id'])$data['twitter_id'] = $RAW['twitter_id'];
                if ($RAW['vkontakte_id'] && $RAW['vkontakte_id'] > $user['vkontakte_id']) $data['vkontakte_id'] = $RAW['vkontakte_id'];
                if ($data) {
                    $this->m_users->update($user['id'], $data);
                    $this->session->set_userdata(array('user_id' => $user['id']));
                    $result['status'] = 2;
                }

            } else {
                if ($RAW['twitter_id']) {
                    $data['twitter_id'] = $RAW['twitter_id'];

                    $data['twitter_oa_access_token'] = $session['twitter_access_token'];

                    $data['first_name'] = $session['twitter_screen_name'];
                    $data['url_friendly_name'] = $session['twitter_screen_name'];
                }
                if ($RAW['vkontakte_id']) {
                    $this->load->library('OAuth', array('handler_type' => 'vkontakte'));
                    $oa_user_id = $this->oauth->getUserID();
                    if ($oa_user_id) {
                        $user = $this->oauth->getUserData();
                        $data['first_name'] = $user['first_name'];
                        $data['last_name'] = $user['last_name'];
                        $data['url_friendly_name'] = $user['url_friendly_name'];
                        $data['timezone'] = $user['timezone'];
                        $data['gender'] = $user['gender'];
                        $data['vkontakte_id'] = $user['vkontakte_id'];
                    }
                }
                if ($data) {
                    $data['email'] = $email;
                    $id = $this->m_users->create($data);
                    if ($id) {
                        $this->session->set_userdata(array('user_id' => $id));
                        $result['status'] = 1;
                    }
                }
            }
        }
        return $this->json->parse($result);
    }
	
	/**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */	
	function _setAutologinKey($user_id) {
		
		$sec_valid = 2592000; //30 days //'31536000', //1 year
		
		$this->load->helper('string');
		$al_key = sha1(random_string('alnum', 16)+microtime());
			
		if(!$this->m_users->addAutoLoginKey((int) $user_id, $al_key, (time() + $sec_valid))) {
			return false;
		}
		
		$this->input->set_cookie(array(
											 'name'		=> 'opt',
											 'value'	=> $al_key,
											 'expire'	=> $sec_valid,
											 //'secure' => TRUE //TODO: Enable later.
										 ));
		
		$this->input->set_cookie(array(
											 'name'		=> 'aes',
											 'value'	=> 1,
											 'expire'	=> $sec_valid,
										 ));
	}
}

/* End of file auth.php */
/* Location: ./system/application/controllers/auth.php */