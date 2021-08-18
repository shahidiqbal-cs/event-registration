<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('event_model', 'title_model', 'registration_model', 'propagation_model', 'majlis_amomi_model'));
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

    private function get_event_organizer($event) {
        if ($event->organizer == 'region'):
            $event->organizer_urdu = lang('region');
            $organizer_region = $this->organization_model->get_region(array('region_id' => $event->organizer_id));
            if ($organizer_region):
                $event->organizer_name = $organizer_region->region_name;
            endif;
        elseif ($event->organizer == 'zone'):
            $event->organizer_urdu = lang('zone');
            $organizer_zone = $this->organization_model->get_zone(array('zone_id' => $event->organizer_id));
            if ($organizer_zone):
                $event->organizer_name = $organizer_zone->zone_name;
            endif;
        elseif ($event->organizer == 'city'):
            $event->organizer_urdu = lang('city');
            $organizer_city = $this->organization_model->get_city(array('city_id' => $event->organizer_id));
            if ($organizer_city):
                $event->organizer_name = $organizer_city->city_name;
            endif;
        else:
            $event->organizer = 'Unknown';
            $event->organizer_name = 'Unknown';
        endif;
    }

    private function initialize_event($data) {
        if ($this->input->post()):
            $data->organizer_id = set_value('organizer_id');
            $data->event_name = set_value('event_name');
            $data->event_location = set_value('event_location');
            $data->event_date = set_value('event_date');
            $data->organizer = set_value('organizer');
//            $data->participant_by_ideology = set_value('ideologies');
//            $data->participant_by_propagation = set_value('propagations');
            $data->print_header = set_value('print_header');
        endif;
        $data->content = 'event-form';
        $data->event_titles = $this->title_model->get_titles();
        $data->zones = $this->organization_model->get_zones();
        $data->ideologies = $this->ideology_model->get_ideologies();
        $data->propagations = $this->propagation_model->get_propagations();
        $data->majlis_amomis = $this->majlis_amomi_model->get();
        if ($data->organizer == 'region'):
            $data->list_of_organizer = $this->organization_model->get_regions();
        elseif ($data->organizer == 'zone'):
            $data->list_of_organizer = $this->organization_model->get_zones();
        elseif ($data->organizer == 'city'):
            $data->list_of_organizer = $this->organization_model->get_cities();
            $data->list_of_organizer = false;
        endif;

        if (!empty($data->cutom_zone) && ($data->city_option == 'custom')):
            $data->cities = array();
            foreach ($data->cutom_zone as $zone):
                $cutome_cities_in_zone = $this->organization_model->get_city_against_zone($zone);
                if (empty($data->cities)):
                    $data->cities = $cutome_cities_in_zone;
                else:
                    foreach ($cutome_cities_in_zone as $cutome_city_in_zone):
                        array_push($data->cities, $cutome_city_in_zone);
                    endforeach;
                endif;
            endforeach;
        else:
            $data->cities = false;
        endif;
    }

    private function urdu_name_of_organization($english_name) {
        if ($english_name == 'region'):
            return lang('region');
        elseif ($english_name == 'zone'):
            return lang('zone');
        elseif ($english_name == 'city'):
            return lang('city');
        endif;
    }

    private function get_participant_organization($organization, $ids) {
        $organization_data = array();
        if ($organization == 'region'):
            foreach ($ids as $id):
                $organization_data[$id] = $this->organization_model->get_region(array('region_id' => $id))->region_name;
            endforeach;
        elseif ($organization == 'zone'):
            foreach ($ids as $id):
                $organization_data[$id] = $this->organization_model->get_zone(array('zone_id' => $id))->zone_name;
            endforeach;
        elseif ($organization == 'city'):
            foreach ($ids as $id):
                $organization_data[$id] = $this->organization_model->get_city(array('city_id' => $id))->city_name;
            endforeach;
        else:
            return false;
        endif;
        return $organization_data;
    }

    function index() {
        $data = (object) array();
        $data->title = 'Events';
        $data->heading = 'Events';
        $data->heading_desc = 'Events';
        $data->content = 'events';
        $data->events = $this->event_model->get_events();
        if ($data->events):
            //Redering orginzer
            foreach ($data->events as $event):
                $this->get_event_organizer($event);
                $this->get_participant_types($event);
            endforeach;
        endif;
        $this->template($data);
    }

    function get_participant_types($event) {
        $event->participant_types = '';
        if ($event->selected_ideology):
            $selected_ids = unserialize($event->selected_ideology);
            foreach ($selected_ids as $id):
                $event->participant_types .= $this->ideology_model->get_ideology(array('ideology_id' => $id))->ideology_status;
                $event->participant_types .='<br/>';
            endforeach;
        endif;
        if ($event->selected_majlis_amomi):
            $selected_ids = unserialize($event->selected_majlis_amomi);
            foreach ($selected_ids as $id):
                $event->participant_types .= $this->majlis_amomi_model->get_row(array('majlis_amomi_id' => $id))->majlis_amomi_status;
                $event->participant_types .='<br/>';
            endforeach;
        endif;
        if ($event->selected_propagation):
            $selected_ids = unserialize($event->selected_propagation);
            foreach ($selected_ids as $id):
                $event->participant_types .= $this->propagation_model->get_propagation(array('propagation_id' => $id))->propagation_status;
                $event->participant_types .='<br/>';
            endforeach;
        endif;
        if ($event->selected_propagation):
            $event->event_type = lang('dawati');
        else:
            $event->event_type = lang('tarbiati');
        endif;
    }

    function create() {
        if (user_role() != 'admin'):
            flash_msg('error', 'You are not allowed for this action.');
            redirect(site_url('event'));
        endif;
        if ($this->form_validation->run('event') == FALSE) :
            $data = (object) array();
            $data->title = 'Add new event';
            $data->heading = 'Add new event';
            $data->heading_desc = 'Add new event';
            ///////////////// Event data strings /////////////////
            $data->event_name = '';
            $data->event_date = '';
            $data->event_location = '';
            $data->print_header = '';
            $data->organizer = 'zone';
            $data->organizer_id = '';
            $data->event_type = 'tarbiati';
            $data->event_type_ids = array();
            $data->selected_ideology = false;
            $data->selected_majlis_amomi = false;
            $data->selected_propagation = false;
            $data->selected_intazamia = false;
            $data->zone_option = 'all';
            $data->city_option = 'all';
            $data->cutom_zone = array();
            $data->cutom_city = array();
            $this->initialize_event($data);
            ///////////////// Event data strings /////////////////
            $this->template($data);
        else:
            $eventData = $this->form_data();
            $register_event = $this->event_model->register_event($eventData);
            if ($register_event):
                $event_id = $this->tfw_model->last_id();
                $event = $this->event_model->get_a_event(array('event_id' => $event_id));
                $where = array();
                $where_can_be_optional = array();
                $where['participant.participant_status'] = array(1);
                $where[$event->participants_organization . '.' . $event->participants_organization . '_id'] = unserialize($event->organization_ids);

                if ($event->selected_ideology):
                    $where_can_be_optional['ideology.ideology_id'] = unserialize($event->selected_ideology);
                endif;
                if ($event->selected_majlis_amomi):
                    $where_can_be_optional['majlis_amomi.majlis_amomi_id'] = unserialize($event->selected_majlis_amomi);
                endif;
                if ($event->selected_propagation):
                    $where_can_be_optional['propagation.propagation_id'] = unserialize($event->selected_propagation);
                endif;

                $participants = $this->registration_model->get_relevant_participant($where, $where_can_be_optional, $columns = 'participant.participant_id');
                if ($participants):
                    foreach ($participants as $participant):
                        $participant->event_id = $event_id;
                    endforeach;
                    $attendanceSheet = $this->registration_model->insert_batch_registration($participants);
                    if ($attendanceSheet):
                        flash_msg('success', 'Event added successfully.');
                        $this->session->set_userdata('active_event', $event_id);
                        redirect(site_url('event/update/' . $event_id));
                    else:
                        flash_msg('error', 'Event added but faild to create sheet.');
                    endif;
                else:
                    flash_msg('error', 'Event created but no participant found for this event.');
                endif;
            else:
                flash_msg('error', 'Error to add new event. Try again.');
            endif;
            redirect(current_url());
        endif;
    }

    private function form_data() {
        $organization_ids = array();
//        $event_type_ids = $this->input->post('event_type_ids');
//        $selected_ideologies = $this->input->post('ideologies');
//        $propagations = $this->input->post('propagations');
//        $eventData['event_type'] = $this->input->post('event_type');
        $eventData['event_date'] = date('Y-m-d', strtotime($this->input->post('event_date')));
        $eventData['event_location'] = $this->input->post('event_location');
        $eventData['organizer_id'] = $this->input->post('organizer_id');
        $eventData['organizer'] = $this->input->post('organizer');
        $eventData['event_header'] = $this->input->post('print_header');
//        $eventData['event_type_ids'] = serialize($event_type_ids);
//        $eventData['participant_by_ideology'] = serialize($selected_ideologies);
//        $eventData['participant_by_propagation'] = serialize($propagations);
        $eventData['event_name'] = $this->input->post('event_name');

        if ($this->input->post('tabiat') == 'custom'):
            if ($this->input->post('ideologies') && $this->input->post('majlis_amomis')):
                $eventData['selected_ideology'] = serialize($this->input->post('ideologies'));
                $eventData['selected_majlis_amomi'] = serialize($this->input->post('majlis_amomis'));
            elseif ($this->input->post('ideologies')):
                $eventData['selected_ideology'] = serialize($this->input->post('ideologies'));
            elseif ($this->input->post('majlis_amomis')):
                $eventData['selected_majlis_amomi'] = serialize($this->input->post('majlis_amomis'));
            else:
                flash_msg('error', 'You must select ideology.');
                redirect(current_url());
            endif;
        endif;
        if ($this->input->post('dawat') == 'custom'):
            if ($this->input->post('propagations')):
                $eventData['selected_propagation'] = serialize($this->input->post('propagations'));
            else:
                flash_msg('error', 'You must select propagation.');
                redirect(current_url());
            endif;
        endif;
        if ($this->input->post('zone') == 'all'):
            $eventData['participants_organization'] = 'zone';
            $zones = $this->organization_model->get_zones();
            foreach ($zones as $zone):
                array_push($organization_ids, $zone->zone_id);
            endforeach;
        elseif (($this->input->post('zone') == 'custom') && ($this->input->post('city') == 'all')):
            $eventData['participants_organization'] = 'zone';
            $organization_ids = $this->input->post('custom_zone');
        elseif ($this->input->post('city') == 'custom'):
            $eventData['participants_organization'] = 'city';
            $organization_ids = $this->input->post('custom_city');
        endif;
        $eventData['organization_ids'] = serialize($organization_ids);
        return $eventData;
    }

    function update($event_id) {
        if (user_role() != 'admin'):
            flash_msg('error', 'You are not allowed for this action.');
            redirect(site_url('event'));
        endif;
        $event = $this->event_model->get_a_event(array('event_id' => $event_id));
        if (!$event):
            flash_msg('info', 'Create Event first.');
            redirect(site_url('tfw/event_new'));
        endif;

        if ($this->form_validation->run('event') == FALSE) :
            ///////////////// Event data strings /////////////////
            $data = (object) array();
            $data->title = 'Event';
            $data->heading = 'Event';
            $data->heading_desc = 'Event';
            $data->event_name = $event->event_name;
            $data->event_date = $event->event_date;
            $data->event_location = $event->event_location;
            $data->print_header = $event->event_header;
            $data->organizer = $event->organizer;
            $data->organizer_id = $event->organizer_id;
            $data->selected_ideology = ($event->selected_ideology) ? unserialize($event->selected_ideology) : false;
            $data->selected_propagation = ($event->selected_propagation) ? unserialize($event->selected_propagation) : false;
            $data->selected_majlis_amomi = ($event->selected_majlis_amomi) ? unserialize($event->selected_majlis_amomi) : false;
            $data->selected_intazamia = $event->selected_intazamia;
            $data->participants_organization = $event->participants_organization;
            $data->organization_ids = unserialize($event->organization_ids);
            $data->zone_option = 'all';
            $data->city_option = 'all';
            $data->cutom_zone = array();
            $data->cutom_city = array();
            $this->get_event_organizer($event);
            $data->the_event = (array) $event;
            $organization_ids = unserialize($event->organization_ids);
            if ($data->participants_organization == 'zone'):
                $data->cutom_zone = $organization_ids;
                $zones = $this->organization_model->get_zones();
                foreach ($zones as $zone):
                    if (!in_array($zone->zone_id, $organization_ids)):
                        $data->zone_option = 'custom';
                        break;
                    endif;
                endforeach;
            elseif ($data->participants_organization == 'city'):
                $data->zone_option = 'custom';
                $cities = $this->organization_model->get_cities();
                $cutom_zone_ids = array();
                $data->cutom_city = $organization_ids;
                foreach ($cities as $city):
                    if (!in_array($city->city_id, $organization_ids)):
                        $data->city_option = 'custom';
                    elseif (!in_array($city->zone_id, $cutom_zone_ids)):
                        $cutom_zone_ids[] = $city->zone_id;
                    endif;
                endforeach;
                $data->cutom_zone = $cutom_zone_ids;
            endif;
            $this->initialize_event($data);
        else:
            $eventData = $this->form_data();
            $updateParticipant = $this->event_model->update_event($eventData, array('event_id' => $event_id));
            if ($updateParticipant):
                $this->update_registration($event_id);
                flash_msg('success', 'Event updated successfully.');
            else:
                flash_msg('error', 'Error to update Event. Try again.');
            endif;
            redirect(current_url());
        endif;
        $this->template($data);
    }

    private function update_registration($event_id) {
        $existing_registration = array();
        $new_registration = array();
        $event_registration = $this->registration_model->get_registrations(array('event_id' => $event_id));
        foreach ($event_registration as $participant):
            if (!in_array($participant->participant_id, $existing_registration)):
                array_push($existing_registration, $participant->participant_id);
            endif;
        endforeach;

        $where = array();
        $where_can_be_optional = array();
        $event = $this->event_model->get_a_event(array('event_id' => $event_id));
        $where['participant.participant_status'] = array(1);
        $where[$event->participants_organization . '.' . $event->participants_organization . '_id'] = unserialize($event->organization_ids);
        if ($event->selected_ideology):
            $where_can_be_optional['ideology.ideology_id'] = unserialize($event->selected_ideology);
        endif;
        if ($event->selected_majlis_amomi):
            $where_can_be_optional['majlis_amomi.majlis_amomi_id'] = unserialize($event->selected_majlis_amomi);
        endif;
        if ($event->selected_propagation):
            $where_can_be_optional['propagation.propagation_id'] = unserialize($event->selected_propagation);
        endif;
        $participants = $this->registration_model->get_relevant_participant($where, $where_can_be_optional, $columns = 'participant.participant_id');
        foreach ($participants as $participant):
            if (!in_array($participant->participant_id, $new_registration)):
                array_push($new_registration, $participant->participant_id);
            endif;
        endforeach;
        $have_to_remove = array_diff($existing_registration, $new_registration);
        $have_to_add = array_diff($new_registration, $existing_registration);
        foreach ($have_to_add as $participant_id):
            $this->registration_model->insert_registration(array('participant_id' => $participant_id, 'event_id' => $event_id));
        endforeach;
        foreach ($have_to_remove as $participant_id):
            $this->registration_model->remove_registration(array('participant_id' => $participant_id, 'event_id' => $event_id));
        endforeach;
    }

    function read($event_id) {
        if ($event_id):
            $data = (object) array();
            $data->title = 'Event';
            $data->heading = 'Event';
            $data->heading_desc = 'Event';
            $event = $this->event_model->get_a_event(array('event_id' => $event_id));
            if (!$event):
                flash_msg('info', 'Create Event first.');
                redirect(site_url('event/create'));
            endif;
            $this->get_event_organizer($event);
            $this->get_participant_types($event);
            $data->the_event = (array) $event;
            $data->urdu_name_of_organization = $this->urdu_name_of_organization($event->participants_organization);
            $data->participants_organizations = $this->get_participant_organization($event->participants_organization, unserialize($event->organization_ids));
            $data->content = 'event-single';
            $data->attendance = $this->registration_model->get_registrations(array('event_id' => $event_id));
            $this->template($data);
        else:
            flash_msg('error', 'Trying a wrong url.');
            redirect(site_url('event'));
        endif;
    }

    function active($event_id) {
        if ($event_id):
            if ($this->session->userdata('active_event') && $this->session->userdata('active_event') === $event_id):
                $this->session->unset_userdata('active_event');
                flash_msg('success', 'Event deactivated.');
            else:
                $this->session->set_userdata('active_event', $event_id);
                flash_msg('success', 'Event is activated.');
            endif;
        else:
            flash_msg('error', 'Trying a wrong url.');
        endif;
        redirect(site_url('event'));
    }

    function delete($event_id) {
        if (user_role() != 'admin'):
            flash_msg('error', 'You are not allowed for this action.');
            redirect(site_url('event'));
        endif;
        if ($event_id):
            $delete = $this->event_model->delete_event($event_id);
            if ($delete):
                flash_msg('success', 'Event removed successfully.');
            else:
                flash_msg('error', 'Error to remove event. Try again.');
            endif;
        else:
            flash_msg('error', 'Trying a wrong url.');
        endif;
        redirect(site_url('event'));
    }

    function get_selected_event_type($event_type_request = false, $ids = array()) {
        $result['status'] = true;
        $result['data'] = '';
        if (!$event_type_request):
            $event_type = $this->input->post('event_type');
        else:
            $event_type = $event_type_request;
        endif;
        if ($event_type == 'tarbiati'):
            $ideologies = $this->ideology_model->get_ideologies();
            foreach ($ideologies as $ideology):
                $result['data'] .= $this->get_event_type_html($ideology->ideology_id, $ideology->ideology_status, $ids);
            endforeach;
        elseif ($event_type == 'majlis_amomi'):
            $majlis_amomis = $this->majlis_amomi_model->get();
            foreach ($majlis_amomis as $majlis_amomi):
                $result['data'] .= $this->get_event_type_html($majlis_amomi->majlis_amomi_id, $majlis_amomi->majlis_amomi_status, $ids);
            endforeach;
        elseif ($event_type == 'dawati'):
            $propagations = $this->propagation_model->get_propagations();
            foreach ($propagations as $propagation):
                $result['data'] .= $this->get_event_type_html($propagation->propagation_id, $propagation->propagation_status, $ids);
            endforeach;
        elseif ($event_type == 'intazami'):
            $result['status'] = false;
        else:
            $result['status'] = false;
        endif;
        if ($event_type_request):
            return $result['data'];
        endif;
        echo json_encode($result);
    }

    private function get_event_type_html($id, $title, $ids) {
        $checked = '';
        if (!empty($ids) && in_array($id, $ids)):
            $checked = 'checked';
        endif;
        $html = '<div class="col-sm-3 pull-right"><label class="control-label">';
        $html .= '<input type="checkbox" class="minimal" name="event_type_ids[]" value="' . $id . '" ' . $checked . ' /> ' . $title;
        $html .= '</label></div>';
        return $html;
    }

}
