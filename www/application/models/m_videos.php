<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_videos extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create($data)
    {
        if (!$data) return false;
        $this->db->insert('videos', $data);
        $video_id = $this->db->insert_id();
        return $video_id;
    }

    public function update($id, $data)
    {
        if (!$data || !$id) return false;
        $id = (int)$id;
        $this->db->update('videos', $data, array('id'=>$id));
        return true;
    }

    public function getItem($id = 0)
    {
        $id = (int)$id;
        if (!$id) return array();
        $this->db->where('id', $id);
        $query = $this->db->get('videos', 1);
        $video = $query->row_array();
        if (!$video) return false;
        return $video;
    }

    public function getItems($where = array(), $order = array())
    {
        $where['is_deleted'] = 0;
        if (!$order)
            $order['id'] = 'desc';


        $this->db->where($where);
        if ($order){
            foreach($order as $o_key=>$o_val)
            {
                $this->db->order_by($o_key, $o_val);
            }
        }

        $query = $this->db->get('videos', 16);
        $videos=$query->result_array();


        return $videos;
    }
}