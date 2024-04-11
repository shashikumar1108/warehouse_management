<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShopOrders extends CI_Controller {

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
        $user_id = $this->session->userdata['id'];
        $shop_id = $this->db->select('s.id')
              ->from('shops s')
              ->join('user_shop_relationship us', 'us.shop_id = s.id')
              ->join('users u', 'u.id = us.user_id')
              ->where('u.id', $user_id)                  
              ->get()
              ->result_array();


        $db2 = $this->load->database('database2', TRUE);			        
       // $orders = $db2->select('*')->from('shop_orders')->where('shop_id', $shop_id[0]['id'])->get()->result_array();                

        if($this->session->userdata['shop_id'] == -1){
            $orders = array();
        }elseif($this->session->userdata['shop_id'] == 0){
            $orders = $db2->select('*')->from('shop_orders')->where('shop_id', $_GET['id'])->get()->result_array();
        }else{
            $orders = $db2->select('*')->from('shop_orders')->where('shop_id', $this->session->userdata['shop_id'])->get()->result_array();
        }


        /* print_r($this->session->userdata['shop_id']);
        exit(); */

        foreach($orders as $k=>$o){

            $products = json_decode($o['products']); 

            $orders[$k]['products'] = $this->db->select('id, name')->from('products')->where_in('id',$products)->get()->result_array();
            $orders[$k]['shop_name'] = $this->db->select('name')->from('shops')->where('id',$o['shop_id'])->get()->result_array();
            $orders[$k]['user_name'] = $this->db->select('first_name, last_name')->from('users')->where('id',$o['user_id'])->get()->result_array();
 
        }                

        $data['data'] = $orders;
        $this->load->view('shoporders/list_shoporders', $data);		
    }

    public function viewOrderDetails(){    //exit();     
        $db2 = $this->load->database('database2', TRUE);
        $order = $db2->select('*')->from('shop_orders')->where('id', $this->uri->segment(3))->get()->result_array();                
        
            $products = json_decode($order[0]['products']); 
            $quantities = json_decode($order[0]['quantity']); 

            $order[0]['quantities'] = $quantities;
            $order[0]['products'] = $this->db->select('id, name')->from('products')->where_in('id',$products)->get()->result_array();
            $order[0]['shop_name'] = $this->db->select('name')->from('shops')->where('id',$order[0]['shop_id'])->get()->result_array();
            $order[0]['user_name'] = $this->db->select('first_name, last_name')->from('users')->where('id',$order[0]['user_id'])->get()->result_array();
 
        $data['data'] = $order;
        /* echo "<pre>";
        print_r($order);
        exit(); */

        $this->load->view('shoporders/order_details', $data);
    }

    
    
    public function create(){
        $this->load->view('shoporders/create_order');
    }

    public function add(){
        
        $n=10; 

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
    
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
    
        $order_id = $randomString; 



        $db2 = $this->load->database('database2', TRUE);
        
        $products = $_POST['product_id'];
        $quantities = $_POST['quantity'];

        foreach($quantities as $k=>$q){
            if($q == 0){
                unset($products[$k]);
                unset($quantities[$k]);
            }
        }        

        $products = str_replace(':',',',json_encode($products));
        $quantities = str_replace(':',',',json_encode($quantities));

        $products = str_replace('{','[',$products);
        $quantities = str_replace('{','[',$quantities);

        $products = str_replace('}',']',$products);
        $quantities = str_replace('}',']',$quantities);            

        /* print_r($quantities);
        exit(); */


        $Added = $db2->insert('shop_orders', array(  
                'order_id'=>'SO-'.$order_id,           
                'user_id'=>$_POST['user_id'],                     
                'shop_id'=>$_POST['shop_id'],
                'products'=>$products, 
                'quantity'=>$quantities                                         
            ));
       
            
        if($Added){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Shop Order Created Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not create, please try later');           
        }               
        redirect('ShopOrders');        
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
