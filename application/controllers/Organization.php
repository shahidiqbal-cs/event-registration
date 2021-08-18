<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends CI_Controller {

    public function __construct() {
        parent::__construct();
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

    function regions() {
        $data = (object) array();
        $data->title = lang('region');
        $data->heading = lang('region');
        $data->heading_desc = '';
        $data->content = 'Regions';
        $data->regions = $this->organization_model->get_regions();
        $this->template($data);
    }

    function zones() {
        $data = (object) array();
        $data->title = lang('zone');
        $data->heading = lang('zone');
        $data->heading_desc = '';
        $data->content = 'Zones';
        $data->zones = $this->organization_model->get_zones();
        $this->template($data);
    }

    function region($action, $id = null) {
        if ($action == 'edit' && $id):
            if ($this->form_validation->run('organization') == FALSE) :
                $data = (object) array();
                $data->title = lang('region');
                $data->heading = lang('region');
                $data->heading_desc = '';
                $data->content = 'region-form';
                $detail = $this->organization_model->get_region(array('region_id' => $id));
                $data->organization_name = $detail->region_name;
                $data->organization_parent = 'dummay';
                $data->organization_description = $detail->region_description;
                $this->initialize_organization($data);
                $this->template($data);
            else:
                $region['region_name'] = $this->input->post('organization_name');
                $region['region_description'] = $this->input->post('organization_description');
                $update = $this->organization_model->update_region($region, array('region_id' => $id));
                if ($update):
                    flash_msg('success', 'Saved successfully.');
                else:
                    flash_msg('error', 'Fail to update region. Try again');
                endif;
                redirect(site_url('organization/regions'));
            endif;
        else:
            flash_msg('error', 'Not allowed.');
            redirect(site_url('organization/regions'));
        endif;
    }

    function zone($action, $zone_id = null) {
        if ($action == 'new' or $action == 'edit'):
            if ($this->form_validation->run('organization') == FALSE) :
                $data = (object) array();
                $data->title = lang('zone');
                $data->heading = lang('zone');
                $data->heading_desc = '';
                $data->content = 'zone-form';
                $data->organization_name = '';
                $data->organization_parent = '';
                $data->organization_description = '';
                if ($action == 'edit'):
                    if ($zone_id != null):
                        $zone_detail = $this->organization_model->get_zone(array('zone_id' => $zone_id));
                        if ($zone_detail):
                            $data->organization_name = $zone_detail->zone_name;
                            $data->organization_parent = $zone_detail->region_id;
                            $data->organization_description = $zone_detail->zone_description;
                        endif;
                    else:
                        flash_msg('error', 'The url you are trying is not right.');
                        redirect(site_url('organization/zones'));
                    endif;
                endif;
                $data->regions = $this->organization_model->get_regions();
                $this->initialize_organization($data);
                $this->template($data);
            else:
                $zone['zone_name'] = $this->input->post('organization_name');
                $zone['region_id'] = $this->input->post('organization_parent');
                $zone['zone_description'] = $this->input->post('organization_description');
                if ($action == 'new'):
                    $insert_query = $this->organization_model->insert_zone($zone);
                    if ($insert_query):
                        $zone_id = $this->organization_model->last_id();
                        flash_msg('success', 'New zone added successfully.');
                    else:
                        flash_msg('error', 'Fail to add new zone. Try again');
                    endif;
                elseif ($action == 'edit' && $zone_id != null):
                    $update = $this->organization_model->update_zone($zone, array('zone_id' => $zone_id));
                    if ($update):
                        flash_msg('success', 'Saved successfully.');
                    else:
                        flash_msg('error', 'Fail to update zone. Try again');
                    endif;
                else:
                    flash_msg('error', 'The url you are trying is not right.');
                endif;
                redirect(site_url('organization/zones'));
            endif;
        elseif ($action == 'delete' && $zone_id != null):
            $delete = $this->organization_model->delete_zone($zone_id);
            if ($delete):
                flash_msg('success', 'Deleted successfully.');
            else:
                flash_msg('error', 'Error! Fail to delete. Try again');
            endif;
            redirect(site_url('organization/zones'));
        else:
            flash_msg('error', 'Fail to add new zone. Try again');
            redirect(site_url('organization/zones'));
        endif;
    }

    function cities() {
        $data = (object) array();
        $data->title = lang('city');
        $data->heading = lang('city');
        $data->heading_desc = '';
        $data->content = 'cites';
        $data->cities = $this->organization_model->get_cities();
        $this->template($data);
    }

    function city($action, $city_id = null) {
        if ($action == 'new' or $action == 'edit'):
            if ($this->form_validation->run('organization') == FALSE) :
                $data = (object) array();
                $data->title = lang('city');
                $data->heading = lang('city');
                $data->heading_desc = '';
                $data->content = 'city-form';
                $data->organization_name = '';
                $data->organization_parent = '';
                $data->organization_description = '';
                if ($action == 'edit'):
                    if ($city_id != null):
                        $city_detail = $this->organization_model->get_city(array('city_id' => $city_id));
                        if ($city_detail):
                            $data->organization_name = $city_detail->city_name;
                            $data->organization_parent = $city_detail->zone_id;
                            $data->organization_description = $city_detail->city_description;
                        endif;
                    else:
                        flash_msg('error', 'The url you are trying is not right.');
                        redirect(site_url('organization/cities'));
                    endif;
                endif;
                $data->zones = $this->organization_model->get_zones();
                $this->initialize_organization($data);
                $this->template($data);
            else:
                $city['city_name'] = $this->input->post('organization_name');
                $city['zone_id'] = $this->input->post('organization_parent');
                $city['city_description'] = $this->input->post('organization_description');
                if ($action == 'new'):
                    $insert_query = $this->organization_model->insert_city($city);
                    if ($insert_query):
                        $city_id = $this->organization_model->last_id();
                        flash_msg('success', 'New city added successfully.');
                    else:
                        flash_msg('error', 'Fail to add new city. Try again');
                    endif;
                elseif ($action == 'edit' && $city_id != null):
                    $update = $this->organization_model->update_city($city, array('city_id' => $city_id));
                    if ($update):
                        flash_msg('success', 'Saved successfully.');
                    else:
                        flash_msg('error', 'Fail to update city. Try again');
                    endif;
                else:
                    flash_msg('error', 'The url you are trying is not right.');
                endif;

                redirect(site_url('organization/cities'));
            endif;
        elseif ($action == 'delete' && $city_id != null):
            $delete = $this->organization_model->delete_city($city_id);
            if ($delete):
                flash_msg('success', 'Deleted successfully.');
            else:
                flash_msg('error', 'Error! Fail to delete. Try again');
            endif;
            redirect(site_url('organization/cities'));
        else:
            flash_msg('error', 'Fail to add new city. Try again');
            redirect(site_url('organization/cities'));
        endif;
    }

    function get_below_organization() {
        $result['status'] = true;
        $result['city_list'] = '';
        $result['halqa_list'] = '';
        $id = $this->input->post('id');
        $level = $this->input->post('level');
        if ($level == 'zone'):
            $cities = $this->organization_model->get_city_against_zone($id);
            if ($cities):
                foreach ($cities as $city):
                    $result['city_list'] .= '<option value="' . $city->city_id . '">' . $city->city_name . '</option>';
                endforeach;
            else:
                $result['status'] = false;
            endif;
        elseif ($level == 'city'):
            $halqa_jaat = $this->organization_model->get_halqa_against_city($id);
            if ($halqa_jaat):
                foreach ($halqa_jaat as $halqa):
                    $result['halqa_list'] .= '<option value="' . $halqa->halqa_id . '">' . $halqa->halqa_name . '</option>';
                endforeach;
            else:
                $result['status'] = false;
            endif;
        else:
            $result['status'] = false;
        endif;
        echo json_encode($result);
    }

    function get_event_organizers() {
        $result['status'] = true;
        $result['organizers'] = '';
        $organization = $this->input->post('organization');
        if ($organization == 'region'):
            $organizers = $this->organization_model->get_regions();
            if ($organizers):
                foreach ($organizers as $organizer):
                    $result['organizers'] .= '<div class="col-sm-3 pull-right"><label class="control-label">';
                    $result['organizers'] .= '<input type="radio" name="organizer_id" class="minimal" value="' . $organizer->region_id . '" /> ' . $organizer->region_name;
                    $result['organizers'] .= '</label></div>';
                endforeach;
            else:
                $result['status'] = false;
            endif;
        elseif ($organization == 'zone'):
            $organizers = $this->organization_model->get_zones();
            if ($organizers):
                foreach ($organizers as $organizer):
                    $result['organizers'] .= '<div class="col-sm-3 pull-right"><label class="control-label">';
                    $result['organizers'] .= '<input type="radio" name="organizer_id" class="minimal" value="' . $organizer->zone_id . '" /> ' . $organizer->zone_name;
                    $result['organizers'] .= '</label></div>';
                endforeach;
            else:
                $result['status'] = false;
            endif;
        elseif ($organization == 'city'):
            $organizers = $this->organization_model->get_cities();
            if ($organizers):
                foreach ($organizers as $organizer):
                    $result['organizers'] .= '<div class="col-sm-3 pull-right"><label class="control-label">';
                    $result['organizers'] .= '<input type="radio" name="organizer_id" class="minimal" value="' . $organizer->city_id . '" /> ' . $organizer->city_name;
                    $result['organizers'] .= '</label></div>';
                endforeach;
            else:
                $result['status'] = false;
            endif;
        elseif ($organization == 'halqa'):
            $organizers = $this->organization_model->get_halqas();
            if ($organizers):
                foreach ($organizers as $organizer):
                    $result['organizers'] .= '<div class="col-sm-3 pull-right"><label class="control-label">';
                    $result['organizers'] .= '<input type="radio" name="organizer_id" class="minimal" value="' . $organizer->halqa_id . '" /> ' . $organizer->halqa_name;
                    $result['organizers'] .= '</label></div>';
                endforeach;
            else:
                $result['status'] = false;
            endif;
        else:
            $result['status'] = false;
        endif;
        echo json_encode($result);
    }

    function get_cities_in_zones() {
        $result['status'] = true;
        $result['data'] = '';
        $zones = $this->input->post('zones');
        if (is_array($zones) && !empty($zones)):
            foreach ($zones as $zone):
                $cities = $this->organization_model->get_city_against_zone($zone);
                if ($cities):
                    foreach ($cities as $city):
                        $result['data'] .= '<div class="col-sm-4 pull-right"><label class="control-label">';
                        $result['data'] .= '<input type="checkbox" class="minimal" name="custom_city[]" value="' . $city->city_id . '" /> ' . $city->city_name;
                        $result['data'] .= '</label></div>';
                    endforeach;
                endif;
            endforeach;
        else:
            $result['status'] = false;
        endif;
        echo json_encode($result);
    }

    function get_halqas_in_cities() {
        $result['status'] = true;
        $result['data'] = '';
        $cities = $this->input->post('cities');
        if (is_array($cities) && !empty($cities)):
            foreach ($cities as $city):
                $halqas = $this->organization_model->get_halqa_against_city($city);
                if ($halqas):
                    foreach ($halqas as $halqa):
                        $result['data'] .= '<div class="col-sm-4 pull-right"><label class="control-label">';
                        $result['data'] .= '<input type="checkbox" class="minimal" name="custom_halqa[]" value="' . $halqa->halqa_id . '" /> ' . $halqa->halqa_name;
                        $result['data'] .= '</label></div>';
                    endforeach;
                endif;
            endforeach;
        else:
            $result['status'] = false;
        endif;
        echo json_encode($result);
    }

}
