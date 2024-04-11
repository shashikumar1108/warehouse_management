<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banks extends CI_Controller {

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
        $data['banks'] = $this->db->select('*')->from('banks')->where('delete_status',0)->get()->result_array();
        $this->load->view('banks/list_banks', $data);
		
    }
    
    public function addBank(){
         
        $bankAdded = $this->db->insert('banks', array( 
            'name'=>$_POST['name'],
            'branch'=>$_POST['branch'],                     
            'branch_code'=>$_POST['branch_code'],
            'account_title'=>$_POST['account_title'], 
            'account_number'=>$_POST['account_number'],
            'account_type'=>$_POST['account_type'],
            'current_balance'=>$_POST['current_balance']                   
        ));

        if($bankAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Bank Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('bank/banks');        
    }

    public function delete(){
        $bankDeleted = $this->db->where('id',$_GET['id'])->update('banks', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Bank Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('bank/banks');        
    }

    public function editBank(){
        /* print_r($_POST);
        exit(); */

        $bankUpdated = $this->db->where('id',$_POST['id'])
            ->update('banks', array(                       
                'name'=>$_POST['name'],
                'branch'=>$_POST['branch'],                     
                'branch_code'=>$_POST['branch_code'],
                'account_title'=>$_POST['account_title'], 
                'account_number'=>$_POST['account_number'],
                'account_type'=>$_POST['account_type'],
                'current_balance'=>$_POST['current_balance']                 
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Bank Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('bank/banks');
    }

    
	}
