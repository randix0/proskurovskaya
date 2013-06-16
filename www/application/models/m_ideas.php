<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_products extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create($data)
    {
        if (!$data) return false;
        $this->db->insert('ideas', $data);
        $idea_id = $this->db->insert_id();
        return $idea_id;
    }

    public function create_attachment($data)
{
    if (!$data) return false;
    $this->db->insert('ideas_attachments', $data);
    $idea_attach_id = $this->db->insert_id();
    return $idea_attach_id;
}
    public function create_team($data)
    {
        if (!$data) return false;
        $this->db->insert('ideas_team', $data);
        $idea_team_id = $this->db->insert_id();
        return $idea_team_id;
    }

    public function create_comment($data, $idea_update = array())
    {
        if (!$data || !isset($data['idea_id']) || !$data['idea_id']) return false;

        if (!$idea_update){
            $idea = $this->getItem($data['idea_id']);
            $comments_count = (int)$idea['comments_count'];
            $idea_update = array('comments_count'=>$comments_count);
        }

        $this->db->insert('ideas_comments', $data);
        $idea_comment_id = $this->db->insert_id();
        if ($idea_comment_id)
            $this->update($data['idea_id'],$idea_update);
        return $idea_comment_id;
    }

    public function update($id, $data)
    {
        if (!$data || !$id) return false;
        $id = (int)$id;
        $this->db->update('ideas', $data, array('id'=>$id));
        return true;
    }

    public function getItem($id = 0, $fetch = false)
    {
        if (!$id) return array();

        if (is_array($id)) {
            $this->db->where($id);
        } else {
            $id = (int)$id;
            $this->db->where('id', $id);
        }


        $query = $this->db->get('ideas', 1);

        $idea = $query->row_array();

        if (!$idea) return false;

        $user_id = $this->user->uid();

        $idea_id = (int)$idea['id'];

        if ($fetch) {
            $this->db->where('id', $idea['user_id']);
            $query = $this->db->get('users', 1);
            $idea_author=$query->row_array();

            $this->db->where('idea_id', $idea_id);
            $query = $this->db->get('ideas_comments', 20);
            $idea_comments=$query->result_array();

            $this->db->where('idea_id', $idea_id);
            $query = $this->db->get('ideas_team', 20);
            $idea_team=$query->result_array();

            $this->db->where('idea_id', $idea_id);
            $query = $this->db->get('ideas_attachments', 20);
            $idea_attachments=$query->result_array();

            $leader = array(
                'id' =>-1,
                'idea_id' => $idea_id,
                'user_id' => $idea['user_id'],
                'first_name' => $idea['contact_first_name'],
                'last_name' => $idea['contact_last_name'],
                'role' => $idea['contact_role'],
                'avatar_s' => $idea_author['avatar_b'],
                'avatar_m' => $idea_author['avatar_b'],
                'avatar_b' => $idea_author['avatar_b'],
                'is_deleted' => -1
            );

            $idea_team = array_merge(array($leader),$idea_team);

            $idea['author'] = $idea_author;
            $idea['comments'] = $idea_comments;
            $idea['team'] = $idea_team;
            $idea['attachments'] = $idea_attachments;

            /*
            $qr_name = $this->m_ideas->generateQR($idea_id);
            $this->m_ideas->update($idea_id,array('qr_code'=>$qr_name));
            */

        }


        $idea['rating_stars'] = $idea['rating_judges'];

        if ($user_id && $user_id != $idea['user_id']){
            $this->db->where(array( 'idea_id' => $idea_id, 'user_id' => $user_id));
            $query = $this->db->get('ideas_votes', 1);
            $isVoted = $query->row_array();
        } else {
            $isVoted = 1;
        }
        $idea['isVoted'] = $isVoted;


        $idea['is_can_edit'] = 0;
        $idea['is_author'] = 0;
        if ($this->user->logged()) {
            if ($this->user->uid() == $idea['user_id'])
                $idea['is_author'] = 1;
            if (($idea['is_author'] || $this->user->access_level > 50))
                $idea['is_can_edit'] = 1;
        }

        return $idea;
    }

    public function getItems($where = array(), $order = array() ,$fetch = false)
    {
        if (!$where || !isset($where['is_deleted']) || !$where['is_deleted'])
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

        $query = $this->db->get('ideas', 16);
        $ideas=$query->result_array();

        if ($ideas && $fetch) {
            foreach($ideas as &$idea)
            {
                $idea['rating_stars'] = $idea['rating_judges'];
            }
        }

        return $ideas;
    }

    public function generateQR($idea_id = 0)
    {
        $this->load->helper('url');
        $this->load->library('ciqrcode');

        $upload_path = 'upload/qr/';
        $upload_dir = FCPATH.$upload_path;

        $qr_name = $upload_path.'u4ua_idea_'.$idea_id.'.png';

        $params['data'] = base_url('item/'.$idea_id);
        $params['level'] = 'H';
        $params['size'] = 5;
        $params['savename'] = FCPATH.$qr_name;
        $this->ciqrcode->generate($params);

        return $qr_name;
    }

    public function isVoted($idea_id = 0, $user_id = 0)
    {
        if (!$idea_id) return true;
        if (!$user_id) return false;
        $result = true;

        $where = array( 'idea_id' => $idea_id, 'user_id' => $user_id);
        $this->db->where($where);
        $query = $this->db->get('ideas_votes', 1);
        $vote=$query->row_array();
        if (!$vote) $result = false;
        return $result;
    }

    public function vote($idea_id = 0, $handler_type = '', $user_id = 0, &$idea, $is_judge = 0, $is_deleted = 0)
    {
        if (!$this->user->logged() || !$handler_type || !$idea_id || !$user_id || $this->isVoted($idea_id,$user_id) || !$idea) return false;


        $vote = array(
            'user_id' => $user_id,
            'idea_id' => $idea_id,
            'handler_type' => $handler_type,
            'is_deleted' => $is_deleted,
            'add_date' => time()
        );

        if ($is_judge)
            $vote['is_judge'] = 1;

        $this->db->insert('ideas_votes', $vote);
        $vote_id = $this->db->insert_id();

        $idea_update = array();
        if ($is_judge) {
            $idea['rating_judges']++;
            $idea_update['rating_judges'] = $idea['rating_judges'];
        } else {
            $tinyHandler = '';
            if ($handler_type == 'facebook' || $handler_type == 'fb') $tinyHandler = 'fb';
            elseif ($handler_type == 'vkontakte' || $handler_type == 'vk') $tinyHandler = 'fb';
            elseif ($handler_type == 'google' || $handler_type == 'gp') $tinyHandler = 'gp';
            elseif ($handler_type == 'twitter' || $handler_type == 'tw') $tinyHandler = 'tw';
            if ($tinyHandler) {
                $idea['rating_'.$tinyHandler]++;
                $idea_update['rating_'.$tinyHandler] = $idea['rating_'.$tinyHandler];
            }
            $idea['rating']++;
            $idea_update['rating'] = $idea['rating'];
        }

        if ($idea_update)
            $this->update($idea_id, $idea_update);


        return $vote_id;

    }
}