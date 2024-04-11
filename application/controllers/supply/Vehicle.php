<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends CI_Controller {

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
        $data['data'] = $this->db->select('*')->from('vehicles')->where('delete_status',0)->get()->result_array();
        $this->load->view('supply/list_vehicles', $data);
		
    }
    
    public function add(){
         
        $Added = $this->db->insert('vehicles', array( 
            'name'=>$_POST['name'],
            'vehicle_number'=>$_POST['vehicle_number'],                     
            'vehicle_id'=>$_POST['vehicle_id'],
            'chase_number'=>$_POST['chase_number'], 
            'engine_number'=>$_POST['engine_number'],
            'date'=>$_POST['date']                              
        ));

        if($Added){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Vehicle Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('supply/vehicle');        
    }

    public function delete(){
        $Deleted = $this->db->where('id',$_GET['id'])->update('vehicles', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Vehicle Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('supply/vehicle');      
    }

    public function edit(){
        
        $Updated = $this->db->where('id',$_POST['id'])
            ->update('vehicles', array(                       
                'name'=>$_POST['name'],
                'vehicle_number'=>$_POST['vehicle_number'],                     
                'vehicle_id'=>$_POST['vehicle_id'],
                'chase_number'=>$_POST['chase_number'], 
                'engine_number'=>$_POST['engine_number'],
                'date'=>$_POST['date']                 
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Vehicle Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('supply/vehicle');
    }

    
	}
