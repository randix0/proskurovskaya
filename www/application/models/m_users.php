<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_users extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function sign_in($login='', $password='')
    {
        $this->db->where('login', $login);
        $this->db->where('password', md5($login.$password.'u4ua'));
        $query = $this->db->get('users', 1);
        $user = $query->row_array();

        //$this->load->model('m_avatars');
        //$user=$this->m_avatars->get($user['avatars_id'],$user);

        $this->m_users->setOnline($user['id']);

        return $user;
    }

    public function setOnline($users_id = 0, $timeDiff = 300)
    {
        if ($users_id < 1) return false;
        $onlineTill = time()+$timeDiff;
        $this->db->where('id', $users_id);
        $this->db->update('users', array('online_till'=>$onlineTill));
    }

    public function get($users_id=0)
    {
        $this->db->where('id', $users_id);
        $query = $this->db->get('users', 1);
        $user=$query->row_array();
        //$this->load->model('m_avatars');
        //if ($user) $user=$this->m_avatars->get($user['avatars_id'],$user);

        return $user;
    }

    public function getByLogin($login=0)
    {
        $this->db->where('login', $login);
        $query = $this->db->get('users', 1);
        $user=$query->row_array();
        //$this->load->model('m_avatars');
        //if ($user) $user=$this->m_avatars->get($user['avatars_id'],$user);

        return $user;
    }

    public function create($user=array())
    {
        if (!$user) return false;
        //$user['password']=md5($user['password'].'u4ua');
        $user['add_date']=time();
        $this->db->insert('users', $user);
        return $this->db->insert_id();
    }

    public function getItems($limit=0,$offset=0,$order='id',$by='desc', $whereArr = array())
    {
        if ($whereArr)
        {
            foreach($whereArr as $key=>$value)
            {
                $this->db->where($key, $value);
            }
        }
        if ($order && $by)
            $this->db->order_by($order, $by);
        if ($limit > 0)
            $query = $this->db->get('users', $limit, $offset);
        else
            $query = $this->db->get('users');

        $users=$query->result_array();

        /*$this->load->model('m_avatars');

        foreach($users as &$user)
        {
            $user=$this->m_avatars->get($user['avatars_id'],$user);
        }
        */

        return $users;
    }

    public function update($id,$data)
    {
        if (!$data || !$id) return false;
        $this->db->update('users', $data, array('id'=>$id));
        foreach($data as $key=>$value){
            $this->session->set_userdata($key, $value);
        }
        return true;
    }

    public function getByAutoLoginKey($al_key)
    {
        $this->db->where('auto_login_key', $al_key);
        $query = $this->db->get('users', 1);
        $user=$query->row_array();
        //$this->load->model('m_avatars');
        //if ($user) $user=$this->m_avatars->get($user['avatars_id'],$user);

        return $user;
    }

    public function deleteAutoLoginKey($al_key)
    {
        $this->db->where('auto_login_key', $al_key);
        $this->db->update('users', array('auto_login_key'=>''));
    }

    public function getByEmail($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users', 1);
        $user=$query->row_array();
        return $user;
    }

    public function getBySocialID($getHandlerType, $oa_user_id = 0)
    {
        $this->db->where($getHandlerType.'_id', $oa_user_id);
        $query = $this->db->get('users', 1);
        $user=$query->row_array();
        return $user;
    }

    public function isEmailExists($email)
    {
        $result = false;
        $this->db->where('email', $email);
        $query = $this->db->get('users', 1);
        $user=$query->row_array();
        if ($user) $result = true;
        return $result;
    }

    public function edit(){}

    public function addAutoLoginKey($user_id, $al_key, $sec_valid)
    {
        //$this->db->where('auto_login_key', $al_key);
        //$this->db->update('users', array('auto_login_key'=>''));
    }
}
?>