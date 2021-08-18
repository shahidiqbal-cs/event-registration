<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Majlis_amomi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('majlis_amomi_model'));
        if (!is_logged()):
            redirect(site_url('login'));
        elseif (user_role() != 'admin'):
            redirect(site_url());
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
        $data->title = 'Majlis Amomi';
        $data->heading = 'Majlis Amomi';
        $data->heading_desc = 'Majlis Amomi';
        $data->content = 'majlis_amomis';
        $data->majlis_amomis = $this->majlis_amomi_model->get();
        $this->template($data);
    }

    function create() {
        if ($this->form_validation->run('event_title') == FALSE) :
            $data = (object) array();
            $data->title = 'Create new majlis amomi';
            $data->heading = 'Create new majlis amomi';
            $data->heading_desc = 'Create new majlis amomi';
            $data->content = 'majlis_amomis_form';
            $data->status = '';
            $data->description = '';
            $this->template($data);
        else:
            $values['majlis_amomi_status'] = $this->input->post('title');
            $values['majlis_amomi_description'] = $this->input->post('description');
            if ($this->majlis_amomi_model->insert($values)):
                flash_msg('success', 'New majlis amomi created successfully.');
                redirect(site_url('majlis_amomi'));
            else:
                flash_msg('error', 'Error creating majlis amomi. Try again!');
                redirect(current_url());
            endif;
        endif;
    }

    function edit($id) {
        if ($this->form_validation->run('event_title') == FALSE) :
            $data = (object) array();
            $data->title = 'Edit majlis amomi';
            $data->heading = 'Edit majlis amomi';
            $data->heading_desc = 'Edit majlis amomi';
            $data->content = 'majlis_amomis_form';
            $row = $this->majlis_amomi_model->get_row(array('majlis_amomi_id' => $id));
            $data->status = $row->majlis_amomi_status;
            $data->description = $row->majlis_amomi_description;
            $this->template($data);
        else:
            $values['majlis_amomi_status'] = $this->input->post('title');
            $values['majlis_amomi_description'] = $this->input->post('title_description');
            if ($this->majlis_amomi_model->update($values, array('majlis_amomi_id' => $id))):
                flash_msg('success', 'Update successfully.');
            else:
                flash_msg('error', 'Error updating title. Try again!');
            endif;
            redirect(current_url());
        endif;
    }

    function delete($id) {
        if ($this->majlis_amomi_model->delete($id)):
            flash_msg('success', 'Majlis amomi Deleted successfully.');
        else:
            flash_msg('error', 'Error Deleting Majlis amomi. Try again!.');
        endif;
        redirect(site_url('majlis_amomi'));
    }

}
