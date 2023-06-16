<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View_load {

    private $CI;

    public function __construct() {
        $this->CI = &get_instance();
    }

    public function load($view, $data=null, $header_data=array('title'=>'HighCode Certifications'), $footer_data=null) {
        $this->CI->load->view('layouts/admin_header', $header_data);
        $this->CI->load->view('admin/'.$view.'_view', $data);
        $this->CI->load->view('layouts/admin_footer', $footer_data);
    }

    public function view($view, $data=null, $header_data=array('title'=>'HighCode Certifications'), $footer_data=null) {
        $this->CI->load->view('layouts/header', $header_data);
        $this->CI->load->view($view.'_view', $data);
        $this->CI->load->view('layouts/footer', $footer_data);
    }
}
