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

    /* Request Quote */
    function request_for_quote(){
        // $this->db->select('q.*');
        // $this->db->from('quotation q');
        // $this->db->where(array('q.delete_status' => '0','q.quotation_status' => '1','q.approval_status' => 'UnApproved'));
        // $this->db->where('q.delete_status',0);
        // $data['quotation_list'] = $this->db->get()->result_array();
        $this->load->view('orders/new/request_for_quote_list',array());
    }

    public function getQuoteTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $proposal_status = '4';
        $products = $this->getQuoteTableData($_POST);
        // echo '<pre>';print_r($products);exit;
        $data = array();
        $i = 1;
        if( isset($_POST['start']) && intval($_POST['start']) > 0 ){
            $i = $_POST['start'] + 1;
        }
        foreach ($products['data'] as $row) {
            $status = '';
            if( (int)$row['quotation_status'] == 1 ){
                $status = 'UnApproved';
            }
            $rowData = array();
            $rowData[] = $i;
            $rowData[] = $row['ref_number'];
            $rowData[] = $status;
            $action = '<a class="btn btn-info" href="'.base_url().'orders/edit_request_for_quote/'.$row['quotation_id'].'">Edit</a>';
            $action .= '<a class="btn btn-warning" href="'.base_url().'orders/delete_quotation?id='.$row['quotation_id'].'">Delete</a>';
            $rowData[] = $action;
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

    public function getQuoteTableData($payload = array()){
        $warehouse_id = $this->session->userdata('warehouse_id');
        $order_column = array("q.quotation_id","q.ref_number","q.quotation_status","q.quotation_id");
        $result = array('data'=>array(),'total'=>0);
        $start = 0;
        $limit = 10;
        if( isset($payload['start']) ){
           $start = (int)$payload['start'];
        }

        if( isset($payload['length']) ){
           $limit = (int)$payload['length'];
        }

        $select = 'q.quotation_id,q.ref_number,q.quotation_status';
        $this->db->select($select)
            ->from('quotation q')
            ->join('warehouse w','w.id=q.warehouse_id')
            ->where(array(
                'q.approval_status' => 'UnApproved',
                'q.delete_status' => '0',
                'q.quotation_status' => 1,
                'q.warehouse_id'=> $warehouse_id,
            ));

        if( isset($payload['search']['value']) ){
           $this->db->like('q.ref_number', trim($payload['search']['value']));
        }
        
        if( isset($payload['order'][0]['column']) && $payload['order'][0]['column'] == 0 ){
           $this->db->order_by('q.quotation_id', 'desc');
        }else if( isset($payload['order'][0]['column']) && $payload['order'][0]['column'] > 0 ){
           $this->db->order_by($order_column[$payload['order'][0]['column']], $payload['order'][0]['dir']);
        }
        
        $result['data'] = $this->db->limit($limit,$start)->get()->result_array();
        
        $this->db->select("q.quotation_id")
            ->from('quotation q')
            ->join('warehouse w','w.id=q.warehouse_id')
            ->where(array(
            'q.approval_status' => 'UnApproved',
            'q.delete_status' => '0',
            'q.quotation_status' => 1,
            'q.warehouse_id'=> $warehouse_id,
            ));

        if( isset($payload['search']['value']) ){
           $this->db->like('q.ref_number', trim($payload['search']['value']));
        }

        $result['total'] = $this->db->get()->num_rows();
        return $result;
    }

    function add_request_for_quote(){
        $warehouse_id = $this->session->userdata('warehouse_id');
        $code = "RFQ_WHNO_";
        $ref = $this->db->select('quotation_id')->from('quotation')->order_by('quotation_id','desc')->get()->row();
        if(!empty($ref)){
            $ref = $ref->quotation_id;
        }else{
            $ref = 0;
        }
        $data['new_ref_no'] = $code . sprintf('%03d', $ref+1);
        $data['warehouse_id'] = $warehouse_id;
        //echo $data['new_ref_no'];exit;
        $this->load->view('orders/new/add_request_for_quote',$data);
    }

    public function add_new_quotation(){

        // echo '<pre>';print_r($_POST);exit;
        $warehouse_id = $this->session->userdata('warehouse_id');
        //$suppilers = $this->order_model->getWarehouseSuppliers($this->input->post('warehouse_id'));
        $temp_data = array('ref_number' => $_POST['ref_number'],'approval_status' =>'UnApproved','warehouse_id' => $warehouse_id,'description' => $_POST['description'],'quotation_status' => '1');

        $temp_product['product_id'] = $_POST['product_id'];
        $temp_product['category_id'] = $_POST['category_id'];
        $temp_product['sub_category_one_id'] = $_POST['sub_category_one_id'];
        $temp_product['sub_category_two_id'] = $_POST['sub_category_two_id'];
        $temp_product['quantity'] = $_POST['quantity'];

        $result = $this->order_model->add_new_quotation_details($temp_data,$temp_product);
        if($result){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Quotation Details Added Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');
        }
        redirect(base_url('orders/request_for_quote'));
    }

    public function edit_request_for_quote($quotation_id){

        $data['warehouse_id'] = $warehouse_id = $this->session->userdata('warehouse_id');
        $data['quotation'] = $this->order_model->edit_quotation_details($quotation_id,$warehouse_id);
        $data['quotation_product'] = $this->order_model->get_quotation_product_details($quotation_id);

        if( count($data['quotation']) == 0 ){
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Quotation not found');
            redirect(base_url('orders/request_for_quote'));
        }

        // echo "<pre>";
        // print_r($data['quotation']);
        // print_r($data['quotation_product']);
        // exit();

        $this->load->view('orders/new/edit_request_for_quote',$data);
    }

    public function update_quotation(){

        // echo "<pre>";print_r($_POST);exit();
        $data['warehouse_id'] = $warehouse_id = $this->session->userdata('warehouse_id');
        $quotation_id = $_POST['quotation_id'];
        $temp_data = array('ref_number' => $_POST['ref_number'],'warehouse_id' => $warehouse_id,'description' => $_POST['description'],'quotation_status' => '1');

        $temp_product['product_id'] = $_POST['product_id'];
        $temp_product['category_id'] = $_POST['category_id'];
        $temp_product['sub_category_one_id'] = $_POST['sub_category_one_id'];
        $temp_product['sub_category_two_id'] = $_POST['sub_category_two_id'];
        $temp_product['quantity'] = $_POST['quantity'];

        if(!empty($_POST['qp_id'])){
            $temp_product['qp_id'] = $_POST['qp_id'];
        }else{
            $temp_product['qp_id'] = array();
        }

        $qp_ids = $this->order_model->get_current_quotation_product_ids($quotation_id);
        if( count($qp_ids) == 0 ){

        }
        // echo "<pre>";print_r($qp_ids);exit();
        foreach($qp_ids as $value){
            $qp_present_ids[] = $value['qp_id'];
        }

        $drop_qp_ids=array_diff($qp_present_ids, $temp_product['qp_id']);

        // echo "<pre>";
        // print_r($temp_product['qp_id']);
        // print_r($qp_ids);
        // print_r($drop_qp_ids);
        // exit();

        $result = $this->order_model->update_quotation_details($temp_data,$quotation_id,$temp_product,$drop_qp_ids);
        if($result){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Quotation Details Updated Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not update, please try later');
        }
        redirect(base_url('orders/request_for_quote'));
    }

    public function delete_quotation(){
        $quotation_id = $_GET['id'];
        $warehouse_id = $this->session->userdata('warehouse_id');
        $temp_data = array('delete_status' => '1');
        $where = array(
            'quotation_id' => $quotation_id,
            'warehouse_id' => $warehouse_id,
        );
        $result = $this->order_model->delete_quotation_details($temp_data,$where);

        if($result){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Quotation Details Deleted Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');
        }
        redirect(base_url('orders/request_for_quote'));
    }

    // Start Request For Quotation
    function approve_rfq(){
        $data = array();
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
            $rowData[] = "<button class='btn btn-primary' onclick='viewQ(".$rowId.")'>View</button>";
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
        $warehouse_id = $this->session->userdata('warehouse_id');
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
            ->where(array('q.delete_status'=>0,'q.approval_status'=>'Approved','q.quotation_status'=>1,'q.warehouse_id'=>$warehouse_id));

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
            ->where(array('q.delete_status'=>0,'q.approval_status'=>'Approved','q.quotation_status'=>1,'q.warehouse_id'=>$warehouse_id));

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

    public function new_confirm_quotation_list(){
        $data = array();
        $this->load->view('orders/confirm/new_confirm_quotation_list',$data);
    }

    public function getConfirmTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $warehouse_id = $this->session->userdata('warehouse_id');
        $products = $this->vendor_model->confirmTableData($_POST,$warehouse_id);
        // echo '<pre>';print_r($products);exit;
        $data = array();
        $i = 1;
        if( isset($_POST['start']) && intval($_POST['start']) > 0 ){
            $i = $_POST['start'] + 1;
        }
        foreach ($products['data'] as $row) {
            $rowData = array();
            $rowData[] = $i;
            // $rowData[] = '<a href="'.base_url().'orders/quotation_proposal/'.$row['quotation_id'].'">New Confirm</a>';
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
        $warehouse_id = $this->session->userdata('warehouse_id');
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
            ->where(array('q.delete_status'=>0,'q.approval_status'=>'UnApproved','q.quotation_status'=>1,'q.warehouse_id'=>$warehouse_id));

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
            ->where(array('q.delete_status'=>0,'q.approval_status'=>'UnApproved','q.quotation_status'=>1,'q.warehouse_id'=>$warehouse_id));

        if( isset($payload['search']['value']) ){
            $this->db->like('q.ref_number', trim($payload['search']['value']));
        }

        $result['total'] = $this->db->get()->num_rows();
        return $result;
    }

    // START TRACK SHIPMENT
    public function track_shipment(){
        $data = array();
        $warehouse_id = $this->session->userdata('warehouse_id');
        $this->load->view('orders/track/track_shipment_list', $data);
    }

    public function getTrackShipmentTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $proposal_status = '7';
        $warehouse_id = $this->session->userdata('warehouse_id');
        $products = $this->order_model->get_order_quotation_table_list($_POST,$proposal_status,$warehouse_id);
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
            // $rowData[] = '<a href="'.base_url().'orders/add_track_shipment/'.$row['quotation_id'].'">New Shipment</a>';
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

    /** End of functions */


    // START CONFIRM GOODS RECEIPT NOTES

    public function confirmed_goods_receipt_list(){

        $proposal_status = '5';
        $data = array();
        $this->load->view('orders/goodsreceipt/confirmed_goods_receipt_list', $data);
    }

    public function getGoodsReceiptTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $proposal_status = '5';
        $warehouse_id = $this->session->userdata('warehouse_id');
        $products = $this->order_model->get_order_quotation_table_list($_POST,$proposal_status,$warehouse_id);
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
            $rowData[] = '<a href="'.base_url().'orders/add_confirm_goods_receipt/'.$row['quotation_id'].'/'.$row['vendor_quote_id'].'">New Receipt</a>';
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

    public function add_confirm_goods_receipt($quotation_id, $vendor_quote_id = 0){
        $proposal_status = '5';
        $warehouse_id = $this->session->userdata('warehouse_id');
        $data['vendor_quotation'] = $this->order_model->get_single_order_quotation_details($quotation_id,$proposal_status,$warehouse_id, $vendor_quote_id);

        if( count($data['vendor_quotation']) == 0 ){
            $this->session->set_flashdata('status','fail');
            $this->session->set_flashdata('message','Goods receipt not found'); 
            redirect(base_url('orders/confirmed_goods_receipt_list'));
        }
        $data['quotation_price_details'] = $this->order_model->get_order_price_details($quotation_id,$proposal_status,$warehouse_id, $vendor_quote_id);
        // echo '<pre>';print_r($data['quotation_price_details']);exit;
        $this->load->view('orders/goodsreceipt/add_confirm_goods_receipt',$data);
    }

    public function create_goods_delivery_note(){

        // echo "<pre>";print_r($_POST);exit();
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

        // echo "<pre>";print_r($quotation_data);print_r($temp_product);exit();
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
