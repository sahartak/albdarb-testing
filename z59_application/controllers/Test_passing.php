<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_passing extends CI_Controller {
    
	public function __construct() {
		parent::__construct();
		$this->load->model('test_passing_model');
	}

	public function get_test($test_id = 0) {
		$test_id = abs((int)$test_id);
		if(! ($data['test_info'] = $this->test_model->check_test_exist($test_id, array('is_open' => 1))) )
			show_404();
		if($this->session->flashdata('test_'.$test_id.'_allowed') && $this->session->userdata('test_'.$test_id.'_passing')) {
			$data['test_passing'] = $this->test_passing_model->get_test_passing_questions($data['test_info'], $this->session->userdata('test_'.$test_id.'_passing'));
			$this->view_load->view('get_test', $data);
		} else {
			$invalid_pass = false;
			if($this->input->post('getting_test')) {
				$this->form_validation->set_rules($this->test_passing_model->get_passing_rules($data['test_info']['is_public']));
				if ($this->form_validation->run()) {
					if(!$data['test_info']['is_public']) {
						$pass = $this->test_model->get_secure_pass($this->input->post('test_password', TRUE));
						if(!$this->test_passing_model->check_test_password($test_id, $pass))
							$invalid_pass = true;
					} else {
					   $this->session->set_flashdata('test_'.$test_id.'_allowed', TRUE);
					}
					if(!$invalid_pass) {
						$this->test_passing_model->init_get_test($test_id);
						redirect(site_url('get_test/'.$test_id));
					}
						
				}
			}
			$courses = $this->test_passing_model->get_courses();
			$data = array(
						 'test_id' => $test_id,
						 'invalid_pass' => $invalid_pass,
						 'is_public' => $data['test_info']['is_public'],
						 'courses' => $courses
					);
			$this->view_load->view('test_login_form', $data);
		}
	}

	public function send_answer() {
		$this->form_validation->set_rules($this->test_passing_model->get_answer_rules());
		if(!$this->input->is_ajax_request() || !$this->session->userdata('getting_test') || !$this->form_validation->run())
			show_404();
		$this->test_passing_model->sending_answer();
		echo $this->security->get_csrf_hash();
	}

	public function end_test() {
		if(!($test_info = $this->session->userdata('getting_test')))
			show_404();
		$this->test_passing_model->ending_test($test_info['passing_id']);
        $data['test_end_info'] = $this->test_passing_model->get_end_test_info($test_info['passing_id']);
		$this->view_load->view('end_test', $data);
	}
}