<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting_model extends CI_Model {
	
	public function _consruct(){
		parent::_construct();
   }

   public function create_new_invoice($data,$vendor_update = array()){

      $this->db->insert('invoice',$data);
      $row1 = $this->db->affected_rows();

      $invoice_history = array(
         'invoice_id' => $this->db->insert_id(),
         'amount'     => $data['paid_amount'],
         'payment_date' => date('Y-m-d H:i:s'),  
      );
      $this->db->insert('invoice_history',$invoice_history);

      $where = array(
         'vendor_quote_id' => $data['vendor_quote_id'],
         'quotation_id' => $data['quotation_id'],
      );
      $this->db->set($vendor_update)->where($where)->update('vendor_quotation');
      $row2 = $this->db->affected_rows();

      if($row1>0 && $row2 > 0){
         return true;
      }else{
         return false;
      }
   }

   public function get_quotation_invoice_details($proposal_status,$invoice_status){

      $this->db->distinct();
      $this->db->select('q.*,w.name as warehouse_name,vq.vendor_quote_id,s.name as supplier_name,s.phone as supplier_phone,s.email as supplier_email');
      $this->db->from('quotation q');
      $this->db->join('invoice i','q.quotation_id=i.quotation_id');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->join('warehouse w','w.id=q.warehouse_id');
      $this->db->join('suppliers s','s.id=vq.supplier_id');
      $this->db->where(array('q.approval_status' => 'approved','q.delete_status' => '0','vq.proposal_status' => $proposal_status,'i.invoice_status' => $invoice_status));
      return $this->db->get()->result_array();
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

   public function getAdvancePaymentList($proposal_status){
      $select = 'q.*,w.name as warehouse_name,vq.vendor_quote_id,s.name as supplier_name,s.phone,s.email';
      $this->db->select($select)
         ->from('quotation q')
         ->join('vendor_quotation vq','q.quotation_id=vq.quotation_id')
         ->join('warehouse w','w.id=q.warehouse_id')
         ->join('suppliers s','s.id=vq.supplier_id')
         ->where(array(
            'q.approval_status' => 'approved',
            'q.delete_status' => '0',
            'vq.proposal_status' => $proposal_status
         ));
      return $this->db->get()->result_array();
   }


   public function get_vendor_quotation_details($quotation_id,$proposal_status,$vendor_quote_id = 0){
      $this->db->select('q.*,vq.*,w.name as warehouse_name');
      $this->db->from('quotation q');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->join('warehouse w','w.id=q.warehouse_id');
      $this->db->where(array('q.quotation_id' => $quotation_id,'vq.proposal_status' => $proposal_status));
      if( $vendor_quote_id != 0 ){
         $this->db->where('vq.vendor_quote_id',$vendor_quote_id);
      }
      return $this->db->get()->row_array();
   }

   public function get_vendor_price_details($quotation_id,$proposal_status, $vendor_quote_id = 0){

      $this->db->select('q.quotation_id,q.ref_number,q.description,qp.*,p.name as product_name,vqd.vqd_id,vqad.*,w.name as warehouse_name');
      $this->db->from('quotation q');
      $this->db->join('quotation_products qp','q.quotation_id=qp.quotation_id');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      // $this->db->join('vendor_quotation_details vqd','qp.qp_id=vqd.quotation_product_id');
      $this->db->join('vendor_quotation_details vqd','vqd.vendor_quote_id = vq.vendor_quote_id and qp.qp_id=vqd.quotation_product_id');
         $this->db->join('vendor_quotation_approved_details vqad','vqad.vendor_quote_id = vq.vendor_quote_id and qp.qp_id=vqad.quotation_product_id');
      $this->db->join('products p','qp.product_id=p.id');
      $this->db->join('warehouse w','q.warehouse_id=w.id');
      $this->db->where(array('q.quotation_id' => $quotation_id,'vq.proposal_status' => $proposal_status));
      if( $vendor_quote_id != 0 ){
         $this->db->where('vq.vendor_quote_id',$vendor_quote_id);
      }
      return $this->db->get()->result_array();
   }


   public function update_invoice_details($data,$invoice_id){

      $this->db->set($data)->where('invoice_id',$invoice_id)->update('invoice');
      $row = $this->db->affected_rows();

      $invoice_history = array(
         'invoice_id' => $invoice_id,
         'amount'     => $data['paid_amount'],
         'payment_date' => date('Y-m-d H:i:s'),  
      );
      $this->db->insert('invoice_history',$invoice_history);

      // $this->db->set('proposal_status','4')->where('vendor_quote_id',$vendor_quote_id)->update('vendor_quotation');
      // $row2 = $this->db->affected_rows();

      if($row>0){
         return true;
      }else{
         return false;
      }
   }


   public function get_paid_invoice_details($invoice_status){
      $this->db->select('q.*,w.name as warehouse_name,vq.vendor_quote_id,s.name as supplier_name,s.phone as supplier_phone,s.email as supplier_email');
      $this->db->from('quotation q');
      $this->db->join('invoice i','q.quotation_id=i.quotation_id');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->join('warehouse w','w.id=q.warehouse_id');
      $this->db->join('suppliers s','s.id=vq.supplier_id');
      $this->db->where(array('q.approval_status' => 'approved','q.delete_status' => '0','i.invoice_status' => $invoice_status,'vq.proposal_status !='=>4));
      $this->db->group_by('vq.vendor_quote_id');
      return $this->db->get()->result_array();
   }

   
}
?>