<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Regions extends CI_Controller {

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
        $data['data'] = $this->db->select('*')->from('regions')->where('delete_status',0)->get()->result_array();
        $this->load->view('Initilization/list_regions', $data);
		
    }
    
    public function add(){
         
        $Added = $this->db->insert('regions', array( 
            'name'=>$_POST['name'],
            'region_code'=>$_POST['region_code'],                           
        ));

        if($Added){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Region Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('Initilization/regions');        
    }

    public function delete(){
        $Deleted = $this->db->where('id',$_GET['id'])->update('regions', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Region Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('Initilization/regions');        
    }

    public function edit(){
        /* print_r($_POST);
        exit(); */

        $Updated = $this->db->where('id',$_POST['id'])
            ->update('regions', array(                       
                'name'=>$_POST['name'],   
                'region_code'=>$_POST['region_code'],                           
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Region Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('Initilization/regions');        
    }


	}
