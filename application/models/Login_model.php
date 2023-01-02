<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
    protected $username;
    protected $password;

    public function __construct()
    {
        parent::__construct();
    }

    public function login($username = '', $password = '')
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function is_user_exist()
    {
        $username = $this->username;

        $check = $this->db
            ->where('email', $username)
            ->get('user')
            ->num_rows();

        return ($check > 0) ? TRUE : FALSE;
    }

    protected function _get($row = '')
    {
        $username = $this->username;

        $field = $this->db
            ->select($row)
            ->where('email', $username)
            ->get('user')
            ->row()
            ->$row;

        return $field;
    }

    public function get_role()
    {
        return $this->_get('role');
    }

    public function get_password()
    {
        return $this->_get('password');
    }

    public function logged_user_id()
    {
        return $this->_get('id');
    }


}
