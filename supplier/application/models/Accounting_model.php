<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting_model extends CI_Model {
	
	public function _consruct(){
		parent::_construct();
   }

   public function create_new_invoice($data,$temp_data,$vendor_quote_id){

      $this->db->insert('invoice',$data);
      $row1 = $this->db->affected_rows();

      $this->db->set($temp_data)->where('vendor_quote_id',$vendor_quote_id)->update('vendor_quotation');
      $row2 = $this->db->affected_rows();

      if($row1>0 && $row2 > 0){
         return true;
      }else{
         return false;
      }
   }

   public function get_quotation_invoice_details($proposal_status,$invoice_status){

      $this->db->distinct();
      $this->db->select('q.*,w.name as warehouse_name,vq.vendor_quote_id');
      $this->db->from('quotation q');
      $this->db->join('invoice i','q.quotation_id=i.quotation_id');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->join('warehouse w','w.id=q.warehouse_id');
      $this->db->where(array('q.approval_status' => 'approved','q.delete_status' => '0','vq.proposal_status' => $proposal_status,'i.invoice_status' => $invoice_status));
      return $this->db->get()->result_array();
   }

   public function get_quotation_invoice_details_table_list($payload = array(), $proposal_status = 4, $invoice_status = 0){

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

      $select = 'q.*,w.name as warehouse_name,vq.vendor_quote_id';
      $this->db->select($select)
         ->from('quotation q')
         ->join('invoice i','q.quotation_id=i.quotation_id')
         ->join('vendor_quotation vq','q.quotation_id=vq.quotation_id')
         ->join('warehouse w','w.id=q.warehouse_id')
         ->where(array(
            'q.approval_status' => 'approved',
            'q.delete_status' => '0',
            'vq.proposal_status' => $proposal_status,
            'i.invoice_status' => $invoice_status
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
         ->join('invoice i','q.quotation_id=i.quotation_id')
         ->join('vendor_quotation vq','q.quotation_id=vq.quotation_id')
         ->join('warehouse w','w.id=q.warehouse_id')
         ->where(array(
            'q.approval_status' => 'approved',
            'q.delete_status' => '0',
            'vq.proposal_status' => $proposal_status
         ));

      if( isset($payload['search']['value']) ){
         $this->db->like('q.ref_number', trim($payload['search']['value']));
      }

      $result['total'] = $this->db->get()->num_rows();
      return $result;
   }

   public function get_quotation_invoice($quotation_id,$invoice_status){
      $this->db->select('i.*');
      $this->db->from('quotation q');
      $this->db->join('invoice i','q.quotation_id=i.quotation_id');
      $this->db->where(array('i.quotation_id' => $quotation_id,'invoice_status' => $invoice_status));
      return $this->db->get()->row_array();
   }

   public function get_quotation_details($proposal_status){

      $this->db->select('q.*,vq.vendor_quote_id');
      $this->db->from('quotation q');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->where(array('q.approval_status' => 'approved','q.delete_status' => '0','vq.proposal_status' => $proposal_status));
      return $this->db->get()->result_array();
   }

   public function get_order_quotation_table_list($payload = array(), $proposal_status = 4){

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

      $select = 'q.*,w.name as warehouse_name,vq.vendor_quote_id';
      $this->db->select($select)
         ->from('quotation q')
         ->join('vendor_quotation vq','q.quotation_id=vq.quotation_id')
         ->join('warehouse w','w.id=q.warehouse_id')
         ->where(array(
            'q.approval_status' => 'approved',
            'q.delete_status' => '0',
            'vq.proposal_status' => $proposal_status
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
         ->join('vendor_quotation vq','q.quotation_id=vq.quotation_id')
         ->join('warehouse w','w.id=q.warehouse_id')
         ->where(array(
            'q.approval_status' => 'approved',
            'q.delete_status' => '0',
            'vq.proposal_status' => $proposal_status
         ));

      if( isset($payload['search']['value']) ){
         $this->db->like('q.ref_number', trim($payload['search']['value']));
      }

      $result['total'] = $this->db->get()->num_rows();
      return $result;
   }


   public function get_vendor_quotation_details($quotation_id,$proposal_status){

      $this->db->select('q.*,vq.*,w.name as warehouse_name');
      $this->db->from('quotation q');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->join('warehouse w','w.id=q.warehouse_id');
      $this->db->where(array('q.quotation_id' => $quotation_id,'vq.proposal_status' => $proposal_status));
      return $this->db->get()->row_array();
   }

   public function get_vendor_price_details($quotation_id,$proposal_status){

      $this->db->select('q.quotation_id,q.ref_number,q.description,qp.*,p.name as product_name,vqd.*,w.name as warehouse_name');
      $this->db->from('quotation q');
      $this->db->join('quotation_products qp','q.quotation_id=qp.quotation_id');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->join('vendor_quotation_details vqd','qp.qp_id=vqd.quotation_product_id');
      $this->db->join('products p','qp.product_id=p.id');
      $this->db->join('warehouse w','q.warehouse_id=w.id');
      $this->db->where(array('q.quotation_id' => $quotation_id,'vq.proposal_status' => $proposal_status));
      return $this->db->get()->result_array();
   }


   public function update_invoice_details($data,$invoice_id){

      $this->db->set($data)->where('invoice_id',$invoice_id)->update('invoice');
      $row = $this->db->affected_rows();

      // $this->db->set('proposal_status','4')->where('vendor_quote_id',$vendor_quote_id)->update('vendor_quotation');
      // $row2 = $this->db->affected_rows();

      if($row>0){
         return true;
      }else{
         return false;
      }
   }


   public function get_paid_invoice_details($invoice_status){

      $this->db->select('q.*,w.name as warehouse_name,vq.vendor_quote_id');
      $this->db->from('quotation q');
      $this->db->join('invoice i','q.quotation_id=i.quotation_id');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->join('warehouse w','w.id=q.warehouse_id');
      $this->db->where(array('q.approval_status' => 'approved','q.delete_status' => '0','i.invoice_status' => $invoice_status));
      return $this->db->get()->result_array();
   }


   public function get_paid_invoice_details_table_list($payload = array(), $invoice_status = 0){

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

      $select = 'q.*,w.name as warehouse_name,vq.vendor_quote_id';
      $this->db->select($select)
         ->from('quotation q')
         ->join('invoice i','q.quotation_id=i.quotation_id')
         ->join('vendor_quotation vq','q.quotation_id=vq.quotation_id')
         ->join('warehouse w','w.id=q.warehouse_id')
         ->where(array(
            'q.approval_status' => 'approved',
            'q.delete_status' => '0',
            'i.invoice_status' => $invoice_status
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
         ->join('invoice i','q.quotation_id=i.quotation_id')
         ->join('vendor_quotation vq','q.quotation_id=vq.quotation_id')
         ->join('warehouse w','w.id=q.warehouse_id')
         ->where(array(
            'q.approval_status' => 'approved',
            'q.delete_status' => '0',
            'i.invoice_status' => $invoice_status
         ));

      if( isset($payload['search']['value']) ){
         $this->db->like('q.ref_number', trim($payload['search']['value']));
      }

      $result['total'] = $this->db->get()->num_rows();
      return $result;
   }
   
}
?>