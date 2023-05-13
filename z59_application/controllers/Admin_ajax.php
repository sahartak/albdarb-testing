<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_ajax extends CI_Controller {
    
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('z59_admin_logged') !== 'albdarb-testing-admin' || !$this->input->is_ajax_request()) {
			show_404();
		}
		$this->load->model('admin_ajax_model');
	}

	public function delete_cat() {
		$this->admin_ajax_model->delete_test_cat($this->input->post('cat_id', TRUE));
		echo $this->security->get_csrf_hash();
	}

	public function add_update_cat() {
		$result = array();
		if($this->input->post('cat_id')) {
			$result['response'] = $this->admin_ajax_model->update_test_cat($this->input->post('cat_id', TRUE), $this->input->post('name', TRUE));
		} else {
			$result['response'] = $this->admin_ajax_model->add_test_cat($this->input->post('test_id', TRUE), $this->input->post('name', TRUE));
		}
		$result['secure'] = $this->security->get_csrf_hash();
		echo json_encode($result);
	}

    public function category_select()
    {
        $id = $this->input->post('id');
        $is_selected = $this->input->post('checked');
        $this->admin_ajax_model->update_category_selection($id, $is_selected ? 1 : 0);
        echo $this->security->get_csrf_hash();
    }

	public function update_question_total(){
		$this->admin_ajax_model->update_test_field($this->input->post('test_id'), $this->input->post('field', TRUE), $this->input->post('total'));
		echo $this->security->get_csrf_hash();
	}

	public function update_test_status() {
		$this->admin_ajax_model->update_test_field($this->input->post('test_id'), 'is_open', $this->input->post('status'));
		echo $this->security->get_csrf_hash();
	}

	public function update_test_point() {
		$this->admin_ajax_model->update_test_field($this->input->post('test_id'), 'point', $this->input->post('point'));
		echo $this->security->get_csrf_hash();
	}

}