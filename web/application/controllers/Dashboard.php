<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index() {
		if (!$this->session->has_userdata('id')) {
			redirect('login');
		}

		$this->load->view('welcome_message');
	}
}
