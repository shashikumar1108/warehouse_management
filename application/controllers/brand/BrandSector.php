<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BrandSector extends CI_Controller {

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
        $data['data'] = $this->db->select('*')->from('brand_sector')->where('delete_status',0)->get()->result_array();
        $this->load->view('brands/list_brandsectors', $data);
		
    }
    
    public function add(){
         
        $Added = $this->db->insert('brand_sector', array( 
            'name'=>$_POST['name'],                           
        ));

        if($Added){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Brand Sector Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('brand/BrandSector');        
    }

    public function delete(){
        $Deleted = $this->db->where('id',$_GET['id'])->update('brand_sector', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Brand Sector Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('brand/BrandSector');     
    }

    public function edit(){
        
        $Updated = $this->db->where('id',$_POST['id'])
            ->update('brand_sector', array(                       
                'name'=>$_POST['name'],                              
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Brand Sector Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('brand/BrandSector');    
     }

    

	}
