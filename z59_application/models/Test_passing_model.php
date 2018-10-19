<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_passing_model extends CI_Model {

	public function get_passing_rules($no_pass) {
		$config = array(
					array(
						'field' => 'first_name',
						'label' => 'Անուն',
						'rules' => 'required|trim|strip_tags|ucfirst|htmlspecialchars|min_length[2]|max_length[50]'
					),
					array(
						'field' => 'last_name',
						'label' => 'Ազգանուն',
						'rules' => 'required|trim|strip_tags|ucfirst|htmlspecialchars|min_length[2]|max_length[50]'
					),
					array(
						'field' => 'father_name',
						'label' => 'Հայրանուն',
						'rules' => 'trim|strip_tags|ucfirst|htmlspecialchars|min_length[2]|max_length[50]'
					),
					array(
						'field' => 'course',
						'label' => 'Խումբը',
						'rules' => 'required|trim|is_natural'
					),
					array(
						'field' => 'course_name',
						'label' => 'խմբի անվանումը',
						'rules' => 'trim|strip_tags|htmlspecialchars|max_length[50]'
					),
			   );
		if(!$no_pass) {
			$config[] = array(
						'field' => 'test_password',
						'label' => 'Թեստի գաղտնաբառը',
						'rules' => 'required|trim'
					);
		}
		return $config;
	}

	public function check_test_password($test_id, $pass) {
	    /*if($_SERVER['REMOTE_ADDR'] == '37.252.83.218') {
            $this->session->set_flashdata('test_'.$test_id.'_allowed', TRUE);
	        return true;
        }*/
		$this->db->select('id');
		$this->db->limit(1);
		$query = $this->db->get_where('tests', array('id' => $test_id, 'password' => $pass));
		if($query->num_rows()) {
			$this->session->set_flashdata('test_'.$test_id.'_allowed', TRUE);
			return true;
		}
		return false;
	}

	public function get_test_passing_questions(&$test_info, $get_test_id) {
		$questions = array();
		for($i=1; $i<=5; $i++) {
			if($test_info['diff_'.$i.'_total']) {
				$query = $this->db ->select('id, question, answer_mode')
								   ->where(array('test_id' => $test_info['id'], 'difficulty' => $i))
								   ->order_by('id', 'RANDOM')
								   ->limit($test_info['diff_'.$i.'_total'])
								   ->get('questions');
				if($query->num_rows()) {
					$insert = array();
					$result = $query->result_array();
					foreach($result as $row) {
						$row['answers'] = $this->test_model->get_question_answers($row['id']);
						$questions[] = $row;
						$insert[] = array(
										'get_test_id' => $get_test_id,
										'question_id' => $row['id'],
										'answer_ids' => ''
									);
					}
					$this->db->insert_batch('gotten_test_answers', $insert);
				}
			}
		}
		return $questions;
	}

	public function get_courses() {
		$query = $this->db->get('courses');
		if($query->num_rows())
			return $query->result_array();
		return array();
	}

	private function register_new_user() {
		$insert = array(
					'first_name' => $this->input->post('first_name', TRUE),
					'last_name' => $this->input->post('last_name', TRUE),
					'father_name' => $this->input->post('father_name', TRUE),
					'group_id' => $this->input->post('course', TRUE)
				  );
		$user = $this->db->select('id')->get_where('users', $insert)->row();
		if(!$user) {
			$this->db->insert('users', $insert);
			return $this->db->insert_id();
		} else {
			return $user->id;
		}
	}

	private function check_group() {
		$group_id = $this->input->post('course', TRUE);
		$course_name = $this->input->post('course_name', TRUE);
		if(!$group_id && $course_name) {
			$course = $this->db->select('id')->get_where('courses', ['name' => $course_name])->row();
			if(!$course) {
				$this->db->insert('courses', ['name' => $course_name]);
				$_POST['course'] = $this->db->insert_id();
			} else {
				$_POST['course'] = $course->id;
			}
		}
	}

	public function init_get_test($test_id) {
		$this->check_group();
		$user_id = $this->register_new_user();
		$insert = array(
					'test_id' => $test_id,
					'user_id' => $user_id,
					'start_time' => date('Y-m-d H:i:s'),
					'ip' => $_SERVER["REMOTE_ADDR"]
				  );
		$this->db->insert('get_test', $insert);
		$insert_id = $this->db->insert_id();
		$this->session->set_userdata('getting_test', array('test_id' => $test_id, 'passing_id' => $insert_id));
		$this->session->set_userdata('test_'.$test_id.'_passing', $insert_id);
	}

	public function get_answer_rules() {
		$config = array(
					array(
						'field' => 'question_id',
						'label' => 'question_id',
						'rules' => 'required|trim|is_natural'
					),
					array(
						'field' => 'answer[]',
						'label' => 'answer',
						'rules' => 'trim|is_natural'
					),
			   );
		return $config;
	}

	public function sending_answer() {
		$question_id = $this->input->post('question_id', TRUE);
		$test_info = $this->session->userdata('getting_test');
		
		$query = $this->db ->select('get_test.start_time, questions.answer_mode, tests.time')
						   ->join('questions', 'questions.test_id=get_test.test_id')
						   ->join('tests', 'tests.id=get_test.test_id')
						   ->where(array('get_test.id' => $test_info['passing_id'], 'questions.id' => $question_id))
						   ->get('get_test');
		if($query->num_rows()) {
			$answer = $this->input->post('answer', TRUE);
            $answer_str = $answer ? implode(',', $answer) : '';

			
			$this->db   ->where(array('get_test_id' => $test_info['passing_id'], 'question_id' => $question_id))
						->update('gotten_test_answers', array('answer_ids' => $answer_str));
			return true;
		}
		return false;
	}

	private function getting_end_test_questions($end_test_id, $point) {
		$point = (float)$point;        
		$query = $this->db  ->select('gotten_test_answers.question_id, answer_ids, questions.question, questions.answer_mode')
							->join('questions', 'questions.id=gotten_test_answers.question_id')
							->where('gotten_test_answers.get_test_id', $end_test_id)
							->get('gotten_test_answers');
		if($query->num_rows()) {
			$end_point = 0;
			$questions = $query->result_array();
			foreach($questions as $key => $question) {
				$user_right = 0;
				$user_wrong = 0;
				$question_right = 0;
				$questions[$key]['answers'] = $this->test_model->get_question_answers($question['question_id']);
				$current_point = 0;
				if($question['answer_mode']) {
					
					$answer_ids = explode(',', $question['answer_ids']);
					$right_answers = array();
					foreach($questions[$key]['answers'] as $answer_key => $answer) {
						$checked = false;
                        if (in_array($answer['id'], $answer_ids)) {
							$checked = true;
                            $questions[$key]['answers'][$answer_key]['checked'] = true;
                        }
                        if ($answer['is_right']) {
                            $right_answers[$answer['id']] = (float)$answer['point'];
                            $question_right++;
                        } elseif($answer['point'] && $checked) {
                            $current_point += (float)$answer['point'];
                        }
                    }
					foreach($answer_ids as $id) {
						if(array_key_exists($id, $right_answers)) {
							$user_right++;
							$current_point += $right_answers[$id];
						} else {
							$user_wrong++;
						}
					}
				} else {
					foreach($questions[$key]['answers'] as $answer_key => $answer) {
						$checked = false;
						if($answer['id'] == $question['answer_ids']) {
							$checked = true;
							$questions[$key]['answers'][$answer_key]['checked'] = true;
						}
						if($answer['id'] == $question['answer_ids']) {
						    if($answer['is_right']) {
                                $user_right = $question_right = 1;
                                $current_point = $point;
                            } elseif ($answer['point'] && $checked) {
                                $current_point = floatval($answer['point']);
                            }

						}
					}
				}
				$questions[$key]['current_point'] = $current_point;
				$questions[$key]['point'] = $point;
				if($user_right && $user_right === $question_right && !$user_wrong) {
					$current_point = $point;
					$questions[$key]['is_right'] = TRUE;
				} else {
					$questions[$key]['is_right'] = FALSE;
				}
				$end_point += $current_point;
			}
			$end_point = (float)$end_point;
			$max_point = $point * count($questions);
			$this->db->where('id', $end_test_id)->update('get_test', array('point' => $end_point, 'max_point' => $max_point));
			$result = array('questions' => $questions, 'end_point' => $end_point, 'max_point' => $max_point);
			return $result;
		}
		return false;
	}

	public function ending_test($passing_id) {
		$this->db->where('id', $passing_id)
				 ->update('get_test', array('end_time' => date('Y-m-d H:i:s')));
		session_destroy();
	}

	public function get_end_test_info($passing_id) {
		$query = $this->db  ->select('get_test.start_time, get_test.end_time, tests.point, tests.display_mode')
							->where('get_test.id', $passing_id)
							->join('tests','tests.id=get_test.test_id')
							->get('get_test');
		if($query->num_rows()) {
			$get_test = $query->row_array();
			$result = $this->getting_end_test_questions($passing_id, $get_test['point']);
			$result['display_mode'] = $get_test['display_mode'];
			$result['time'] = $this->test_model->get_times_interval($get_test['start_time'], $get_test['end_time']);
			return $result;
		}
		return false;
	}

}