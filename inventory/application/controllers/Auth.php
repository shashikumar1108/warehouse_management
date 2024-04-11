<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function login()
	{	

		if($this->session->userdata('login') == true){
			redirect(base_url('/auth/dashboard'));
		}else{
			if($this->uri->segment(3) == 1){
				$data['invalid_credentials'] = true;
				$this->load->view('auth/login', $data);
			}else{
				$this->load->view('auth/login');
			}
		}		
		
	}

	public function registration()
	{
		$this->load->view('auth/registration');
	}

	public function verifyLogin(){
		$user = $this->db->select('*')
		->from('users')
		->where(array('username'=>$_POST['username'], 'password'=>md5($_POST['password'])))
		->get()
		->result_array();
		
		if(!empty($user)){//print_r('hi');
			$this->session->set_userdata(
				array(
					'login'=>true,
					'username'=>$user[0]['username'], 
					'user_type'=>$user[0]['user_type']
					)
			);

			redirect(base_url('/auth/dashboard'));
		}else{
			redirect(base_url('/auth/login/1'));
		}		
	}

	public function dashboard(){
		if($this->session->userdata('login') == true){
		$this->load->view('dashboard');
		}else{
			redirect(base_url('/auth/login'));	
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url('/auth/login'));
	}
}
