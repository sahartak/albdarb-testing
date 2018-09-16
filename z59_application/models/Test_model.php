<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test_model extends CI_Model {

	public function get_secure_pass($password) {
		$salt = 'z59_salt';
		$salt = md5($salt.$password).sha1($salt.$password);
		$password = password_hash($password, PASSWORD_BCRYPT, array('salt' => $salt));
		return $password;
	}    

	public function get_question_answers($question_id) {
		$this->db->order_by('id', 'RANDOM');
		$query = $this->db->where(array('question_id' => $question_id))->get('answers');
		return $query->result_array();
	}

	public function get_test_questions($test_id, $where = null) {
		$questions = array();
		$this->db->select('questions.*, categories.name as category_name, difficulty.difficulty_name');
		$this->db->join('categories','categories.id=questions.category','left');
		$this->db->join('difficulty','difficulty.id=questions.difficulty','left');
		$where['questions.test_id'] = $test_id;
		$this->db->where($where);
		$query = $this->db->get('questions');
		if($query->num_rows()) {
			$questions = $query->result_array();
			$count = count($questions);
			for($i=0; $i<$count; $i++) {
				$questions[$i]['answers'] = $this->get_question_answers($questions[$i]['id']);
			}
		}
		return $questions;
	}

	public function get_test_details($id, $where = null) {
		$id = abs((int)$id);
		$test = array();
		$this->db->select('id, name, created, description, is_public, point, is_open, diff_1_total, diff_2_total, diff_3_total, diff_4_total, diff_5_total,
						 (diff_1_total + diff_2_total + diff_3_total + diff_4_total + diff_5_total) as total_sum ');
		$where['id'] = $id;
		$query = $this->db->get_where('tests', $where);
		if($query->num_rows()) {
			$test = $query->row_array();
			$test['questions'] = $this->get_test_questions($id);
		}
		return $test;    
	}

	public function check_test_exist($test_id, $where = null) {
		$where['id'] = $test_id;
		$query = $this->db->get_where('tests', $where);
		if($query->num_rows())
			return $query->row_array();
		return false;    
	}

	public function get_test_categories($test_id) {
		$query = $this->db->get_where('categories', array('test_id'=>$test_id));
		if($query->num_rows())
			return $query->result_array();
		return array();
	}

	public function get_test_categories_with_count($test_id) {
		 $this->db->select('COUNT(category) as total, questions.category, categories.name');
		 $this->db->join('categories','categories.id = questions.category', 'left');
		 $this->db->where('questions.test_id', $test_id);
		 $this->db->group_by('questions.category'); 
		 $query = $this->db->get('questions');
		 if($query->num_rows())
			return $query->result_array();
		 return array(); 
	}

	public function get_tests($where = null) {
		$this->db->select('id, name, description, time, created, is_public, point, is_open');
		if($where) {
			$this->db->where($where);
		}
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('tests');
		if($query->num_rows())
			return $query->result_array();
		return false;
	}

	public function get_difficulty() {
		$query = $this->db->get('difficulty');
		if($query->num_rows())
			return $query->result_array();
		return false;
	}

	public function get_question_details($question_id) {
		$question_id = abs((int)$question_id);
		$query = $this->db->get_where('questions', array('id' => $question_id));
		if($query->num_rows()) {
			$question = $query->row_array();
			$question['answers'] = $this->get_question_answers($question_id);
			return $question;
		}
		return false;
	}

	public function get_questions_difficulty_counts($test_id) {
		$this->db->select('COUNT(difficulty) as total, difficulty.difficulty_name, difficulty.id');
		$this->db->group_by('questions.difficulty');
		$this->db->join('difficulty', 'difficulty.id = questions.difficulty');
		$query = $this->db->get_where('questions', array('test_id' => $test_id));
		if($query->num_rows()) {
			return $query->result_array();
		}
		return array();
	}

	public function get_statistics($test_id) {
		$query = $this->db  ->select('COUNT(id) as total, MAX(point) as max_point, MIN(point) as min_point')
							->where('test_id', $test_id)
							->get('get_test');
		if($query->num_rows())
			return $query->row_array();
		return false;
	}

	public function get_times_interval($start, $end) {
		$start = new DateTime($start);
		$end = new DateTime($end);
		$interval = $end->diff($start);
		return $interval->format('%H:%I:%S');
	}

	public function get_test_results($test_id) {
		$query = $this->db  ->select('get_test.*,
									users.first_name, users.last_name, users.father_name, courses.name as group')
							->join('users', 'users.id=get_test.user_id')
							->join('courses', 'courses.id=users.group_id', 'LEFT')
							->where(array('test_id' => $test_id, 'end_time >' => '0000-00-00 00:00:00'))
							->order_by('get_test.point', 'DESC')
							->get('get_test');
		if($query->num_rows()) {
			return $query->result_array();
		}
		return array();
	}

}