<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Idea extends CI_Controller {

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
    public function index($idea_id)
    {
        $this->load->helper('url');
        if (!$idea_id) redirect('/');
        $idea_id = (int)$idea_id;
        $this->load->model('m_ideas');
        $idea = $this->m_ideas->getItem($idea_id, true);

        if (!$idea) redirect('/');

        if ($idea) {
            if (!$idea['qr_code']) {
                $idea['qr_code'] = $qr_name = $this->m_ideas->generateQR($idea_id);
                $this->m_ideas->update($idea_id,array('qr_code'=>$qr_name));
            }
            if ($idea['qr_code']) $idea['qr_code'] = base_url($idea['qr_code']);
        }

        $ps = array(
            '__PAGE' => 'idea',
            'idea' => $idea
        );
        $this->mysmarty->view('global/idea/item/index.tpl', $ps);
    }

    public function ajaxItem($idea_id)
    {
        $this->load->helper('url');
        if (!$idea_id) redirect('/');
        $idea_id = (int)$idea_id;
        $this->load->model('m_ideas');
        $idea = $this->m_ideas->getItem($idea_id, true);
        if (!$idea) redirect('/');

        $ps = array(
            '__PAGE' => 'idea',
            'idea' => $idea,
            'prevIdea' => $this->m_ideas->getItem(array('id <'=>$idea_id), true),
            'nextIdea' => $this->m_ideas->getItem(array('id >'=>$idea_id), true)
        );
        $this->mysmarty->view('global/idea/ajaxItem/index.tpl', $ps, false);
    }

    public function add()
    {
        $this->load->helper('url');
        if (!$this->user->logged()) return redirect(base_url('/'));

        $idea = array(
            'id' => 0,
            'youtube_code' => '',
            'iname' => '',
            'idesc' => '',
            'contact_first_name' => '',
            'contact_last_name' => '',
            'contact_email' => '',
            'contact_phone' => '',
            'contact_role' => ''
        );
        $ps = array(
            '__PAGE' => 'idea',
            'idea' => $idea
        );
        $this->mysmarty->view('global/idea/add/index.tpl', $ps);
    }

    public function edit($idea_id = 0)
    {
        if (!$idea_id) return redirect(base_url('/'));
        if (!$this->user->logged()) return redirect(base_url('/idea/'.$idea_id));
        $idea_id = (int)$idea_id;
        $this->load->model('m_ideas');
        $idea = $this->m_ideas->getItem($idea_id, true);

        $ps = array(
            '__PAGE' => 'idea',
            'idea' => $idea
        );
        $this->mysmarty->view('global/idea/add/index.tpl', $ps);
    }

    public function qr($idea_id = 0)
    {
        $this->load->helper('url');
        /*
        $this->load->library('ciqrcode');

        $params['data'] = base_url('item/'.$idea_id);
        $params['level'] = 'H';
        $params['size'] = 5;
        $params['savename'] = FCPATH.'resources/img/qr/u4ua_idea_'.$idea_id.'.png';
        $this->ciqrcode->generate($params);
        */

        $this->load->model('m_ideas');
        echo $this->m_ideas->generateQR($idea_id);

        //$params['savename']
        //echo $params['data'].'<img src="/resources/img/qr/u4ua_idea_'.$idea_id.'.png" />';
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */