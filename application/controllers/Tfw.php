<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tfw extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('PHPExcel'));
        $this->load->model(array('registration_model'));
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
