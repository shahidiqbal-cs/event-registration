<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Organization_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->region = 'region';
        $this->zone = 'zone';
        $this->city = 'city';
        $this->halqa = 'halqa';
    }

    function last_id() {
        return $this->db->insert_id();
    }

    function zone_join() {
        $this->db->join('region', 'region.region_id = zone.region_id');
    }

    function city_join() {
        $this->db->join('zone', 'zone.zone_id = city.zone_id');
        $this->zone_join();
    }

    function halqa_join() {
        $this->db->join('city', 'city.city_id = halqa.city_id');
        $this->city_join();
    }

    /* Regions */

    function get_regions() {
        return $this->db->get($this->region)->result();
    }

    function get_region($where) {
        return $this->db->get_where($this->region, $where)->row();
    }

    function update_region($data, $where) {
        return $this->db->update($this->region, $data, $where);
    }

    /* Zones */

    function get_zones() {
        $this->zone_join();
        return $this->db->get($this->zone)->result();
    }

    function get_zone($where) {
        $this->zone_join();
        return $this->db->get_where($this->zone, $where)->row();
    }

    function insert_zone($data) {
        return $this->db->insert($this->zone, $data);
    }

    function update_zone($data, $where) {
        return $this->db->update($this->zone, $data, $where);
    }

    function delete_zone($zone_id) {
        return $this->db->delete($this->zone, array('zone_id' => $zone_id));
    }

    /* Cites */

    function get_cities() {
        $this->city_join();
        return $this->db->get($this->city)->result();
    }

    function get_city_against_zone($Id) {
        $this->city_join();
        return $this->db->get_where($this->city, array('city.zone_id' => $Id))->result();
    }

    function get_city($where) {
        $this->city_join();
        return $this->db->get_where($this->city, $where)->row();
    }

    function insert_city($data) {
        return $this->db->insert($this->city, $data);
    }

    function update_city($data, $where) {
        return $this->db->update($this->city, $data, $where);
    }

    function delete_city($city_id) {
        return $this->db->delete($this->city, array('city_id' => $city_id));
    }

    /* End Cites */

    /* Halqas */

    function get_halqas() {
        $this->halqa_join();
        return $this->db->get($this->halqa)->result();
    }

    function get_halqa($where) {
        $this->halqa_join();
        return $this->db->get_where($this->halqa, $where)->row();
    }

    function insert_halqa($data) {
        return $this->db->insert($this->halqa, $data);
    }

    function update_halqa($data, $where) {
        return $this->db->update($this->halqa, $data, $where);
    }

    function delete_halqa($halqa_id) {
        return $this->db->delete($this->halqa, array('halqa_id' => $halqa_id));
    }

    function get_halqa_against_city($cityId) {
        $this->halqa_join();
        return $this->db->get_where($this->halqa, array('halqa.city_id' => $cityId))->result();
    }

    /* End Halqas */
}
