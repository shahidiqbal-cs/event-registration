<?php

//is_logged     true
//user_role     return user role
//user_id       user'id
//user_name     user's name
//logged_in_user--Create user's session
//** @param     1.userid,   2.name,     3.user_role
//flash_msg     create flash msg
//** @param     1.alertType,   2.msg
//logout        Destroy session
if (!function_exists('is_logged')) {

    function is_logged() {
        $CI = & get_instance();
        $is_logged = $CI->session->userdata('user_id');
        if (isset($is_logged) && $is_logged != '') {
            return true;
        } else {
            return false;
        }
    }

}
if (!function_exists('user_id')) {

    function user_id() {
        $CI = & get_instance();
        $user_id = $CI->session->userdata('user_id');
        if (isset($user_id) && $user_id != '') {
            return $user_id;
        } else {
            return false;
        }
    }

}
if (!function_exists('user_name')) {

    function user_name() {
        $CI = & get_instance();
        $user_name = $CI->session->userdata('user_name');
        if (isset($user_name) && $user_name != '') {
            return $user_name;
        } else {
            return false;
        }
    }

}
if (!function_exists('user_role')) {

    function user_role() {
        $CI = & get_instance();
        $user_role = $CI->session->userdata('user_role');
        return $user_role;
    }

}
if (!function_exists('logged_in_user')) {

    function logged_in_user($userId = '', $name = '', $user_role) {
        $CI = & get_instance();
        $data['user_id'] = $userId;
        $data['user_name'] = $name;
        $data['user_role'] = $user_role;
        $CI->session->set_userdata($data);
    }

}
if (!function_exists('flash_msg')) {

    function flash_msg($alertType = 'info', $msg = '') {
        $CI = & get_instance();
        $CI->session->set_flashdata($alertType, $msg);
    }

}
if (!function_exists('logout')) {

    function logout() {
        $CI = & get_instance();
        $CI->session->sess_destroy();
    }

}
?>