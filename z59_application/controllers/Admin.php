<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Admin_model $admin_model
 * @property Test_model $test_model
 * @property View_load $view_load
 * @property CI_Form_validation $form_validation
 * @property CI_Session $session
 * @property CI_Input $input
 */
class Admin extends CI_Controller
{

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('z59_admin_logged') !== 'albdarb-testing-admin') {
			redirect(site_url('admin_login'));
		}
		$this->load->model('admin_model');
	}

    public function index()
    {
        redirect(site_url('admin/tests'));
    }

    public function create_test()
    {
        $this->form_validation->set_rules($this->admin_model->get_create_test_rules());
        if ($this->form_validation->run()) {
            $id = $this->admin_model->create_test();
            if ($id) {
                $this->session->set_flashdata('test_created', true);
                redirect(site_url('admin/add_category/' . $id));
            }
        }
        $this->view_load->load('create_test');
    }

    public function edit_test($id = 0)
    {
        $id = abs((int)$id);
        if (!$this->test_model->check_test_exist($id))
            show_404();
        $config = $this->admin_model->get_create_test_rules();
        unset($config[0]);
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $result = $this->admin_model->update_test($id);
            if ($result) {
                $this->session->set_flashdata('test_updated', true);
                redirect(site_url('admin/edit_category/' . $id));
            }
        }
        $data['test'] = $this->test_model->get_test_details($id);
        $this->view_load->load('edit_test', $data);
    }

    public function add_category($test_id = 0)
    {
        $test_id = abs((int)$test_id);
        if (!$this->test_model->check_test_exist($test_id))
            show_404();
        if ($count = $this->input->post('category_count')) {
            if ($this->admin_model->create_category($test_id, $count)) {
                redirect(site_url('admin/add_question/' . $test_id));
            }
        }
        $this->view_load->load('add_category');
    }

    public function add_question($test_id = 0)
    {
        $test_id = abs((int)$test_id);
        if (!($data['test'] = $this->test_model->check_test_exist($test_id)))
            show_404();
        $this->form_validation->set_rules($this->admin_model->get_add_question_rules());
        if ($this->form_validation->run()) {
            $id = $this->admin_model->create_question($test_id);
            if ($id) {
                $this->session->set_flashdata('question_created', true);
                if ($this->input->post('create_mode', TRUE) == 1) {
                    redirect(site_url('admin/add_question/' . $test_id));
                } else {
                    redirect(site_url('admin/view_test/' . $test_id));
                }
            }
        }
        $data['categories'] = $this->test_model->get_test_categories($test_id);
        $data['difficulty'] = $this->test_model->get_difficulty();
        $this->view_load->load('add_question', $data);
    }

    public function tests()
    {
        $data['tests'] = $this->test_model->get_tests();
        $this->view_load->load('tests', $data);
    }

    public function delete_test($test_id = 0)
    {
        $this->admin_model->delete_test($test_id);
        redirect(site_url('admin/tests'));
    }

    public function delete_question($question_id = 0)
    {
        $this->admin_model->delete_question($question_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function edit_question($question_id = 0)
    {
        if (!($data['question'] = $this->test_model->get_question_details($question_id)))
            show_404();
        $this->form_validation->set_rules($this->admin_model->get_add_question_rules());
        if ($this->form_validation->run()) {
            $this->admin_model->update_question($question_id);
            redirect($_SERVER['HTTP_REFERER']);
        }
        $data['categories'] = $this->test_model->get_test_categories($data['question']['test_id']);
        $data['difficulty'] = $this->test_model->get_difficulty();
        $this->view_load->load('edit_question', $data);
    }

    public function edit_category($test_id = 0)
    {
        $test_id = abs((int)$test_id);
        if (!$this->test_model->check_test_exist($test_id))
            show_404();
        $data['test_id'] = $test_id;
        $data['categories'] = $this->test_model->get_test_categories($test_id);
        $this->view_load->load('edit_category', $data);
    }

    public function view_test($test_id = 0)
    {
        $test_id = abs((int)$test_id);
        if (!$this->test_model->check_test_exist($test_id))
            show_404();
        $data = [];
        $data['test'] = $this->test_model->get_test_details($test_id);
        $data['test']['difficulty'] = $this->test_model->get_questions_difficulty_counts($test_id);
        $data['test']['categories'] = $this->test_model->get_test_categories($test_id, true);
        $data['statistics'] = $this->test_model->get_statistics($test_id);
        $this->view_load->load('view_test', $data);
    }

    public function test_results($test_id = 0)
    {
        $test_id = abs((int)$test_id);
        if (!($data['test_info'] = $this->test_model->check_test_exist($test_id)))
            show_404();
        $data['test_results'] = $this->test_model->get_test_results($test_id);
        $this->view_load->load('test_results', $data);
    }

    public function test_result($id = 0)
    {
        $this->load->model('test_passing_model');
        $data['test_end_info'] = $this->test_passing_model->get_end_test_info($id);
        $this->view_load->view('end_test', $data);
    }

    public function delete_test_result($id = 0)
    {
        $this->admin_model->delete_result($id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function import_tests($test_id = 0)
    {
        if (!$test_id || !($current_test = $this->test_model->check_test_exist($test_id))) {
            show_404();
        }
        $this->form_validation->set_rules($this->admin_model->get_import_tests_rules());
        if ($this->form_validation->run()) {
            $test_ides = $this->input->post('tests');
            foreach ($test_ides as $id) {
                $questions = $this->test_model->get_test_questions($id);
                $this->admin_model->import_test_questions($test_id, $questions);
            }
            redirect(site_url('admin/view_test/' . $test_id));
        }
        $tests = $this->test_model->get_tests(['id <>' => $test_id]);
        $this->view_load->load('import_tests', compact('current_test', 'tests'));
    }

}