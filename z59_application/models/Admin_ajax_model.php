<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_ajax_model extends CI_Model {
    
	public function delete_test_cat($cat_id) {
		$cat_id = abs((int)$cat_id);
		$this->db->delete('categories', array('id' => $cat_id));
		$this->db->update('questions', array('category' =>0 ), array('category' => $cat_id));
	}

	public function update_test_cat($cat_id, $name) {
		$cat_id = abs((int)$cat_id);
		$this->db->update('categories', array('name' => $name), array('id' => $cat_id));
		return null;
	}

	public function add_test_cat($test_id, $name) {
		$this->db->insert('categories', array('name' => $name, 'test_id' => $test_id));
		return $this->db->insert_id();
	}

	public function update_test_field($test_id, $field, $total) {
		$test_id = abs((int)$test_id);
		$this->db->update('tests', array($field => $total), array('id' => $test_id));
	}           
}