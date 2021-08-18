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
        if ($output->content != 'grocery_crud'):
            $editor = $this->tfw_model->get_option('active_gc_editor_for_admin')->option_value;
            $css_files = array();
            $js_files = array();
            if ($editor == 'ckeditor'):
                $js_files = array(
                    base_url('assets/grocery_crud/texteditor/ckeditor/ckeditor.js'),
                    base_url('assets/grocery_crud/texteditor/ckeditor/adapters/jquery.js'),
                    base_url('assets/grocery_crud/js/jquery_plugins/config/jquery.ckeditor.config.js')
                );
            elseif ($editor == 'tinymce'):
                $js_files = array(
                    base_url('assets/grocery_crud/texteditor/tiny_mce/jquery.tinymce.js'),
                    base_url('assets/grocery_crud/js/jquery_plugins/config/jquery.tine_mce.config.js')
                );
            elseif ($editor == 'bootstrap-wysihtml5'):
                $css_files = array(
                    base_url('assets/grocery_crud/texteditor/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')
                );
                $js_files = array(
                    base_url('assets/grocery_crud/texteditor/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'),
                    base_url('assets/grocery_crud/js/jquery_plugins/config/jquery.bootstrap3-wysihtml5.config.js')
                );
            elseif ($editor == 'markitup'):
                $css_files = array(
                    base_url('assets/grocery_crud/texteditor/markitup/skins/markitup/style.css'),
                    base_url('assets/grocery_crud/texteditor/markitup/sets/default/style.css')
                );
                $js_files = array(
                    base_url('assets/grocery_crud/texteditor/markitup/jquery.markitup.js'),
                    base_url('assets/grocery_crud/js/jquery_plugins/config/jquery.markitup.config.js')
                );
            endif;

            $output->css_files = $css_files;
            $output->js_files = $js_files;
        endif;
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
