<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shops extends CI_Controller {

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
        $data['shops'] = $this->db->select('*')->from('shops')->where('delete_status',0)->get()->result_array();
        $this->load->view('shops/list_shops', $data);
		
    }
    
    public function addShop(){
         
        $shopAdded = $this->db->insert('shops', array( 
            'name'=>$_POST['name'],
            'gst'=>$_POST['gst'],                     
            'state_code'=>$_POST['state_code'],
            'address'=>$_POST['address'],                   
        ));

        if($shopAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Shop Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }               
        redirect('shops');        
    }

    public function delete(){
        $shopDeleted = $this->db->where('id',$_GET['id'])->update('shops', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Shop Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('shops');
    }

    public function editShop(){
        /* print_r($_POST);
        exit(); */

        $userUpdated = $this->db->where('id',$_POST['id'])
            ->update('shops', array(                       
                'name'=>$_POST['name'],
                'gst'=>$_POST['gst'],
                'state_code'=>$_POST['state_code'],
                'address'=>$_POST['address'],                
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Shop Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }       
        
        redirect('shops');
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
        /* $data['products'] = $this->db->select('p.id, p.description, p.name as product_name, b.name as brand_name, c.name as category_name, sco.name as sub_category_one_name, sct.name as sub_category_two_name')
                            ->from('product_shop_relationship psr')
                            ->join('products p', 'p.id = psr.product_id')
                            ->join('brand b', 'b.id = p.brand')
                            ->join('category c', 'c.id = p.category')
                            ->join('sub_categories_one sco', 'sco.id = p.sub_category_one')
                            ->join('sub_categories_two sct', 'sct.id = p.sub_category_two')                           
                            ->where('psr.shop_id', $_GET['id'])
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
    
        $data['shop_id'] = $_GET['id'];                                    
        $this->load->view('shops/products_shop', $data);
    }
    
    public function addProduct(){
        /* print_r($_POST);
        exit(); */
        foreach($_POST['products'] as $p){
    
            $alreadyExists = $this->db->select('*')
                            ->from('product_shop_relationship')
                            ->where(array('product_id'=>$p, 'shop_id'=>$_POST['shop_id']))
                            ->where('delete_status',0)
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
        /* print_r($_GET);
        exit(); */
        $productDeleted = $this->db->where(array('shop_id'=>$_GET['shop_id'], 'product_id'=>$_GET['id']))->update('product_shop_relationship', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Product Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('shops/products?id='.$_GET['shop_id']);
    }

    public function batches(){

	    $db1 = $this->db;
        $db2 = $this->load->database('database2', TRUE);

        $shop_id = $_GET['shop_id'];

        /* if($this->session->userdata['usertype'] == 1){        
        $batches = $db2->select('*')->from('shop_batches')->where('product_id',$_GET['id'])->get()->result_array();
        }else{
        $shop_id = $this->db->select('shop_id')->from('user_shop_relationship')->where('user_id',$this->session->userdata['id'])->get()->result_array();                
        $batches = $db2->select('*')->from('shop_batches')->where(array('product_id'=>$_GET['id'], 'shop_id'=>$shop_id[0]['shop_id']))->get()->result_array();            
        } */
        
        if($this->session->userdata['shop_id'] == -1){
            $batches = array();
        }elseif($this->session->userdata['shop_id'] == 0){
            $batches = $db2->select('*')->from('shop_batches')->where(array('product_id'=>$_GET['id'],'shop_id'=>$shop_id))->get()->result_array();
        }else{
            $batches = $db2->select('*')->from('shop_batches')->where(array('product_id'=>$_GET['id'],'shop_id'=>$shop_id))->get()->result_array();
        }



        /* echo "<pre>";
        print_r($shop_id);
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

        $this->load->view('shops/batches_shops', $data);
	    
	
    }

	}
