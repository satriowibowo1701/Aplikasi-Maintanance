<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('init')) {
    function init()
    {
        $CI = &get_instance();
        return $CI;
    }
}

if (!function_exists('user_data')) {
    function user_data()
    {
        $CI = init();
        $user_id = get_current_user_id();
        $user_data = $CI->db->where('id', $user_id)->get('user')->row();
        return $user_data;
    }
}

if (!function_exists('session_data')) {
    function session_data()
    {
        $CI = init();


        $read_session_in_session = $CI->session->userdata('__ACTIVE_SESSION_DATA');

        if ($read_session_in_session) {

            $read_data = json_decode($read_session_in_session);
            return $read_data;
        } else {
            $default_session = new stdClass();
            $default_session->is_login = FALSE;
            $default_session->user_id = 0;
            $default_session->login_at = 0;
            $default_session->remember_me = FALSE;
            return $default_session;
        }
    }
}

if (!function_exists('is_login')) {
    function is_login()
    {
        $login_data = session_data();

        return ($login_data->is_login === TRUE);
    }
}

if (!function_exists('get_current_user_id')) {
    function get_current_user_id()
    {
        $login_data = session_data();

        return $login_data->user_id;
    }
}

if (!function_exists('get_user_mesin')) {
    function get_user_mesin()
    {
        $login_data = user_data();
        return $login_data->mesin;
    }
}

if (!function_exists('verify_session')) {
    function verify_session($what_to_verify)
    {
        if (!is_login()) {
            redirect('auth');
        } else if ($what_to_verify == 'Admin') {
            if (!is_admin()) {
                redirect('auth');
            }
        } else if ($what_to_verify == 'Operator') {
            if (!is_operator()) {
                redirect('auth');
            }
        }
        else if ($what_to_verify == 'Direktur') {
            if (!is_direktur()) {
                redirect('auth');
            }
        }
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        $user_data = user_data();
        $role = $user_data->role;

        return ($role == 'Admin');
    }
}

if (!function_exists('is_operator')) {
    function is_operator()
    {
        $user_data = user_data();
        $role = $user_data->role;

        return ($role == 'Operator');
    }
}

if (!function_exists('is_direktur')) {
    function is_direktur()
    {
        $user_data = user_data();
        $role = $user_data->role;

        return ($role == 'Direktur');
    }
}
