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
/* 
		$db2 = $this->load->database('database2', TRUE);


		$db2->select('*');
		$q = $db2->get('invoice');
		$result2 = $q->result_array();

		print_r($result2);
		exit(); */		

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
		->where(array('username'=>$_POST['username'], 'password'=>md5($_POST['password']), 'active_status'=>'1', 'delete_status'=>'0'))
		->get()
		->result_array();


		if(empty($user)){
			$user = $this->db->select('*')
			->from('users')
			->where(array('email'=>$_POST['username'], 'password'=>md5($_POST['password']), 'active_status'=>'1', 'delete_status'=>'0'))
			->get()
			->result_array();
		}

		if(empty($user)){
			$user = $this->db->select('*')
			->from('users')
			->where(array('mobile'=>$_POST['username'], 'password'=>md5($_POST['password']), 'active_status'=>'1', 'delete_status'=>'0'))
			->get()
			->result_array();
		}
		
		
		if(!empty($user)){//print_r('hi');
				$shop_id = -1;
				$warehouse_id = -1;
				$supplier_id = -1;
				$department_id = -1;
				$supplier_name = '';
			if($user[0]['usertype'] == 1){	// Super admin 
				$shop_id = 0;
				$warehouse_id = 0; 
				$supplier_id = 0;
				$department_id = 0;
			}elseif($user[0]['usertype'] == 2 || $user[0]['usertype'] == 3 || $user[0]['usertype'] ==4){	// Warehouse users 
				$warehouse_id = $this->db->select('warehouse_id')->from('user_warehouse_relationship')->where('user_id',$user[0]['id'])->get()->result_array();
				if(!empty($warehouse_id)){
					$warehouse_id = $warehouse_id[0]['warehouse_id'];
				}
			}elseif($user[0]['usertype'] == 5){	// Supplier 
				$supplier_id = $this->db->select('supplier_id')->from('user_supplier_relationship')->where('user_id',$user[0]['id'])->get()->result_array();
				if(!empty($supplier_id)){
					$supplier_id = $supplier_id[0]['supplier_id'];
					$supplier_name = $this->db->select('name')->from('suppliers')->where('id',$supplier_id[0]['supplier_id'])->get()->result_array()[0]['name'];
				}
			}elseif($user[0]['usertype'] == 6){	// Agent 
				
			}elseif($user[0]['usertype'] == 7){	// Shop 
				$shop_id = $this->db->select('shop_id')->from('user_shop_relationship')->where('user_id',$user[0]['id'])->get()->result_array();
				if(!empty($shop_id)){
					$shop_id = $shop_id[0]['shop_id'];
				}
			}elseif($user[0]['usertype'] == 8){	// Department 
				$department_id = $this->db->select('department_id')->from('user_department_relationship')->where('user_id',$user[0]['id'])->get()->result_array();
				if(!empty($department_id)){
					$department_id = $department_id[0]['department_id'];
				}
			}else{ // None
				
			}

			/* echo "<pre>";
			print_r($shop_id);
			print_r($warehouse_id);
			print_r($supplier_id);
			print_r($department_id);
			exit(); */


			$this->session->set_userdata(
				array(
					'login'=>true,
					'id'=>$user[0]['id'],
					'username'=>$user[0]['username'], 
					'usertype'=>$user[0]['usertype'],
					'first_name'=>$user[0]['first_name'],
					'last_name'=>$user[0]['last_name'],
					'email'=>$user[0]['email'],
					'mobile'=>$user[0]['mobile'],
					'profile_pic'=>$user[0]['profile_pic'],
					'supplier_id'=>$supplier_id,
					'supplier_name'=>$supplier_name,
					'warehouse_id'=>$warehouse_id,
					'shop_id'=>$shop_id,
					'department_id'=>$department_id
					)
			);
			
			redirect(base_url('/auth/dashboard'));
		}else{
			redirect(base_url('/auth/login/1'));
		}		
	}

	public function dashboard(){		

		if($this->session->userdata('login') == true){
			$data['profile'] = $this->db->select('*')
			->from('users')
			->where('id',$this->session->userdata('id'))
			->get()
			->result_array();
		
		$db2 = $this->load->database('database2', TRUE);	
		$data['total_warehouses'] = $this->db->select('*')->from('warehouse')->get()->num_rows();
		$data['total_suppliers'] = $this->db->select('*')->from('suppliers')->get()->num_rows();
		$data['total_shops'] = $this->db->select('*')->from('shops')->get()->num_rows();
		$data['total_products'] = $this->db->select('*')->from('products')->get()->num_rows();
		$data['total_brands'] = $this->db->select('*')->from('brand')->get()->num_rows();
		$data['total_categories'] = $this->db->select('*')->from('category')->get()->num_rows();
		$data['total_agents'] = $this->db->select('*')->from('users')->where('usertype', 6)->get()->num_rows();
		$data['total_supplier_users'] = $this->db->select('*')->from('users')->where('usertype', 5)->get()->num_rows();
		$data['total_state_codes'] = $this->db->select('*')->from('state_code')->get()->num_rows();
		$data['total_accountants'] = $this->db->select('*')->from('users')->where('usertype', 3)->get()->num_rows();	
		$data['total_sales_managers'] = $this->db->select('*')->from('users')->where('usertype', 4)->get()->num_rows();
		$data['total_batches'] = $db2->select('*')->from('batches')->get()->num_rows();		
			

			/* echo "<pre>";
			print_r($data);
			exit(); */


		$this->load->view('dashboard', $data);
		}else{
			redirect(base_url('/auth/login'));	
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url('/auth/login'));
	}

	public function profile(){
		$data['profile'] = $this->db->select('*')
			->from('users')
			->where('id',$this->session->userdata('id'))
			->get()
			->result_array();

			$this->load->view('profile', $data);
	}




	public function updateProfile(){			

			$check_email = $this->db->select('*')
			->from('users')
			->where(array('id!='=>$this->session->userdata('id'), 'email'=>$_POST['email']))
			->get()
			->result_array();
			
			if(!empty($check_email)){
				$this->session->set_flashdata('profile_update_status','fail');
				$this->session->set_flashdata('profile_update_message','Email already exists for other user');
				$data['profile'] = $this->db->select('*')
				->from('users')
				->where('id',$this->session->userdata('id'))
				->get()
				->result_array();

				$this->load->view('profile', $data);
			
			}else{
				$check_mobile = $this->db->select('*')
				->from('users')
				->where(array('id!='=>$this->session->userdata('id'), 'mobile'=>$_POST['mobile']))
				->get()
				->result_array();
			
				if(!empty($check_mobile)){
					$this->session->set_flashdata('profile_update_status','fail');
					$this->session->set_flashdata('profile_update_message','Mobile number already exists for other user');			
					$data['profile'] = $this->db->select('*')
					->from('users')
					->where('id',$this->session->userdata('id'))
					->get()
					->result_array();

					$this->load->view('profile', $data);
				}else{
					$update_status = 'false';
				if(isset($_POST['password']) && $_POST['password'] != ''){
					
					/* print_r($_POST['c_password'] != $_POST['password']);
					exit();
	*/
						if($_POST['password'] != $_POST['c_password']){ 
							$update_status = 'p_mm';
						}else{
							$profile_data = array(
								'first_name'=>$_POST['first_name'],
								'last_name'=>$_POST['last_name'],
								'email'=>$_POST['email'],
								'mobile'=>$_POST['mobile'],
								'password'=>md5($_POST['password'])
							);
							$update_status = $this->db->where('id',$this->session->userdata('id'))->update('users', $profile_data);
						}

						


				}else{ 
							$profile_data = array(
								'first_name'=>$_POST['first_name'],
								'last_name'=>$_POST['last_name'],
								'email'=>$_POST['email'],
								'mobile'=>$_POST['mobile'],
							);
							$update_status = $this->db->where('id',$this->session->userdata('id'))->update('users', $profile_data);
						
							
							
				}	
				//echo $update_status;exit();


				if($update_status == '1'){
					$this->session->set_flashdata('profile_update_status','success');
					$this->session->set_flashdata('profile_update_message','Profile updated successfully');							
				}elseif($update_status == '0'){
					$this->session->set_flashdata('profile_update_status','fail');
					$this->session->set_flashdata('profile_update_message','Something went wrong, please try later');						
				}else{
					$this->session->set_flashdata('profile_update_status','fail');
					$this->session->set_flashdata('profile_update_message','Password and Confirm password are not matching');												
					
				}


				$data['profile'] = $this->db->select('*')
				->from('users')
				->where('id',$this->session->userdata('id'))
				->get()
				->result_array();

				$this->load->view('profile', $data);

				


			

				}

				}

				
				
		}
	}
