<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

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
        $db2 = $this->load->database('database2', TRUE);
    }


	public function index()
	{			        
	    	    
	    
	        $products = $this->db->select('p.*, u.first_name, u.last_name')
                    ->from('products p')
                    ->join('users u', 'u.id = p.user_added')
                    ->where('p.delete_status',0)
                    ->get()->result_array();
	    
	    
        
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

        $this->load->view('products/list_products', $data);
		
    }
    
    public function addProduct(){
        
        $productAdded = $this->db->insert('products', array( 
            'name'=>$_POST['name'],
            'brand'=>$_POST['brand'],
            'category'=>$_POST['category'],
            'sub_category_one'=>$_POST['sub_category_one'],
            'sub_category_two'=>$_POST['sub_category_two'], 
            'user_added'=>$this->session->userdata['id'],                               
            'description'=>$_POST['description'],                              
        ));

        if($productAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Product Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('products');        
    }

    public function delete(){
        $productsDeleted = $this->db->where('id',$_GET['id'])->update('products', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Product Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('products');
    }

    public function editProduct(){
        /* print_r($_POST);
        exit(); */

        $productUpdated = $this->db->where('id',$_POST['id'])
            ->update('products', array(                       
                'name'=>$_POST['name'],
                // 'brand'=>$_POST['brand'],
                'category'=>$_POST['category'],
                'sub_category_one'=>$_POST['sub_category_one'],
                'sub_category_two'=>$_POST['sub_category_two'],                                
                'description'=>$_POST['description'],                
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Product Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('products');
    }

    public function batches()
	{
	    $db1 = $this->db;
        $db2 = $this->load->database('database2', TRUE);

        
            $batches = $db2->select('*')->from('batches')->where('product_id',$_GET['id'])->get()->result_array();
        
        
        /* echo "<pre>";
        print_r($batches);
        exit(); */


        foreach($batches as $k=>$b){
            $product_details =  $this->db->select('*')->from('products')->where('id',$b['product_id'])->get()->result_array();
            $batches[$k]['product_name'] = $product_details[0]['name'];
            $batches[$k]['brand_name'] = $this->db->select('*')->from('brand')->where('id',$product_details[0]['brand'])->get()->result_array()[0]['name'];
            $batches[$k]['category_name'] = $this->db->select('*')->from('category')->where('id',$product_details[0]['category'])->get()->result_array()[0]['name'];
            $batches[$k]['supplier_name'] = $this->db->select('u.id, s.name')
            ->from('users u')
            ->join('user_supplier_relationship us', 'us.user_id = u.id')
            ->join('suppliers s', 's.id = us.supplier_id')
            ->where('u.id',$b['supplier_id'])
            ->get()
            ->result_array();
        }
        /* echo "<pre>";
        print_r($batches);
        exit(); */

        $data['product_id'] = $_GET['id'];
        $data['batches'] = $batches;        

        $this->load->view('products/list_batches', $data);
	    
	}
    
    public function addBatch(){
         
        /* print_r($_POST);
        exit(); */

        $db2 = $this->load->database('database2', TRUE);
	
        $batchAdded = $db2->insert('batches', array( 
            'user_added'=>$this->session->userdata('id'),
            'supplier_id'=>$_POST['supplier_id'],
            'product_id'=>$_POST['product_id'],             
            'batch_id'=>$_POST['batch_id'],
            'product_code'=>$_POST['product_code'],
            'wholesale_price'=>$_POST['wholesale_price'],
            'retail_price_per_product'=>$_POST['retail_price_per_product'],                                
            'tax_type'=>$_POST['tax_type'],
            'expiry_date'=>$_POST['expiry_date'],
            'quantity'=>$_POST['quantity'],
            'cgst'=>$_POST['cgst'], 
            'sgst'=>$_POST['sgst'], 
            'igst'=>$_POST['igst'], 
            'cgst_tax'=>$_POST['cgst_tax'], 
            'sgst_tax'=>$_POST['sgst_tax'], 
            'igst_tax'=>$_POST['igst_tax'], 
            'total_tax'=>$_POST['total_tax'], 
            'total'=>$_POST['total']                                          
        ));

        if($batchAdded){
            
            $quantity =$db2->select_sum('quantity')->from('batches')->where('product_id',$_POST['product_id'])->get()->result_array();
            
            $this->db->where('id',$_POST['product_id'])->update('products', array('quantity'=>$quantity[0]['quantity']));
            
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Batch Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('products/batches?id='.$_POST['product_id']);        
    }

    public function deleteBatch(){//exit();
        $batchDeleted = $this->db->where('id',$_GET['id'])->update('inventory_transaction.batches', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Batch Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('products');
    }



    public function editBatchView(){
        $db1 = $this->db;
        $db2 = $this->load->database('database2', TRUE);


        $batch = $db2->select('*')->from('batches')->where('id',$_GET['id'])->get()->result_array();
        
        $product_details =  $this->db->select('*')->from('products')->where('id',$batch[0]['product_id'])->get()->result_array();
        $batch['product_name'] = $product_details[0]['name'];
        $batch['brand_name'] = $this->db->select('*')->from('brand')->where('id',$product_details[0]['brand'])->get()->result_array()[0]['name'];
        $batch['category_name'] = $this->db->select('*')->from('category')->where('id',$product_details[0]['category'])->get()->result_array()[0]['name'];
       
        /* print_r($batch);
        exit(); */

        $data['product_id'] = $batch[0]['product_id'];
        $data['batch_id'] = $_GET['id'];
        $data['batch'] = $batch;        

        $this->load->view('products/edit_batch', $data);
    }




    public function editBatch(){
        /* print_r($_POST);
        exit(); */

$db2 = $this->load->database('database2', TRUE);

        $productUpdated = $db2->where('id',$_POST['id'])
            ->update('batches', array(                       
                'user_added'=>$this->session->userdata('id'),
                'product_id'=>$_POST['product_id'],            
                'batch_id'=>$_POST['batch_id'],
                'product_code'=>$_POST['product_code'],
                'wholesale_price'=>$_POST['wholesale_price'],
                'retail_price_per_product'=>$_POST['retail_price_per_product'],                                
                'tax_type'=>$_POST['tax_type'],
                'expiry_date'=>$_POST['expiry_date'], 
                'quantity'=>$_POST['quantity'],
                'cgst'=>$_POST['cgst'], 
                'sgst'=>$_POST['sgst'], 
                'igst'=>$_POST['igst'], 
                'cgst_tax'=>$_POST['cgst_tax'], 
                'sgst_tax'=>$_POST['sgst_tax'], 
                'igst_tax'=>$_POST['igst_tax'], 
                'total_tax'=>$_POST['total_tax'], 
                'total'=>$_POST['total']                
        ));

        if($db2->affected_rows() == 1){
            
            $quantity =$db2->select_sum('quantity')->from('batches')->where('product_id',$_POST['product_id'])->get()->result_array();
            
            $this->db->where('id',$_POST['product_id'])->update('products', array('quantity'=>$quantity[0]['quantity']));
            
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Batch Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('products');
    }

    public function assignProduct(){

        $alreadyAssigned = $this->db->select('*')
                            ->from('product_department_relationship')
                            ->where('product_id', $_POST['id'])
                            ->where('department_id', $_POST['department_id'])
                            ->get()
                            ->result_array();
            
        if(!empty($alreadyAssigned)){
                            $this->session->set_flashdata('status','fail'); 
                            $this->session->set_flashdata('message','This product has already been asigned for the selected department');                   
                            redirect('products');
                            }   
                            
                $assignSuccess = $this->db->insert('product_department_relationship', array(                                          
                                'product_id'=>$_POST['id'],
                                'department_id'=>$_POST['department_id'],                                        
                            ));
                    
                if($assignSuccess){
                                $this->session->set_flashdata('status','success');
                                $this->session->set_flashdata('message','Product assigned to department successfully');            
                            }else{
                                $this->session->set_flashdata('status','fail'); 
                                $this->session->set_flashdata('message','Could not assign, please try later');           
                            }               
                            redirect('products');                             


    }
    
	}

