<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CI_Controller {

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
        
        $db2 = $this->load->database('database2', TRUE);

        if(!$this->session->userdata('login') == true){
			redirect(base_url('/auth/login'));
        }
    }




	public function index()
	{			        
        $data['suppliers'] = $this->db->select('*')->from('suppliers')->where('delete_status',0)->get()->result_array();
        $this->load->view('suppliers/list_suppliers', $data);
		
    }
    
    public function addSupplier(){        

        $supplierData = array( 
            'name'=>$_POST['name'],
            'phone'=>$_POST['phone'],
            'email'=>$_POST['email'],
            'pan'=>$_POST['pan'],
            'gst'=>$_POST['gst'],                                
            'state_code'=>$_POST['state_code'],
            'description'=>$_POST['description'], 
            'address'=>$_POST['address'],                   
        );

        if($this->session->userdata['usertype'] != 1){
            $supplierData['active_status'] = 0;
        }


        $supplierAdded = $this->db->insert('suppliers', $supplierData);

        if($supplierAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Supplier Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('suppliers');        
    }

    public function delete(){
        $supplierDeleted = $this->db->where('id',$_GET['id'])->update('suppliers', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Supplier Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('suppliers');
    }

    public function editSupplier(){
        /* print_r($_POST);
        exit(); */

        $supplierUpdated = $this->db->where('id',$_POST['id'])
            ->update('suppliers', array(                       
                'name'=>$_POST['name'],
                'phone'=>$_POST['phone'],
                'email'=>$_POST['email'],
                'pan'=>$_POST['pan'],
                'gst'=>$_POST['gst'],                                
                'state_code'=>$_POST['state_code'],
                'description'=>$_POST['description'], 
                'address'=>$_POST['address'],               
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Supplier Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('suppliers');
    }

    public function assignShopWarehouse(){
       
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

    public function users()
	{	$data['supplier_id'] = $_GET['id'];		   
        $user_ids = $this->db->select('user_id')
                    ->from('user_supplier_relationship')
                    ->where('supplier_id',$_GET['id'])
                    ->get()->result_array();  


        if(!empty($user_ids)){
            $data['users'] = $this->db->select('*')
                        ->from('users')
                        ->where_in('id',array_column($user_ids, 'user_id'))
                        ->where('delete_status',0)
                        ->get()->result_array();
        }else{
            $data['users'] = $this->db->select('*')
                        ->from('users')
                        ->where_in('id','AAABBBCCC')
                        ->where('delete_status',0)
                        ->get()->result_array();
        }

        
        $this->load->view('suppliers/users_suppliers', $data);
		
    }

    public function addUser(){

/* 
        print_r($_POST);
        exit(); */

        $emailExists = $this->db->select('*')
                        ->from('users')
                        ->where(array('email'=>$_POST['email']))
                        ->get()
                        ->result_array();

        if(!empty($emailExists)){
            $this->session->set_flashdata('userAdded_status','fail'); 
            $this->session->set_flashdata('userAdded_message','Email already exists');                   
            redirect('suppliers/users?id='.$_POST['supplier_id']); 
        }

        $mobileExists = $this->db->select('*')
                        ->from('users')
                        ->where(array('mobile'=>$_POST['mobile']))
                        ->get()
                        ->result_array(); 
                        
        if(!empty($mobileExists)){
            $this->session->set_flashdata('userAdded_status','fail'); 
            $this->session->set_flashdata('userAdded_message','Mobile number already exists');                   
            redirect('suppliers/users?id='.$_POST['supplier_id']); 
        }     
        
        $n=10; 

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
    
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
    
        $username = $randomString; 

        $userAdded = $this->db->insert('users', array(
            'username'=>$username,            
            'email'=>$_POST['email'],
            'mobile'=>$_POST['mobile'],
            'first_name'=>$_POST['first_name'],
            'last_name'=>$_POST['last_name'],
            'password'=>md5('password'),
            'usertype'=>5         
        ));

        if($userAdded){

            $this->db->insert('user_supplier_relationship', array('user_id'=>$this->db->insert_id(),'supplier_id'=>$_POST['supplier_id']));

            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','User Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('suppliers/users?id='.$_POST['supplier_id']);        
    }

    public function editUser(){
        /* print_r($_POST);
        exit(); */
        $emailExists = $this->db->select('*')
                        ->from('users')
                        ->where(array('id!='=>$_POST['id'],'email'=>$_POST['email']))
                        ->get()
                        ->result_array();

        if(!empty($emailExists)){
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Email already exists for other user');                   
            redirect('suppliers/users?id='.$_POST['supplier_id']); 
        }

        $mobileExists = $this->db->select('*')
                        ->from('users')
                        ->where(array('id!='=>$_POST['id'],'mobile'=>$_POST['mobile']))
                        ->get()
                        ->result_array(); 
                        
        if(!empty($mobileExists)){
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Mobile number already exists for other user');                   
            redirect('suppliers/users?id='.$_POST['supplier_id']); 
        }

        $userUpdated = $this->db->where('id',$_POST['id'])
            ->update('users', array(                       
                'email'=>$_POST['email'],
                'mobile'=>$_POST['mobile'],
                'first_name'=>$_POST['first_name'],
                'last_name'=>$_POST['last_name'],                
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','User Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('suppliers/users?id='.$_POST['supplier_id']); 
    }

    public function deleteUser(){
        
        $userDeleted = $this->db->where('id',$_GET['id'])->update('users', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','User Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('suppliers/users?id='.$_GET['supplier_id']); 
    }

    public function activateSupplier(){
        $supplierActivated = $this->db->where('id',$_GET['id'])->update('suppliers', array('active_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Supplier Activated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('suppliers');
    }

    public function assignSupplierWarehouse(){
       

        $alreadyAssigned = $this->db->select('*')
                            ->from('supplier_warehouse_relationship')
                            ->where('supplier_id', $_POST['id'])
                            ->where('warehouse_id', $_POST['warehouse_id'])
                            ->get()
                            ->result_array();
            
        if(!empty($alreadyAssigned)){
                            $this->session->set_flashdata('status','fail'); 
                            $this->session->set_flashdata('message','This supplier has already been asigned for the selected warehouse');                   
                            redirect('suppliers');
                            }


        $assignSuccess = $this->db->insert('supplier_warehouse_relationship', array(                                          
                        'supplier_id'=>$_POST['id'],
                        'warehouse_id'=>$_POST['warehouse_id'],                                        
                    ));
            
        if($assignSuccess){
                        $this->session->set_flashdata('status','success');
                        $this->session->set_flashdata('message','Supplier assigned to warehouse successfully');            
                    }else{
                        $this->session->set_flashdata('status','fail'); 
                        $this->session->set_flashdata('message','Could not assign, please try later');           
                    }               
                    redirect('suppliers');                             


}   

public function products(){
    /* $data['products'] = $this->db->select('p.id, p.description, p.name as product_name, b.name as brand_name, c.name as category_name, sco.name as sub_category_one_name, sct.name as sub_category_two_name')
                        ->from('product_supplier_relationship psr')
                        ->join('products p', 'p.id = psr.product_id')
                        ->join('brand b', 'b.id = p.brand')
                        ->join('category c', 'c.id = p.category')
                        ->join('sub_categories_one sco', 'sco.id = p.sub_category_one')
                        ->join('sub_categories_two sct', 'sct.id = p.sub_category_two')                           
                        ->where('psr.supplier_id', $_GET['id'])
                        ->where('psr.delete_status', 0)
                        ->get()
                        ->result_array(); */

        $data['products'] = $this->db->select('p.id, p.description, p.name as product_name, b.name as brand_name, c.name as category_name, sco.name as sub_category_one_name, sct.name as sub_category_two_name')
                        ->from('products p')                        
                        ->join('brand b', 'b.id = p.brand')
                        ->join('category c', 'c.id = p.category')
                        ->join('sub_categories_one sco', 'sco.id = p.sub_category_one')
                        ->join('sub_categories_two sct', 'sct.id = p.sub_category_two')                                                   
                        ->get()
                        ->result_array();                        

    $data['supplier_id'] = $_GET['id'];                                    
    $this->load->view('suppliers/products_supplier', $data);
}

public function addProduct(){

    foreach($_POST['products'] as $p){

        $alreadyExists = $this->db->select('*')
                        ->from('product_supplier_relationship')
                        ->where(array('product_id'=>$p, 'supplier_id'=>$_POST['supplier_id']))
                        ->where('delete_status',0)
                        ->get()->result_array();

        if(empty($alreadyExists)){
            $productAdded = $this->db->insert('product_supplier_relationship', array(
                'product_id'=>$p,
                'supplier_id'=>$_POST['supplier_id'],                        
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

    $data['supplier_id'] = $_POST['id'];                                    
    redirect('suppliers/products?id='.$_POST['supplier_id']);
}

public function deleteProduct(){
    $productDeleted = $this->db->where('id',$_GET['id'])->update('product_supplier_relationship', array('delete_status'=>1));
    if($this->db->affected_rows() == 1){
        $this->session->set_flashdata('status','success');
        $this->session->set_flashdata('message','Product Deleted Successfully');            
    }else{
        $this->session->set_flashdata('status','fail'); 
        $this->session->set_flashdata('message','Could not delete, please try later');           
    }       
    
    redirect('suppliers/products?id='.$_GET['supplier_id']);
}


public function batches()
	{   
	    $db1 = $this->db;
        $db2 = $this->load->database('database2', TRUE);

        if($this->session->userdata['usertype'] == 1){        
        $batches = $db2->select('*')->from('batches')->where('product_id',$_GET['id'])->get()->result_array();
        }else{
            $batches = $db2->select('*')->from('batches')->where(array('product_id'=>$_GET['id'], 'supplier_id'=>$this->session->userdata['supplier_id']))->get()->result_array();    
        }
        
        /* echo "<pre>";
        print_r($this->session->userdata['supplier_id']);
        exit(); */


        foreach($batches as $k=>$b){
            $product_details =  $this->db->select('*')->from('products')->where('id',$b['product_id'])->get()->result_array();
            $batches[$k]['product_name'] = $product_details[0]['name'];
            $batches[$k]['brand_name'] = $this->db->select('*')->from('brand')->where('id',$product_details[0]['brand'])->get()->result_array()[0]['name'];
            $batches[$k]['category_name'] = $this->db->select('*')->from('category')->where('id',$product_details[0]['category'])->get()->result_array()[0]['name'];
            /* $batches[$k]['supplier_name'] = $this->db->select('u.id, s.name')
            ->from('users u')
            ->join('user_supplier_relationship us', 'us.user_id = u.id')
            ->join('suppliers s', 's.id = us.supplier_id')
            ->where('u.id',$b['supplier_id'])
            ->get()
            ->result_array(); */
            $batches[$k]['supplier_name'] = $this->session->userdata['supplier_name'];
        }
        /* echo "<pre>";
        print_r($batches);
        exit(); */

        $data['product_id'] = $_GET['id'];
        $data['batches'] = $batches;        

        $this->load->view('suppliers/batches_supplier', $data);
	    
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
        redirect('suppliers/batches?id='.$_POST['product_id']);        
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
        
        redirect('suppliers');
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

        $this->load->view('suppliers/edit_batch', $data);
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
        
        redirect('suppliers');
    }

    public function assignBatchToWarehouse(){
        $db2 = $this->load->database('database2', TRUE);

        $batch = $db2->select('*')->from('batches')->where(array('id'=>$_POST['batch_id'],'product_id'=>$_POST['product_id']))->get()->result_array();

        $db2->where(array('id'=>$_POST['batch_id'],'product_id'=>$_POST['product_id']))
            ->update('batches', array('quantity'=>($batch[0]['quantity']-$_POST['quantity'])));

        /* echo "<pre>";
        print_r($batch); */
        //exit();

        $batch[0]['quantity'] = $_POST['quantity'];
        $batch[0]['warehouse_id'] = $_POST['warehouse_id'];
        $batch[0]['batch_id_name'] = $batch[0]['batch_id'];
        $batch[0]['batch_id'] = $batch[0]['id'];
        

        unset($batch[0]['id']);unset($batch[0]['user_added']);unset($batch[0]['delete_status']);        

        if($batch[0]['tax_type'] == 0){ // exclusive
            $batch[0]['cgst_tax'] = ($batch[0]['retail_price_per_product']/100)*$batch[0]['cgst']*$_POST['quantity'];
            $batch[0]['sgst_tax'] = ($batch[0]['retail_price_per_product']/100)*$batch[0]['sgst']*$_POST['quantity'];
            $batch[0]['igst_tax'] = ($batch[0]['retail_price_per_product']/100)*$batch[0]['igst']*$_POST['quantity'];
            $batch[0]['total_tax'] = $batch[0]['cgst_tax']+$batch[0]['sgst_tax']+$batch[0]['igst_tax'];
            $batch[0]['total'] = ($batch[0]['retail_price_per_product'] * $_POST['quantity'])+$batch[0]['total_tax'];
        }else{  // inclusive
            $batch[0]['cgst_tax'] = ($batch[0]['retail_price_per_product']/(100+($batch[0]['cgst']+$batch[0]['sgst']+$batch[0]['igst'])))*($batch[0]['cgst'])*$_POST['quantity'];
            $batch[0]['sgst_tax'] = ($batch[0]['retail_price_per_product']/(100+($batch[0]['cgst']+$batch[0]['sgst']+$batch[0]['igst'])))*($batch[0]['sgst'])*$_POST['quantity'];
            $batch[0]['igst_tax'] = ($batch[0]['retail_price_per_product']/(100+($batch[0]['cgst']+$batch[0]['sgst']+$batch[0]['igst'])))*($batch[0]['igst'])*$_POST['quantity'];
            $batch[0]['total_tax'] = $batch[0]['cgst_tax']+$batch[0]['sgst_tax']+$batch[0]['igst_tax'];
            $batch[0]['total'] = $batch[0]['retail_price_per_product'] * $_POST['quantity'];
        }

        $db2->insert('warehouse_batches', $batch[0]);
        
        /* print_r($batch); */

        $this->session->set_flashdata('status','success');
        $this->session->set_flashdata('message','Batch assigned to warehouse successfully');
        redirect('suppliers/batches?id='.$_POST['product_id']);
    }

	}
