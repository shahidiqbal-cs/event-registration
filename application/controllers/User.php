<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('user_model'));
    }

    function login() {
        if (is_logged()):
            redirect(site_url());
        endif;
        if ($this->form_validation->run('login') == FALSE) :
            $this->load->view('login');
        else:
            $login_data ['user_name'] = $this->input->post('user_name');
            $login_data ['user_password'] = $this->input->post('password');
            $user = $this->user_model->get_user($login_data);
            if ($user) :
                $userId = $user->user_id;
                $name = $user->user_name;
                $user_role = $user->user_role;
                logged_in_user($userId, $name, $user_role);
            else:
                flash_msg('error', 'Wrong user name/password');
            endif;
            redirect(current_url());
        endif;
    }

    function logout() {
        logout();
        redirect(site_url());
    }

}
