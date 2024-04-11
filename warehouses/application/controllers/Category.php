<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

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
        $data['categories'] = $this->db->select('*')->from('category')->where('delete_status',0)->get()->result_array();
        $this->load->view('categories/list_categories', $data);
		
    }
    
    public function addCategory(){
         
        $categoryAdded = $this->db->insert('category', array( 
            'name'=>$_POST['name'],                           
        ));

        if($categoryAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Category Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('category');        
    }

    public function delete(){
        $categoryDeleted = $this->db->where('id',$_GET['id'])->update('category', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Category Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('category');
    }

    public function editCategory(){
        /* print_r($_POST);
        exit(); */

        $categoryUpdated = $this->db->where('id',$_POST['id'])
            ->update('category', array(                       
                'name'=>$_POST['name'],                              
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Category Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('category');
    }

    public function listSubCategoryOne()
	{			        
        $data['listSubCategoryOne'] = $this->db->select('sco.*,c.name as parent_category')
        ->from('sub_categories_one sco')
        ->join('category c', 'sco.category_id=c.id')
        ->where('sco.delete_status',0)
        ->where('c.delete_status',0)
        ->get()->result_array();

        /* print_r($data);
        exit(); */

        $this->load->view('categories/list_subcategories_one', $data);
		
    }

    public function addSubCategoryOne(){
        $subCategoryOneAdded = $this->db->insert('sub_categories_one', array( 
            'name'=>$_POST['name'],
            'category_id'=>$_POST['category_id']                        
        ));

        if($subCategoryOneAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Sub Category One Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('category/listSubCategoryOne');
    }

    public function editSubCategoryOne(){
        /* print_r($_POST);
        exit(); */

        $subCategoryOneUpdated = $this->db->where('id',$_POST['id'])
            ->update('sub_categories_one', array(                       
                'name'=>$_POST['name'],
                'category_id'=>$_POST['category_id']                              
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Sub Category One Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('category/listSubCategoryOne');
    }
    
    public function deleteSubCategoryOne(){
        $subCategoryOneDeleted = $this->db->where('id',$_GET['id'])->update('sub_categories_one', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Sub Category One Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('category/listSubCategoryOne');
    }

    public function listSubCategoryTwo()
	{			        
        $data['listSubCategoryTwo'] = $this->db->select('sct.*,sco.id as sub_parent_one_id, sco.name as sub_parent_one_name,c.name as parent_category,')
        ->from('sub_categories_two sct')
        ->join('sub_categories_one sco', 'sct.sub_category_one_id=sco.id')
        ->join('category c', 'sct.category_id=c.id')
        ->where('sco.delete_status',0)
        ->where('sct.delete_status',0)
        ->where('c.delete_status',0)
        ->get()->result_array();

        /* echo "<pre>";
        print_r($data);
        exit(); */

        $this->load->view('categories/list_subcategories_two', $data);
		
    }

    public function addSubCategoryTwo(){
        $subCategoryTwoAdded = $this->db->insert('sub_categories_two', array( 
            'name'=>$_POST['name'],
            'category_id'=>$_POST['category_id'],
            'sub_category_one_id'=>$_POST['sub_category_one_id'],                        
        ));

        if($subCategoryTwoAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Sub Category Two Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('category/listSubCategoryTwo');
    }

    public function editSubCategoryTwo(){
        /* print_r($_POST);
        exit(); */

        $subCategoryTwoUpdated = $this->db->where('id',$_POST['id'])
            ->update('sub_categories_two', array(                       
                'name'=>$_POST['name'],
                'category_id'=>$_POST['category_id'],  
                'sub_category_one_id'=>$_POST['sub_category_one_id'],                            
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Sub Category Two Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('category/listSubCategoryTwo');
    }
    
    public function deleteSubCategoryTwo(){
        $subCategoryTwoDeleted = $this->db->where('id',$_GET['id'])->update('sub_categories_two', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Sub Category Two Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('category/listSubCategoryTwo');
    }

    public function getSubCategoryOne(){

        $categories = $this->db->select('*')
                    ->from('sub_categories_one')
                    ->where('delete_status',0)
                    ->where('category_id', $_GET['category_id'])
                    ->get()->result_array();
        echo json_encode(array('data'=> $categories));

    }  

    public function getSubCategorytwo(){
        
        $categories = $this->db->select('*')
                    ->from('sub_categories_two')
                    ->where('delete_status',0)
                    ->where('category_id',$_GET['category_id'])
                    ->where('sub_category_one_id', $_GET['sub_category_one_id'])
                    ->get()->result_array();
        echo json_encode(array('data'=> $categories));

    }   


    }
    

