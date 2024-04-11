<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends CI_Controller {

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
        $db2 = $this->load->database('database2', TRUE);			        
        $expenses = $db2->select('*')->from('expenses')->where('delete_status',0)->get()->result_array();
       
        foreach($expenses as $k=>$e){
            $expenses[$k]['expense_category'] = $this->db->select('name')->from('expense_category')->where('id',$e['category_id'])->get()->result_array()[0]['name'];
        }
        /* echo "<pre>";
        print_r($expenses);
        exit(); */
        $data['expenses'] = $expenses;
        $this->load->view('expenses/list_expenses', $data);		
    }
    
    public function addExpense(){
         
        $db2 = $this->load->database('database2', TRUE);
        $expenseAdded = $db2->insert('expenses', array( 
            'category_id'=>$_POST['category_id'],
            'amount'=>$_POST['amount'],
            'notes'=>$_POST['notes'],                           
        ));

        if($expenseAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Expense Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('expense');        
    }

    public function delete(){
        $db2 = $this->load->database('database2', TRUE);
        $expenseDeleted = $db2->where('id',$_GET['id'])->update('expenses', array('delete_status'=>1));
        if($db2->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Expense Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('expense');        
    }

    public function editExpense(){
        /* print_r($_POST);
        exit(); */
        $db2 = $this->load->database('database2', TRUE);
        $brandUpdated = $db2->where('id',$_POST['id'])
            ->update('expenses', array(                       
                'category_id'=>$_POST['category_id'],
                'amount'=>$_POST['amount'],
                'notes'=>$_POST['notes']                              
        ));

        if($db2->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Expense Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('expense');
    }

    public function category()
	{			        
        $db2 = $this->load->database('database2', TRUE);			        
        $data['expense_categories'] = $this->db->select('*')->from('expense_category')->where('delete_status',0)->get()->result_array();
        $this->load->view('expenses/list_expense_categories', $data);		
    }

    public function addExpenseCategory(){
         
        $expenseAdded = $this->db->insert('expense_category', array( 
            'name'=>$_POST['name'],                           
        ));

        if($expenseAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Expense Category Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('expense/category');        
    }

    public function deleteExpenseCategory(){
        $expenseCategoryDeleted = $this->db->where('id',$_GET['id'])->update('expense_category', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Expense Category Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('expense/category');        
    }

    public function editExpenseCategory(){        

        $expenseCategoryUpdated = $this->db->where('id',$_POST['id'])
            ->update('expense_category', array(                       
                'name'=>$_POST['name'],                              
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Expense Category Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('expense/category');        
    }

	}
