<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Participant extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('propagation_model', 'majlis_amomi_model', 'registration_model', 'event_model'));
        if (!is_logged()):
            redirect(site_url('login'));
        endif;
    }

    private function template($output)
    {
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

    private function initialize_participant($data)
    {
        if ($this->input->post()):
            $data->name = set_value('name');
            $data->fname = set_value('father_name');
            $data->email = set_value('participant_email');
            $data->participant_no = set_value('participant_no');
            $data->cnic = set_value('participant_cnic');
//            $data->temp_address = set_value('temp_address');
//            $data->permanent_address = set_value('permanent_address');
            $data->ideology_id = set_value('ideology_id');
            $data->propagation_id = set_value('propagation_id');
            $data->administrative_status = set_value('administrative_status');
            $data->majlis_amomi_id = set_value('majlis_amomi_id');
            $data->zone_id = set_value('zone_id');
            $data->city_id = set_value('city_id');
            $data->blood_group = set_value('blood_group');
        endif;
        $data->content = 'participant-form';
        $data->propagations = $this->propagation_model->get_propagations();
        $data->majlis_amomis = $this->majlis_amomi_model->get();
        $data->zones = $this->organization_model->get_zones();
        $data->cites = $this->organization_model->get_city_against_zone($data->zone_id);
    }

    function index()
    {
        $data = (object)array();
        $data->title = 'Participants';
        $data->heading = 'Participants';
        $data->heading_desc = 'Participants';
        $data->content = 'participants';
        if ($this->input->get('ideology') && !empty($this->input->get('ideology'))):
            $where['participant.ideology_id'] = $this->input->get('ideology');
        endif;
        if ($this->input->get('propagation') && !empty($this->input->get('propagation'))):
            $where['participant.propagation_id'] = $this->input->get('propagation');
        endif;
        if ($this->input->get('city') && !empty($this->input->get('city'))):
            $where['city.city_id'] = $this->input->get('city');
        endif;
        $where['participant.participant_status'] = 1;
        $data->cites = $this->organization_model->get_cities();

        $data->propagations = $this->propagation_model->get_propagations();
        $data->participants = $this->participant_model->get_participants($where);
        $this->template($data);
    }

//CRUD
    function create()
    {
        if ($this->form_validation->run('participant') == FALSE) :
            $data = (object)array();
            $data->title = 'Add new participant';
            $data->heading = 'Add new participant';
            $data->heading_desc = 'Add new participant';
            ///////////////// User data strings /////////////////
            $data->participant_id = '';
            $data->name = '';
            $data->fname = '';
            $data->email = '';
            $data->participant_no = '';
            $data->cnic = '';
            $data->ideology_id = '';
            $data->propagation_id = '';
            $data->majlis_amomi_id = 0;
            $data->administrative_status = '';
            $data->blood_group = '';
            $zones = $this->organization_model->get_zones();
            $data->zone_id = count($zones) ? $zones[0]->zone_id : '';
            $cites = $this->organization_model->get_city_against_zone($data->zone_id);
            $data->city_id = count($cites) ? $cites[0]->city_id : '';
            $this->initialize_participant($data);
            ///////////////// User data strings /////////////////
            $this->template($data);
        else:
            $participantData = $this->input->post();
            unset($participantData['zone_id']);
            unset($participantData['add_to_current_event']);
            $register = $this->participant_model->register_participant($participantData);
            if ($register):
                if ($this->session->userdata('active_event') && $this->input->post('add_to_current_event')):
                    $participant_id = $this->participant_model->last_id();
                    $event_id = $this->session->userdata('active_event');
                    if ($this->check_participant_belong_to_event($participant_id, $event_id)):
                        $event_entry['event_id'] = $event_id;
                        $event_entry['participant_id'] = $participant_id;
                        $event_entry['registration_status'] = 1;
                        $event_entry['registration_time'] = date('Y-m-d G:i:s');
                        if ($this->registration_model->insert_registration($event_entry)):
                            flash_msg('success', 'Participant added successfully and mark as present in current event.');
                        else:
                            flash_msg('success', 'Participant added successfully. But failed to add in event.');
                        endif;
                    else:
                        flash_msg('success', 'Participant added successfully. But participant not belog to this event.');
                    endif;
                else:
                    flash_msg('success', 'Participant added successfully.');
                endif;
            else:
                flash_msg('error', 'Error to add new participant. Try again.');
            endif;
            redirect(site_url('participant/create'));
        endif;
    }

    function read($participant_id)
    {
        if ($participant_id):
            $data = (object)array();
            $data->title = 'Participant';
            $data->heading = 'Participant';
            $data->heading_desc = 'Participant';
            $participant = $this->participant_model->get_a_participant(array('participant_id' => $participant_id));
            $data->the_participant = (array)$participant;
            $data->content = 'participant-single';
            $this->template($data);
        else:
            flash_msg('error', 'Trying a wrong url.');
            redirect(site_url('participant'));
        endif;
    }

    function update($participant_id)
    {
        if ($participant_id):
            if ($this->form_validation->run('participant') == FALSE) :
                ///////////////// User data strings /////////////////
                $data = (object)array();
                $data->title = 'Participant';
                $data->heading = 'Participant';
                $data->heading_desc = 'Participant';
                $participant = $this->participant_model->get_a_participant(array('participant_id' => $participant_id));
                $data->the_participant = (array)$participant;
                $data->participant_id = $participant->participant_id;
                $data->name = $participant->name;
                $data->fname = $participant->father_name;
                $data->email = $participant->participant_email;
                $data->participant_no = $participant->participant_no;
                $data->cnic = $participant->participant_cnic;
                $data->ideology_id = $participant->ideology_id;
                $data->propagation_id = $participant->propagation_id;
                $data->majlis_amomi_id = $participant->majlis_amomi_id;
                $data->administrative_status = $participant->administrative_status;
                $data->zone_id = $participant->zone_id;
                $data->city_id = $participant->city_id;
                $data->blood_group = $participant->blood_group;
                $this->initialize_participant($data);
                $this->template($data);
            else:
                $participantData = $this->input->post();
                unset($participantData['zone_id']);
                $updateParticipant = $this->participant_model->update_participant($participantData, array('participant_id' => $participant_id));
                if ($updateParticipant):
                    flash_msg('success', 'Participant updated successfully.');
                else:
                    flash_msg('error', 'Error to update participant. Try again.');
                endif;
                redirect(current_url());
            endif;
        else:
            flash_msg('error', 'Trying a wrong url.');
            redirect(site_url('participant'));
        endif;
    }

    function delete($participant_id)
    {
        if ($participant_id):
            $delete_participant_data = array('participant_status' => 0, 'participant_status_text' => 'drop');
            $updateParticipant = $this->participant_model->update_participant($delete_participant_data, array('participant_id' => $participant_id));
            if ($updateParticipant):
                flash_msg('success', 'Participant removed successfully.');
            else:
                flash_msg('error', 'Error to remove participant. Try again.');
            endif;
        else:
            flash_msg('error', 'Trying a wrong url.');
        endif;
        redirect(site_url('participant'));
    }

    function export()
    {
        if ($this->form_validation->run('export_participant') == FALSE) :
            $data = (object)array();
            $data->title = 'Export';
            $data->heading = 'Export';
            $data->heading_desc = 'Export';
            $data->content = 'participant-export';
            $data->ideologies = $this->ideology_model->get_ideologies();
            $data->propagations = $this->propagation_model->get_propagations();
            $data->zones = $this->organization_model->get_zones();
            $this->template($data);
        else:
            $allPossibleColumns = array(
                'participant.participant_id' => 'ID',
                'participant.name' => lang('name'),
                'participant.father_name' => lang('father_name'),
                'ideology.ideology_status' => lang('ideology_status'),
                'propagation.propagation_status' => lang('propagation_status'),
                'participant.administrative_status' => lang('administrative_status'),
                'majlis_amomi.majlis_amomi_status' => lang('majlis_amomi'),
                'zone.zone_name' => lang('zone'),
                'city.city_name' => lang('city'),
                'participant.participant_no' => lang('contact_number'),
                'participant.participant_email' => lang('email'),
                'participant.blood_group' => lang('blood') . ' ' . lang('group'),
                'participant.participant_cnic' => lang('cnic')
            );
            $select = '';
            $readAbleColumns = array(lang('number_count'));
            $query_array = array();
            $query_array['participant.participant_status'] = array(1);
            $exportcolumns = $this->input->post('exportcolumns');

            foreach ($exportcolumns as $key => $column):
                array_push($readAbleColumns, strtr($column, $allPossibleColumns));
                if ($key != 0):
                    $select .= ', ';
                endif;
                $select .= $column;
            endforeach;
            $ideologies = $this->input->post('ideologies');
            $propagation = $this->input->post('propagation');
            $zone = $this->input->post('zone');
            $city = $this->input->post('city');
            $query_array['participant.ideology_id'] = $ideologies;
            $query_array['participant.propagation_id'] = $propagation;
            if ($zone == 'custom'):
                if ($city == 'custom'):
                    $custom_city = $this->input->post('custom_city');
                    $query_array['city.city_id'] = $custom_city;
                else:
                    $custom_zone = $this->input->post('custom_zone');
                    $query_array['zone.zone_id'] = $custom_zone;
                endif;
            endif;
            $participant_data = $this->participant_model->get_participants_for_export_data($query_array, $select);
            if (!$participant_data):
                flash_msg('error', 'Something went wrong. Contact admin.');
                redirect(site_url('export'));
            endif;
            $data_to_export = array();
            array_push($data_to_export, $readAbleColumns);

            foreach ($participant_data as $key => $participant):
                $participant_details = array();

                array_push($participant_details, $key + 1);
                foreach ($exportcolumns as $column):
                    $prefix_and_column = explode('.', $column);
                    $col = $prefix_and_column[1];
                    array_push($participant_details, $participant->$col);
                endforeach;
                array_push($data_to_export, $participant_details);
            endforeach;
            $file_name = 'Participant';
            $this->create_excel_file($data_to_export, lang('participant'), count($exportcolumns), $file_name);
        endif;
    }

    function create_excel_file($data, $heading, $no_of_column, $file_name, $active_sheet_index = 0, $rtl_direction = true)
    {
        $creator_name = 'tfw';
        /*
         * ************************ Header Setting *************************
         */
        // Redirect output to a client's web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $file_name . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        /*
         * ************************ Header Setting *************************
         */

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator($creator_name)
            ->setLastModifiedBy($creator_name)
            ->setTitle($file_name)
            ->setSubject($file_name)
            ->setDescription($file_name)
            ->setKeywords($file_name)
            ->setCategory($file_name); // Set document properties
        $objPHPExcel->setActiveSheetIndex($active_sheet_index); // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->getActiveSheet()->setRightToLeft($rtl_direction); // Right-to-left worksheet
        $objPHPExcel->getActiveSheet()->setTitle($file_name); // Rename worksheet
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $heading);
        //$objPHPExcel->getActiveSheet()->setCellValue('A1', $heading);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A3');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
    }

    private function check_participant_belong_to_event($participant_id, $event_id)
    {
        $event = $this->event_model->get_a_event(array('event_id' => $event_id));
        $participant = $this->participant_model->get_a_participant(array('participant_id' => $participant_id));
        if ($event->selected_ideology && in_array($participant->ideology_id, unserialize($event->selected_ideology))):
            return true;
        endif;
        if ($event->selected_propagation && in_array($participant->propagation_id, unserialize($event->selected_propagation))):
            return true;
        endif;
        if ($event->selected_majlis_amomi && in_array($participant->majlis_amomi_id, unserialize($event->selected_majlis_amomi))):
            return true;
        endif;
        if ($event->selected_intazamia && in_array($participant->intazami_id, unserialize($event->selected_intazamia))):
            return true;
        endif;
        return false;
    }

    function trash()
    {
        $data = (object)array();
        $data->title = 'Participants';
        $data->heading = 'Participants';
        $data->heading_desc = 'Participants';
        $data->content = 'participants-trash';
        if ($this->input->get('ideology') && !empty($this->input->get('ideology'))):
            $where['participant.ideology_id'] = $this->input->get('ideology');
        endif;
        if ($this->input->get('propagation') && !empty($this->input->get('propagation'))):
            $where['participant.propagation_id'] = $this->input->get('propagation');
        endif;
        if ($this->input->get('city') && !empty($this->input->get('city'))):
            $where['city.city_id'] = $this->input->get('city');
        endif;
        $where['participant.participant_status'] = 0;
        $data->cites = $this->organization_model->get_cities();

        $data->propagations = $this->propagation_model->get_propagations();
        $data->participants = $this->participant_model->get_participants($where);
        $this->template($data);
    }

    function trash_update($participant_id)
    {
        if ($participant_id):
            if ($this->form_validation->run('participant_trash') == FALSE) :
                $data = (object)array();
                $data->title = 'Participants';
                $data->heading = 'Participants';
                $data->heading_desc = 'Participants';
                $data->content = 'participants-trash-form';
                $participant = $this->participant_model->get_a_participant(array('participant_id' => $participant_id));
                $data->participant = (array)$participant;
                $this->template($data);
            else:
                $trash_update = $this->input->post();
                if ($trash_update['participant_status']):
                    $trash_update['participant_status_text'] = '';
                    $trash_update['comments'] = '';
                endif;
                if ($this->participant_model->update_participant($trash_update, array('participant_id' => $participant_id))):
                    flash_msg('success', 'Request completed successfully.');
                else:
                    flash_msg('error', 'Fail to update. Contact admin.');
                endif;
                redirect(site_url('participant/trash'));
            endif;
        else:
            flash_msg('error', 'Trying a wrong url.');
            redirect(site_url('participant/trash'));
        endif;
    }

    function trash_delete($participant_id)
    {
        if ($participant_id):
            if ($this->registration_model->remove_registration(array('participant_id' => $participant_id)) && $this->participant_model->delete_participant($participant_id)):
                flash_msg('success', 'Participant data erased from database.');
            else:
                flash_msg('error', 'Fail to delete data. Try again or contact admin.');
            endif;
        else:
            flash_msg('error', 'Trying a wrong url.');
        endif;
        redirect(site_url('participant/trash'));
    }

}
