<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ideology_model extends CI_Model {


    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->ideology = 'ideology';
    }

    function get_ideologies() {
        return $this->db->get($this->ideology)->result();
    }

    function get_ideology($where) {
        return $this->db->get_where($this->ideology, $where)->row();
    }
    function insert_ideology($data) {
        return $this->db->insert($this->ideology, $data);
    }

    function update_ideology($data, $where) {
        return $this->db->update($this->ideology, $data, $where);
    }

    function delete_ideology($ideology_id) {
        return $this->db->delete($this->ideology, array('ideology_id' => $ideology_id));
    }
}
