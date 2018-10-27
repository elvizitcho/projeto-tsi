<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index() {
		if ($this->session->has_userdata('id')) {
			redirect('');
		}

		$this->load->view('login/login');
	}
}
