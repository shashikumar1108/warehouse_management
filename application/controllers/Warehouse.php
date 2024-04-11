<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends CI_Controller {

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
        $data['warehouses'] = $this->db->select('*')->from('warehouse')->where('delete_status',0)->get()->result_array();
        $this->load->view('warehouse/list_warehouse', $data);
		
    }
    
    public function addWarehouse(){
        $warehouseAdded = $this->db->insert('warehouse', array(
            'name'=>$_POST['name'],
            'location'=>$_POST['location'],
            'state_code'=>$_POST['state_code'],
            'gst'=>$_POST['gst'],
            'pan'=>$_POST['pan'],
            'address'=>$_POST['address'],
        ));

        if($warehouseAdded){
            $this->session->set_flashdata('warehouseAdded_status','success');
            $this->session->set_flashdata('warehouseAdded_message','Warehouse Added Successfully');            
        }else{
            $this->session->set_flashdata('warehouseAdded_status','fail'); 
            $this->session->set_flashdata('warehouseAdded_status','Could not add, please try later');           
        }       
        
        redirect('warehouse');
        
    }

    public function delete(){
        $warehouseDeleted = $this->db->where('id',$_GET['id'])->update('warehouse', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('warehouseDeleted_status','success');
            $this->session->set_flashdata('warehouseDeleted_message','Warehouse Deleted Successfully');            
        }else{
            $this->session->set_flashdata('warehouseDeleted_status','fail'); 
            $this->session->set_flashdata('warehouseDeleted_message','Could not delete, please try later');           
        }       
        
        redirect('warehouse');
    }

    public function editWarehouse(){
        $warehouseUpdated = $this->db->where('id',$_POST['id'])
            ->update('warehouse', array(
            'name'=>$_POST['name'],
            'location'=>$_POST['location'],
            'state_code'=>$_POST['state_code'],
            'gst'=>$_POST['gst'],
            'pan'=>$_POST['pan'],
            'address'=>$_POST['address'],
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('warehouseUpdated_status','success');
            $this->session->set_flashdata('warehouseUpdated_message','Warehouse Updated Successfully');            
        }else{
            $this->session->set_flashdata('warehouseUpdated_status','fail'); 
            $this->session->set_flashdata('warehouseUpdated_message','Could not update, please try later');           
        }       
        
        redirect('warehouse');
    }

    public function users(){
        $data['warehouse_admin'] = $this->db->select('u.*')
                            ->from('users u')
                            ->join('user_warehouse_relationship uwr', 'u.id=uwr.user_id')
                            ->where('u.usertype', 2)
                            ->where('uwr.warehouse_id', $_GET['id'])
                            ->get()
                            ->result_array();

        $data['warehouse_accountant'] = $this->db->select('u.*')
                            ->from('users u')
                            ->join('user_warehouse_relationship uwr', 'u.id=uwr.user_id')
                            ->where('u.usertype', 3)
                            ->where('uwr.warehouse_id', $_GET['id'])
                            ->get()
                            ->result_array();
        $data['warehouse_sales'] = $this->db->select('u.*')
                            ->from('users u')
                            ->join('user_warehouse_relationship uwr', 'u.id=uwr.user_id')
                            ->where('u.usertype', 4)
                            ->where('uwr.warehouse_id', $_GET['id'])
                            ->get()
                            ->result_array();                            
        $this->load->view('warehouse/users_warehouse', $data);
    }

    public function shops(){
        $data['shops'] = $this->db->select('s.*')
                            ->from('shops s')
                            ->join('shop_warehouse_relationship swr', 's.id=swr.shop_id')
                            ->where('swr.warehouse_id', $_GET['id'])
                            ->get()
                            ->result_array();

                                    
        $this->load->view('warehouse/shops_warehouse', $data);
    }

    public function racks(){
        $data['racks'] = $this->db->select('*')
                            ->from('racks')                            
                            ->where('warehouse_id', $_GET['id'])
                            ->where('delete_status', 0)
                            ->get()
                            ->result_array();

        $data['warehouse_id'] = $_GET['id'];                                    
        $this->load->view('warehouse/racks_warehouse', $data);
    }

    public function addRack(){
        $rackAdded = $this->db->insert('racks', array(
            'rack_number'=>$_POST['rack_number'],
            'warehouse_id'=>$_POST['id'],
            'description'=>$_POST['description'],            
        ));

        if($rackAdded){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Rack Added Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');           
        }       
        
        redirect('warehouse/racks?id='.$_POST['id']);
    }

    public function deleteRack(){
        $rackDeleted = $this->db->where('id',$_GET['id'])->update('racks', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Rack Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('warehouse/racks?id='.$_GET['id']);
    }

    public function editRack(){
        $rackUpdated = $this->db->where('id',$_POST['id'])
            ->update('racks', array(
                'rack_number'=>$_POST['rack_number'],                
                'description'=>$_POST['description'],
        ));

        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Rack Updated Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');           
        }

        redirect('warehouse/racks?id='.$_POST['warehouse_id']);
    }

    public function products(){
        /* $data['products'] = $this->db->select('p.id, p.description, p.name as product_name, b.name as brand_name, c.name as category_name, sco.name as sub_category_one_name, sct.name as sub_category_two_name')
                            ->from('product_warehouse_relationship pwr')
                            ->join('products p', 'p.id = pwr.product_id')
                            ->join('brand b', 'b.id = p.brand')
                            ->join('category c', 'c.id = p.category')
                            ->join('sub_categories_one sco', 'sco.id = p.sub_category_one')
                            ->join('sub_categories_two sct', 'sct.id = p.sub_category_two')                           
                            ->where('pwr.warehouse_id', $_GET['id'])
                            ->where('pwr.delete_status', 0)
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

        $data['warehouse_id'] = $_GET['id'];                                    
        $this->load->view('warehouse/products_warehouse', $data);
    }

    public function addProduct(){

        foreach($_POST['products'] as $p){

            $alreadyExists = $this->db->select('*')
                            ->from('product_warehouse_relationship')
                            ->where(array('product_id'=>$p, 'warehouse_id'=>$_POST['warehouse_id']))
                            ->where('delete_status',0)
                            ->get()->result_array();

            if(empty($alreadyExists)){
                $productAdded = $this->db->insert('product_warehouse_relationship', array(
                    'product_id'=>$p,
                    'warehouse_id'=>$_POST['warehouse_id'],                        
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

        $data['warehouse_id'] = $_POST['id'];                                    
        redirect('warehouse/products?id='.$_POST['warehouse_id']);
    }

    public function deleteProduct(){
        $productDeleted = $this->db->where('id',$_GET['id'])->update('product_warehouse_relationship', array('delete_status'=>1));
        if($this->db->affected_rows() == 1){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Product Deleted Successfully');            
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');           
        }       
        
        redirect('warehouse/products?id='.$_GET['warehouse_id']);
    }
    
    public function batches()
	{
	    $db1 = $this->db;
        $db2 = $this->load->database('database2', TRUE);

        if($this->session->userdata['usertype'] == 1){        
        $batches = $db2->select('*')->from('warehouse_batches')->where('product_id',$_GET['id'])->get()->result_array();
        }else{
        $warehouse_id = $this->db->select('warehouse_id')->from('user_warehouse_relationship')->where('user_id',$this->session->userdata['id'])->get()->result_array();                
        $batches = $db2->select('*')->from('warehouse_batches')->where(array('product_id'=>$_GET['id'], 'warehouse_id'=>$warehouse_id[0]['warehouse_id']))->get()->result_array();            
        }
        
        /* echo "<pre>";
        print_r($warehouse_id);
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

        $this->load->view('warehouse/batches_warehouse', $data);
	    
	}




	}
