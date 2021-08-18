<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Options_model extends CI_Model {

    protected $options;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->options = 'options';
    }

    //****************************** Last inserted id ******************************//
    function last_id() {
        return $this->db->insert_id();
    }

    function insert_option($data) {
        return $this->db->insert($this->options, $data);
    }

    function get_option($option_name) {
        $query = $this->db->get_where($this->options, array('option_name' => $option_name));
        return $query->row();
    }

    function update_option($id, $data) {
        return $this->db->update($this->options, $data, array('option_name' => $id));
    }

    function delete_option($id) {
        return $this->db->delete($this->options, array('option_id' => $id));
    }

}
