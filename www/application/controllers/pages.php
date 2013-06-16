<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

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
    public function about()
    {
        $ps = array(
            '__PAGE' => 'about'
        );
        $this->mysmarty->view('global/about/index.tpl', $ps);
    }

    public function campaign()
    {
        $ps = array(
            '__PAGE' => 'compaign'
        );
        $this->mysmarty->view('global/campaign/index.tpl', $ps);
    }

    public function lookbook()
    {
        $ps = array(
            '__PAGE' => 'lookbook'
        );
        $this->mysmarty->view('global/lookbook/index.tpl', $ps);
    }

    public function news()
    {
        $ps = array(
            '__PAGE' => 'news'
        );
        $this->mysmarty->view('global/news/index.tpl', $ps);
    }

    public function private_order()
    {
        $ps = array(
            '__PAGE' => 'private_order'
        );
        $this->mysmarty->view('global/private_order/index.tpl', $ps);
    }

    public function contacts()
    {
        $ps = array(
            '__PAGE' => 'contacts'
        );
        $this->mysmarty->view('global/contacts/index.tpl', $ps);
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */