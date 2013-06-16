<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modal extends CI_Controller {

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
    }

    public function login($reason = '')
    {
        $ps = array(
            'reason' => $reason
        );
        $this->mysmarty->view('modals/login/index.tpl', $ps, false);
    }

    public function voteIdea($idea_id = 0)
    {
        if (!$idea_id) return show_404();
        $ps = array(
            'idea_id' => $idea_id
        );
        $this->mysmarty->view('modals/voteIdea/index.tpl', $ps, false);
    }

    public function alertSuccess($code = 0)
    {
        $this->mysmarty->view('modals/alert/indexSuccess.tpl', array('code'=>$code), false);
    }

    public function alertError($code = 0)
    {
        $this->mysmarty->view('modals/alert/indexError.tpl', array('code'=>$code), false);
    }

    public function upload($upload_type = '', $id = 0, $multiple = 1)
    {
        if ($multiple > 0) $multiple = true;
        else $multiple = false;
        $ps = array(
            'upload_type' => $upload_type,
            'id' => $id,
            'multiple'=>$multiple
        );
        $this->mysmarty->view('modals/upload/index.tpl', $ps, false);
    }

}