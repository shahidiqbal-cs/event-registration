<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tfw_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->options = 'options';
        $this->participant = 'participant';
        $this->ideology = 'ideology';
    }

    function last_id() {
        return $this->db->insert_id();
    }

    //options
    function get_option($option_name) {
        return $this->db->get_where($this->options, array('option_name' => $option_name))->row();
    }

    function get_numbers(){
        return $this->db->get('numbers')->result();
    }
}
