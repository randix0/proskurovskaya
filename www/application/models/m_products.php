<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_products extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getItem($getItem = array(), $fetch = false)
    {
        $where = $order = array();
        $limit = 1;
        $offset = 0;

        if ($getItem) {
            if (is_array($getItem)) {
                if (isset($getItem['where']) && $getItem['where']) $where = $getItem['where'];
                if (isset($getItem['order']) && $getItem['order']) $order = $getItem['order'];
                //if (isset($getItem['limit']) && $getItem['limit']) $limit = $getItem['limit'];
                if (isset($getItem['offset']) && $getItem['offset']) $offset = $getItem['offset'];
            } elseif (is_int($getItem)){
                $where = array('id'=>(int)$getItem);
            } else {
                $where = array('uri'=>$getItem);
            }
        }

        $this->db->where($where);
        if ($order){
            foreach($order as $o_key=>$o_val)
                $this->db->order_by($o_key, $o_val);
        }

        if ($offset)
            $query = $this->db->get('products', $limit, $offset);
        else
            $query = $this->db->get('products', $limit);
        $product = $query->row_array();

        if (!$product) return false;

        if ($fetch) {
            $product['photos'] = $this->db->where(array('product_id'=>$product['id']))->get('products_photos')->result_array();
            $details_links = $this->db->where(array('product_id'=>$product['id']))->get('products_details')->result_array();
            $details_ids = $details = array();
            foreach($details_links as $dl)
            {
                $details_ids[] = (int)$dl['detail_id'];
            }
            if ($details_ids)
                $details = $this->db->where_in('id',$details_ids)->get('details')->result_array();

            $product['details_ids'] = $details_ids;
            $product['details'] = $details;
        }

        return $product;
    }

    public function getItems($getItems = array(), $table = 'products')
    {
        $where = $order = array();
        $limit = 100;
        $offset = 0;

        if ($getItems) {
            if (isset($getItems['where']) && $getItems['where']) $where = $getItems['where'];
            if (isset($getItems['order']) && $getItems['order']) $order = $getItems['order'];
            if (isset($getItems['limit']) && $getItems['limit']) $limit = $getItems['limit'];
            if (isset($getItems['offset']) && $getItems['offset']) $offset = $getItems['offset'];
        }

        if (!$where || (!isset($where['is_deleted']) && !isset($where['is_deleted >'])))
            $where['is_deleted'] = 0;

        $this->db->where($where);
        if ($order){
            foreach($order as $o_key=>$o_val)
                $this->db->order_by($o_key, $o_val);
        }

        if ($offset)
            $query = $this->db->get($table, $limit, $offset);
        else
            $query = $this->db->get($table, $limit);
        $products = $query->result_array();

        return $products;
    }

    public function getCollections($getItems = array())
    {
        $where = $order = array();
        $limit = 100;
        $offset = 0;

        if ($getItems) {
            if (isset($getItems['where']) && $getItems['where']) $where = $getItems['where'];
            if (isset($getItems['order']) && $getItems['order']) $order = $getItems['order'];
            if (isset($getItems['limit']) && $getItems['limit']) $limit = $getItems['limit'];
            if (isset($getItems['offset']) && $getItems['offset']) $offset = $getItems['offset'];
        }

        $this->db->where($where);
        if ($order){
            foreach($order as $o_key=>$o_val)
                $this->db->order_by($o_key, $o_val);
        }

        if ($offset)
            $query = $this->db->get('collections', $limit, $offset);
        else
            $query = $this->db->get('collections', $limit);
        $collections = $query->result_array();

        return $collections;
    }

    public function getCategories($getItems = array())
    {
        $where = $order = array();
        $limit = 100;
        $offset = 0;

        if ($getItems) {
            if (isset($getItems['where']) && $getItems['where']) $where = $getItems['where'];
            if (isset($getItems['order']) && $getItems['order']) $order = $getItems['order'];
            if (isset($getItems['limit']) && $getItems['limit']) $limit = $getItems['limit'];
            if (isset($getItems['offset']) && $getItems['offset']) $offset = $getItems['offset'];
        }

        $this->db->where($where);
        if ($order){
            foreach($order as $o_key=>$o_val)
                $this->db->order_by($o_key, $o_val);
        }

        if ($offset)
            $query = $this->db->get('categories', $limit, $offset);
        else
            $query = $this->db->get('categories', $limit);
        $categories = $query->result_array();

        return $categories;
    }

    public function get($what = '', $id = 0)
    {
        if (!$id) return false;
        if (is_array($id)) {
            $this->db->where($id);
        } else {
            $this->db->where(array('id'=>(int)$id));
        }
        $query = $this->db->get($what, 1);
        $row = $query->row_array();
        return $row;
    }

    public function save($type = 'products', $id = 0, $data = array())
    {
        $id = (int)$id;
        if (!$data) return false;
        if ($id) {
            $this->db->update($type, $data, array('id'=>$id));
        } else {
            $this->db->insert($type, $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }
}