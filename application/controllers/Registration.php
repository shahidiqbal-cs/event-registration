<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('propagation_model', 'event_model', 'registration_model', 'majlis_amomi_model'));

        $this->event_id = $this->session->userdata('active_event');
        if (!is_logged()):
            redirect(site_url('login'));
        elseif (!$this->event_id):
            flash_msg('error', 'Please activate event before getting attendance.');
            redirect(site_url('event'));
        endif;
    }

    private function template($output)
    {
        $output->ideologies = $this->ideology_model->get_ideologies();
        $this->parser->parse('template', $output);
    }

    private function get_involvements($event)
    {
        $involvements = array();
        if ($event->selected_propagation && !$event->selected_ideology):
            $propagations_in_registration = $this->registration_model->get_registrations(array('event_id' => $event->event_id), 'propagation.propagation_id');
            foreach ($propagations_in_registration as $propagation):
                $values = array(
                    'id' => $propagation->propagation_id,
                    'heading' => $propagation->propagation_status,
                    'column_prefix' => 'propagation',
                );
                array_push($involvements, $values);
            endforeach;
        else:
            $ideologies_in_registration = $this->registration_model->get_registrations(array('event_id' => $event->event_id), 'ideology.ideology_id');
            foreach ($ideologies_in_registration as $ideology):
                $values = array(
                    'id' => $ideology->ideology_id,
                    'heading' => $ideology->ideology_status,
                    'column_prefix' => 'ideology',
                );
                array_push($involvements, $values);
            endforeach;
        endif;
        return $involvements;
    }

    function index()
    {
        $data = (object)array();
        $data->title = 'Attendance';
        $data->heading = 'Attendance';
        $data->heading_desc = 'Attendance';
        $data->content = 'registration_page';
        $where['event_id'] = $this->event_id;
        if ($this->input->get('ideology')):
            $where['participant.ideology_id'] = $this->input->get('ideology');
        endif;
        if ($this->input->get('city')):
            $where['city.city_id'] = $this->input->get('city');
        endif;
        if ($this->input->get('status')):
            $where['registration.registration_status'] = $this->input->get('status');
        endif;
        $data->attendance = $this->registration_model->get_registrations($where);
        $this->template($data);
    }

    function print_section($print)
    {
        $data = (object)array();
        $data->title = 'Attendance';
        $data->heading = 'Attendance';
        $data->heading_desc = 'Attendance';
        $data->content = 'registration_print';
        $where['event_id'] = $this->event_id;
        if ($print == 'present'):
            $where['registration.registration_status'] = 1;
        elseif ($print == 'absent'):
            $where['registration.registration_status'] = 0;
            $where['registration.on_leave'] = 0;
        elseif ($print == 'leave'):
            $where['registration.registration_status'] = 0;
            $where['registration.on_leave'] = 1;
        endif;
        if ($this->input->get('ideology') && !empty($this->input->get('ideology'))):
            $where['participant.ideology_id'] = $this->input->get('ideology');
        endif;
        if ($this->input->get('propagation') && !empty($this->input->get('propagation'))):
            $where['participant.propagation_id'] = $this->input->get('propagation');
        endif;
        if ($this->input->get('city') && !empty($this->input->get('city'))):
            $where['city.city_id'] = $this->input->get('city');
        endif;

        $data->attendance = $this->registration_model->get_registrations($where);
        $data->event = (array)$this->event_model->get_a_event(array('event_id' => $this->event_id));
        $data->cites = $this->organization_model->get_cities();
        $data->propagations = $this->propagation_model->get_propagations();
        $this->template($data);
    }

    function get_selected_event_type($event_type)
    {
        $result = array();
        if ($event_type == 'tarbiati'):
            $ideologies = $this->ideology_model->get_ideologies();
            foreach ($ideologies as $ideology):
                array_push($result, array('id' => $ideology->ideology_id, 'heading' => $ideology->ideology_status));
            endforeach;
        elseif ($event_type == 'majlis_amomi'):
            $majlis_amomis = $this->majlis_amomi_model->get();
            foreach ($majlis_amomis as $majlis_amomi):
                array_push($result, array('id' => $majlis_amomi->majlis_amomi_id, 'heading' => $majlis_amomi->majlis_amomi_status));
            endforeach;
        elseif ($event_type == 'dawati'):
            $propagations = $this->propagation_model->get_propagations();
            foreach ($propagations as $propagation):
                array_push($result, array('id' => $propagation->propagation_id, 'heading' => $propagation->propagation_status));
            endforeach;
        elseif ($event_type == 'intazami'):
            return false;
        else:
            return false;
        endif;
        return $result;
    }

    function group()
    {
        $data = (object)array();
        $data->title = 'Groups';
        $data->heading = 'Create groups';
        $data->heading_desc = 'Create groups';
        $event = $this->event_model->get_a_event(array('event_id' => $this->event_id));
        $involvements = $this->get_involvements($event);
        $involved_ids = array();
        foreach ($involvements as $involvement):
            array_push($involved_ids, $involvement['id']);
        endforeach;
        $event_attendance = $this->registration_model->get_registrations(array('event_id' => $this->event_id));
        $summary = array();
        $total_participant = 0;
        $total_participant_present = 0;
        foreach ($involvements as $involvement):
            $id = $involvement['id'];
            $id_column = $involvement['column_prefix'] . '_id';
            $status_column = $involvement['column_prefix'] . '_status';
            $no_of_participant = 0;
            $status = '';
            $no_of_participant_present = 0;
            foreach ($event_attendance as $attendance):
                if (in_array($attendance->$id_column, $involved_ids)):
                    if ($attendance->$id_column == $id):
                        if (!$status):
                            $status = $attendance->$status_column;
                        endif;
                        if ($attendance->registration_status):
                            $no_of_participant_present++;
                        endif;
                        $no_of_participant++;
                    endif;
                endif;
            endforeach;
            if ($no_of_participant > 0):
                $partial_summary = array(
                    'id' => $id,
                    'status' => $status,
                    'column_prefix' => $involvement['column_prefix'],
                    'total' => $no_of_participant,
                    'present' => $no_of_participant_present,
                    'absent' => ($no_of_participant - $no_of_participant_present),
                    'percentage' => ($no_of_participant != 0) ? (round(($no_of_participant_present / $no_of_participant * 100), 2)) : ''
                );
                array_push($summary, $partial_summary);
            endif;
            $total_participant += $no_of_participant;
            $total_participant_present += $no_of_participant_present;
        endforeach;
        $data->summary = $summary;
        $data->total = $total_participant;
        $data->present = $total_participant_present;
        $data->percentage = ($total_participant != 0) ? (round(($total_participant_present / $total_participant * 100), 2)) : '';
        $data->content = 'registration_create_groups';
        $data->attendance = $this->registration_model->get_registrations(array('event_id' => $this->event_id));
        $this->template($data);
    }

    function group_calculatation()
    {
        if ($this->input->post() && $this->input->post('ids')):
            $groups = array();
            $group_number = 1;
            $no_of_groups = $this->input->post('no_of_groups');
            $event = $this->event_model->get_a_event(array('event_id' => $this->event_id));
            $involvements = $this->get_involvements($event);
            foreach ($involvements as $involvement):
                if (in_array($involvement['id'], $this->input->post('ids'))):
                    $where['event_id'] = $this->event_id;
                    $where['registration_status'] = 1;
                    $where['participant.' . $involvement['column_prefix'] . '_id'] = $involvement['id'];
                    $event_attendance = $this->registration_model->get_registrations($where);
                    shuffle($event_attendance);
                    foreach ($event_attendance as $attendance):
                        $groups[$group_number][] = $attendance;
                        $group_number++;
                        if ($group_number > $no_of_groups):
                            $group_number = 1;
                        endif;
                    endforeach;
                endif;
            endforeach;
            $data = (object)array();
            $data->title = 'Groups';
            $data->heading = 'Groups';
            $data->heading_desc = 'Groups';
            $data->content = 'registration_groups';
            $data->groups = $groups;
            $data->event = (array)$this->event_model->get_a_event(array('event_id' => $this->event_id));
            $this->template($data);
        else:
            flash_msg('error', 'Choose no. of groups and ideology.');
            redirect(site_url('registration/group'));
        endif;
    }

    function update_registration_status()
    {
        $result['status'] = false;
        if ($this->session->userdata('active_event')):
            $event_id = $this->session->userdata('active_event');
            $id = $this->input->post('registration_id');
            $data['registration_status'] = $this->input->post('registration_status');
            $data['registration_time'] = date('Y-m-d G:i:s');
            $query = $this->registration_model->update_registration($data, array('registration_id' => $id));
            if ($query):
                $result['present'] = $this->registration_model->count_registration(array('registration.event_id' => $event_id, 'registration_status' => '1'));
                $result['total'] = $this->registration_model->count_registration(array('registration.event_id' => $event_id));
                if ($this->input->post('registration_status') == 1):
                    $result['time'] = date('d-M-Y g:i a', strtotime($data['registration_time']));
                else:
                    $result['time'] = '';
                endif;
                $result['status'] = true;
            endif;
        endif;
        echo json_encode($result);
    }

    function update_registration_on_leave()
    {
        $result['status'] = false;
        if ($this->session->userdata('active_event')):
            $event_id = $this->session->userdata('active_event');
            $id = $this->input->post('registration_id');
            $data['on_leave'] = $this->input->post('on_leave');
            $data['leave_date_time'] = date('Y-m-d G:i:s');
            $query = $this->registration_model->update_registration($data, array('registration_id' => $id));
            if ($query):
                $result['present'] = $this->registration_model->count_registration(array('registration.event_id' => $event_id, 'registration_status' => '1'));
                $result['total'] = $this->registration_model->count_registration(array('registration.event_id' => $event_id));
                if ($this->input->post('on_leave') == 1):
                    $result['time'] = date('d-M-Y g:i a', strtotime($data['leave_date_time']));
                else:
                    $attendance = $this->registration_model->get_a_registration(array('registration_id' => $id));
                    if ($attendance->registration_status):
                        $result['time'] = date('d-M-Y g:i a', strtotime($attendance->registration_status));
                    else:
                        $result['time'] = '';
                    endif;
                endif;
                $result['status'] = true;
            endif;
        endif;
        echo json_encode($result);
    }

    function summary()
    {
        $data = (object)array();
        $data->title = 'Summary';
        $data->heading = 'Summary';
        $data->heading_desc = 'Summary';

        $event = $this->event_model->get_a_event(array('event_id' => $this->event_id));
        $data->event = (array)$event;
        $data->summary = $this->genrate_summary($event);
        $data->content = 'registration-summary-' . $event->participants_organization;
        if ($event->participants_organization != 'zone'):
            echo 'Under Construction';
            exit(0);
        endif;
        $this->template($data);
    }

    private function summary_zone_part($zones, $query)
    {
        $summary = array();
        $half_leave_in_all = 0;
        $full_leave_in_all = 0;
        $absent_in_all = 0;
        $present_in_all = 0;
        $total_in_all = 0;
        $no_of_city = 0;
        foreach ($zones as $id):
            $ids = array();
            $cities = $this->organization_model->get_city_against_zone($id);
            foreach ($cities as $city):
                $ids[] = $city->city_id;
            endforeach;
            $child_summary = $this->summary_city_part($ids, $query);
            $half_leave = $child_summary['half_leave'];
            $full_leave = $child_summary['full_leave'];
            $absent = $child_summary['absent'];
            $present = $child_summary['present'];
            $total = $child_summary['total'];
            $object_summary = array(
                'details' => $this->organization_model->get_zone(array('zone_id' => $id)),
                'cities' => $child_summary['cities'],
                'no_of_city' => $child_summary['no_of_city'],
                'half_leave' => $half_leave,
                'full_leave' => $full_leave,
                'absent' => $absent,
                'present' => $present,
                'total' => $total
            );
            array_push($summary, $object_summary);
            $no_of_city += $child_summary['no_of_city'];
            $half_leave_in_all += $half_leave;
            $full_leave_in_all += $full_leave;
            $absent_in_all += $absent;
            $present_in_all += $present;
            $total_in_all += $total;
        endforeach;
        return array(
            'zones' => $summary,
            'no_of_city' => $no_of_city,
            'half_leave' => $half_leave_in_all,
            'full_leave' => $full_leave_in_all,
            'absent' => $absent_in_all,
            'present' => $present_in_all,
            'total' => $total_in_all
        );
    }

    private function summary_city_part($cities, $query)
    {
        $summary = array();
        $half_leave_in_all = 0;
        $full_leave_in_all = 0;
        $absent_in_all = 0;
        $present_in_all = 0;
        $total_in_all = 0;
        $query['registration.event_id'] = $this->event_id;
        foreach ($cities as $city):
            $query['city.city_id'] = $city;
            //
            //Prepay query to get on participant those are on half leave
            $query['registration.on_leave'] = 1; //On Leave
            $query['registration.registration_status'] = 1;  //Present
            $half_leave = $this->registration_model->count_registration($query);
            //End half leave query
            //
            //
            //Prepay query to get on participant those are on full leave
            $query['registration.registration_status'] = 0;  //Absent (On leave will be inherit from previous)
            $full_leave = $this->registration_model->count_registration($query);
            //End full leave query
            //
            //
            //Prepay query to get on participant those are absent
            $query['registration.on_leave'] = 0;  //not on leave (Absent will be inherit from previous)
            $absent = $this->registration_model->count_registration($query);
            //End absent query
            //
            //
            //Prepay query to get on participant those are present
            $query['registration.registration_status'] = 1;  //Present (Not on leave will be inherit from previous)
            $present = $this->registration_model->count_registration($query);
            //End present query
            //

            $total = $present + $absent + $half_leave + $full_leave; //Number of total participant
            //Summary againset single city array
            $object_summary = array(
                'details' => $this->organization_model->get_city(array('city_id' => $city)),
                'half_leave' => $half_leave,
                'full_leave' => $full_leave,
                'absent' => $absent,
                'present' => $present,
                'total' => $total
            );
            array_push($summary, $object_summary);
            $half_leave_in_all += $half_leave;
            $full_leave_in_all += $full_leave;
            $absent_in_all += $absent;
            $present_in_all += $present;
            $total_in_all += $total;
        endforeach;
        return array(
            'cities' => $summary,
            'no_of_city' => count($cities),
            'half_leave' => $half_leave_in_all,
            'full_leave' => $full_leave_in_all,
            'absent' => $absent_in_all,
            'present' => $present_in_all,
            'total' => $total_in_all
        );
    }

    private function summary_halqa_part($halqas, $query)
    {
        $summary = array();
        $half_leave_in_all = 0;
        $full_leave_in_all = 0;
        $absent_in_all = 0;
        $present_in_all = 0;
        $total_in_all = 0;
        $query['registration.event_id'] = $this->event_id;
        foreach ($halqas as $halqa):
            $query['halqa.halqa_id'] = $halqa;
            //
            //Prepay query to get on participant those are on half leave
            $query['registration.on_leave'] = 1; //On Leave
            $query['registration.registration_status'] = 1;  //Present
            $half_leave = $this->registration_model->count_registration($query);
            //End half leave query
            //
            //
            //Prepay query to get on participant those are on full leave
            $query['registration.registration_status'] = 0;  //Absent (On leave will be inherit from previous)
            $full_leave = $this->registration_model->count_registration($query);
            //End full leave query
            //
            //
            //Prepay query to get on participant those are absent
            $query['registration.on_leave'] = 0;  //not on leave (Absent will be inherit from previous)
            $absent = $this->registration_model->count_registration($query);
            //End absent query
            //
            //
            //Prepay query to get on participant those are present
            $query['registration.registration_status'] = 1;  //Present (Not on leave will be inherit from previous)
            $present = $this->registration_model->count_registration($query);
            //End present query
            //

            $total = $present + $absent + $half_leave + $full_leave; //Number of total participant
            //Summary againset single halqa array
            $object_summary = array(
                'details' => $this->organization_model->get_halqa(array('halqa_id' => $halqa)),
                'half_leave' => $half_leave,
                'full_leave' => $full_leave,
                'absent' => $absent,
                'present' => $present,
                'total' => $total
            );
            array_push($summary, $object_summary);
            $half_leave_in_all += $half_leave;
            $full_leave_in_all += $full_leave;
            $absent_in_all += $absent;
            $present_in_all += $present;
            $total_in_all += $total;
        endforeach;
        return array(
            'halqas' => $summary,
            'no_of_halqa' => count($halqas),
            'half_leave' => $half_leave_in_all,
            'full_leave' => $full_leave_in_all,
            'absent' => $absent_in_all,
            'present' => $present_in_all,
            'total' => $total_in_all
        );
    }

    private function genrate_summary($event)
    {
        $summary = array();
        $involvements = $this->get_involvements($event);

        $participants_organization = $event->participants_organization;
        $organization_ids = unserialize($event->organization_ids);

        //Main Loop for ideologies (Will create array index(s) on base of ideologies)
        foreach ($involvements as $element):
            $common_query_condition['participant.' . $element['column_prefix'] . '_id'] = $element['id']; //Query building to specify the ideology_id(Sirkel,forum,jaizapas..etc)

            if ($participants_organization == 'city'):
                $sub_summary = $this->summary_city_part($organization_ids, $common_query_condition);
            elseif ($participants_organization == 'zone'):
                $sub_summary = $this->summary_zone_part($organization_ids, $common_query_condition);
            else:
                flash_msg('error', 'Something going wrong.');
                redirect(site_url('event'));
            endif;

            $sub_summary['event_type_heading'] = $element['heading'];
            array_push($summary, $sub_summary); //Pushing sub summary into main summary
        endforeach; //End main loop for ideologies
        return $summary;
    }

    function badge()
    {
        $data = (object)array();
        $data->title = 'Badges';
        $data->heading = 'Badges';
        $data->heading_desc = 'Badges';
        if ($this->form_validation->run('badges') == FALSE) :
            $data->content = 'registration_badges_form';
        else:
            $where = array();
            $where['registration.event_id'] = array($this->event_id);
            $data->badge_header = $this->input->post('badge_header');
            $data->badge_sub_heading = $this->input->post('badge_sub_heading');
            $data->badge_footer = $this->input->post('badge_footer');
            $data->badge_for = $this->input->post('badge_for');
            $data->custom_ids = $this->input->post('custom_ids');
            if ($data->badge_for == 'present'):
                $where['registration.registration_status'] = array(1);
            elseif ($data->badge_for == 'custom'):
                $where['registration.participant_id'] = array_filter(array_unique(array_map('trim', explode(',', $data->custom_ids))));
            endif;
            $data->content = 'registration_badges';
            $data->badges = $this->registration_model->registration_badges($where);
        endif;
        $this->template($data);
    }

    function export_registration($status)
    {
        $where['registration.event_id'] = $this->event_id;
        if ($status == 'present'):
            $where['registration.registration_status'] = 1;
        elseif ($status == 'absent'):
            $where['registration.registration_status'] = 0;
        elseif ($status == 'leave'):
            $where['registration.registration_status'] = 0;
            $where['registration.on_leave'] = 1;
        else:
            echo 'Under Construction';
            exit(0);
        endif;

        $columns = array(
            lang('number_count'),
            lang('name'),
            lang('father_name'),
            lang('ideology_status'),
            lang('zone'),
            lang('city'),
            lang('attendance'),
            lang('arrival_time')
        );
        $data_to_export = array();
        array_push($data_to_export, $columns);
        $registrations = $this->registration_model->get_registrations($where);
        foreach ($registrations as $key => $registration):
            $registration_status = ($registration->registration_status) ? lang('present') : lang('absent');
            $arrivel_time = ($registration->registration_status) ? date('h:i A', strtotime($registration->registration_time)) : '';
            $participant_details = array(
                $key + 1,
                $registration->name,
                $registration->father_name,
                $registration->ideology_status,
                $registration->zone_name,
                $registration->city_name,
                $registration_status,
                $arrivel_time
            );

            array_push($data_to_export, $participant_details);
        endforeach;
        $file_name = $status;
        $heading = $status . ' list';
//        echo '<pre>';
//        print_r($data_to_export);
//        exit(0);
        $this->create_excel_file($data_to_export, $heading, count($columns), $file_name);
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
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A3');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
    }

    function delete($id)
    {
        $remove = $this->registration_model->remove_registration(array('registration_id' => $id, 'event_id' => $this->event_id));
        if ($remove):
            flash_msg('success', 'Removed successfully.');
        else:
            flash_msg('error', 'Not exists or may be something wrong.');
        endif;
        $url = $this->input->get('url');
        if ($url):
            redirect($url);
        else:
            redirect(site_url('registration'));
        endif;
    }

    function manual_entry($participant_id)
    {
        $participant = $this->registration_model->get_a_registration(array('event_id' => $this->event_id, 'participant_id' => $participant_id));

        if ($participant):
            flash_msg('error', 'Already exists.');
        else:
            if (!$this->check_participant_belong_to_event($participant_id)) :
                flash_msg('error', 'This participant not belongs to this event.');
            else:
                $data['event_id'] = $this->event_id;
                $data['participant_id'] = $participant_id;
                $data['registration_status'] = 1;
                $data['registration_time'] = date('Y-m-d G:i:s');
                $new_entry = $this->registration_model->insert_registration($data);
                if ($new_entry):
                    flash_msg('success', 'Enter successfully and mark as present.');
                else:
                    flash_msg('error', 'Error in entry. Please try again.');
                endif;
            endif;
        endif;
        redirect('participant');
    }

    private function check_participant_belong_to_event($participant_id)
    {
        $event = $this->event_model->get_a_event(array('event_id' => $this->event_id));
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

    function sms()
    {
        $data = (object)array();
        $data->title = 'SMS Summary';
        $data->heading = 'SMS Summary';
        $data->heading_desc = 'SMS Summary';
        $data->content = 'registration_sms_summary';
        $data->numbers = $this->db->get('numbers')->result();
        if ($this->form_validation->run('sms') == FALSE) :
            $this->template($data);
        else:
            $tanzeem = $this->input->post('tanzeem');
            $number = $this->input->post('number');
            $marge_jaizapass = $this->input->post('marge_jaizapass');
            $this->create_sms_summary($tanzeem, $number, $marge_jaizapass);
        endif;
    }

    function create_sms_summary($orgnization, $number, $marge)
    {
        $message_heading = '';
        $tanzeem = 'city';
        $tanzeem_id = 0;
        switch ($orgnization) {
            case 'overall':
                $message_heading = 'Overall Summary';
                $tanzeem = 'all';
                $tanzeem_id = 0;
                break;
            case 'combine':
                $message_heading = 'Overall Summary';
                $tanzeem_id = 0;
                break;
            case 'bwp_zone':
                $message_heading = 'Bahawalpur Zone';
                $tanzeem = 'zone';
                $tanzeem_id = 1;
                break;
            case 'iub':
                $message_heading = 'IUB Tanzeem';
                $tanzeem = 'zone';
                $tanzeem_id = 2;
                break;
            case 'wasti':
                $message_heading = 'Wasti Shehri Tanzeem';
                $tanzeem_id = 1;
                break;
            case 'gharbi':
                $message_heading = 'Gharbi Shehri Tanzeem';
                $tanzeem_id = 2;
                break;
            case 'sharqi':
                $message_heading = 'Sharqi Shehri Tanzeem';
                $tanzeem_id = 3;
                break;
            case 'miscellaneous':
                $message_heading = 'Degar';
                $tanzeem_id = 5;
                break;
            case 'hasilpur':
                $message_heading = 'Hasilpur Tanzeem';
                $tanzeem_id = 9;
                break;
            default:
                exit(0);
        }

        $event = $this->event_model->get_a_event(array('event_id' => $this->event_id));
        $message = "";
        $message .= $message_heading;
        $message .= "\r\n";
        $message .= "Date: " . $event->event_date;
        $message .= "\r\n";
        $message .= $event->event_name;
        $message .= "\r\n";
        if ($orgnization == 'combine'):
            $registration_orgnizations = $this->registration_model->get_registrations(array('event_id' => $this->event_id), 'city.city_id');
            foreach ($registration_orgnizations as $registration):
                $registration->city_id;
                $message .= $registration->city_name_english;
                $message .= "\r\n";
                $message .= $this->report_message($this->summary_report($tanzeem, $registration->city_id), true);
                $message .= "\r\n";
            endforeach;
//            echo str_replace("\r\n","<br>",$message);
//            exit(0);
        else:
            $message .= $this->report_message($this->summary_report($tanzeem, $tanzeem_id), $marge);
        endif;


        $result = $this->send($message, $number);
        if ($result['status'] == 200):
            flash_msg('success', 'Message send to server successfully.');
            flash_msg('message', $message);
        else:
            flash_msg('error', 'Fail to send sms. Please try again.');
        endif;
        redirect(site_url('registration/sms'));
    }

    private function summary_report($tanzeem, $id)
    {
        return array(
            'invited' => $this->report_result($tanzeem, $id),
            'present' => $this->report_result($tanzeem, $id, true)
        );
    }


    private function report_result($report, $id, $only_present = false)
    {
        $result = [];
        if ($only_present) {
            $where['registration.registration_status'] = 1;
        }
        if ($report == 'city'):
            $where['city.city_id'] = $id;
        elseif ($report == 'zone'):
            $where['zone.zone_id'] = $id;
        endif;
        $where['registration.event_id'] = $this->event_id;
        $where['ideology.ideology_id'] = 2; //Mohazir Sirkel
        $result['mohazir_sirkel'] = $this->registration_model->count_registration($where); //Total Mohzir sirkel
        $where['ideology.ideology_id'] = 3; //Mohazir Forum
        $result['mohazir_forum'] = $this->registration_model->count_registration($where); //Total Mohzir forum
        $where['ideology.ideology_id'] = 4; //JaizaPass
        $result['jaizapass'] = $this->registration_model->count_registration($where); //Total JaizaPass
        $where['ideology.ideology_id'] = 5; //Sirkel
        $result['sirkel'] = $this->registration_model->count_registration($where); //Total Sirkel
        $result['total_jaizapass'] = $result['mohazir_sirkel'] + $result['mohazir_forum'] + $result['jaizapass'];
        $result['total'] = $result['total_jaizapass'] + $result['sirkel'];
        return $result;
    }

    private function report_message($report, $combine = false)
    {
        $message = "";
        if ($combine):
            $message .= "JaizaPass: " . $report['present']['total_jaizapass'] . "/" . $report['invited']['total_jaizapass'];
        else:
            $message .= "Mohazir Sirkle: " . $report['present']['mohazir_sirkel'] . "/" . $report['invited']['mohazir_sirkel'];
            $message .= "\r\n";
            $message .= "Mohazir Forum: " . $report['present']['mohazir_forum'] . "/" . $report['invited']['mohazir_forum'];
            $message .= "\r\n";
            $message .= "JaizaPass: " . $report['present']['jaizapass'] . "/" . $report['invited']['jaizapass'];
        endif;
        $message .= "\r\n";
        $message .= "Sirkel: " . $report['present']['sirkel'] . "/" . $report['invited']['sirkel'];
        $message .= "\r\n";
        $message .= "Total: " . $report['present']['total'] . "/" . $report['invited']['total'];
        $message .= "\r\n";
        return $message;
    }

    private function send($message, $number)
    {
        $this->load->library('smsGateway');
        $smsGateway = new SmsGateway();
        $deviceID = 35498;
        $options = [];
        $message_length = 150*3;
        if (strlen($message) > $message_length) {
            $smsGateway->sendMessageToNumber($number, substr($message, 0, ($message_length-1)), $deviceID, $options);
            $this->send(substr($message, 0, ($message_length-1)), $number);
        }
        return $smsGateway->sendMessageToNumber($number, $message, $deviceID, $options);

//        $numbers = ['+923038753386'];
//        return $smsGateway->sendMessageToManyNumbers($numbers, $message, $deviceID, $options);
    }

}
