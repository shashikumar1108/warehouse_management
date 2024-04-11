<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->helper('utility');
        $this->load->model('vendor_model');
        $this->load->model('order_model');
        
        if(!$this->session->userdata('login') == true){
			redirect(base_url('/auth/login'));
        }
    }


	public function new_quotation_list()
	{			        
        $data = array();
        $this->load->view('vendor/new_quotation_list', $data);
    }

    public function getVendotQuoteTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $records = $this->vendorQuoteTableData($_POST);
        // echo '<pre>';print_r($products);exit;
        $data = array();
        $i = 1;
        if( isset($_POST['start']) && intval($_POST['start']) > 0 ){
            $i = $_POST['start'] + 1;
        }
        foreach ($records['data'] as $row) {
            $rowData = array();
            $rowData[] = $i;
            $rowData[] = $row['ref_number'];
            $rowData[] = $row['warehouse'];
            $rowData[] = "<a class='btn btn-primary' href='".base_url('vendor/new_proposal/'.$row['quotation_id'])."'>Apply</a>";
            $i++;
            $data[] = $rowData;
        }

        $result = array(
            // 'draw'  =>  $_POST['draw'],
            'data'  =>  $data,
            'recordsFiltered' => $records['total'],
            'recordsTotal' => $records['total'],
        );
        echo json_encode($result);
    }

    public function vendorQuoteTableData($payload = array()){
        // echo '<pre>';print_r($this->session->userdata());exit;
        $user_id = $this->session->userdata('id');
        $supplier_id = $this->session->userdata('supplier_id');
        $vendor_quotation_ids = $this->db->select('quotation_id')
            ->from('vendor_quotation')
            ->where('supplier_id',$supplier_id)
            ->get()->result_array();

        // echo $this->db->last_query();
        // echo '<pre>';print_r($vendor_quotation_ids);exit;

        $quotation_ids = array();
        if(!empty($vendor_quotation_ids)){
            $quotation_ids = array_column($vendor_quotation_ids,'quotation_id');
        }

        $order_column = array("q.quotation_id","q.ref_number","w.name","q.quotation_id");
        $result = array('data'=>array(),'total'=>0);
        $start = 0;
        $limit = 10;
        if( isset($payload['start']) ){
            $start = (int)$payload['start'];
        }

        if( isset($payload['length']) ){
            $limit = (int)$payload['length'];
        }

        $select = 'q.quotation_id, q.ref_number, q.approval_status, q.warehouse_id, q.description, q.quotation_status';
        $select .= ', w.name as warehouse, w.location';
        $this->db->select($select)
            ->from('quotation q')
            ->join('warehouse w', 'w.id = q.warehouse_id')
            ->join('supplier_warehouse_relationship swr', 'swr.warehouse_id = w.id')
            ->where(array('q.delete_status'=>0,'q.approval_status'=>'approved','q.quotation_status'=>1,'swr.supplier_id'=>$supplier_id));

        if(!empty($quotation_ids)){
            $this->db->where_not_in('q.quotation_id',$quotation_ids); 
        }

        if( isset($payload['search']['value']) ){
            $this->db->like('q.ref_number', trim($payload['search']['value']));
        }
        
        if( isset($payload['order'][0]['column']) && $payload['order'][0]['column'] == 0 ){
            $this->db->order_by('q.quotation_id', 'desc');
        }else if( isset($payload['order'][0]['column']) && $payload['order'][0]['column'] > 0 ){
            $this->db->order_by($order_column[$payload['order'][0]['column']], $payload['order'][0]['dir']);
        }
        

        $result['data'] = $this->db->limit($limit,$start)->get()->result_array();
        $this->db->select('q.quotation_id')
            ->from('quotation q')
            ->join('warehouse w', 'w.id = q.warehouse_id')
            ->join('supplier_warehouse_relationship swr', 'swr.warehouse_id = w.id')
            ->where(array('q.delete_status'=>0,'q.approval_status'=>'approved','q.quotation_status'=>1,'swr.supplier_id'=>$supplier_id));

        if(!empty($quotation_ids)){
            $this->db->where_not_in('q.quotation_id',$quotation_ids); 
        }

        if( isset($payload['search']['value']) ){
            $this->db->like('q.ref_number', trim($payload['search']['value']));
        }

        $result['total'] = $this->db->get()->num_rows();
        return $result;
    }


    public function new_proposal($quotation_id){
        $data['quotation'] = $this->vendor_model->get_requested_quotation_details($quotation_id);
        $data['quotation_products'] = $this->vendor_model->fetch_quotation_product_details($quotation_id);

        $select = 'usr.supplier_id,s.name';
        $data['supplier_details'] = $this->db->select($select)
            ->from('users u')
            ->join('user_supplier_relationship usr', 'usr.user_id = u.id')
            ->join('suppliers s', 's.id = usr.supplier_id')
            ->where(array('u.id'=>$this->session->userdata('id')))->get()->result_array();
        // echo "<pre>";print_r($data['supplier']);exit();
        $this->load->view('vendor/new_proposal',$data);
    }

    public function add_quotation_proposal(){
        // echo "<pre>";print_r($_POST);exit();
        $user_id = $this->session->userdata('id');
        $temp_data = array(
            'quotation_id' => $_POST['quotation_id'],
            'user_id' =>$user_id,
            'conditions' => $_POST['conditions'],
            'delivery_days' =>$_POST['delivery_days'],
            'transport_cost' => $_POST['transport_cost'],
            'grand_wholesale_price' => $_POST['grand_wholesale_price'],
            'grand_retail_price' => $_POST['grand_retail_price'],
            'proposal_status' => '1',
            'delete_status' => '0',
            'supplier_id'=>$_POST['supplier']
        );
        // echo "<pre>";print_r($temp_data);exit();

        $temp_quotation['supplier_id'] = $_POST['supplier_id'];
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

        // echo "<pre>";
        // print_r($temp_data);
        // print_r($temp_quotation);
        // exit();

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
        $this->load->view('vendor/delivery/delivery_note', $data);
    }

    public function getConfirmedDeliveryNoteTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $proposal_status = 2;
        $records = $this->confirmedDeliveryNoteData($_POST,$proposal_status);
        // echo $this->db->last_query();exit;
        // echo '<pre>';print_r($products);exit;
        $data = array();
        $i = 1;
        if( isset($_POST['start']) && intval($_POST['start']) > 0 ){
            $i = $_POST['start'] + 1;
        }
        foreach ($records['data'] as $row) {
            $rowData = array();
            $rowData[] = $i;
            $rowData[] = $row['ref_number'];
            $rowData[] = $row['warehouse'];
            $rowData[] = "<a class='btn btn-primary' href='".base_url('vendor/add_delivery_note/'.$row['quotation_id'].'/'.$row['vendor_quote_id'])."'>New Note</a>";
            $i++;
            $data[] = $rowData;
        }

        $result = array(
            // 'draw'  =>  $_POST['draw'],
            'data'  =>  $data,
            'recordsFiltered' => $records['total'],
            'recordsTotal' => $records['total'],
        );
        echo json_encode($result);
    }

    public function confirmedDeliveryNoteData($payload = array(),$proposal_status = 0){

        $user_id = $this->session->userdata('id');
        $supplier_id = $this->session->userdata('supplier_id');
        // echo $supplier_id;exit;
        
        $order_column = array("q.quotation_id","q.ref_number","w.name","q.quotation_id");
        $result = array('data'=>array(),'total'=>0);
        $start = 0;
        $limit = 10;
        if( isset($payload['start']) ){
            $start = (int)$payload['start'];
        }

        if( isset($payload['length']) ){
            $limit = (int)$payload['length'];
        }

        $select = 'q.*, vq.vendor_quote_id,w.name as warehouse';
        $this->db->select($select)
            ->from('quotation q')
            ->join('vendor_quotation vq','q.quotation_id=vq.quotation_id')
            ->join('warehouse w', 'w.id = q.warehouse_id')
            ->where(
                array(
                    'q.delete_status'=>0,
                    'q.approval_status'=>'Approved',
                    'vq.proposal_status' => $proposal_status,
                    'vq.supplier_id'=>$supplier_id,
                )
            );

        if( isset($payload['search']['value']) ){
            $this->db->like('q.ref_number', trim($payload['search']['value']));
        }
        
        if( isset($payload['order'][0]['column']) && $payload['order'][0]['column'] == 0 ){
            $this->db->order_by('q.quotation_id', 'desc');
        }else if( isset($payload['order'][0]['column']) && $payload['order'][0]['column'] > 0 ){
            $this->db->order_by($order_column[$payload['order'][0]['column']], $payload['order'][0]['dir']);
        }
        

        $result['data'] = $this->db->limit($limit,$start)->get()->result_array();
        $this->db->select('q.quotation_id')
            ->from('quotation q')
            ->join('vendor_quotation vq','q.quotation_id=vq.quotation_id')
            ->join('warehouse w', 'w.id = q.warehouse_id')
            ->where(
                array(
                    'q.delete_status'=>0,
                    'q.approval_status'=>'approved',
                    'vq.proposal_status' => $proposal_status,
                    'vq.supplier_id'=>$supplier_id,
                )
            );

        if( isset($payload['search']['value']) ){
            $this->db->like('q.ref_number', trim($payload['search']['value']));
        }

        $result['total'] = $this->db->get()->num_rows();
        return $result;
    }

    public function add_delivery_note($quotation_id, $vendor_quote_id = 0){
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
    

