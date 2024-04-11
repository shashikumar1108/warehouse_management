<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->helper('utility');
        $this->load->model('order_model');
        $this->load->model('vendor_model');
        
        if(!$this->session->userdata('login') == true){
			redirect(base_url('/auth/login'));
        }
    }

    // Start Request For Quotation
    function approve_rfq(){
        $this->db->select('q.*');
        $this->db->from('quotation q');
        $this->db->where(array('q.approval_status' => 'UnApproved','q.delete_status' => '0','q.quotation_status' => '1'));
        $this->db->where('q.delete_status',0);
        $data['quotation_list'] = $this->db->get()->result_array();
        $this->load->view('orders/new/approve_rfq_list',$data);
    }

    public function getApproveTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $products = $this->approveTableData($_POST);
        // echo '<pre>';print_r($products);exit;
        $data = array();
        $i = 1;
        if( isset($_POST['start']) && intval($_POST['start']) > 0 ){
            $i = $_POST['start'] + 1;
        }
        foreach ($products['data'] as $row) {
            $rowData = array();
            $rowData[] = $i;
            $rowData[] = $row['ref_number'];
            $rowData[] = $row['approval_status'];
            $rowData[] = $row['warehouse'];
            $rowId = $row['quotation_id'];
            $rowData[] = "<button class='btn btn-primary' onclick='viewQ(".$rowId.")'>View & Approve</button>";
            $i++;
            $data[] = $rowData;
        }

        $result = array(
            // 'draw'  =>  $_POST['draw'],
            'data'  =>  $data,
            'recordsFiltered' => $products['total'],
            'recordsTotal' => $products['total'],
        );
        echo json_encode($result);
    }

    public function approveTableData($payload = array()){

        // $this->db->select('q.*');
        // $this->db->from('quotation q');
        // $this->db->where(array('q.approval_status' => 'UnApproved','q.delete_status' => '0','q.quotation_status' => '1'));
        // $this->db->where('q.delete_status',0);

        $order_column = array("q.id","q.ref_number","q.approval_status","w.name","q.id");
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
        $select .= ', w.name as warehouse, w.location, sc.state_name';
        $this->db->select($select)
            ->from('quotation q')
            ->join('warehouse w', 'w.id = q.warehouse_id')
            ->join('state_code sc', 'sc.id = w.state_code')
            ->where(array('q.delete_status'=>0,'q.approval_status'=>'UnApproved','q.quotation_status'=>1));

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
            ->join('state_code sc', 'sc.id = w.state_code')
            ->where(array('q.delete_status'=>0,'q.approval_status'=>'UnApproved','q.quotation_status'=>1));

        if( isset($payload['search']['value']) ){
            $this->db->like('q.ref_number', trim($payload['search']['value']));
        }

        $result['total'] = $this->db->get()->num_rows();
        return $result;
    }

    function getRequestData(){
        $html = '';
        if( !empty($_GET['request_id']) ){
            $quotation_id = $this->input->get('request_id');
            $data = array();
            $data['quotation'] = $this->order_model->edit_quotation_details($quotation_id);
            $data['quotation_product'] = $this->order_model->get_quotation_product_details($quotation_id);
            $html = $this->load->view('orders/new/approve_quote',$data,true);
        }
        echo $html;
    }

    public function approve_quotation(){

        //echo "<pre>";print_r($_POST);exit();
        $quotation_id = $_POST['quotation_id'];
        $temp_data = array('approval_status' => 'Approved');

        $this->db->where('quotation_id',$quotation_id)->update('quotation',$temp_data);
        $result = $this->db->affected_rows();

        if($result){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Quotation Approved Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');
        }

        redirect(base_url('orders/approve_rfq'));

    }



    // START Confirm Quotation List

    public function new_confirm_quotation_list(){
        $data = array();
        $this->load->view('orders/confirm/new_confirm_quotation_list',$data);
    }

    public function getConfirmTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $products = $this->vendor_model->confirmTableData($_POST);
        // echo '<pre>';print_r($products);exit;
        $data = array();
        $i = 1;
        if( isset($_POST['start']) && intval($_POST['start']) > 0 ){
            $i = $_POST['start'] + 1;
        }
        foreach ($products['data'] as $row) {
            $rowData = array();
            $rowData[] = $i;
            $rowData[] = '<a href="'.base_url().'orders/quotation_proposal/'.$row['quotation_id'].'">New Confirm</a>';
            $rowData[] = $row['ref_number'];
            // $rowData[] = $row['approval_status'];
            $rowData[] = $row['warehouse'];
            $rowData[] = $row['supplier'];
            $rowData[] = $row['delivery_days'];
            $rowData[] = $row['transport_cost'];
            $rowData[] = $row['grand_wholesale_price'];
            $rowData[] = $row['grand_retail_price'];
            $i++;
            $data[] = $rowData;
        }

        $result = array(
            // 'draw'  =>  $_POST['draw'],
            'data'  =>  $data,
            'recordsFiltered' => $products['total'],
            'recordsTotal' => $products['total'],
        );
        echo json_encode($result);
    }

    public function confirmTableData($payload = array()){

        

        $order_column = array("q.id","q.ref_number","q.approval_status","w.name","q.id");
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
        $select .= ', w.name as warehouse, w.location, sc.state_name';
        $this->db->select($select)
            ->from('quotation q')
            ->join('warehouse w', 'w.id = q.warehouse_id')
            ->join('state_code sc', 'sc.id = w.state_code')
            ->where(array('q.delete_status'=>0,'q.approval_status'=>'UnApproved','q.quotation_status'=>1));

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
            ->join('state_code sc', 'sc.id = w.state_code')
            ->where(array('q.delete_status'=>0,'q.approval_status'=>'UnApproved','q.quotation_status'=>1));

        if( isset($payload['search']['value']) ){
            $this->db->like('q.ref_number', trim($payload['search']['value']));
        }

        $result['total'] = $this->db->get()->num_rows();
        return $result;
    }
    

    public function quotation_proposal($quotation_id){
        $data['quotation'] = $this->order_model->get_quotation_proposal_details($quotation_id);
        $data['quotation_products'] = $this->order_model->get_quotation_product_details($quotation_id);
        $data['vendor_quotation'] = $this->order_model->get_vendor_quotation($quotation_id);
        // echo "<pre>";print_r($data['vendor_quotation']);exit();
        $this->load->view('orders/confirm/quotation_proposal',$data);
    }

    public function quotation_proposal_details($vendor_quote_id){

        $data['quotation_price_details'] = $this->order_model->get_quotation_product_price($vendor_quote_id);

        foreach ($data['quotation_price_details'] as $key => $value) {
             $quotation_id = $value['quotation_id'];
        }

        $data['vendor_quotation'] = $this->order_model->get_requested_vendor_details($quotation_id);

        $data['quotation'] = $this->order_model->get_quotation_proposal_details($quotation_id);

        $this->load->view('orders/confirm/quotation_proposal_details',$data);

    }

    public function confirm_vendor_quotation($vendor_quote_id){
        $suppiler = $this->vendor_model->getSupplierByVendorQuote($vendor_quote_id);
        //echo '<pre>';print_r($suppiler);exit;
        $temp = $this->db->select('quotation_id')->from('vendor_quotation')->where('vendor_quote_id',$vendor_quote_id)->get()->row();
        if(!empty($temp)){
            $quotation_id = $temp->quotation_id;
        }else{
            $quotation_id = "";
        }

        $result = $this->order_model->update_proposal_details($vendor_quote_id,$quotation_id);
        if($result){
            if( count($suppiler) ){
                $to = explode(',',$suppiler[0]['email']);
                if( count($to) ){
                    $subject = 'Quotation Approved';
                    $message = 'Your quotation for '.$suppiler[0]['ref_number'].' is approved.';
                    $this->sendmail($to,$subject,$message);
                }
            }
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Vendor Confirmed Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not confirm, please try later');
        }

        redirect(base_url('orders/new_confirm_quotation_list'));

    }

    // END Confirm Quotation List

    // START TRACK SHIPMENT

    public function track_shipment(){

        $proposal_status = '7';
        $data['quotation_list'] = $this->order_model->get_order_quotation_details($proposal_status);
        $this->load->view('orders/track/track_shipment_list', $data);
    }

    public function getTrackShipmentTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $suppiler_id = $this->session->userdata('supplier_id');
        $proposal_status = 7;
        $products = $this->order_model->get_order_quotation_table_list($_POST,$proposal_status,$suppiler_id);
        // echo '<pre>';print_r($products);exit;
        $data = array();
        $i = 1;
        if( isset($_POST['start']) && intval($_POST['start']) > 0 ){
            $i = $_POST['start'] + 1;
        }
        foreach ($products['data'] as $row) {
            $rowData = array();
            $rowData[] = $i;
            $rowData[] = $row['ref_number'];
            $rowData[] = $row['warehouse_name'];
            $rowData[] = '<a href="'.base_url().'orders/add_track_shipment/'.$row['quotation_id'].'/'.$row['vendor_quote_id'].'">New Shipment</a>';
            $i++;
            $data[] = $rowData;
        }

        $result = array(
            // 'draw'  =>  $_POST['draw'],
            'data'  =>  $data,
            'recordsFiltered' => $products['total'],
            'recordsTotal' => $products['total'],
        );
        echo json_encode($result);
    }

    public function add_track_shipment($quotation_id, $vendor_quote_id = 0){
        $proposal_status = 7;
        $data['vendor_quotation'] = $this->order_model->get_single_order_quotation_details($quotation_id,$proposal_status,$vendor_quote_id);
        $data['quotation_price_details'] = $this->order_model->get_order_price_details($quotation_id,$proposal_status,$vendor_quote_id);
        // echo "<pre>";print_r($data['vendor_quotation']);exit();
        $this->load->view('orders/track/add_track_shipment',$data); 
    }

    public function create_track_shipment(){
        // echo "<pre>";print_r($_POST);exit();
        $vendor_quote_id = $_POST['vendor_quote_id'];
        $temp_data = array('proposal_status' => '5');
        $temp_product = array(
            'lorry_number' => $_POST['lorry_number'],
            'lorry_details' => $_POST['lorry_details'],
            'vendor_quote_id' => $_POST['vendor_quote_id']
        );
        $result = $this->order_model->create_track_shipment_details($temp_data,$temp_product,$vendor_quote_id);
        if($result){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Track Shipment added Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not confirm, please try later');
        }
        redirect(base_url('orders/track_shipment'));
    }

    // END TRACK SHIPMENT


    // START CONFIRM GOODS RECEIPT NOTES

    public function confirmed_goods_receipt_list(){

        $proposal_status = '5';
        $data['quotation_list'] = $this->order_model->get_order_quotation_details($proposal_status);

        $this->load->view('orders/goodsreceipt/confirmed_goods_receipt_list', $data);
    }

    public function getGoodsReceiptTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $proposal_status = '5';
        $products = $this->order_model->get_order_quotation_table_list($_POST,$proposal_status);
        // echo '<pre>';print_r($products);exit;
        $data = array();
        $i = 1;
        if( isset($_POST['start']) && intval($_POST['start']) > 0 ){
            $i = $_POST['start'] + 1;
        }
        foreach ($products['data'] as $row) {
            $rowData = array();
            $rowData[] = $i;
            $rowData[] = $row['ref_number'];
            $rowData[] = $row['warehouse_name'];
            $rowData[] = '<a href="'.base_url().'orders/view_confirm_goods_receipt/'.$row['quotation_id'].'">View Receipt</a>';
            $i++;
            $data[] = $rowData;
        }

        $result = array(
            // 'draw'  =>  $_POST['draw'],
            'data'  =>  $data,
            'recordsFiltered' => $products['total'],
            'recordsTotal' => $products['total'],
        );
        echo json_encode($result);
    }

    public function view_confirm_goods_receipt($quotation_id){
        $proposal_status = '5';
        $data['vendor_quotation'] = $this->order_model->get_single_order_quotation_details($quotation_id,$proposal_status);
        $data['quotation_price_details'] = $this->order_model->get_order_price_details($quotation_id,$proposal_status);
        // echo '<pre>';print_r($data);exit;
        $this->load->view('orders/goodsreceipt/view_confirm_goods_receipt',$data);
    }

    public function create_goods_delivery_note(){

        // echo "<pre>";
        // print_r($_POST);
        // exit();

        $quotation_data = array('quotation_status' => '3');
        $quotation_id = $_POST['quotation_id'];

        $vendor_quote_id = $_POST['vendor_quote_id'];
        $temp_data = array(
            'grand_wholesale_price' => $_POST['grand_wholesale_price'],
            'grand_retail_price' => $_POST['grand_retail_price'],
            'proposal_status' => '6');

        $temp_product = array(
            'total_qty' => $_POST['total_qty'],
            'breakage_qty' => $_POST['breakage_qty'],
            'reduced_wh_amount' => $_POST['reduced_wh_amount'],
            'total_wh_amount' => $_POST['total_wh_amount'],
            'reduced_rp_amount' => $_POST['reduced_rp_amount'],
            'total_rp_amount' => $_POST['total_rp_amount'],
            'vqd_id' => $_POST['vqd_id']
        );

        // echo "<pre>";
        // print_r($quotation_data);
        // print_r($temp_product);
        // exit();

        $result = $this->order_model->update_vendor_quotation_details($temp_data,$temp_product,$vendor_quote_id,$quotation_id,$quotation_data);

        if($result){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Goods receipt note added Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not confirm, please try later');
        }

        redirect(base_url('orders/confirmed_goods_receipt_list'));

    }
    // END CONFIRM GOODS RECEIPT NOTES

    public function sendmail($to,$subject,$message)
    {
        $this->load->config('email');
        $this->load->library('email');        
        $from = $this->config->item('smtp_user');
        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            //echo 'Your Email has successfully been sent.';
            return 1;
        } else {
            //show_error($this->email->print_debugger());
            return 0;
        }
    }
}
