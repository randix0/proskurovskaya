<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Twitter OAuth library.
 * Sample controller.
 * Requirements: enabled Session library, enabled URL helper
 */

class Twitter extends CI_Controller
{
	/**
	 * TwitterOauth class instance.
	 */
	private $connection;
	
	/**
	 * Controller constructor
	 */
	function __construct()
	{
		parent::__construct();

        $this->CI = &get_instance();

        $this->CI->config->load('oauth');

		// Loading TwitterOauth library. Delete this line if you choose autoload method.
		$this->load->library('twitteroauth');
        $this->load->helper('url');
        $this->load->helper('cookie');
		// Loading twitter configuration.
        $this->CI->config->load('twitter');
		
		if($this->session->userdata('twitter_access_token') && $this->session->userdata('twitter_access_token_secret'))
		{
			// If user already logged in
			$this->connection = $this->twitteroauth->create($this->CI->config->item('twitter_consumer_token'), $this->CI->config->item('twitter_consumer_secret'), $this->session->userdata('twitter_access_token'),  $this->session->userdata('twitter_access_token_secret'));
		}
		elseif($this->session->userdata('request_token') && $this->session->userdata('request_token_secret'))
		{
			// If user in process of authentication
			$this->connection = $this->twitteroauth->create($this->CI->config->item('twitter_consumer_token'), $this->CI->config->item('twitter_consumer_secret'), $this->session->userdata('request_token'), $this->session->userdata('request_token_secret'));
		}
		else
		{
			// Unknown user
			$this->connection = $this->twitteroauth->create($this->CI->config->item('twitter_consumer_token'), $this->CI->config->item('twitter_consumer_secret'));
		}
	}
	
	/**
	 * Here comes authentication process begin.
	 * @access	public
	 * @return	void
	 */
	public function auth($reason = '')
	{
		if($this->session->userdata('twitter_access_token') && $this->session->userdata('twitter_access_token_secret'))
		{
			// User is already authenticated. Add your user notification code here.
			//redirect(base_url('/'));
            //$this->session->set_userdata(array('twitter_auth_status'=>'logged'));

            $twitter_id = $this->session->userdata('twitter_user_id');
            $twitter_auth_status = $this->session->userdata('twitter_auth_status');


            setcookie('sl', 1, 0 , '/');
            echo '<script type="text/javascript">window.close();</script>';
            return;
		}
		else
		{
			// Making a request for request_token
			$request_token = $this->connection->getRequestToken(base_url('/twitter/callback/'.$reason));

            if ($request_token && isset($request_token['oauth_token']) && $request_token['oauth_token'] && isset($request_token['oauth_token_secret']) && $request_token['oauth_token_secret']){
                $this->session->set_userdata('request_token', $request_token['oauth_token']);
                $this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);

                if($this->connection->http_code == 200)
                {
                    $url = $this->connection->getAuthorizeURL($request_token);
                    redirect($url);
                }
                else
                {
                    // An error occured. Make sure to put your error notification code here.
                    $this->session->set_userdata(array('twitter_auth_status'=>'error'));
                    setcookie('sl', 1, 0 , '/');
                    $this->reset_session();
                    echo '<script type="text/javascript">alert(\'Error: 87\'); window.close();</script>';
                    return;
                    //echo 'An error occured. Make sure to put your error notification code here.';
                }
            } else {
                $this->session->set_userdata(array('twitter_auth_status'=>'error'));
                $this->reset_session();
                echo '<script type="text/javascript">window.close();</script>';
                return;
            }
		}
	}
	
	/**
	 * Callback function, landing page for twitter.
	 * @access	public
	 * @return	void
	 */
	public function callback($reason = '')
	{
        $result = array();
        $result['status'] = 0;
        $merge = ($this->user->logged() && $reason == 'merge')?true:false;

        if($this->user->logged() && !$merge) {
            $result['status'] = 1;
            setcookie('sl', 1, 0 , '/');
            echo '<script type="text/javascript">window.close();</script>';
            return;
        }

		if($this->input->get('oauth_token') && $this->session->userdata('request_token') !== $this->input->get('oauth_token'))
		{
			$this->reset_session();
			redirect(base_url('/twitter/auth/'.$reason));
		}
		else
		{
			$twitter_access_token = $this->connection->getAccessToken($this->input->get('oauth_verifier'));
		
			if ($this->connection->http_code == 200)
			{
				$this->session->set_userdata('twitter_access_token', $twitter_access_token['oauth_token']);
				$this->session->set_userdata('twitter_access_token_secret', $twitter_access_token['oauth_token_secret']);
				$this->session->set_userdata('twitter_user_id', $twitter_access_token['user_id']);
				$this->session->set_userdata('twitter_screen_name', $twitter_access_token['screen_name']);

				$this->session->unset_userdata('request_token');
				$this->session->unset_userdata('request_token_secret');
				//echo '200 + OK';

                $this->load->model('m_users');


                $user = array();
                //if user_id was set in previous step
                if($twitter_access_token['user_id']) {
                    //Check user exists in DB
                    $user = $this->m_users->getBySocialID('twitter', $twitter_access_token['user_id']);
                }

                if(!$merge) {
                    //if user exists login her
                    if($user) {

                        $id = $user['id'];
                        $this->session->set_userdata(array('user_id' => $user['id']));

                        $result['status'] = 1;
                    } else {
                        if($this->CI->config->item('full_account_creation_needed')) {

                            //TODO: accaunt creation routines

                            $result['status']	= 2;
                            $result['header']	= '';
                            $result['body']		= $this->mysmarty->view('auth/signup/social/index.tpl', array('hItem' => &$user), false, true);

                        } elseif(!$this->CI->config->item('account_email_needed')) {
                            $user = array(
                                'first_name' => $twitter_access_token['screen_name'],
                                'twitter_id' => $twitter_access_token['user_id']
                            );
                            $id = $this->m_users->create($user);

                            if($id) {
                                $data = $this->m_users->get($id);

                                $photo = 'https://api.twitter.com/1/users/profile_image?screen_name='.$twitter_access_token['screen_name'].'&size=bigger';
                                //https://api.twitter.com/1/users/profile_image?screen_name=randix0&size=bigger

                                if($photo) {
                                          $this->load->library('avatars');
                                          $this->avatars->upload($id, $photo);
                              }

                                setcookie('sl', 1, 0 , '/');
                                $this->session->set_userdata(array('user_id' => $id, 'twitter_auth_status'=>'created'));
                            }
                        } else {
                            $this->session->set_userdata(array('twitter_auth_status' => 'needed_email'));
                        }
                    }
                } else {
                    if($user) {
                        return $this->mysmarty->view('auth/signup/social/already_exists.tpl', array('hItem' => &$user), false);
                    } else {
                        $data = array(
                            'twitter_id' => $twitter_access_token['user_id'],
                            'twitter_oa_access_token' => $twitter_access_token['oauth_token']
                        );
                        $this->m_users->update($this->user->uid(), $data);
                        $result['status'] = 1;
                    }
                }

                if(!$merge && $result['status'] === 1) {
                    $this->m_users->update($id, array(
                        'twitter_oa_access_token' => $twitter_access_token['oauth_token'],
                        'twitter_oa_valid_till' => time()+120
                    ));

                    if (!isset($user['email']) || !$user['email'])
                        $this->session->set_userdata(array('email_needed' => 1));

                    setcookie('sl', 1, 0 , '/');

                    //$this->_onLogin($id);

                    $this->load->helper('cookie');
                    $sec_valid = 2592000; //30 days //'31536000', //1 year

                    $this->load->helper('string');
                    $al_key = sha1(random_string('alnum', 16)+microtime());

                    if(!$this->m_users->addAutoLoginKey((int) $id, $al_key, (time() + $sec_valid))) {

                        echo '<script type="text/javascript">window.close();</script>';
                        return;
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
                } elseif ($merge && $result['status'] == 1){
                    setcookie('sl', 1, 0 , '/');
                }
                setcookie('sl', 1, 0 , '/');

                echo '<script type="text/javascript">window.close();</script>';
                return;
			}
			else
			{
				// An error occured. Add your notification code here.
                $this->session->set_userdata(array('twitter_auth_status'=>'error'));
                $this->reset_session();
                echo '<script type="text/javascript">window.close();</script>';
                return;
			}
		}
	}
	
	public function post($in_reply_to)
	{
		$message = $this->input->post('message');
		if(!$message || mb_strlen($message) > 140 || mb_strlen($message) < 1)
		{
			// Restrictions error. Notification here.
			redirect(base_url('/'));
		}
		else
		{
			if($this->session->userdata('twitter_access_token') && $this->session->userdata('twitter_access_token_secret'))
			{
				$content = $this->connection->get('account/verify_credentials');
				if(isset($content->error))
				{
					// Most probably, authentication problems. Begin authentication process again.
					$this->reset_session();
					redirect(base_url('/twitter/auth'));
				}
				else
				{
					$data = array(
						'status' => $message,
						'in_reply_to_status_id' => $in_reply_to
					);
					$result = $this->connection->post('statuses/update', $data);

					if(!isset($result->error))
					{
						// Everything is OK
						redirect(base_url('/'));
					}
					else
					{
						// Error, message hasn't been published
						redirect(base_url('/'));
					}
				}
			}
			else
			{
				// User is not authenticated.
				redirect(base_url('/twitter/auth'));
			}
		}
	}
	
	/**
	 * Reset session data
	 * @access	private
	 * @return	void
	 */
	public function reset_session()
	{
		$this->session->unset_userdata('twitter_access_token');
		$this->session->unset_userdata('twitter_access_token_secret');
		$this->session->unset_userdata('request_token');
		$this->session->unset_userdata('request_token_secret');
		$this->session->unset_userdata('twitter_user_id');
		$this->session->unset_userdata('twitter_screen_name');
	}
}

/* End of file twitter.php */
/* Location: ./application/controllers/twitter.php */