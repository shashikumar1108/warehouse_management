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

	public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->helper('utility');
		// echo '<pre>';print_r($this->session->userdata());exit;
    }

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
		->where(array('usertype'=>3,'email'=>$_POST['username'], 'password'=>md5($_POST['password'])))
		->get()
		->result_array();

		// echo $this->db->last_query();
		// echo '<pre>';print_r($user);exit;

		if(!empty($user)){//print_r('hi');
			$this->session->set_userdata(
				array(
					'portal'=>'account',
					'login'=>true,
					'username'=>$user[0]['username'], 
					'user_type'=>$user[0]['usertype'],
					'profile_pic'=>$user[0]['profile_pic'],
					'id'=>$user[0]['id'],
				)
			);

			redirect(base_url('/auth/dashboard'));
		}else{
			redirect(base_url('/auth/login/1'));
		}		
	}

	public function dashboard(){
		// echo '<pre>';print_r($this->session->userdata());exit;
		if($this->session->userdata('login') == true && $this->session->userdata('portal') == 'account'){
			$db2 = $this->load->database('database2', TRUE);	
			$data['total_warehouses'] = $this->db->select('id')->from('warehouse')->where('delete_status',0)->get()->num_rows();
			$data['total_suppliers'] = $this->db->select('id')->from('suppliers')->where('delete_status',0)->get()->num_rows();
			// $data['total_shops'] = $this->db->select('*')->from('shops')->get()->num_rows();
			$data['total_products'] = $this->db->select('id')->from('products')->where('delete_status',0)->get()->num_rows();
			$data['total_brands'] = $this->db->select('id')->from('brand')->where('delete_status',0)->get()->num_rows();
			$data['total_categories'] = $this->db->select('id')->from('category')->where('delete_status',0)->get()->num_rows();
			$data['total_subcategories_one'] = $this->db->select('id')->from('sub_categories_one')->where('delete_status',0)->get()->num_rows();
			$data['total_subcategories_two'] = $this->db->select('id')->from('sub_categories_two')->where('delete_status',0)->get()->num_rows();
			// $data['total_agents'] = $this->db->select('*')->from('users')->where('usertype', 6)->get()->num_rows();
			// $data['total_supplier_users'] = $this->db->select('*')->from('users')->where('usertype', 5)->get()->num_rows();
			$data['total_state_codes'] = $this->db->select('*')->from('state_code')->where('delete_status',0)->get()->num_rows();
			$data['total_accountants'] = $this->db->select('*')->from('users')->where('delete_status',0)->where('usertype', 3)->get()->num_rows();	
			// $data['total_sales_managers'] = $this->db->select('*')->from('users')->where('usertype', 4)->get()->num_rows();
			// $data['total_batches'] = $db2->select('*')->from('batches')->get()->num_rows();

			$data['payment']['paid'] = 0;
			$data['payment']['pending'] = 0;
			$payment = $this->db->select('sum(paid_amount) as paid,sum(pending_amount) as pending')->from('invoice')->get()->result_array();
			if( count($payment) ){
				$data['payment'] = $payment[0];
			}
			// echo '<pre>';print_r($payment);exit;
			$this->load->view('dashboard',$data);
		}else{
			redirect(base_url('/auth/login'));	
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url('/auth/login'));
	}

	public function change_password(){
		if($this->session->userdata('login') == true && $this->session->userdata('portal') == 'account'){
			$data['user'] = $this->db->select('*')
							->from('users')
							->where(array('id'=>$this->session->userdata('id'),'usertype'=>3))
							->get()
							->result_array();
			// echo '<pre>';print_r($data);exit;
			if( count($data['user']) ){
				// echo '<pre>';print_r($data);exit;
				$this->load->view('change_password',$data);
			}else{
				redirect(base_url('/auth/login'));	
			}
		}else{
			redirect(base_url('/auth/login'));	
		}
	}

	public function update_password(){
		$result = array('status'=>false,'message'=>'Invalid Access');
		if($this->session->userdata('login') == true && $this->session->userdata('portal') == 'account'){

			if( !empty($_POST['npassword']) && !empty($_POST['npassword']) ){
				$password = md5(trim($_POST['npassword']));
				// echo $password;exit;
				$data['user'] = $this->db->select('*')
					->from('users')
					->where(array('id'=>$this->session->userdata('id'),'usertype'=>3))
					->get()
					->result_array();
				if( count($data['user']) ){					
					$this->db->where('id', $this->session->userdata('id'));
    				$this->db->update('users', array('password' => $password));
					$result['status'] = true;
					$result['message'] = 'Password changed successfully';
					echo json_encode($result);exit;
				}else{
					$result['message'] = 'User not found !!!';
					echo json_encode($result);exit;
				}
			}else{
				$result['message'] = 'Required fields are missing !!!';
				echo json_encode($result);exit;
			}
			
		}else{
			echo json_encode($result);exit;
		}
		
	}

	public function profile(){
		// echo '<pre>';print_r($this->session->userdata());exit;
		if($this->session->userdata('login') == true && $this->session->userdata('portal') == 'account'){

			$data['user'] = $this->db->select('*')
							->from('users')
							->where(array('id'=>$this->session->userdata('id'),'usertype'=>3))
							->get()
							->result_array();
			if( count($data['user']) ){
				// echo '<pre>';print_r($data);exit;
				$this->load->view('profile',$data);
			}else{
				redirect(base_url('/auth/login'));	
			}
		}else{
			redirect(base_url('/auth/login'));	
		}
	}

	public function update_profile(){
		$result = array('status'=>false,'message'=>'Invalid Access');
		if($this->session->userdata('login') == true && $this->session->userdata('portal') == 'account'){
			if( !empty($_POST['username']) && !empty($_POST['first_name']) && !empty($_POST['last_name'])
				&& !empty($_POST['email']) && !empty($_POST['mobile']) ){
				$username = trim($_POST['username']);
				$first_name = trim($_POST['first_name']);
				$last_name = trim($_POST['last_name']);
				$email = trim($_POST['email']);
				$mobile = trim($_POST['mobile']);
				// echo $password;exit;
				$data['user'] = $this->db->select('*')
					->from('users')
					->where(array('id'=>$this->session->userdata('id'),'usertype'=>3))
					->get()
					->result_array();
				if( count($data['user']) ){	
					
					$checkMobile = $this->db->select('id')
						->from('users')
						->where(array('id != '=>$this->session->userdata('id')))
						->group_start()
						->where('mobile',$mobile)
						->or_where('email',$email)
						->group_end()
						->get()
						->result_array();
					
					// echo $this->db->last_query();
					// echo '<pre>';print_r($checkMobile);exit;

					if( count($checkMobile) ){
						$result['status'] = true;
						$result['message'] = 'Mobile number or email already exists !!!';
						echo json_encode($result);exit;
					}					

					$update = array(
						'username'=>$username,
						'first_name'=>$first_name,
						'last_name'=>$last_name,
						'email'=>$email,
						'mobile'=>$mobile,
					);			
					$this->db->where('id', $this->session->userdata('id'));
    				$this->db->update('users', $update);
					$result['status'] = true;
					$result['message'] = 'Profile updated successfully';
					echo json_encode($result);exit;
				}else{
					$result['message'] = 'User not found !!!';
					echo json_encode($result);exit;
				}
			}else{
				$result['message'] = 'Required fields are missing !!!';
				echo json_encode($result);exit;
			}			
		}else{
			echo json_encode($result);exit;
		}		
	}

	public function update_profile_pic(){
		// echo '<pre>';print_r($_FILES);exit;
		$config['upload_path']          = 'assets/profile/';
		$config['allowed_types']        = 'jpg|png';
		// $config['max_size']             = 100;
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;

		$this->load->library('upload', $config);
		
		$result = array('status'=>false,'message'=>'Invalid Access');
		if($this->session->userdata('login') == true && $this->session->userdata('portal') == 'account'){
			if( !empty($_FILES['file']) && !empty($_FILES['file']['name']) ){
				
				$data['user'] = $this->db->select('*')
					->from('users')
					->where(array('id'=>$this->session->userdata('id'),'usertype'=>3))
					->get()
					->result_array();
					
				if( count($data['user']) ){	
					if ( ! $this->upload->do_upload('file')){
						$error = array('error' => $this->upload->display_errors());
						echo '<pre>';print_r($error);exit;
						$result['message'] = 'Something went wrong !!!';
						echo json_encode($result);exit;
					}else {
						$image = array('upload_data' => $this->upload->data());
						$profile_pic = 'assets/profile/'.$image['upload_data']['file_name'];
						// echo '<pre>';print_r($image);exit;
						$update = array('profile_pic'=>$profile_pic);
						$this->db->where('id', $this->session->userdata('id'));
						$this->db->update('users', $update);
						$result['status'] = true;
						$result['message'] = 'Profile picture updated successfully';

						$this->session->set_userdata(
							array(
								'portal'=>'account',
								'login'=>true,
								'username'=>$data['user'][0]['username'], 
								'user_type'=>$data['user'][0]['usertype'],
								'profile_pic'=>$profile_pic,
								'id'=>$data['user'][0]['id'],
							)
						);
						echo json_encode($result);exit;
					}
				}else{
					$result['message'] = 'User not found !!!';
					echo json_encode($result);exit;
				}
			}else{
				$result['message'] = 'Required fields are missing !!!';
				echo json_encode($result);exit;
			}
			
		}else{
			echo json_encode($result);exit;
		}
	}
}
