<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Propagation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->propagation = 'propagation';
    }

    function last_id() {
        return $this->db->insert_id();
    }

    function get_propagations() {
        return $this->db->get($this->propagation)->result();
    }

    function get_propagation($where) {
        return $this->db->get_where($this->propagation, $where)->row();
    }

    function insert_propagation($data) {
        return $this->db->insert($this->propagation, $data);
    }

    function update_propagation($data, $where) {
        return $this->db->update($this->propagation, $data, $where);
    }

    function delete_propagation($propagation_id) {
        return $this->db->delete($this->propagation, array('propagation_id' => $propagation_id));
    }
}
