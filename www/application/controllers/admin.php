<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    function __construct()
    {
        parent::__construct();
        $this->load->library('json');
        $this->load->helper('url');
        //$this->load->model('m_admin');

        if (!$this->user->logged() || $this->user->access_level < 50 || $this->user->is_deleted) {
            redirect('/');
        }
    }

    public function index()
    {
        //$this->load->view('welcome_message');
        $ps = array(
            '__PAGE' => 'main',
            'ADMIN' => true,
            //'stat' => $this->m_admin->getStatistic()
        );
        $this->mysmarty->view('admin/main/index.tpl', $ps);
    }

    public function categories()
    {
        $this->load->model('m_products');
        $categories = $this->m_products->getCategories();
        $ps = array(
            'ADMIN' => true,
            'categories' => $categories
        );
        $this->mysmarty->view('admin/categories/items/index.tpl', $ps);
    }

    public function addCategory()
    {
        $ps = array(
            'ADMIN' => true,
        );
        $this->mysmarty->view('admin/categories/add/index.tpl', $ps);
    }

    public function collections()
    {
        $this->load->model('m_products');
        $collections = $this->m_products->getCollections();
        $ps = array(
            'ADMIN' => true,
            'collections' => $collections
        );
        $this->mysmarty->view('admin/collections/items/index.tpl', $ps);
    }

    public function products()
    {
        $this->load->model('m_products');
        $products = $this->m_products->getItems();
        $ps = array(
            'ADMIN' => true,
            'products' => $products
        );
        $this->mysmarty->view('admin/products/items/index.tpl', $ps);
    }

    public function addProduct($id = 0)
    {
        $id = (int)$id;
        $product = array(
            'id' => 0,
            'uri' => '',
            'iname' => '',
            'idesc' => '',
            'price' => 0,
            'collection_id' => 0,
            'category_id' => 0
        );
        $this->load->model('m_products');
        $categories = $this->m_products->getItems(false,'categories');
        $collections = $this->m_products->getItems(false,'collections');
        $details = $this->m_products->getItems(false, 'details');
        if ($id)
            $product = $this->m_products->getItem($id, true);

        $ps = array(
            'ADMIN' => true,
            'categories' => $categories,
            'collections' => $collections,
            'details' => $details,
            'product' => $product
        );
        $this->mysmarty->view('admin/products/add/index.tpl', $ps);
    }

    public function details()
    {
        $this->load->model('m_products');
        $details = $this->m_products->getItems(false, 'details');
        $ps = array(
            'ADMIN' => true,
            'details' => $details
        );
        $this->mysmarty->view('admin/details/items/index.tpl', $ps);
    }

    public function addDetail()
    {
        $this->load->model('m_products');
        $ps = array(
            'ADMIN' => true,
        );
        $this->mysmarty->view('admin/details/add/index.tpl', $ps);
    }

    public function photos($id = 0)
    {
        $this->load->model('m_photos');

        $gen_raw_id = false;

        $where = array();
        $order = array('id'=>'desc');
        $order_by = 'date';

        $getItems = array(
            'where' => $where,
            'order' => $order,
            'limit' => 20
        );

        $ps = array(
            '__PAGE' => 'photos',
            'ADMIN' => true,
            '__SUBPAGE' => 'active',
            'filter_type' => 'active',
            'order_by' => $order_by
        );

        if ($id && preg_match('/(all|active|deleted|stage|final)(\d+){0,}/',$id, $matches)) {
            $filter_type = $matches[1];
            $stage_number = 0;
            $ps['__SUBPAGE'] = $matches[0];
            $ps['filter_type'] = $filter_type;
            if ($filter_type == 'stage' && isset($matches[2]) && $matches[2]) {
                $stage_number = $matches[2];
                $getItems['where']['top_ten_stage'] = $stage_number;
                $getItems['where']['is_stage_winner'] = 1;

            } elseif ($filter_type == 'all'){
                $getItems['where']['is_deleted >'] = -1;
            } elseif ($filter_type == 'active'){
                $getItems['where']['is_deleted'] = 0;
            } elseif ($filter_type == 'deleted'){
                $getItems['where']['is_deleted'] = 1;
            }
            $id = 0;
        }

        $s = $this->input->get('item');
        if ($s && is_array($s)) {
            if (isset($s['user_first_name']) && $s['user_first_name']) $getItems['where']['user_first_name'] = $s['user_first_name'];
            if (isset($s['user_last_name']) && $s['user_last_name']) $getItems['where']['user_last_name'] = $s['user_last_name'];
            if (isset($s['iname']) && $s['iname']) $getItems['where']['iname'] = $s['iname'];
            if (isset($s['ip']) && $s['ip']) $getItems['where']['ip'] = $s['ip'];
            if (isset($s['id']) && $s['id']) $getItems['where']['id'] = $s['id'];
            if (isset($s['user_id']) && $s['user_id']) $getItems['where']['user_id'] = $s['user_id'];
            if (isset($s['is_deleted'])) $getItems['where']['is_deleted'] = $s['is_deleted'];
            $ps['__SUBPAGE'] = 'search';
        }
        $ps['s'] = $s;


        if ($id){
            $photo = $this->m_photos->getItem($id, 'admin');

            $ps['photo'] = $photo;
            $this->mysmarty->view('admin/photos/item/index.tpl', $ps);
        } else {
            $ps['getItems_code'] = urlencode(base64_encode(json_encode($getItems)));
            $ps['photos'] = $this->m_photos->getItems($getItems, 'admin', $gen_raw_id);
            $this->mysmarty->view('admin/photos/items/index.tpl', $ps);
        }
    }

    public function users($id = 0)
    {
        //$this->load->view('welcome_message');
        $this->load->model('m_users');

        $where = array();
        $order = array('id'=>'desc');
        $order_by = 'date';

        $getItems = array(
            'where' => $where,
            'order' => $order,
            'limit' => 20
        );

        $ps = array(
            '__PAGE' => 'users',
            'ADMIN' => true,
            '__SUBPAGE' => 'active',
            'filter_type' => 'active',
            'order_by' => $order_by
        );

        if ($id && preg_match('/(all|admin|active|deleted|competitors|non_competitors)/',$id, $matches)) {
            $filter_type = $matches[1];
            $stage_number = 0;
            $ps['__SUBPAGE'] = $matches[0];
            $ps['filter_type'] = $filter_type;
            if ($filter_type == 'all'){
                $getItems['where']['is_deleted >'] = -1;
            } elseif ($filter_type == 'active'){
                $getItems['where']['is_deleted'] = 0;
            } elseif ($filter_type == 'deleted'){
                $getItems['where']['is_deleted'] = 1;
            } elseif ($filter_type == 'admin') {
                $getItems['where']['access_level >'] = 50;
            } elseif ($filter_type == 'competitors') {
                $getItems['where']['photos_count >'] = 0;
            } elseif ($filter_type == 'non_competitors') {
                $getItems['where']['photos_count'] = 0;
            }
            $id = 0;
        }

        $s = $this->input->get('item');
        if ($s && is_array($s)) {
            if (isset($s['first_name']) && $s['first_name']) $getItems['where']['first_name'] = $s['first_name'];
            if (isset($s['last_name']) && $s['last_name']) $getItems['where']['last_name'] = $s['last_name'];
            if (isset($s['email']) && $s['email']) $getItems['where']['email'] = $s['email'];
            if (isset($s['ip']) && $s['ip']) $getItems['where']['ip'] = $s['ip'];
            if (isset($s['id']) && $s['id']) $getItems['where']['id'] = $s['id'];

            if (isset($s['facebook_id']) && $s['facebook_id']) $getItems['where']['facebook_id'] = $s['facebook_id'];
            if (isset($s['vkontakte_id']) && $s['vkontakte_id']) $getItems['where']['vkontakte_id'] = $s['vkontakte_id'];
            if (isset($s['odnoklassniki_id']) && $s['odnoklassniki_id']) $getItems['where']['odnoklassniki_id'] = $s['odnoklassniki_id'];

            if (isset($s['is_deleted'])) $getItems['where']['is_deleted'] = $s['is_deleted'];
            $ps['__SUBPAGE'] = 'search';
        }
        $ps['s'] = $s;

        if ($id) {
            $ps['user'] = $this->m_users->get($id);
            $this->mysmarty->view('admin/users/item/index.tpl', $ps);
        } else {
            $ps['users'] = $this->m_users->getItems($getItems);
            $ps['getItems_code'] = urlencode(base64_encode(json_encode($getItems)));
            $this->mysmarty->view('admin/users/items/index.tpl', $ps);
        }
    }

    public function settings()
    {
        $this->load->model('m_settings');
        $ps = array(
            'settings' => $this->m_settings->getItems(),
            'stored' => $this->settings->getAllData(),
            '__PAGE' => 'settings',
            'ADMIN' => true
        );
        $this->mysmarty->view('admin/settings/index.tpl', $ps);
    }

    public function ip($ip = '')
    {
        $data = array();
        error_reporting(E_ALL ^ E_NOTICE);
        if (!$ip) $ip = $this->input->ip_address();

        if (function_exists('geoip_record_by_name')) {
            $data = geoip_record_by_name($ip);
        }
        $ps = array(
            'data' => $data,
            'ip' => $ip,
            'ADMIN' => true
        );

        $this->mysmarty->view('admin/ip/index.tpl', $ps);
    }
}