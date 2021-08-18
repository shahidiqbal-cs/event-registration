<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Title_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tbl = 'event_title';
    }

    //****************************** Last inserted id ******************************//
    function last_id() {
        return $this->db->insert_id();
    }

    function get_titles() {
        return $this->db->get($this->tbl)->result();
    }

    function get_title($where) {
        return $this->db->get_where($this->tbl, $where)->row();
    }

    function add_title($data) {
        return $this->db->insert($this->tbl, $data);
    }

    function update_title($data, $where) {
        return $this->db->update($this->tbl, $data, $where);
    }

    function delete($id) {
        return $this->db->delete($this->tbl, array('title_id' => $id));
    }


}
