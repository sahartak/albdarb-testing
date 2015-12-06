<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index() {
       $this->view_load->load('home');
	}
    
    public function get_test($test_id = 0) {
        $test_id = abs((int)$test_id);
        $data['test'] = $this->test_model->get_test_details($test_id);
        print_r($data['test']);
    }
}
