<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->event = 'event';
        $this->registration = 'registration';
    }

    //****************************** Last inserted id ******************************//
    function last_id() {
        return $this->db->insert_id();
    }

    function get_events() {
        return $this->db->order_by('event_date', 'DESC')->get($this->event)->result();
    }

    function get_a_event($where) {
        return $this->db->get_where($this->event, $where)->row();
    }

    function register_event($data) {
        return $this->db->insert($this->event, $data);
    }

    function update_event($data, $where) {
        return $this->db->update($this->event, $data, $where);
    }

    function delete_event($id) {
        $this->db->delete($this->event, array('event_id' => $id));
        return $this->delete_registration(array('event_id' => $id));
    }

    private function delete_registration($where) {
        return $this->db->delete($this->registration, $where);
    }

}
