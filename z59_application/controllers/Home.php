<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index() {
	   $data['tests'] = $this->test_model->get_tests(array('is_open' => 1));
	   $this->view_load->view('home', $data);
	}
}