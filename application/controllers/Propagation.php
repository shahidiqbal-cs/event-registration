<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Propagation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('propagation_model'));
        if (!is_logged() && (user_role() != 'admin')):
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

    private function initialize_organization($data) {
        if ($this->input->post()):
            $data->organization_name = set_value('organization_name');
            $data->organization_parent = set_value('organization_parent');
            $data->organization_description = set_value('organization_description');
        endif;
    }

    function index() {
        $data = (object) array();
        $data->title = 'Propagation';
        $data->heading = 'Propagation';
        $data->heading_desc = 'Propagation';
        $data->content = 'propagations';
        $data->propagations = $this->propagation_model->get_propagations();
        $this->template($data);
    }

    function propagation($action, $propagation_id = null) {
        if ($action == 'new' or $action == 'edit'):
            if ($this->form_validation->run('organization') == FALSE) :
                $data = (object) array();
                $data->title = 'Propagation';
                $data->heading = 'Propagation';
                $data->heading_desc = 'Propagation';
                $data->content = 'propagation-form';
                $data->organization_name = '';
                $data->organization_parent = 'dummay';
                $data->organization_description = '';

                if ($action == 'edit'):
                    if ($propagation_id != null):
                        $query = $this->propagation_model->get_propagation(array('propagation_id' => $propagation_id));
                        if ($query):
                            $data->organization_name = $query->propagation_status;
                            $data->organization_description = $query->propagation_description;
                        endif;
                    else:
                        flash_msg('error', 'The url you are trying is not right.');
                        redirect(site_url('propagation'));
                    endif;
                endif;
                $this->initialize_organization($data);
                $this->template($data);
            else:
                $post_data['propagation_status'] = $this->input->post('organization_name');
                $post_data['propagation_description'] = $this->input->post('organization_description');
                if ($action == 'new'):
                    $insert_query = $this->propagation_model->insert_propagation($post_data);
                    if ($insert_query):
                        $propagation_id = $this->propagation_model->last_id();
                        flash_msg('success', 'New propagation added successfully.');
                    else:
                        flash_msg('error', 'Fail to add new propagation. Try again');

                    endif;
                elseif ($action == 'edit' && $propagation_id != null):
                    $update = $this->propagation_model->update_propagation($post_data, array('propagation_id' => $propagation_id));
                    if ($update):
                        flash_msg('success', 'Saved successfully.');
                    else:
                        flash_msg('error', 'Fail to update. Try again');
                    endif;
                else:
                    flash_msg('error', 'The url you are trying is not right.');
                endif;
                redirect(site_url('propagation'));
            endif;
        elseif ($action == 'delete' && $propagation_id != null):
            $delete = $this->propagation_model->delete_propagation($propagation_id);
            if ($delete):
                flash_msg('success', 'Deleted successfully.');
            else:
                flash_msg('error', 'Error! Fail to delete. Try again');
            endif;
            redirect(site_url('propagation'));
        else:
            flash_msg('error', 'Fail to add new propagation. Try again');
            redirect(site_url('propagation'));
        endif;
    }

}
