<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Towns extends CI_Controller {

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
        $data['data'] = $this->db->select('t.*, r.name as region, r.id as region_id')->from('towns t')->join('regions r', 'r.id=t.region_id')->where('t.delete_status',0)->get()->result_array();
        $this->load->view('Initilization/list_towns', $data);
		
    }
    
    public function add(){
         
        $Added = $this->db->insert('towns', array( 
            'name'=>$_POST['name'],
            'region_id'=>$_POST['region_id']                           
        ));

        if($Added){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Town Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('Initilization/towns');        
    }

    public function delete(){
        $Deleted = $this->db->where('id',$_GET['id'])->update('towns', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Town Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('Initilization/towns');
    }

    public function edit(){
        /* print_r($_POST);
        exit(); */

        $Updated = $this->db->where('id',$_POST['id'])
            ->update('towns', array(                       
                'name'=>$_POST['name'],
                'region_id'=>$_POST['region_id'],                              
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Town Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('Initilization/towns');    
    }

    

	}
