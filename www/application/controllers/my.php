<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My extends CI_Controller {

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
        $this->load->helper('url');
        if (!$this->user->logged()) return redirect(base_url('/'));
    }

    public function index()
    {
        $this->load->model('m_ideas');
        $user_id = $this->user->uid();
        $ps = array(
            '__PAGE' => 'my',
            'is_author' => 1,
            'ideas' => $this->m_ideas->getItems(array('user_id' => $user_id), array(), true)
        );
        $this->mysmarty->view('global/my/index.tpl', $ps);
    }
}