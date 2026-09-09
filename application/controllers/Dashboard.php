<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('PHPExcel'));
        $this->load->model(array('registration_model'));
        if (!is_logged()):
            redirect(site_url('login'));
        endif;
    }

    private function template($output) {
        $output->ideologies = $this->ideology_model->get_ideologies();
        $this->parser->parse('template', $output);
    }

    function index() {
        $data = (object) array();
        $data->title = 'Dashboard';
        $data->heading = 'Dashboard';
        $data->heading_desc = 'Control panel';
        $data->content = 'dashboard';
        $data->attendance = '';
        $data->all_participants = $this->participant_model->count_participants(array('participant_status' => 1));
        if ($this->session->userdata('active_event')):
            $event_id = $this->session->userdata('active_event');
            $data->attendance = $this->registration_model->get_registrations(array('event_id' => $event_id));
            $data->present = $this->registration_model->count_registration(array('event_id' => $event_id, 'registration_status' => '1'));
        endif;
        $this->template($data);
    }

}
