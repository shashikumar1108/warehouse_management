<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

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
        $data['department'] = $this->db->select('*')->from('department')->where('delete_status',0)->get()->result_array();
        $this->load->view('department/list_department', $data);
		
    }
    
    public function addDepartment(){
         
        $departmentAdded = $this->db->insert('department', array( 
            'name'=>$_POST['name']                           
        ));

        if($departmentAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Department Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('Department');        
    }

    public function delete(){
        $departmentDeleted = $this->db->where('id',$_GET['id'])->update('department', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Department Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('Department');
    }

    public function editDepartment(){
        /* print_r($_POST);
        exit(); */

        $StateCodeUpdated = $this->db->where('id',$_POST['id'])
            ->update('department', array(                       
                'name'=>$_POST['name']                             
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Department Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('Department');
    }

    public function products(){

            /* print_r($this->session->userdata);
            exit(); */

            if($this->session->userdata['department_id'] == -1){
                $products = array();
            }elseif($this->session->userdata['department_id'] == 0){
                $product_ids = $this->db->select('product_id')->from('product_department_relationship')->where('department_id', $_GET['id'])->get()->result_array();
                
                /* print_r($product_ids);
                exit(); */
                $product_ids = array_column($product_ids, 'product_id');
                
                $products = $this->db->select('p.*, u.first_name, u.last_name')
                    ->from('products p')
                    ->where_in('p.id', $product_ids)
                    ->join('users u', 'u.id = p.user_added')
                    ->where('p.delete_status',0)
                    ->get()->result_array();
            }else{
                $product_ids = $this->db->select('product_id')->from('product_department_relationship')->where('department_id', $this->session->userdata['department_id'])->get()->result_array();
                $product_ids = array_column($product_ids, 'product_id');
                
                $products = $this->db->select('p.*, u.first_name, u.last_name')
                        ->from('products p')
                        ->where_in('p.id', $product_ids)
                        ->join('users u', 'u.id = p.user_added')
                        ->where('p.delete_status',0)
                        ->get()->result_array();
            }            
            
            foreach($products as $key=>$p){
                $brand = $this->db->select('*')->from('brand')->where('id', $p['brand'])->get()->result_array();            
                $products[$key]['brand_name'] = empty($brand) ? '-' : $brand[0]['name'];            
                $category = $this->db->select('*')->from('category')->where('id', $p['category'])->get()->result_array();            
                $products[$key]['category_name'] = empty($category) ? '-' : $category[0]['name'];                        
                $sub_category_one = $this->db->select('*')->from('sub_categories_one')->where('id', $p['sub_category_one'])->get()->result_array();            
                $products[$key]['sub_category_one_name'] = empty($sub_category_one) ? '-' : $sub_category_one[0]['name'];                        
                $sub_category_two = $this->db->select('*')->from('sub_categories_two')->where('id', $p['sub_category_two'])->get()->result_array();            
                $products[$key]['sub_category_two_name'] = empty($sub_category_two) ? '-' : $sub_category_two[0]['name'];
                
            }
            
            $data['products'] = $products;        
    
            $this->load->view('department/list_products', $data);    
    }



	}
