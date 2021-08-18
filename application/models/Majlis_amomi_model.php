<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Majlis_amomi_model extends CI_Model {


    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tbl = 'majlis_amomi';
    }

    function get() {
        return $this->db->get($this->tbl)->result();
    }

    function get_row($where) {
        return $this->db->get_where($this->tbl, $where)->row();
    }
    function insert($data) {
        return $this->db->insert($this->tbl, $data);
    }

    function update($data, $where) {
        return $this->db->update($this->tbl, $data, $where);
    }

    function delete($id) {
        return $this->db->delete($this->tbl, array('majlis_amomi_id' => $id));
    }
}
