<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agents extends CI_Controller {

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
        $data['agents'] = $this->db->select('*')->from('users')->where('delete_status',0)->where('usertype', 6)->get()->result_array();
        $this->load->view('agents/list_agents', $data);
		
    }
    
    public function addAgent(){

        $emailExists = $this->db->select('*')
                        ->from('users')
                        ->where(array('email'=>$_POST['email']))
                        ->get()
                        ->result_array();

        if(!empty($emailExists)){
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Email already exists');                   
            redirect('agents');
        }

        $mobileExists = $this->db->select('*')
                        ->from('users')
                        ->where(array('mobile'=>$_POST['mobile']))
                        ->get()
                        ->result_array(); 
                        
        if(!empty($mobileExists)){
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Mobile number already exists');                   
            redirect('agents');
        }     
        
        $n=10; 

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
    
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
    
        $username = $randomString; 

        $agentAdded = $this->db->insert('users', array(
            'username'=>$username,            
            'email'=>$_POST['email'],
            'mobile'=>$_POST['mobile'],            
            'password'=>md5('password'),
            'usertype'=>6,
            'state_code'=>$_POST['state_code'],
            'gst'=>$_POST['gst'],
            'commision'=>$_POST['commision']         
        ));

        if($agentAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Agent Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('agents');        
    }

    public function delete(){
        $agentDeleted = $this->db->where('id',$_GET['id'])->update('users', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Agent Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('agents');
    }

    public function editAgent(){
        /* print_r($_POST);
        exit(); */
        $emailExists = $this->db->select('*')
                        ->from('users')
                        ->where(array('id!='=>$_POST['id'],'email'=>$_POST['email']))
                        ->get()
                        ->result_array();

        if(!empty($emailExists)){
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Email already exists for other user');                   
            redirect('agents');
        }

        $mobileExists = $this->db->select('*')
                        ->from('users')
                        ->where(array('id!='=>$_POST['id'],'mobile'=>$_POST['mobile']))
                        ->get()
                        ->result_array(); 
                        
        if(!empty($mobileExists)){
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Mobile number already exists for other user');                   
            redirect('agents');
        }

        $agentUpdated = $this->db->where('id',$_POST['id'])
            ->update('users', array(                                                  
                'email'=>$_POST['email'],
                'mobile'=>$_POST['mobile'],                                            
                'state_code'=>$_POST['state_code'],
                'gst'=>$_POST['gst'],
                'commision'=>$_POST['commision']                 
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Agent Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('agents');
    }

	
	}
