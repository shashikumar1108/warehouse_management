<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
        
        if(!$this->session->userdata('login') == true){
			redirect(base_url('/auth/login'));
        }
    }




	public function index()
	{			        
        $data['users'] = $this->db->select('*')->from('users')->where('delete_status',0)->get()->result_array();
        $this->load->view('users/list_users', $data);
		
    }
    
    public function addUser(){
        
        /*print_r($_POST);
        exit();*/

        $emailExists = $this->db->select('*')
                        ->from('users')
                        ->where(array('email'=>$_POST['email']))
                        ->get()
                        ->result_array();

        if(!empty($emailExists)){
            $this->session->set_flashdata('userAdded_status','fail'); 
            $this->session->set_flashdata('userAdded_message','Email already exists');                   
            redirect('users');
        }

        $mobileExists = $this->db->select('*')
                        ->from('users')
                        ->where(array('mobile'=>$_POST['mobile']))
                        ->get()
                        ->result_array(); 
                        
        if(!empty($mobileExists)){
            $this->session->set_flashdata('userAdded_status','fail'); 
            $this->session->set_flashdata('userAdded_message','Mobile number already exists');                   
            redirect('users');
        }     
        
        $n=10; 

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
    
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
    
        $username = $randomString; 

        $userAdded = $this->db->insert('users', array(
            'username'=>$username,            
            'email'=>$_POST['email'],
            'mobile'=>$_POST['mobile'],
            'first_name'=>$_POST['first_name'],
            'last_name'=>$_POST['last_name'],
            'password'=>md5('password'),
            'usertype'=>$_POST['usertype']         
        ));

        if($userAdded){
            $this->session->set_flashdata('userAdded_status','success');
            $this->session->set_flashdata('userAdded_message','User Added Successfully');            
        }else{
            $this->session->set_flashdata('userAdded_status','fail'); 
            $this->session->set_flashdata('userAdded_message','Could not add, please try later');           
        }               
        redirect('users');        
    }

    public function delete(){
        $userDeleted = $this->db->where('id',$_GET['id'])->update('users', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('userDeleted_status','success');
            $this->session->set_flashdata('userDeleted_message','User Deleted Successfully');            
        }else{
            $this->session->set_flashdata('userDeleted_status','fail'); 
            $this->session->set_flashdata('userDeleted_message','Could not delete, please try later');           
        }       
        
        redirect('users');
    }

    public function editUser(){
        /* print_r($_POST);
        exit(); */
        $emailExists = $this->db->select('*')
                        ->from('users')
                        ->where(array('id!='=>$_POST['id'],'email'=>$_POST['email']))
                        ->get()
                        ->result_array();

        if(!empty($emailExists)){
            $this->session->set_flashdata('userUpdated_status','fail'); 
            $this->session->set_flashdata('userUpdated_message','Email already exists for other user');                   
            redirect('users');
        }

        $mobileExists = $this->db->select('*')
                        ->from('users')
                        ->where(array('id!='=>$_POST['id'],'mobile'=>$_POST['mobile']))
                        ->get()
                        ->result_array(); 
                        
        if(!empty($mobileExists)){
            $this->session->set_flashdata('userUpdated_status','fail'); 
            $this->session->set_flashdata('userUpdated_message','Mobile number already exists for other user');                   
            redirect('users');
        }

        $userUpdated = $this->db->where('id',$_POST['id'])
            ->update('users', array(                       
                'email'=>$_POST['email'],
                'mobile'=>$_POST['mobile'],
                'first_name'=>$_POST['first_name'],
                'last_name'=>$_POST['last_name'],                
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('userUpdated_status','success');
            $this->session->set_flashdata('userUpdated_message','User Updated Successfully');            
        }else{
            $this->session->set_flashdata('userUpdated_status','fail'); 
            $this->session->set_flashdata('userUpdated_message','Could not update, please try later');           
        }       
        
        redirect('users');
    }

    public function assignUserWarehouse(){
       

        if($_POST['usertype'] == 2){
            $wh_admins = $this->db->select('id')
                        ->from('users')
                        ->where('usertype', 2)
                        ->get()
                        ->result_array();


            $adminAssigned = $this->db->select('*')
                            ->from('user_warehouse_relationship')                            
                            ->where('warehouse_id', $_POST['warehouse_id'])
                            ->where_in('user_id', array_column($wh_admins,'id'))
                            ->get()
                            ->result_array();
            
        if(!empty($adminAssigned)){
                            $this->session->set_flashdata('assign_status','fail'); 
                            $this->session->set_flashdata('assign_message','Already admin has been asigned for the selected warehouse');                   
                            redirect('users');
                            }
        }

        $alreadyAssigned = $this->db->select('*')
                            ->from('user_warehouse_relationship')
                            ->where('user_id', $_POST['id'])
                          //  ->where('warehouse_id', $_POST['warehouse_id'])
                            ->get()
                            ->result_array();
            
        if(!empty($alreadyAssigned)){
                            $this->session->set_flashdata('assign_status','fail'); 
                            $this->session->set_flashdata('assign_message','This user has already been asigned for the selected warehouse');                   
                            redirect('users');
                            }   
                            
                $assignSuccess = $this->db->insert('user_warehouse_relationship', array(                                          
                                'user_id'=>$_POST['id'],
                                'warehouse_id'=>$_POST['warehouse_id'],                                        
                            ));
                    
                if($assignSuccess){
                                $this->session->set_flashdata('assign_status','success');
                                $this->session->set_flashdata('assign_message','User assigned to warehouse successfully');            
                            }else{
                                $this->session->set_flashdata('assign_status','fail'); 
                                $this->session->set_flashdata('assign_message','Could not assign, please try later');           
                            }               
                            redirect('users');                             


    }

    public function assignUserShop(){

        $alreadyAssigned = $this->db->select('*')
                            ->from('user_shop_relationship')
                            ->where('user_id', $_POST['id'])
                           // ->where('shop_id', $_POST['shop_id'])
                            ->get()
                            ->result_array();
            
        if(!empty($alreadyAssigned)){
                            $this->session->set_flashdata('assign_status','fail'); 
                            $this->session->set_flashdata('assign_message','This user has already been asigned for the selected shop');                   
                            redirect('users');
                            }   
                            
                $assignSuccess = $this->db->insert('user_shop_relationship', array(                                          
                                'user_id'=>$_POST['id'],
                                'shop_id'=>$_POST['shop_id'],                                        
                            ));
                    
                if($assignSuccess){
                                $this->session->set_flashdata('assign_status','success');
                                $this->session->set_flashdata('assign_message','User assigned to shop successfully');            
                            }else{
                                $this->session->set_flashdata('assign_status','fail'); 
                                $this->session->set_flashdata('assign_message','Could not assign, please try later');           
                            }               
                            redirect('users');                             


    }
    
    public function assignUserDepartment(){

        $alreadyAssigned = $this->db->select('*')
                            ->from('user_department_relationship')
                            ->where('user_id', $_POST['id'])
                            ->where('department_id', $_POST['department_id'])
                            ->get()
                            ->result_array();
            
        if(!empty($alreadyAssigned)){
                            $this->session->set_flashdata('assign_status','fail'); 
                            $this->session->set_flashdata('assign_message','This user has already been asigned for the selected department');                   
                            redirect('users');
                            }   
                            
                $assignSuccess = $this->db->insert('user_department_relationship', array(                                          
                                'user_id'=>$_POST['id'],
                                'department_id'=>$_POST['department_id'],                                        
                            ));
                    
                if($assignSuccess){
                                $this->session->set_flashdata('assign_status','success');
                                $this->session->set_flashdata('assign_message','User assigned to department successfully');            
                            }else{
                                $this->session->set_flashdata('assign_status','fail'); 
                                $this->session->set_flashdata('assign_message','Could not assign, please try later');           
                            }               
                            redirect('users');                             


    }

	
	}
