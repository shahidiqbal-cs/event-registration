<?php

$config = array(
    'login' => array(
        array(
            'field' => 'user_name',
            'label' => 'Username',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|md5'
        ),
    ),
    'participant' => array(
        array(
            'field' => 'name',
            'label' => 'Participant Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'participant_email',
            'label' => 'Email',
            'rules' => 'trim|valid_email'
        ),
        array(
            'field' => 'ideology_id',
            'label' => 'Ideology Status',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'propagation_id',
            'label' => 'Propagation Status',
            'rules' => 'trim|required'
        ),
    ),
    'export_participant' => array(
        array(
            'field' => 'ideologies[]',
            'label' => 'Ideology',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'propagation[]',
            'label' => 'Propagation',
            'rules' => 'trim|required'
        ),
    ),
    'participant_trash' => array(
        array(
            'field' => 'participant_status',
            'label' => 'status',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'participant_status_text',
            'label' => 'status',
            'rules' => 'trim|required'
        ),
    ),
    'event' => array(
        array(
            'field' => 'event_name',
            'label' => 'Event Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'event_date',
            'label' => 'Date',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'event_location',
            'label' => 'Location',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'organizer_id',
            'label' => 'Organizer',
            'rules' => 'trim|required'
        ),
//        array(
//            'field' => 'event_type',
//            'label' => 'event type',
//            'rules' => 'trim|required'
//        ),
//        array(
//            'field' => 'event_type_ids[]',
//            'label' => 'Dawati haisiat',
//            'rules' => 'trim|required'
//        )
    ),
    'badges' => array(
        array(
            'field' => 'badge_header',
            'label' => 'Badge Header',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'badge_footer',
            'label' => 'Badge Footer',
            'rules' => 'trim|required'
        )
    ),
    'organization' => array(
        array(
            'field' => 'organization_name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'organization_parent',
            'label' => 'Name',
            'rules' => 'trim|required'
        )
    ),
    'ideology' => array(
        array(
            'field' => 'ideology_status',
            'label' => 'Status',
            'rules' => 'trim|required'
        )
    ),
    'event_title' => array(
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required'
        )
    ),
    'feedback' => array(
        array(
            'field' => 'feedbacker_name',
            'label' => 'name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'feedback_type',
            'label' => 'Type',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'feedback',
            'label' => 'feedback',
            'rules' => 'trim|required'
        )
    )
);
?>