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
		$user = $this->db->select('u.*,uwr.warehouse_id')
		->from('users u')
		->join('user_warehouse_relationship uwr','uwr.user_id=u.id')
		->where(array('u.usertype'=>2,'u.email'=>$_POST['username'], 'u.password'=>md5($_POST['password'])))
		->get()
		->result_array();

		// echo $this->db->last_query();
		// echo '<pre>';print_r($user);exit;

		if(!empty($user)){//print_r('hi');
			$this->session->set_userdata(
				array(
					'portal'=>'warehouse',
					'login'=>true,
					'username'=>$user[0]['username'], 
					'user_type'=>$user[0]['usertype'],
					'id'=>$user[0]['id'],
					'warehouse_id'=>$user[0]['warehouse_id'],
					'profile_pic'=>$user[0]['profile_pic'],
				)
			);

			redirect(base_url('/auth/dashboard'));
		}else{
			redirect(base_url('/auth/login/1'));
		}		
	}

	public function dashboard(){
		// print_r($this->session->userdata());exit;
		$warehouse_id = $this->session->userdata('warehouse_id');
		if($this->session->userdata('login') == true && $this->session->userdata('portal') == 'warehouse'){
			// $db2 = $this->load->database('database2', TRUE);	
			$where = array(
				'delete_status'=>0,
				'approval_status'=>'UnApproved',
				'quotation_status'=>1,
				'warehouse_id'=>$warehouse_id,
			);
			$data['pending_quotation'] = $this->db->select('quotation_id')->from('quotation')->where($where)->get()->num_rows();

			$where['approval_status'] = 'Approved';
			$data['approved_quotation'] = $this->db->select('quotation_id')->from('quotation')->where($where)->get()->num_rows();
			
			// $where['proposal_status'] = 2;
			// $data['confirmed_quotation'] = $this->db->select('quotation_id')->from('vendor_quotation')->where($where)->get()->num_rows();
			$data['confirmed_quotation'] = 0;
			
			$data['confirmed_quotation'] = $this->db->select('q.quotation_id')
				->from('quotation q')
				->join('vendor_quotation vq', 'vq.quotation_id=q.quotation_id')
				->join('vendor_quotation_details vqd', 'vqd.vendor_quote_id=vq.vendor_quote_id')
				->join('suppliers s','s.id=vqd.supplier_id')
				->where(array(
					'q.approval_status' => 'approved',
					'q.delete_status' => '0',
					'q.quotation_status' => '2',
					'vq.proposal_status' => 2,
					'vq.delete_status' => 0,
					'q.warehouse_id' => $warehouse_id,
				))->group_by('q.quotation_id')->get()->num_rows();
			
			// $where = array();
			// $data['delivery_note_quotation'] = $this->db->select('quotation_id')->from('vendor_quotation')->where($where)->get()->num_rows();

			$this->db->select('q.quotation_id')
				->from('quotation q')
				->join('vendor_quotation vq','q.quotation_id=vq.quotation_id')
				->join('warehouse w', 'w.id = q.warehouse_id')
				->where(
					array(
						'q.delete_status'=>0,
						'q.approval_status'=>'approved',
						'vq.proposal_status' => 7,
						'q.warehouse_id'=>$warehouse_id,
					)
            );

			$data['shipments'] = $this->db->get()->num_rows();

			$where = array(
				'q.delete_status'=>0,
				'vq.delete_status'=>0,
				'i.invoice_status'=>2,
				// 'vq.supplier_id'=>$this->session->userdata('supplier_id'),
			);
			$select = 'sum(i.grand_total) as total,sum(i.paid_amount) as paid';
			$total = $this->db->select($select)->from('quotation q')
						->join('vendor_quotation vq','vq.quotation_id=q.quotation_id')
						->join('invoice i','i.quotation_id=q.quotation_id')
						->where($where)->get()->result_array();

			$data['amount'] = array(
				'total'=>$total[0]['total'],
				'paid'=>$total[0]['paid'],
				'balance'=>0,
			);

			$where = array(
				'q.delete_status'=>0,
				'vq.delete_status'=>0,
				'i.invoice_status'=>1,
				// 'vq.supplier_id'=>$this->session->userdata('supplier_id'),
			);
			$select = 'sum(i.pending_amount) as pending';
			$total = $this->db->select($select)->from('quotation q')
						->join('vendor_quotation vq','vq.quotation_id=q.quotation_id')
						->join('invoice i','i.quotation_id=q.quotation_id')
						->where($where)->get()->result_array();

			// echo '<pre>';print_r($total);exit;
			$data['amount']['balance'] = ($total[0]['pending']!=''?$total[0]['pending']:0);
			// echo '<pre>';print_r($data);exit;
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
		if($this->session->userdata('login') == true && $this->session->userdata('portal') == 'warehouse'){

			$data['user'] = $this->db->select('*')
							->from('users')
							->where(array('id'=>$this->session->userdata('id'),'usertype'=>2))
							->get()
							->result_array();
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
		if($this->session->userdata('login') == true && $this->session->userdata('portal') == 'warehouse'){

			if( !empty($_POST['npassword']) && !empty($_POST['npassword']) ){
				$password = md5(trim($_POST['npassword']));
				// echo $password;exit;
				$data['user'] = $this->db->select('*')
					->from('users')
					->where(array('id'=>$this->session->userdata('id'),'usertype'=>2))
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
		if($this->session->userdata('login') == true && $this->session->userdata('portal') == 'warehouse'){

			$data['user'] = $this->db->select('*')
							->from('users')
							->where(array('id'=>$this->session->userdata('id'),'usertype'=>2))
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
		if($this->session->userdata('login') == true && $this->session->userdata('portal') == 'warehouse'){

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
					->where(array('id'=>$this->session->userdata('id'),'usertype'=>2))
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
						$result['status'] = false;
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
		if($this->session->userdata('login') == true && $this->session->userdata('portal') == 'warehouse'){
			if( !empty($_FILES['file']) && !empty($_FILES['file']['name']) ){
				
				$data['user'] = $this->db->select('*')
					->from('users')
					->where(array('id'=>$this->session->userdata('id'),'usertype'=>2))
					->get()
					->result_array();
					
				if( count($data['user']) ){	
					if ( ! $this->upload->do_upload('file')){
						$error = array('error' => $this->upload->display_errors());
						// echo '<pre>';print_r($error);exit;
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
								'portal'=>'warehouse',
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
