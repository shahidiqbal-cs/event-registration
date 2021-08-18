<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tbl = 'user';
    }

    public function get_user($where) {
        return $this->db->get_where($this->tbl, $where)->row();
    }

    function update_user($id, $data) {
        return $this->db->update($this->tbl, $data, array('user_id' => $id));
    }
}
