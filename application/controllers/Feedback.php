<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('feedback_model'));
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
        $data->title = 'Feedback';
        $data->heading = 'Feedback';
        $data->heading_desc = 'Feedback';
        $data->content = 'feedbacks';
        $data->feedbacks = $this->feedback_model->get();
        $this->template($data);
    }

    private function initialize_form($data) {
        if ($this->input->post()):
            $data->feedbacker_name = set_value('feedbacker_name');
            $data->feedback_type = set_value('feedback_type');
            $data->feedback = set_value('feedback');
        endif;
    }
    function create() {
        if ($this->form_validation->run('feedback') == FALSE) :
            $data = (object) array();
            $data->title = 'Post new feedback';
            $data->heading = 'Post new feedback';
            $data->heading_desc = 'Post new feedback';
            $data->content = 'feedback_form';
            $data->feedbacker_name = '';
            $data->feedback_type = '';
            $data->feedback = '';
            $this->initialize_form($data);
            $this->template($data);
        else:
            if ($this->feedback_model->insert($this->input->post())):
                flash_msg('success', 'Feedback posted successfully.');
                redirect(site_url('feedback'));
            else:
                flash_msg('error', 'Error creating feedback. Try again!');
                redirect(current_url());
            endif;
        endif;
    }
    function edit($id) {
        if ($this->form_validation->run('feedback') == FALSE) :
            $data = (object) array();
            $data->title = 'Edit feedback';
            $data->heading = 'Edit feedback';
            $data->heading_desc = 'Edit feedback';
            $data->content = 'feedback_form';
            $feedback = $this->feedback_model->get_row(array('feedback_id'=>$id));
            $data->feedbacker_name = $feedback->feedbacker_name;
            $data->feedback_type = $feedback->feedback_type;
            $data->feedback = $feedback->feedback;
            $this->initialize_form($data);
            $this->template($data);
        else:
            if ($this->feedback_model->update($this->input->post(), array('feedback_id' => $id))):
                flash_msg('success', 'Update successfully.');
            else:
                flash_msg('error', 'Error updating feedback. Try again!');
            endif;
            redirect(current_url());
        endif;
    }
}
