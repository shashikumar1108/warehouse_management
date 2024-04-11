<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShopPayments extends CI_Controller {

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
        $payments = $db2->select('*')->from('shop_payments')->get()->result_array();
        
        foreach($payments as $k=>$p){

            if($p['payment_method'] == 2){
                $payments[$k]['bank_name'] = $this->db->select('*')->from('banks')->where('id',$p['bank_id'])->get()->result_array()[0]['name'];            
                $payments[$k]['shop_name'] = $this->db->select('*')->from('shops')->where('id',$p['shop_id'])->get()->result_array()[0]['name'];
    
            }else{
                $payments[$k]['bank_name'] = 'Not Applicable';
                $payments[$k]['shop_name'] = $this->db->select('*')->from('shops')->where('id',$p['shop_id'])->get()->result_array()[0]['name'];
                $payments[$k]['cheque_number'] = 'Not Applicable';
            
            }

            
            
            
        }        
        $data['data'] = $payments;
        $this->load->view('shoppayments/list_shoppayments', $data);		
    }
    
    public function add(){

        $db2 = $this->load->database('database2', TRUE);

        if($_POST['payment_method'] == 1){
            $Added = $db2->insert('shop_payments', array(                                               
                'shop_id'=>$_POST['shop_id'],
                'amount'=>$_POST['amount'], 
                'payment_method'=> 1,                            
                'description'=>$_POST['description']                           
            ));
        }else{
            $Added = $db2->insert('shop_payments', array(             
                'bank_id'=>$_POST['bank_id'],                     
                'shop_id'=>$_POST['shop_id'],
                'amount'=>$_POST['amount'], 
                'cheque_number'=>$_POST['cheque_number'],
                'payment_method'=> 2,             
                'description'=>$_POST['description']                           
            ));
        }

        if($Added){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Shop Payment Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('ShopPayments');        
    }

    /* public function delete(){
        $bankDeleted = $this->db->where('id',$_GET['id'])->update('banks', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Bank Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('bank/banks');        
    } */

    public function edit(){
        /* print_r($_POST);
        exit(); */

        $db2 = $this->load->database('database2', TRUE);
        $Updated = $db2->where('id',$_POST['id'])
            ->update('shop_payments', array(                       
                'amount'=>$_POST['amount'],
                'description'=>$_POST['description']                                  
        ));

        if($db2->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Shop Payment Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('ShopPayments');
    }

    public function assignShopWarehouse(){
       
        $alreadyAssigned = $this->db->select('*')
                            ->from('shop_warehouse_relationship')
                            ->where('shop_id', $_POST['id'])
                            ->where('warehouse_id', $_POST['warehouse_id'])
                            ->get()
                            ->result_array();
            
        if(!empty($alreadyAssigned)){
                            $this->session->set_flashdata('status','fail'); 
                            $this->session->set_flashdata('message','This shop has already been asigned for the selected warehouse');                   
                            redirect('shops');
                            }


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


    }

    public function products(){
        $data['products'] = $this->db->select('p.id, p.description, p.name as product_name, b.name as brand_name, c.name as category_name, sco.name as sub_category_one_name, sct.name as sub_category_two_name')
                            ->from('product_shop_relationship psr')
                            ->join('products p', 'p.id = psr.product_id')
                            ->join('brand b', 'b.id = p.brand')
                            ->join('category c', 'c.id = p.category')
                            ->join('sub_categories_one sco', 'sco.id = p.sub_category_one')
                            ->join('sub_categories_two sct', 'sct.id = p.sub_category_two')                           
                            ->where('psr.shop_id', $_GET['id'])
                            ->where('psr.delete_status', 0)
                            ->get()
                            ->result_array();
    
        $data['shop_id'] = $_GET['id'];                                    
        $this->load->view('shops/products_shop', $data);
    }
    
    public function addProduct(){
    
        foreach($_POST['products'] as $p){
    
            $alreadyExists = $this->db->select('*')
                            ->from('product_shop_relationship')
                            ->where(array('product_id'=>$p, 'shop_id'=>$_POST['shop_id']))
                            ->where('delete_status',1)
                            ->get()->result_array();
    
            if(empty($alreadyExists)){
                $productAdded = $this->db->insert('product_shop_relationship', array(
                    'product_id'=>$p,
                    'shop_id'=>$_POST['shop_id'],                        
                ));
            }
            
        }        
    
        if($productAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Product Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }
    
        $data['shop_id'] = $_POST['id'];                                    
        redirect('shops/products?id='.$_POST['shop_id']);
    }
    
    public function deleteProduct(){
        $productDeleted = $this->db->where('id',$_GET['id'])->update('product_shop_relationship', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Product Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('shops/products?id='.$_GET['shop_id']);
    }

	}
