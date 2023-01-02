<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('Login_model', 'login');
	}
	public function index()
	{
		$params['flash_message'] = $this->session->flashdata('login_flash');
		$params['old_username'] = $this->session->flashdata('old_username');
		$this->load->view('header');
		$this->load->view('login', $params);
		$this->load->view('footer');
	}

	public function do_login()
	{
		$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

		$this->form_validation->set_rules('email', 'Username', 'required', [
			'required' => 'Silahkan masukkan Email untuk login'
		]);
		$this->form_validation->set_rules('password', 'Password', 'required', [
			'required' => 'Silahkan masukkan Password akun'
		]);

		if ($this->form_validation->run() === FALSE) {
			$this->index();
		} else {
			$username = $this->input->post('email');
			$password = $this->input->post('password');

			$this->login->login($username, $password);

			if ($this->login->is_user_exist()) {
				$user_password = $this->login->get_password();

				if (password_verify($password, $user_password)) {
					$login_data = [
						'is_login' => TRUE,
						'user_id' => $this->login->logged_user_id(),
						'login_at' => time(),
					];
					$login_data = json_encode($login_data);
					$role = $this->login->get_role();
					$redir_to = ($role == 'Admin') ? 'admin' : (($role == 'Operator') ? 'operator' :'direktur');
					$this->session->set_userdata('__ACTIVE_SESSION_DATA', $login_data);
					redirect($redir_to);
				} else {
					$this->session->set_flashdata('login_flash', 'Password salah!');
					$this->session->set_flashdata('old_username', $username);

					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('login_flash', 'User dengan username <b>' . $username . '</b> tidak terdaftar');
				redirect('auth');
			}
		}
	}


	public function do_logout()
	{
		$check_session_in_session = $this->session->userdata('__ACTIVE_SESSION_DATA');
		if ($check_session_in_session) {
			$this->session->unset_userdata('__ACTIVE_SESSION_DATA');

			$this->session->set_flashdata('login_flash', 'Berhasil logout!');
		} else {
			$this->session->set_flashdata('login_flash', 'Anda belum login!');
		}

		redirect('auth');
	}
}
