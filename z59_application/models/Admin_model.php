<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_model extends CI_Model {

	private function get_secure_pass($password) {
		$salt = 'z59_salt';
		$salt = md5($salt.$password).sha1($salt.$password);
		$password = password_hash($password, PASSWORD_BCRYPT, array('salt' => $salt));
		return $password;
	}

	public function get_create_test_rules() {
		$config = array(
			array(
					'field' => 'name',
					'label' => 'Թեստի անվանումը',
					'rules' => 'required|max_length[255]|is_unique[tests.name]'
			),
			array(
					'field' => 'is_public',
					'label' => 'Թեստը հասանելի է բոլորին',
					'rules' => 'required|numeric'
			),
		);
		if($this->input->post('is_public') != 1) {
			$config[] = array(
							'field' => 'password',
							'label' => 'Թեստի գաղտնաբառը',
							'rules' => 'required|min_length[4]', 
						);
			$this->form_validation->set_message('min_length', '{field} պետք է պարունակի գոնե {param} սիմվոլ.');
		}
		$this->form_validation->set_message('is_unique', 'Այդ անվանմամբ թեստ արդեն գոյություն ունի');
		return $config;
	}

	public function create_test() {
		if($this->input->post('is_public') != 1) {
			$_POST['password'] = $this->get_secure_pass($this->input->post('password'));
		}
		if($this->db->insert('tests', $_POST)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function get_add_question_rules() {
		$config = array(
			array(
					'field' => 'question',
					'label' => 'Հարցը',
					'rules' => 'required|trim'
			),
			array(
					'field' => 'answer_mode',
					'label' => 'Ճիշտ պատասխանների քանակը',
					'rules' => 'required|numeric'
			),
		);
		return $config;
	}

	public function get_import_tests_rules() {
		$config = array(
			array(
					'field' => 'tests[]',
					'label' => 'Թեստեր',
					'rules' => 'required|trim|numeric'
			),
		);
		return $config;
	}




	public function create_category($test_id, $count) {
		$insert = array();
		for($i=1; $i<=$count; $i++) {
			$insert[] = array(
							'name' => $this->input->post('category_'.$i, TRUE),
							'test_id' => $test_id
						  );
		}
		if($this->db->insert_batch('categories', $insert)) {
			return true;
		}
		return false;
	}

	public function update_category($test_id, $count) {
		$this->db->delete('categories', array('test_id'=>$test_id));
		$this->create_category($test_id, $count);
		return true;
	}

	private function insert_question_answers($question_id) {
		$question_id = (int)$question_id;
		if(!$question_id)
			return false;
		$count = (int) $this->input->post('qty');
		$is_right = $this->input->post('is_right', TRUE);
		$insert = array();
		for($i=1; $i<=$count; $i++) {
			$insert[$i] = array(
							'answer' => htmlspecialchars($this->input->post('answer_'.$i)),
							'point' => (float) $this->input->post('point_'.$i, TRUE),
							'question_id' => $question_id,
							'is_right' => 0
						  );
		}
		
		if(is_array($is_right)) {
			foreach($is_right as $id)
				$insert[$id]['is_right'] = 1;
		} else {
			$insert[$is_right]['is_right'] = 1;
		}
		$this->db->insert_batch('answers', $insert);
	}

	public function create_question($test_id) {
		$insert = array(
					'question' => $this->input->post('question', TRUE),
					'test_id' => $test_id,
					'answer_mode' => $this->input->post('answer_mode', TRUE),
					'category' => $this->input->post('category', TRUE),
					'difficulty' => $this->input->post('difficulty', TRUE),
				  );
		$this->db->insert('questions', $insert);
		$question_id = $this->db->insert_id();
		$this->insert_question_answers($question_id);
		return $question_id;     
	}

	public function get_values_from_array($array, $key = 'id') {
		$values = array();
		foreach($array as $value) {
			$values[] = $value[$key];
		}
		return $values;
	}

	public function delete_test($test_id) {
		$test_id = abs((int)$test_id);
		if($test_id) {
			$this->db->delete('tests', array('id' => $test_id));
			$this->db->select('id');
			$query = $this->db->get_where('questions', array('test_id' => $test_id));
			if($query->num_rows()) {
				$result = $query->result_array();
				$ids = $this->get_values_from_array($result);
				$this->db->where_in('question_id', $ids);
				$this->db->delete('answers');
			}
			$this->db->delete('questions', array('test_id' => $test_id));
			$this->db->delete('categories', array('test_id' => $test_id));
			$this->db->delete('get_test', array('test_id' => $test_id));
		}
	}

	public function delete_question($question_id) {
		$question_id = abs((int)$question_id);
		$this->db->delete('questions', array('id' => $question_id));
		$this->db->delete('answers', array('question_id' => $question_id));
	}

	public function update_question($question_id) {
		$question_id = abs((int)$question_id);
		$update = array(
				'question' => $this->input->post('question', TRUE),
				'answer_mode' => $this->input->post('answer_mode', TRUE),
				'category' => $this->input->post('category', TRUE),
				'difficulty' => $this->input->post('difficulty', TRUE),
			  );
		$this->db->where('id', $question_id);
		$this->db->update('questions', $update);
		$this->db->delete('answers', array('question_id' => $question_id));
		$this->insert_question_answers($question_id);
	}

	public function update_test($test_id) {
		if($this->input->post('is_public') != 1) {
			$_POST['password'] = $this->get_secure_pass($this->input->post('password'));
		}
		$this->db->update('tests', $_POST, array('id'=>$test_id)); 
		return true;
	}

	public function delete_result($id) {
		$id = abs((int)$id);
		$this->db->delete('get_test', array('id' => $id));
		$this->db->delete('gotten_test_answers', array('get_test_id' => $id));
	}

	public function import_test_questions($test_id, $questions) {
		foreach($questions as $question) {
			$insert_question = [
				'test_id' => $test_id,
				'question' => $question['question'],
				'answer_mode' => $question['answer_mode'],
				'category' => $question['category'],
				'difficulty' => $question['difficulty']
			];
			$this->db->insert('questions', $insert_question);
			$question_id = $this->db->insert_id();
			foreach($question['answers'] as $answer) {
				$insert_answer = [
					'question_id' => $question_id,
					'answer' => $answer['answer'],
					'point' => $answer['point'],
					'is_right' => $answer['is_right']
				];
				$this->db->insert('answers', $insert_answer);
			}
		}
	}

}