<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Participant_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->participant = 'participant';
    }

    //****************************** Last inserted id ******************************//
    function last_id() {
        return $this->db->insert_id();
    }

    function participant_join() {
        $this->db->join('ideology', 'ideology.ideology_id = participant.ideology_id','left');
        $this->db->join('propagation', 'propagation.propagation_id = participant.propagation_id','left');
        $this->db->join('majlis_amomi', 'majlis_amomi.majlis_amomi_id = participant.majlis_amomi_id','left');
        $this->db->join('halqa', 'halqa.halqa_id = participant.halqa_id');
        $this->db->join('city', 'city.city_id = halqa.city_id');
        $this->db->join('zone', 'zone.zone_id = city.zone_id');
    }

    function get_participants($where) {
        $this->participant_join();
        $query = $this->db->get_where('participant', $where);
        return $query->result();
    }

    function count_participants($where) {
        $this->db->where($where);
        $this->db->from($this->participant);
        return $this->db->count_all_results();
    }

    function get_participants_for_export_data($query, $columns = '*') {
        $this->db->select($columns);
        $this->participant_join();
        foreach ($query as $column => $values):
            $this->db->group_start();
            foreach ($values as $key => $value):
                if ($key == 0):
                    $this->db->where($column, $value);
                else:
                    $this->db->or_where($column, $value);
                endif;
            endforeach;
            $this->db->group_end();
        endforeach;
        return $this->db->get('participant')->result();
    }

    function get_a_participant($where) {
        $this->participant_join();
        $query = $this->db->get_where('participant', $where);
        return $query->row();
    }

    function register_participant($data) {
        return $this->db->insert($this->participant, $data);
    }

    function update_participant($data, $where) {
        return $this->db->update($this->participant, $data, $where);
    }

    function delete_participant($participant_id) {
        return $this->db->delete('participant', array('participant_id' => $participant_id));
    }

}
