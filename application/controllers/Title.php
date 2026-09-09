<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Title extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('title_model'));
        if (!is_logged()):
            redirect(site_url('login'));
        elseif (user_role() != 'admin'):
            redirect(site_url());
        endif;
    }

    private function template($output) {
        $output->ideologies = $this->ideology_model->get_ideologies();
        $this->parser->parse('template', $output);
    }

    function index() {
        $data = (object) array();
        $data->title = 'Titles';
        $data->heading = 'Titles';
        $data->heading_desc = 'Event Titles';
        $data->content = 'event_title';
        $data->titles = $this->title_model->get_titles();
        $this->template($data);
    }

    function create() {
        if ($this->form_validation->run('event_title') == FALSE) :
            $data = (object) array();
            $data->title = 'Create new title';
            $data->heading = 'Create new title';
            $data->heading_desc = 'Create new title';
            $data->content = 'event_title_form';
            $data->event_title = '';
            $data->title_description = '';
            $this->template($data);
        else:
            $values['event_title'] = $this->input->post('title');
            $values['title_description'] = $this->input->post('title_description');
            if ($this->title_model->add_title($values)):
                flash_msg('success', 'New title created successfully.');
                redirect(site_url('title'));
            else:
                flash_msg('error', 'Error creating title. Try again!');
                redirect(current_url());
            endif;
        endif;
    }

    function edit($title_id) {
        if ($this->form_validation->run('event_title') == FALSE) :
            $data = (object) array();
            $data->title = 'Edit title';
            $data->heading = 'Edit title';
            $data->heading_desc = 'Edit title';
            $data->content = 'event_title_form';
            $title = $this->title_model->get_title(array('title_id' => $title_id));
            $data->event_title = $title->event_title;
            $data->title_description = $title->title_description;
            $this->template($data);
        else:
            $values['event_title'] = $this->input->post('title');
            $values['title_description'] = $this->input->post('title_description');
            if ($this->title_model->update_title($values, array('title_id' => $title_id))):
                flash_msg('success', 'Update successfully.');
            else:
                flash_msg('error', 'Error updating title. Try again!');
            endif;
            redirect(current_url());
        endif;
    }

    function delete($title_id) {
        if ($this->title_model->delete($title_id)):
            flash_msg('success', 'Title Deleted successfully.');
        else:
            flash_msg('error', 'Error Deleting title. Try again!.');
        endif;
        redirect(site_url('title'));
    }

}
