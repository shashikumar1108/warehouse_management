<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('order_model');
        $this->load->model('vendor_model');
        
        if(!$this->session->userdata('login') == true){
			redirect(base_url('/auth/login'));
        }
    }

    // Start Request For Quotation
    function request_for_quote(){

        $this->db->select('q.*');
        $this->db->from('quotation q');
        $this->db->where(array('q.delete_status' => '0','q.quotation_status' => '1','q.approval_status' => 'UnApproved'));
        $this->db->where('q.delete_status',0);
        $data['quotation_list'] = $this->db->get()->result_array();

        $this->load->view('orders/new/request_for_quote_list',$data);
    }

    function add_request_for_quote(){

        $code = "RFQ_WHNO_";
        $ref = $this->db->select('quotation_id')->from('quotation')->order_by('quotation_id','desc')->get()->row();
        if(!empty($ref)){
            $ref = $ref->quotation_id;
        }else{
            $ref = 0;
        }
        $data['new_ref_no'] = $code . sprintf('%03d', $ref+1);
        //echo $data['new_ref_no'];exit;
        $this->load->view('orders/new/add_request_for_quote',$data);
    }
    
    /*
    public function testmail()
    {
        $this->load->config('email');
        $this->load->library('email');
        
        $from = $this->config->item('smtp_user');
        $to = array('shashikumarvchandru@gmail.com','shashikumarvchandru@yahoo.com');
        $subject = 'Test Mail PHP';
        $message = 'Hello';

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            echo 'Your Email has successfully been sent.';
        } else {
            show_error($this->email->print_debugger());
        }
    }
    */

    public function add_new_quotation(){
        // echo '<pre>';print_r($_POST);exit;
        //$suppilers = $this->order_model->getWarehouseSuppliers($this->input->post('warehouse_id'));
        $temp_data = array('ref_number' => $_POST['ref_number'],'approval_status' =>'UnApproved','warehouse_id' => $_POST['warehouse_id'],'description' => $_POST['description'],'quotation_status' => '1');
        $temp_product['product_id'] = $_POST['product_id'];
        $temp_product['category_id'] = $_POST['category_id'];
        $temp_product['sub_category_one_id'] = $_POST['sub_category_one_id'];
        $temp_product['sub_category_two_id'] = $_POST['sub_category_two_id'];
        $temp_product['quantity'] = $_POST['quantity'];

        $result = $this->order_model->add_new_quotation_details($temp_data,$temp_product);

        if($result){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Quotaion Details Added Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');
        }

        redirect(base_url('orders/request_for_quote'));
    }

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


    public function edit_request_for_quote($quotation_id){

        $data['quotation'] = $this->order_model->edit_quotation_details($quotation_id);

        $data['quotation_product'] = $this->order_model->get_quotation_product_details($quotation_id);

        // echo "<pre>";
        // print_r($data['quotation']);
        // print_r($data['quotation_product']);
        // exit();

        $this->load->view('orders/new/edit_request_for_quote',$data);
    }

    public function update_quotation(){

        // echo "<pre>";
        // print_r($_POST);
        // exit();


        $quotation_id = $_POST['quotation_id'];
        $temp_data = array('ref_number' => $_POST['ref_number'],'warehouse_id' => $_POST['warehouse_id'],'description' => $_POST['description'],'quotation_status' => '1');

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
        $temp_data = array('delete_status' => '1');
        $result = $this->order_model->delete_quotation_details($temp_data,$quotation_id);

        if($result){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Quotation Details Deleted Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not delete, please try later');
        }

        redirect(base_url('orders/request_for_quote'));
    }

    // End Request For Quotation

    // Start Request For Quotation
    function approve_rfq(){
        $this->db->select('q.*');
        $this->db->from('quotation q');
        $this->db->where(array('q.approval_status' => 'UnApproved','q.delete_status' => '0','q.quotation_status' => '1'));
        $this->db->where('q.delete_status',0);
        $data['quotation_list'] = $this->db->get()->result_array();
        $this->load->view('orders/new/approve_rfq_list',$data);
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
        $data['quotation_list'] = $this->vendor_model->getConfirmQuotesList();
        // echo "<pre>";print_r($data['quotation_list']);exit();
        $this->load->view('orders/confirm/new_confirm_quotation_list',$data);
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

        // echo "<pre>";
        // print_r($price_details);
        // // print_r($product_details);
        // exit();

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
    
    public function view_quotation_proposals($quotation_id){

        $data = array();
        $data['quotations'] = $this->vendor_model->getVendorQuotations($quotation_id);
        $data['quotation'] = $this->order_model->get_quotation_proposal_details($quotation_id);
        $data['quotation_products'] = $this->order_model->get_quotation_product_details($quotation_id);
        // echo "<pre>";print_r($data['quotations']);exit;
        // $data['vendor_quotation'] = $this->order_model->get_vendor_quotation($quotation_id);
        for ($i=0; $i < count($data['quotations']); $i++) { 
            $data['quotations'][$i]['products'] = array();
            $data['quotations'][$i]['products'] = $this->order_model->get_quotation_product_price($data['quotations'][$i]['vendor_quote_id']);
            // echo $this->db->last_query();exit;
            $data['quotations'][$i]['vendor_quotation'] = $this->order_model->get_vendor_quotation($quotation_id, $data['quotations'][$i]['vendor_quote_id']);
            // echo $this->db->last_query();exit;
            // echo "<pre>";print_r($vendor_quotation);exit();    
        }
        // echo "<pre>";print_r($data['quotations']);exit();
        $this->load->view('orders/confirm/quotation_proposals_list',$data);
    }

    public function approvedVendorQuotes(){
        // echo '<pre>';print_r($_POST);exit;
        if( !empty($_POST['quotation_id']) ){            
            $select = 'q.quotation_id';
            $this->db->select($select);
            $this->db->from('quotation q');
            $this->db->where(
                array(
                    'q.quotation_id'=>$_POST['quotation_id'],
                    'q.quotation_status'=>1,
                    'q.delete_status'=>0,
                    'q.approval_status'=>'Approved'
                )
            );
            $quotation = $this->db->get()->result_array();
            // echo $this->db->last_query();exit;
            if( count($quotation) ){
                foreach ($_POST['products'] as $product) {
                    // print_r($product);
                    $quote_product = $this->order_model->checkQuotationVendorItem(
                        $_POST['quotation_id'],
                        $product['vendor_quote_id'],
                        $product['qp_id'],
                        $product['product_id'],
                        $product['supplier_id'],
                        $product['vpd_id'],
                    );
                    // print_r($quote_product);

                    if( count($quote_product) ){
                        
                        $update = array(
                            'status' => $product['status'],
                            // 'alloted_qty' => $product['alloted_qty'],
                        );
                        $this->db->set($update)->where('vqd_id',$product['vpd_id'])->update('vendor_quotation_details');

                        $approvedStock = array();                        
                        $approvedStock['vendor_quote_id'] = $quote_product[0]['vendor_quote_id'];
                        $approvedStock['quotation_product_id'] = $quote_product[0]['quotation_product_id'];
                        $approvedStock['supplier_id'] = $quote_product[0]['supplier_id'];
                        $approvedStock['free_quantity'] = $quote_product[0]['free_quantity'];
                        $approvedStock['breakage_qty'] = $quote_product[0]['breakage_qty'];
                        $approvedStock['quote_qty'] = $quote_product[0]['total_qty'];
                        $approvedStock['total_qty'] = $product['alloted_qty'];
                        $approvedStock['brand_id'] = $quote_product[0]['brand_id'];
                        $approvedStock['wholesale_price'] = $quote_product[0]['wholesale_price'];
                        $approvedStock['w_total_amount'] = $quote_product[0]['wholesale_price'] * $approvedStock['total_qty'];
                        
                        $w_tax_amount = 0;
                        $total_wh_amount = $approvedStock['w_total_amount'];
                        if( (int)$quote_product[0]['w_tax_type'] == 0 ){
                            if($quote_product[0]['w_cgst'] > 0 && $quote_product[0]['w_sgst'] > 0){
                                $cgst_tax = ($approvedStock['w_total_amount']/100)*($quote_product[0]['w_cgst']);
                                $sgst_tax = ($approvedStock['w_total_amount']/100)*($quote_product[0]['w_sgst']);
                        
                                $w_tax_amount = (int)$cgst_tax + $sgst_tax;
                                $total_wh_amount = (int)$approvedStock['w_total_amount'] + $w_tax_amount;
                        
                            }else if($quote_product[0]['w_igst'] > 0){   
                                $igst_tax = ($approvedStock['w_total_amount']/100)*($approvedStock['w_igst']);
                        
                                $w_tax_amount = (int)$igst_tax;
                                $total_wh_amount = (int)$approvedStock['w_total_amount'] + $w_tax_amount;
                            }
                        }else if( (int)$quote_product[0]['w_tax_type'] == 1 ){
                            if($quote_product[0]['w_cgst'] > 0 && $quote_product[0]['w_sgst'] > 0){                        
                                $total_wh_amount = (int)($approvedStock['w_total_amount']);
                                $w_tax_amount = $total_wh_amount - (int)($total_wh_amount*(100/(100+$quote_product[0]['w_cgst']+$quote_product[0]['w_sgst'])));
                                $total_wh_amount = (int)($total_wh_amount - $w_tax_amount);
                              }else if($quote_product[0]['w_igst'] > 0){                           
                                $total_wh_amount = (int)($approvedStock['w_total_amount']);
                                $w_tax_amount = $total_wh_amount - (int)($total_wh_amount*(100/(100+$quote_product[0]['w_igst'])));
                                $total_wh_amount = (int)($total_wh_amount - $w_tax_amount);
                            }
                        }

                        $approvedStock['w_cgst'] = $quote_product[0]['w_cgst'];
                        $approvedStock['w_sgst'] = $quote_product[0]['w_sgst'];
                        $approvedStock['w_igst'] = $quote_product[0]['w_igst'];
                        $approvedStock['w_tax_amount'] = $w_tax_amount;
                        $approvedStock['w_tax_type'] = $quote_product[0]['w_tax_type'];
                        $approvedStock['total_wholesale_price'] = $approvedStock['w_total_amount'];
                        $approvedStock['reduced_wh_amount'] = $quote_product[0]['reduced_wh_amount'];
                        $approvedStock['total_wh_amount'] = $total_wh_amount;

                        $approvedStock['retail_price'] = $quote_product[0]['retail_price'];
                        $approvedStock['r_total_amount'] = $quote_product[0]['retail_price'] * $approvedStock['total_qty'];

                        $r_tax_amount = 0;
                        $total_rp_amount = $approvedStock['r_total_amount'];
                        if( (int)($quote_product[0]['r_tax_type']) == 0 ){
                            if($quote_product[0]['r_cgst'] > 0 && $quote_product[0]['r_sgst'] > 0){
                                $cgst_tax = ($approvedStock['r_total_amount']/100)*($quote_product[0]['r_cgst']);
                                $sgst_tax = ($approvedStock['r_total_amount']/100)*($quote_product[0]['r_sgst']);
                        
                                $r_tax_amount = (int)($cgst_tax + $sgst_tax);
                                $total_rp_amount = (int)($approvedStock['r_total_amount'] + $r_tax_amount);
                        
                            }else if($quote_product[0]['r_igst'] > 0){   
                                $igst_tax = ($approvedStock['r_total_amount']/100)*($approvedStock['r_igst']);
                        
                                $r_tax_amount = (int)($igst_tax);
                                $total_rp_amount = (int)($approvedStock['r_total_amount'] + $r_tax_amount);
                            }
                        }else if( (int)($quote_product[0]['r_tax_type']) == 1 ){
                            if($quote_product[0]['r_cgst'] > 0 && $quote_product[0]['r_sgst'] > 0){                        
                                $total_rp_amount = (int)($approvedStock['r_total_amount']);
                                $r_tax_amount = $total_rp_amount - (int)($total_rp_amount*(100/(100+$quote_product[0]['r_cgst']+$quote_product[0]['r_sgst'])));
                                $total_rp_amount = (int)($total_rp_amount - $r_tax_amount);
                              }else if($quote_product[0]['r_igst'] > 0){                           
                                $total_rp_amount = (int)($approvedStock['r_total_amount']);
                                $r_tax_amount = $total_rp_amount - (int)($total_rp_amount*(100/(100+$quote_product[0]['r_igst'])));
                                $total_rp_amount = (int)($total_rp_amount - $r_tax_amount);
                            }
                        }
                        
                        $approvedStock['r_cgst'] = $quote_product[0]['r_cgst'];
                        $approvedStock['r_sgst'] = $quote_product[0]['r_sgst'];
                        $approvedStock['r_igst'] = $quote_product[0]['r_igst'];
                        $approvedStock['r_tax_amount'] = $r_tax_amount;
                        $approvedStock['r_tax_type'] = $quote_product[0]['r_tax_type'];
                        $approvedStock['total_retail_price'] = $approvedStock['r_total_amount'];
                        $approvedStock['reduced_rp_amount'] = $quote_product[0]['reduced_rp_amount'];
                        $approvedStock['total_rp_amount'] = $total_rp_amount;
                        $approvedStock['stock_status'] = $quote_product[0]['stock_status'];
                        $approvedStock['status'] = $product['status'];
                        $approvedStock['created_at'] = date('Y-m-d H:i:s');
                        // print_r($approvedStock);     
                        $this->db->insert('vendor_quotation_approved_details',$approvedStock);                   
                    }
                }

                $this->db->select('vendor_quote_id,quotation_id,supplier_id,grand_wholesale_price,grand_retail_price,transport_cost');
                $this->db->from('vendor_quotation');
                $this->db->where(
                    array(
                        'quotation_id'=>$_POST['quotation_id'],
                        'delete_status'=>0,
                    )
                );
                $quotations = $this->db->get()->result_array();
                // echo '<pre>';print_r($quotations);exit;
                foreach ($quotations as $vquote) {
                    $select = 'sum(total_wholesale_price) as total_wholesale_price';
                    $select .= ',sum(total_rp_amount) as total_retail_price';
                    $this->db->select($select);
                    $this->db->from('vendor_quotation_approved_details');                    
                    $this->db->where('vendor_quote_id',$vquote['vendor_quote_id']);
                    $vendor_quote = $this->db->get()->result_array();
                    // echo $this->db->last_query();
                    // echo '<pre>';print_r($vendor_quote);
                    $update = array();
                    if( count($vendor_quote) ){
                        $update = array(
                            'grand_wholesale_price' =>  $vendor_quote[0]['total_wholesale_price'] + $vquote['transport_cost'],
                            'grand_retail_price' =>  $vendor_quote[0]['total_retail_price'],
                            'old_grand_wholesale_price' =>  $vquote['grand_wholesale_price'],
                            'old_grand_retail_price' =>  $vquote['grand_retail_price'],
                        );
                    }  
                    
                    $this->db->select('vqd_id');
                    $this->db->from('vendor_quotation_details');                    
                    $this->db->where(array('vendor_quote_id'=>$vquote['vendor_quote_id'],'status'=>1));
                    $vendor_quote_status = $this->db->get()->result_array();
                    if( count($vendor_quote_status) ){ $update['proposal_status'] = 2; }
                    else{ $update['proposal_status'] = 4; }

                    if( count($update) ){
                        $this->db->set($update)->where('vendor_quote_id',$vquote['vendor_quote_id'])->update('vendor_quotation');
                        $suppiler = $this->vendor_model->getSupplierByVendorQuote($vquote['vendor_quote_id']);
                        if( count($suppiler) ){
                            $to = explode(',',$suppiler[0]['email']);
                            if( count($to) ){
                                $subject = 'Quotation Approved';
                                $message = 'Your quotation for '.$suppiler[0]['ref_number'].' is approved.';
                                $this->sendmail($to,$subject,$message);
                            }
                        }
                        // echo '<pre>';print_r($suppiler);exit;
                    }
                    
                }
                $this->db->set('quotation_status','2')->where('quotation_id',$_POST['quotation_id'])->update('quotation');
                echo json_encode(array('status'=>true,'msg'=>'Quotes processed successfully'));exit;
            }else{
                echo json_encode(array('status'=>false,'msg'=>'Quotation not available'));exit;
            }            
        }else{
            echo json_encode(array('status'=>false,'msg'=>'Required fields are missing!!!'));exit;
        }
    }

    // END Confirm Quotation List

    // START TRACK SHIPMENT

    public function track_shipment(){

        $proposal_status = '7';
        $data['quotation_list'] = $this->order_model->get_order_quotation_details($proposal_status);
        // echo '<pre>';print_r($data);exit;
        $this->load->view('orders/track/track_shipment_list', $data);
    }

    public function add_track_shipment($quotation_id, $vendor_quote_id = 0){
        $proposal_status = 7;
        $data['vendor_quotation'] = $this->order_model->get_single_order_quotation_details($quotation_id,$proposal_status,$vendor_quote_id);
        $data['quotation_price_details'] = $this->order_model->get_order_price_details($quotation_id,$proposal_status,$vendor_quote_id);
        // echo "<pre>";print_r($data['quotation_price_details']);exit();
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
        // echo "<pre>";print_r($data);exit();
        $this->load->view('orders/goodsreceipt/confirmed_goods_receipt_list', $data);
    }

    public function add_confirm_goods_receipt($quotation_id, $vendor_quote_id = 0){
        $proposal_status = '5';
        $data['vendor_quotation'] = $this->order_model->get_single_order_quotation_details($quotation_id,$proposal_status, $vendor_quote_id);
        // echo '<pre>';print_r($data['vendor_quotation']);exit;
        if( count($data['vendor_quotation']) == 0 ){
            $this->session->set_flashdata('status','fail');
            $this->session->set_flashdata('message','Goods receipt not found'); 
            redirect(base_url('orders/confirmed_goods_receipt_list'));
        }
        $data['quotation_price_details'] = $this->order_model->get_order_price_details($quotation_id,$proposal_status,$vendor_quote_id);
        // echo '<pre>';print_r($data);exit;
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

    



}
