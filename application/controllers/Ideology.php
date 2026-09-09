<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ideology extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('propagation_model'));
        if (!is_logged() && (user_role() != 'admin')):
            redirect(site_url('login'));
        endif;
    }

    private function template($output) {
        $output->ideologies = $this->ideology_model->get_ideologies();
        $this->parser->parse('template', $output);
    }

    private function initialize_organization($data) {
        if ($this->input->post()):
            $data->ideology_status = set_value('ideology_status');
        endif;
    }

    function index() {
        $data = (object) array();
        $data->title = 'Ideologies';
        $data->heading = 'Ideologies';
        $data->heading_desc = 'Ideologies';
        $data->content = 'ideologies';
        $data->ideologies = $this->ideology_model->get_ideologies();
        $this->template($data);
    }

    function ideology($action, $ideology_id = null) {
        if ($action == 'new' or $action == 'edit'):
            if ($this->form_validation->run('ideology') == FALSE) :
                $data = (object) array();
                $data->title = 'Ideology';
                $data->heading = 'Ideology';
                $data->heading_desc = 'Ideology';
                $data->content = 'ideology-form';
                $data->ideology_status = '';

                if ($action == 'edit'):
                    if ($ideology_id != null):
                        $query = $this->ideology_model->get_ideology(array('ideology_id' => $ideology_id));
                        if ($query):
                            $data->ideology_status = $query->ideology_status;
                        endif;
                    else:
                        flash_msg('error', 'The url you are trying is not right.');
                        redirect(site_url('ideology'));
                    endif;
                endif;
                $this->initialize_organization($data);
                $this->template($data);
            else:
                $post_data['ideology_status'] = $this->input->post('ideology_status');
                if ($action == 'new'):
                    $insert_query = $this->ideology_model->insert_ideology($post_data);
                    if ($insert_query):
                        $ideology_id = $this->db->insert_id();
                        flash_msg('success', 'New ideology added successfully.');
                    else:
                        flash_msg('error', 'Fail to add new ideology. Try again');
                    endif;
                elseif ($action == 'edit' && $ideology_id != null):
                    $update = $this->ideology_model->update_ideology($post_data, array('ideology_id' => $ideology_id));
                    if ($update):
                        flash_msg('success', 'Saved successfully.');
                    else:
                        flash_msg('error', 'Fail to update. Try again');
                    endif;
                else:
                    flash_msg('error', 'The url you are trying is not right.');
                endif;
                redirect(site_url('ideology'));
            endif;
        elseif ($action == 'delete' && $ideology_id != null):
            $delete = $this->ideology_model->delete_ideology($ideology_id);
            if ($delete):
                flash_msg('success', 'Deleted successfully.');
            else:
                flash_msg('error', 'Error! Fail to delete. Try again');
            endif;
            redirect(site_url('ideology'));
        else:
            flash_msg('error', 'Fail to add new ideology. Try again');
            redirect(site_url('ideology'));
        endif;
    }

}
