<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Admin_login
 * @property Admin_login_model $admin_login_model
 */
class Admin_login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_login_model');
    }

    public function index()
    {
        if ($this->session->userdata('z59_admin_logged') === 'albdarb-testing-admin') {
            redirect(site_url('admin'));
        }
        $this->form_validation->set_rules('login', 'Login', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run()) {
            $login = $this->input->post('login', true);
            $password = $this->input->post('password', true);
            if ($this->admin_login_model->login_admin($login, $password)) {
                redirect(site_url('admin'));
            } else {
                $this->session->set_flashdata('wrong_login', true);
            }
        }
        $this->load->view('admin/admin_login_view');

    }
}