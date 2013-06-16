<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

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

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_products');
        $categories = $this->m_products->getCategories();
        $collections = $this->m_products->getCollections();
        $this->mysmarty->assign('categories', $categories);
        $this->mysmarty->assign('collections', $collections);
    }
    
    public function index($uri)
    {
        $this->load->helper('url');
        if (!$uri) redirect('/');

        $product = $this->m_products->getItem($uri, true);

        if (!$product) redirect('/');

        $collection = $this->m_products->get('collections', (int)$product['collection_id']);
        $category = $this->m_products->get('categories', (int)$product['category_id']);

        $ps = array(
            '__PAGE' => 'idea',
            'product' => $product,
            'current_collection' => $collection,
            'current_category' => $category
        );
        $this->mysmarty->view('global/products/item/index.tpl', $ps);
    }

    public function collections($collection_uri = '')
    {
        $this->load->model('m_products');
        $products = array();
        if ($collection_uri) {
            $collection_uri = trim($collection_uri);
            $collection = $this->m_products->get('collections', array('uri'=>$collection_uri));
            $products = $this->m_products->getItems(array(
                'where' => array(
                    'collection_id' => $collection['id']
                )
            ));
        }

        $ps = array(
            'products' => $products,
            'current_collection' => $collection
        );
        $this->mysmarty->view('global/products/categories/index.tpl', $ps);
    }

    public function categories($category_uri = '')
    {
        $this->load->model('m_products');
        $products = array();
        if ($category_uri) {
            $category_uri = trim($category_uri);
            $category = $this->m_products->get('categories', array('uri'=>$category_uri));
            $products = $this->m_products->getItems(array(
                'where' => array(
                    'category_id' => $category['id']
                )
            ));
        }

        $ps = array(
            'products' => $products,
            'current_category' => $category
        );
        $this->mysmarty->view('global/products/categories/index.tpl', $ps);
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */