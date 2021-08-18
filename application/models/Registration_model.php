<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->zone = 'zone';
        $this->city = 'city';
        $this->halqa = 'halqa';
        $this->event = 'event';
        $this->ideology = 'ideology';
        $this->propagation = 'propagation';
        $this->participant = 'participant';
        $this->registration = 'registration';
    }

    //****************************** Last inserted id ******************************//
    function last_id() {
        return $this->db->insert_id();
    }

    private function participant_join() {
        $this->db->join($this->ideology, 'ideology.ideology_id = participant.ideology_id','left');
        $this->db->join($this->propagation, 'propagation.propagation_id = participant.propagation_id','left');
        $this->db->join('majlis_amomi', 'majlis_amomi.majlis_amomi_id = participant.majlis_amomi_id', 'left');
        $this->db->join($this->halqa, 'halqa.halqa_id = participant.halqa_id');
        $this->db->join($this->city, 'city.city_id = halqa.city_id');
        $this->db->join($this->zone, 'zone.zone_id = city.zone_id');
    }

    function get_a_registration($where) {
        return $this->db->get_where($this->registration, $where)->row();
    }

    function get_registrations($where, $group_by = false) {
        if ($group_by):
            $this->db->group_by($group_by);
            $orderby = $group_by;
        else:
            $orderby = 'ideology.ideology_status';
        endif;
        $this->db->join($this->participant, $this->participant . '.participant_id = ' . $this->registration . '.participant_id');
        $this->db->order_by($orderby, 'ASC');
        $this->participant_join();
        if ($group_by):
            $this->db->group_by($group_by);
        endif;
        $query = $this->db->get_where($this->registration, $where);
        return $query->result();
    }

    function registration_badges($where) {
        $this->db->join($this->participant, $this->participant . '.participant_id = ' . $this->registration . '.participant_id');
        $this->participant_join();
        foreach ($where as $column => $values):
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
        $this->db->order_by($this->participant . '.participant_id', 'ASC');
        return $this->db->get($this->registration)->result();
    }

    function get_relevant_participant($where, $where_can_be_optional = array(), $columns = '*') {
        $this->db->select($columns);
        $this->participant_join();
        $this->db->group_start();
        foreach ($where as $column => $values):
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
        $this->db->group_end();
        $or_key = false;
        $this->db->group_start();
        foreach ($where_can_be_optional as $column => $values):
            foreach ($values as $value):
                if ($or_key):
                    $this->db->or_where($column, $value);
                else:
                    $this->db->where($column, $value);
                    $or_key = true;
                endif;
            endforeach;
        endforeach;
        $this->db->group_end();
        return $this->db->get($this->participant)->result();
    }

    function insert_batch_registration($data) {
        return $this->db->insert_batch($this->registration, $data);
    }

    function insert_registration($data) {
        return $this->db->insert($this->registration, $data);
    }

    function update_registration($data, $where) {
        return $this->db->update($this->registration, $data, $where);
    }

    function remove_registration($where) {
        return $this->db->delete($this->registration, $where);
    }

    function count_registration($where) {
        $this->db->join($this->participant, $this->participant . '.participant_id = ' . $this->registration . '.participant_id');
        $this->participant_join();
        $this->db->where($where);
        // if(in_array('registration.registration_status', $where) && $where['registration.registration_status'] == 1){
        // $this->db->where('registration.registration_time <','2017-10-08 12:00:00');
        // }
        $this->db->from($this->registration);
        return $this->db->count_all_results();
    }

}
