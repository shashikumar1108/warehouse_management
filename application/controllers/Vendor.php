<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('vendor_model');
        $this->load->model('order_model');
        
        if(!$this->session->userdata('login') == true){
			redirect(base_url('/auth/login'));
        }
    }


	public function new_quotation_list()
	{			        
        $user_id = $this->session->userdata('id');

        // $vendor_quotation_ids = $this->db->select('quotation_id')->from('vendor_quotation')->where('user_id',$user_id)
        //                     ->get()->result_array();

        // if(!empty($vendor_quotation_ids)){
        //     $quotation_ids = array_column($vendor_quotation_ids,'quotation_id');
        // }

        $this->db->select('q.*');
        $this->db->from('quotation q');
        $this->db->where(array('q.approval_status' => 'approved','q.delete_status' => '0','q.quotation_status' => '1'));

        // if(!empty($quotation_ids)){
        //    $this->db->where_not_in('q.quotation_id',$quotation_ids); 
        // }
        $data['order_quotation_list'] =$this->db->get()->result_array();

        // echo "<pre>";
        // print_r($data['order_quotation_list']);
        // exit();

        $this->load->view('vendor/new_quotation_list', $data);
		
    }

    public function new_proposal($quotation_id){
        $data['quotation'] = $this->vendor_model->get_requested_quotation_details($quotation_id);
        $data['quotation_products'] = $this->vendor_model->fetch_quotation_product_details($quotation_id);
        //echo "<pre>";print_r($data['quotation']);exit();
        $this->load->view('vendor/new_proposal',$data);
    }

    public function add_quotation_proposal(){

        // echo "<pre>";print_r($_POST);exit();
        $user_id = $this->session->userdata('id');
        $supplier_id = $_POST['supplier_id'];
        $quotation = $this->db->select('quotation_id')->from('vendor_quotation')
            ->where(array(
                'delete_status' =>  0,
                'quotation_id'  =>  $_POST['quotation_id'],
                'supplier_id'   =>  $supplier_id,
            ))->get()->result_array();
        // echo '<pre>';print_r($quotation);exit;
        if( count($quotation) ){
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Vendor quote already submitted for selected supplier !!!');
            redirect(base_url('vendor/new_quotation_list'));
        }else{
            $temp_data = array(
                'quotation_id' => $_POST['quotation_id'],
                'user_id' =>$user_id,
                'conditions' => $_POST['conditions'],
                'delivery_days' =>$_POST['delivery_days'],
                'transport_cost' => $_POST['transport_cost'],
                'grand_wholesale_price' => $_POST['grand_wholesale_price'],
                'grand_retail_price' => $_POST['grand_retail_price'],
                'proposal_status' => 1,
                'delete_status' => 0,
                'supplier_id'   =>  $supplier_id,
            );

            $temp_quotation['supplier_id'] = $supplier_id;
            $temp_quotation['quotation_product_id'] = $_POST['quotation_product_id'];
            $temp_quotation['free_quantity'] = $_POST['free_quantity'];
            $temp_quotation['total_qty'] = $_POST['total_qty'];
            $temp_quotation['brand_id'] = $_POST['brand_id'];

            $temp_quotation['wholesale_price'] = $_POST['wholesale_price'];
            $temp_quotation['w_total_amount'] = $_POST['w_total_amount'];
            $temp_quotation['w_cgst'] = $_POST['w_cgst'];
            $temp_quotation['w_sgst'] = $_POST['w_sgst'];
            $temp_quotation['w_igst'] = $_POST['w_igst'];
            $temp_quotation['w_tax_amount'] = $_POST['w_tax_amount'];
            $temp_quotation['w_tax_type'] = $_POST['w_tax_type'];
            $temp_quotation['total_wholesale_price'] = $_POST['total_wholesale_price'];

            $temp_quotation['retail_price'] = $_POST['retail_price'];
            $temp_quotation['r_total_amount'] = $_POST['r_total_amount'];
            $temp_quotation['r_cgst'] = $_POST['r_cgst'];
            $temp_quotation['r_sgst'] = $_POST['r_sgst'];
            $temp_quotation['r_igst'] = $_POST['r_igst'];
            $temp_quotation['r_tax_amount'] = $_POST['r_tax_amount'];
            $temp_quotation['r_tax_type'] = $_POST['r_tax_type'];
            $temp_quotation['total_retail_price'] = $_POST['total_retail_price'];

            // echo "<pre>";print_r($temp_data);print_r($temp_quotation);exit();
            $result = $this->vendor_model->add_quotation_proposal_details($temp_data,$temp_quotation);
            if($result){
                $this->session->set_flashdata('status','success');
                $this->session->set_flashdata('message','New Quotation Proposal Added Successfully'); 
            }else{
                $this->session->set_flashdata('status','fail'); 
                $this->session->set_flashdata('message','Could not add, please try later');
            }
            redirect(base_url('vendor/new_quotation_list'));
        }

    }

    // ajax call
    public function addBrand(){
         
        $brandAdded = $this->db->insert('brand', array('name'=>$_POST['name']));

        if($brandAdded){
            $brands = $this->db->select('id,name')->from('brand')->where('delete_status',0)->get()->result();
            $result = array('status' => "success","msg" => 'Brand added Successfully','brand' => $brands);
        }else{
            $result = array('status' => "failed","msg" => 'Brand not added');
        }    

        echo json_encode($result);       
    }
    // ajax call

    // START CONFIRMED DELIVERY NOTE
    public function confirmed_delivery_order(){
        $proposal_status = '2';
        $data['order_quotation_list'] = $this->vendor_model->get_vendor_proposed_quotation_details($proposal_status);
        // echo $this->db->last_query();exit;
        // echo '<pre>';print_r($data);exit;
        $this->load->view('vendor/delivery/delivery_note', $data);
    }

    public function add_delivery_note($quotation_id,$vendor_quote_id = 0){
        $proposal_status = '2';
        $data['vendor_quotation'] = $this->vendor_model->get_single_vendor_quotation_details($quotation_id,$proposal_status,$vendor_quote_id);
        $data['approved_products'] = $this->vendor_model->get_vendor_proposed_price_details($quotation_id,$proposal_status,$vendor_quote_id,1);
        // echo $this->db->last_query();
        // echo '<pre>';print_r($data['approved_products']);exit;
        $data['rejected_products'] = $this->vendor_model->get_vendor_proposed_price_details($quotation_id,$proposal_status,$vendor_quote_id,2);
        // echo '<pre>';print_r($data['rejected_products']);exit;
        // echo '<pre>';print_r($data);exit;
        $this->load->view('vendor/delivery/add_delivery_note',$data);
    }

    public function create_delivery_note(){
        // echo "<pre>";print_r($_POST);exit();
        $vendor_quote_id = $_POST['vendor_quote_id'];
        $data = array();
        $data['vendor_quote_id'] = $_POST['vendor_quote_id'];
        $data['delivery_date'] = $_POST['delivery_date'];
        $data['batch_number'] = $_POST['batch_number'];
        $data['mfg_date'] = $_POST['mfg_date'];
        $data['expiry_date'] = $_POST['expiry_date'];
        // echo "<pre>";print_r($data);exit();
        $result = $this->vendor_model->create_delivery_note_details($data,$vendor_quote_id);
        if($result){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Delivery note created Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');
        }
        redirect(base_url('vendor/confirmed_delivery_order'));
    }

    // END DELIVERY NOTE



}
    

