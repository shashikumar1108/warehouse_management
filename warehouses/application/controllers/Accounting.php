<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('accounting_model');
        $this->load->helper('utility');
        $this->load->model('order_model');
        $this->load->model('vendor_model');
        
        if(!$this->session->userdata('login') == true){
			redirect(base_url('/auth/login'));
        }
    }

    // Start Advance Payment
    function advance_payments(){
        // $proposal_status = '3';
        // $data['quotation_list'] = $this->accounting_model->get_quotation_details($proposal_status);
        $data = array();
        $this->load->view('accounting/advance/advance_payments_list',$data);
    }

    public function getAdvancePaymentTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $proposal_status = '3';
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
            $rowData[] = '<a href="'.base_url().'accounting/add_advance_payment/'.$row['quotation_id'].'">New Advance Payment</a>';
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

    function add_advance_payment($quotation_id){
        $proposal_status = '3';
        $data['vendor_quotation'] = $this->accounting_model->get_vendor_quotation_details($quotation_id,$proposal_status);
        $data['quotation_price_details'] = $this->accounting_model->get_vendor_price_details($quotation_id,$proposal_status);
        $this->load->view('accounting/advance/add_advance_payment',$data);
    }
    // End Advance Payment

    public function create_invoice(){

        $vendor_quote_id = $_POST['vendor_quote_id'];

        $data = array('paid_amount' => $_POST['paid_amount'],
                    'pending_amount' => $_POST['pending_amount'],
                    'grand_total' => $_POST['grand_total'],
                    'quotation_id' => $_POST['quotation_id'],
                    'invoice_status' => '1');

        $temp_data = array('proposal_status' => '4');

        $result = $this->accounting_model->create_new_invoice($data,$temp_data,$vendor_quote_id);

        if($result){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Amount Paid Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');
        }

        redirect(base_url('accounting/advance_payments'));
    }

    public function awaiting_order_confirmation(){
        $proposal_status = '5';
        $data['quotation_list'] = $this->accounting_model->get_quotation_details($proposal_status);
        $data = array();
        $this->load->view('accounting/awaiting/awaiting_order_confirmation_list',$data);
    }

    public function getAwaitingOrderTableList(){
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
            $rowData[] = '<a href="'.base_url().'accounting/awaiting_order_details/'.$row['quotation_id'].'">View Details</a>';
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

    function awaiting_order_details($quotation_id){
        $proposal_status = '5';
        $data['vendor_quotation'] = $this->accounting_model->get_vendor_quotation_details($quotation_id,$proposal_status);
        $data['quotation_price_details'] = $this->accounting_model->get_vendor_price_details($quotation_id,$proposal_status);
        $invoice_status = '1';
        $data['invoice'] = $this->accounting_model->get_quotation_invoice($quotation_id,$invoice_status);
        $this->load->view('accounting/awaiting/awaiting_order_details',$data);
    }

    public function pending_invoice(){
        // $proposal_status = '6';
        // $invoice_status = '1';
        // $data['quotation_list'] = $this->accounting_model->get_quotation_invoice_details($proposal_status,$invoice_status);
        $data = array();
        $this->load->view('accounting/pending/pending_invoice_list',$data);
    }

    public function getPendingInvoiceTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $proposal_status = '6';
        $invoice_status = '1';
        $products = $this->accounting_model->get_quotation_invoice_details_table_list($_POST,$proposal_status,$invoice_status);
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
            $rowData[] = '<a href="'.base_url().'accounting/clear_pending_invoice/'.$row['quotation_id'].'">Clear Payment</a>';
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

    function clear_pending_invoice($quotation_id){
        $proposal_status = '6';
        $data['vendor_quotation'] = $this->accounting_model->get_vendor_quotation_details($quotation_id,$proposal_status);
        $data['quotation_price_details'] = $this->accounting_model->get_vendor_price_details($quotation_id,$proposal_status);
        $invoice_status = '1';
        $data['invoice'] = $this->accounting_model->get_quotation_invoice($quotation_id,$invoice_status);
        $this->load->view('accounting/pending/clear_pending_invoice',$data);
    }


    public function update_pending_invoice(){

        // echo "<pre>";
        // print_r($_POST);
        // exit();

        $invoice_id = $_POST['invoice_id'];
        $vendor_quote_id = $_POST['vendor_quote_id'];
        $grand_total = $_POST['grand_total'];

        $paid_amount = $_POST['paid_price'] + $_POST['paid_amount'];

        if($grand_total <= $paid_amount){
            $invoice_data['invoice_status'] = '2';  // 2 for invoice completed
            $invoice_data['pending_amount'] = 0;
            $invoice_data['paid_amount'] = $paid_amount;
            $invoice_data['payment_date'] = date('Y-m-d');
        }else{
            $invoice_data['pending_amount'] = $_POST['pending_amount'];
            $invoice_data['paid_amount'] = $paid_amount;
            $invoice_data['payment_date'] = $_POST['payment_date'];
        }

        
        // echo "<pre>";
        // print_r($invoice_data);
        // exit();

        $result = $this->accounting_model->update_invoice_details($invoice_data,$invoice_id);

        if($result){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Amount Paid Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not add, please try later');
        }

        redirect(base_url('accounting/pending_invoice'));


    }

    public function paid_invoice(){
        $invoice_status = '2';
        $data['invoice_list'] = $this->accounting_model->get_paid_invoice_details($invoice_status);
        $this->load->view('accounting/paid/paid_invoice_list',$data);
    }

    public function getPaidInvoiceTableList(){
        // echo '<pre>';print_r($_POST);exit;
        $invoice_status = '2';
        $products = $this->accounting_model->get_paid_invoice_details_table_list($_POST,$invoice_status);
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
            $rowData[] = '<a href="'.base_url().'accounting/paid_invoice_details/'.$row['quotation_id'].'">View Details</a>';
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

    function paid_invoice_details($quotation_id){
        $proposal_status = '6';
        $data['vendor_quotation'] = $this->accounting_model->get_vendor_quotation_details($quotation_id,$proposal_status);
        $data['quotation_price_details'] = $this->accounting_model->get_vendor_price_details($quotation_id,$proposal_status);
        $invoice_status = '2';
        $data['invoice'] = $this->accounting_model->get_quotation_invoice($quotation_id,$invoice_status);
        $this->load->view('accounting/paid/paid_invoice_details',$data);
    }


}
