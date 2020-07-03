<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Admin_login
 * @property CI_Session $session
 */
class Admin_login_model extends CI_Model {
    
	private function get_secure_pass($password) {
		$salt = 'z59_salt';
		$salt = md5($salt.$password).sha1($salt.$password);
		$password = password_hash($password, PASSWORD_BCRYPT, array('salt' => $salt));
		return $password;
	}

	public function login_admin($login, $password) {
		$password = $this->get_secure_pass($password);
		$this->db->where(array('username'=>$login, 'password'=>$password));
		$query = $this->db->get('admin');
		if($query->num_rows()>0) {
			$admin = $query->row();
			unset($admin->password);
			$this->session->set_userdata('admin', $admin);
			$this->session->set_userdata('z59_admin_logged', 'albdarb-testing-admin');
			return true;
		}
		return false;
	}
}