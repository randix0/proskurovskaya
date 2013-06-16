<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


require_once dirname(__FILE__).'/Abstract.php';
//require_once dirname(__FILE__).'/twitteroauth/twitteroauth.php';


class Twitter extends OAuthAbstract {

    const URL_REQUEST_TOKEN	= 'https://api.twitter.com/oauth/request_token';
    const URL_AUTHORIZE		= 'https://api.twitter.com/oauth/authorize';
    const URL_ACCESS_TOKEN	= 'https://api.twitter.com/oauth/access_token';
    const URL_ACCOUNT_DATA	= 'https://api.twitter.com/1/users/show';// формат подставляется отдельно

    private $config = NULL;
    /**
     * Get segments file name
     *
     * @param integer $generation
     * @return string
     */
    public function __construct() {
        $this->config = $config	 = &get_config();

        $this->app_id		= $config['twitter_app_id'];
        $this->app_secret	= $config['twitter_app_secret'];

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
        $oauth_nonce = md5(uniqid(rand(), true));
        $oauth_timestamp = time();

        $oauth_base_text = "GET&";
        $oauth_base_text .= urlencode(self::URL_REQUEST_TOKEN)."&";
        $oauth_base_text .= urlencode("oauth_callback=".urlencode($this->config['base_url'].'auth/step1/twitter/'.$reason)."&");
        $oauth_base_text .= urlencode("oauth_consumer_key=".$this->app_id."&");
        $oauth_base_text .= urlencode("oauth_nonce=".$oauth_nonce."&");
        $oauth_base_text .= urlencode("oauth_signature_method=HMAC-SHA1&");
        $oauth_base_text .= urlencode("oauth_timestamp=".$oauth_timestamp."&");
        $oauth_base_text .= urlencode("oauth_version=1.0");


        $oauth_base_text = "GET&";
        $oauth_base_text .= urlencode(self::URL_ACCESS_TOKEN)."&";
        $oauth_base_text .= urlencode("oauth_consumer_key=".$this->_consumer_key."&");
        $oauth_base_text .= urlencode("oauth_nonce=".$this->_oauth['nonce']."&");
        $oauth_base_text .= urlencode("oauth_signature_method=HMAC-SHA1&");
        $oauth_base_text .= urlencode("oauth_token=".$this->_oauth['token']."&");
        $oauth_base_text .= urlencode("oauth_timestamp=".$this->_oauth['timestamp']."&");
        $oauth_base_text .= urlencode("oauth_verifier=".$this->_oauth['verifier']."&");
        $oauth_base_text .= urlencode("oauth_version=1.0");

        $key = $this->app_secret."&";

        // Формируем oauth_signature
        $signature = base64_encode(hash_hmac("sha1", $oauth_base_text, $key, true));


        // Формируем GET-запрос
        $token_url = self::URL_REQUEST_TOKEN;
        $token_url .= '?oauth_callback='.urlencode($this->config['base_url'].'auth/step1/twitter/'.$reason);
        $token_url .= '&oauth_consumer_key='.$this->app_id;
        $token_url .= '&oauth_nonce='.$oauth_nonce;
        $token_url .= '&oauth_signature='.urlencode($signature);
        $token_url .= '&oauth_signature_method=HMAC-SHA1';
        $token_url .= '&oauth_timestamp='.$oauth_timestamp;
        $token_url .= '&oauth_version=1.0';

        $response = NULL;

        if($contents = @file_get_contents($token_url)) {
            parse_str($contents, $response);
        } else {
            throw new Exception('Connection error', CONNECTION_ERROR);
        }

        if($response && isset($response['oauth_token']) && $response['oauth_token']) {
            $this->oa_access_token	= $response['oauth_token'];
            $this->oa_valid_till	= time() + @$response['expires_in'];
            $this->oa_user_id		= 0;

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

            if(!$this->oa_access_token) {
                throw new Exception('Token not valid', TOKEN_NOT_VALID);
            }

            if($this->oa_valid_till < time()) {
                throw new Exception('Token expired', TOKEN_EXPIRED);
            }

            $response = NULL;

            if($contents = @file_get_contents('https://graph.facebook.com/me?access_token='.$this->oa_access_token)) {

                $response = json_decode($contents, true);

                if(isset($response['id']) && $response['id']) {
                    $this->user_data_response = $response;
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
            $this->oa_user_id = $response['id'];

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
            $this->oa_user_id = $response['id'];

            return array(
                'first_name'		=> $response['first_name'],
                'last_name'			=> $response['last_name'],
                'url_friendly_name'	=> (isset($response['username'])?$response['username']:''),
                'email'				=> (isset($response['email']) && $response['email'] && isset($response['verified']) && $response['verified'])?$response['email']:'',
                'timezone'			=> $response['timezone'],
                'gender'			=> $response['gender']?(($response['gender']=='male')?2:1):0,
                'facebook_id'		=> $response['id']
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

        if($response) {
            return 'http://graph.facebook.com/'.$response['id'].'/picture?type=large';
        }

        return false;
    }
}
?>