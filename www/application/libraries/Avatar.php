<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Avatar{
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

    public function upload($user_id = 0, $photo = '')
    {
        if (!$user_id || !$photo) return false;
        $this->CI->load->helper('file');
        $avatar = array();
        $avatar_temp = 'upload/temp/'.sha1(time());

        $photo_buffer = @file_get_contents($photo);
        if (!$photo_buffer) return false;

        if (!file_put_contents(FCPATH.$avatar_temp,$photo_buffer)) return false;

        if (class_exists('finfo')) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $avatar['mime_type'] = $finfo->buffer($photo_buffer);
            if ($avatar['mime_type'] == 'image/png') $avatar['ext'] = 'png';
            elseif ($avatar['mime_type'] == 'image/jpeg') $avatar['ext'] = 'jpg';
            elseif ($avatar['mime_type'] == 'image/gif') $avatar['ext'] = 'gif';
            else {
                unlink(FCPATH.$avatar_temp);
                return false;
            }
        } else {
            $file_parts = explode('.',$photo);
            $ext = end($file_parts);
            if ($ext != 'png' && $ext != 'jpg' && $ext != 'gif' && $ext != 'jpeg') {
                unlink(FCPATH.$avatar_temp);
                return false;
            }

            if ($ext == 'jpeg') $ext = 'jpg';
            $avatar['ext'] = $ext;
        }

        $store_name = sha1($photo.time()).'.'.$avatar['ext'];

        $avatar['s'] = 'upload/avatars/s_'.$store_name;
        $avatar['m'] = 'upload/avatars/m_'.$store_name;
        $avatar['b'] = 'upload/avatars/'.$store_name;

        if (class_exists('Imagick')) {
            $image = new Imagick(FCPATH.$avatar['b']);

            $image->cropThumbnailImage(107, 107);
            $image->writeImage(FCPATH.$avatar['b']);
            $image->cropThumbnailImage(48, 48);
            $image->writeImage(FCPATH.$avatar['m']);
            $image->cropThumbnailImage(24, 24);
            $image->writeImage(FCPATH.$avatar['s']);

            unset($image);
        } else {
            copy(FCPATH.$avatar_temp,FCPATH.$avatar['b']);
            copy(FCPATH.$avatar_temp,FCPATH.$avatar['m']);
            copy(FCPATH.$avatar_temp,FCPATH.$avatar['s']);
        }

        $data = array(
            'avatar_s' => $avatar['s'],
            'avatar_m' => $avatar['m'],
            'avatar_b' => $avatar['b']
        );

        $this->CI->m_users->update($user_id, $data);
    }

}