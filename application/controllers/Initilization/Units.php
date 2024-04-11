<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Units extends CI_Controller {

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
        $data['data'] = $this->db->select('*')->from('units')->where('delete_status',0)->get()->result_array();
        $this->load->view('Initilization/list_units', $data);
		
    }
    
    public function add(){
         
        $Added = $this->db->insert('units', array( 
            'name'=>$_POST['name'],
            'symbol'=>$_POST['symbol']                           
        ));

        if($Added){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Unit Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('Initilization/units');        
    }

    public function delete(){
        $Deleted = $this->db->where('id',$_GET['id'])->update('units', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Unit Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('Initilization/units'); 
    }

    public function edit(){
        /* print_r($_POST);
        exit(); */

        $Updated = $this->db->where('id',$_POST['id'])
            ->update('units', array(                       
                'name'=>$_POST['name'],
                'symbol'=>$_POST['symbol']                              
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Unit Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('Initilization/units'); 
    }

    

	}
