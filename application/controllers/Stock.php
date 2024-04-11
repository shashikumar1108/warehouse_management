<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('stock_model');
        
        if(!$this->session->userdata('login') == true){
			redirect(base_url('/auth/login'));
        }
    }

    public function stock_position(){

        $quotation_status = '3';
        $stock_status = '0';
        $data['stock_list'] = $this->stock_model->get_stock_position_price_details($quotation_status,$stock_status);

        // echo "<pre>";
        // print_r($stock_list);
        // exit();

        $this->load->view('stock/position/stock_position', $data);
    }

    public function create_stock_position(){

        // echo "<pre>";
        // print_r($_POST);
        // exit();

        $vendor_quotation_details_id = $_POST['vqad_id'];
        $temp_data = array('stock_status' => '1');

        $temp_product = array(
            'vendor_quotation_details_id' => $_POST['vqad_id'],
            'quotation_id' => $_POST['quotation_id'],
            'rack_id' => $_POST['rack_id']
        );

        // echo "<pre>";
        // print_r($temp_product);
        // print_r($temp_data);
        // exit();

        $result = $this->stock_model->create_stock_position_details($temp_data,$temp_product,$vendor_quotation_details_id);

        if($result){
            $this->session->set_flashdata('status','success');
            $this->session->set_flashdata('message','Stock Position placed Successfully'); 
        }else{
            $this->session->set_flashdata('status','fail'); 
            $this->session->set_flashdata('message','Could not confirm, please try later');
        }

        redirect(base_url('stock/stock_position'));

    }

    public function stock_availability(){

        $quotation_status = '3';
        $stock_status = '1';
        $data['stock_list'] = $this->stock_model->get_stock_availability_price_details($quotation_status,$stock_status);
        // echo "<pre>";
        // print_r($data['stock_list']);
        // exit();

        $this->load->view('stock/availability/stock_availability', $data);
    }


    public function transfer_of_stocks(){

        $quotation_status = '3';
        $stock_status = '1';
        $data['stock_list'] = $this->stock_model->get_stock_availability_price_details($quotation_status,$stock_status);

        // echo "<pre>";
        // print_r($data['stock_list']);
        // exit();

        $this->load->view('stock/transfer/stock_transfer', $data);
    }

    // public function create_stock_transfer(){

    //     // echo "<pre>";
    //     // print_r($_POST);
    //     // exit();

    //     $quotation_id = $_POST['quotation_id'];

    //     $vendor_quotation_details_id = $_POST['vqd_id'];
    //     $temp_data = array(
    //         'stock_status' => '0');

    //     $temp_quotation = array('warehouse_id' => $_POST['warehouse_id']);

    //     // $temp_product = array(
    //     //     'vendor_quotation_details_id' => $_POST['vqd_id'],
    //     //     'quotation_id' => $_POST['quotation_id'],
    //     //     'rack_id' => '0'
    //     // );

    //     // echo "<pre>";
    //     // print_r($temp_product);
    //     // print_r($temp_data);
    //     // exit();

    //     $result = $this->stock_model->create_stock_transfer_details($temp_data,$temp_quotation,$vendor_quotation_details_id,$quotation_id);

    //     if($result){
    //         $this->session->set_flashdata('status','success');
    //         $this->session->set_flashdata('message','Stock Position placed Successfully'); 
    //     }else{
    //         $this->session->set_flashdata('status','fail'); 
    //         $this->session->set_flashdata('message','Could not confirm, please try later');
    //     }

    //     redirect(base_url('stock/stock_transfer'));

    // }
}
