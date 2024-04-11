<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

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
        $data['brands'] = $this->db->select('*')->from('brand')->where('delete_status',0)->get()->result_array();
        $this->load->view('payments/list_payments', $data);
		
    }
    
    public function addBrand(){
         
        $brandAdded = $this->db->insert('brand', array( 
            'name'=>$_POST['name'],                           
        ));

        if($brandAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Brand Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('brand');        
    }

    public function delete(){
        $brandDeleted = $this->db->where('id',$_GET['id'])->update('brand', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Brand Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('brand');
    }

    public function editBrand(){
        /* print_r($_POST);
        exit(); */

        $brandUpdated = $this->db->where('id',$_POST['id'])
            ->update('brand', array(                       
                'name'=>$_POST['name'],                              
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Brand Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('brand');
    }

    /* public function assignShopWarehouse(){
       
                $assignSuccess = $this->db->insert('shop_warehouse_relationship', array(                                          
                                'shop_id'=>$_POST['id'],
                                'warehouse_id'=>$_POST['warehouse_id'],                                        
                            ));
                    
                if($assignSuccess){
                                $this->session->set_flashdata('status','success');
                                $this->session->set_flashdata('message','Shop assigned to warehouse successfully');            
                            }else{
                                $this->session->set_flashdata('status','fail'); 
                                $this->session->set_flashdata('message','Could not assign, please try later');           
                            }               
                            redirect('shops');                             


    } */

	}
