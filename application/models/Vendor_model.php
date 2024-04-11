<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_model extends CI_Model {
	
	public function _consruct(){
		parent::_construct();
   }

   public function get_requested_quotation_details($quotation_id){
      $this->db->select('q.*');
      $this->db->from('quotation q');
      $this->db->where(array('q.approval_status' => 'approved','q.delete_status' => '0','q.quotation_status' => '1','q.quotation_id' => $quotation_id));
      return $this->db->get()->row_array();
   }

   public function fetch_quotation_product_details($quotation_id){
      $this->db->select('qp.*,p.name as product_name,c.name as category_name');
      $this->db->from('quotation_products qp');
      $this->db->join('products p','qp.product_id=p.id');
      $this->db->join('category c','qp.category_id=c.id');
      // $this->db->join('sub_categories_one sc1','qp.sub_category_one_id=sc1.id');
      // $this->db->join('sub_categories_two sc2','qp.sub_category_two_id=sc2.id');
      $this->db->where('qp.quotation_id',$quotation_id);
      return $this->db->get()->result_array();
   }

	public function add_quotation_proposal_details($temp_data,$temp_product){

      $this->db->insert('vendor_quotation',$temp_data);
      $row1 = $this->db->affected_rows();
      $vendor_quote_id = $this->db->insert_id();

      for($i=0;$i<count($temp_product["wholesale_price"]); $i++){
         $batch[] = array(
            'supplier_id' => $temp_product['supplier_id'][$i],
            'free_quantity' => $temp_product['free_quantity'][$i],
            'quotation_product_id' => $temp_product['quotation_product_id'][$i],
            'total_qty' => $temp_product['total_qty'][$i],
            'brand_id' => $temp_product['brand_id'][$i],
            'wholesale_price' => $temp_product['wholesale_price'][$i],'w_total_amount' => $temp_product['w_total_amount'][$i],
            'w_cgst' => $temp_product['w_cgst'][$i],
            'w_sgst' => $temp_product['w_sgst'][$i],
            'w_igst' => $temp_product['w_igst'][$i],'w_tax_amount' => $temp_product['w_tax_amount'][$i],
            'w_tax_type' => $temp_product['w_tax_type'][$i],'total_wholesale_price' => $temp_product['total_wholesale_price'][$i],
            'retail_price' => $temp_product['retail_price'][$i],'r_total_amount' => $temp_product['r_total_amount'][$i],
            'r_cgst' => $temp_product['r_cgst'][$i],
            'r_sgst' => $temp_product['r_sgst'][$i],
            'r_igst' => $temp_product['r_igst'][$i],'r_tax_amount' => $temp_product['r_tax_amount'][$i],
            'r_tax_type' => $temp_product['r_tax_type'][$i],'total_retail_price' => $temp_product['total_retail_price'][$i],
            'vendor_quote_id' => $vendor_quote_id);
      }

      $this->db->insert_batch('vendor_quotation_details',$batch);
      $row2 = $this->db->affected_rows();

		if($row1 > 0 && $row2>0){
			return true;
		}else{
			return false;
		}
	}

   // START CONFIRMED DELIVERY NOTE

   public function get_vendor_proposed_quotation_details($proposal_status){
      $this->db->select('q.*,vq.vendor_quote_id,s.name as supplier_name,s.phone as supplier_phone,s.email as supplier_email');
      $this->db->from('quotation q');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->join('suppliers s','s.id=vq.supplier_id');
      $this->db->where(array('q.approval_status' => 'approved','q.delete_status' => '0','vq.proposal_status' => $proposal_status));
      return $this->db->get()->result_array();
   }


   public function get_single_vendor_quotation_details($quotation_id,$proposal_status,$vendor_quote_id){

      $this->db->select('q.*,vq.*,w.name as warehouse_name');
      $this->db->from('quotation q');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->join('warehouse w','w.id=q.warehouse_id');
      $this->db->where(array('q.quotation_id' => $quotation_id,'vq.proposal_status' => $proposal_status,'vq.vendor_quote_id'=>$vendor_quote_id));
      return $this->db->get()->row_array();
   }

   public function get_vendor_proposed_price_details($quotation_id,$proposal_status,$vendor_quote_id = 0,$status = 0 ){

      $select = 'q.quotation_id,q.ref_number,q.description,qp.*,p.name as product_name,vqd.*,w.name as warehouse_name';
      if( $status == 1 ){
         $select = 'q.quotation_id,q.ref_number,q.description,qp.*,p.name as product_name,vqad.*,w.name as warehouse_name';
      }
      $this->db->select($select);
      $this->db->from('quotation q');
      $this->db->join('quotation_products qp','qp.quotation_id=q.quotation_id');
      $this->db->join('vendor_quotation vq','vq.quotation_id=q.quotation_id');
      $this->db->join('vendor_quotation_details vqd','vqd.vendor_quote_id = vq.vendor_quote_id and qp.qp_id=vqd.quotation_product_id');

      if( $status == 1 ){
         $this->db->join('vendor_quotation_approved_details vqad','vqad.vendor_quote_id = vq.vendor_quote_id and qp.qp_id=vqad.quotation_product_id');
      }

      $this->db->join('products p','qp.product_id=p.id');
      $this->db->join('warehouse w','q.warehouse_id=w.id');

      $where = array(
         'q.quotation_id' => $quotation_id,
         'q.delete_status'=>0,
         'vq.proposal_status' => $proposal_status,
         'vq.vendor_quote_id' => $vendor_quote_id,
         'vqd.status'=>$status
      );

      if( $status == 1 ){
         $where['vqad.vendor_quote_id'] = $vendor_quote_id;
         $where['vqad.status'] = 1;
      }
      $this->db->where($where);
      return $this->db->get()->result_array();
   }

   public function create_delivery_note_details($temp_data,$vendor_quote_id){

      $batch = array();
      for($i=0;$i<count($temp_data["delivery_date"]); $i++){
        $batch[] = array(
            'delivery_date' => $temp_data['delivery_date'][$i],
            'batch_number' => $temp_data['batch_number'][$i],
            'mfg_date' => $temp_data['mfg_date'][$i],
            'expiry_date' => $temp_data['expiry_date'][$i],
            'vendor_quote_id' => $vendor_quote_id,
        );
      }
      // echo "<pre>";print_r($batch);exit();
      $this->db->insert_batch('vendor_delivery',$batch);
      $row1 = $this->db->affected_rows();

      $this->db->set('proposal_status','3')->where('vendor_quote_id',$vendor_quote_id)->update('vendor_quotation');
      $row2 = $this->db->affected_rows();

      if($row1>0 && $row2 > 0){
         return true;
      }else{
         return false;
      }
   }

   // END CONFIRMED DELIVERY NOTE

	public function getSupplierByVendorQuote($vendor_quote_id = null)
   {
      $this->db->select('q.*,vq.delivery_days,vq.transport_cost,vq.grand_wholesale_price,vq.grand_retail_price,s.name as supplier,s.email');
      $this->db->from('quotation q');
      $this->db->join('vendor_quotation vq','vq.quotation_id=q.quotation_id');
      $this->db->join('vendor_quotation_details vqd','vqd.vendor_quote_id=vq.vendor_quote_id');
      $this->db->join('suppliers s','s.id=vq.supplier_id');
      $where = array(
            'q.approval_status' => 'approved',
            'q.delete_status' => '0',
            'q.quotation_status' => '1',
            'vq.delete_status' => 0
      );

      if( $vendor_quote_id != null ){
         $where['vq.vendor_quote_id'] = $vendor_quote_id;
      }
      $this->db->where($where);
      $this->db->group_by('vq.vendor_quote_id');
      return $this->db->get()->result_array();
   }

   public function getConfirmQuotesList($vendor_quote_id = null)
   {
      $this->db->select('q.*,vq.delivery_days,vq.transport_cost,vq.grand_wholesale_price,vq.grand_retail_price,s.name as supplier,s.email,count(vq.quotation_id) as quotations');
      $this->db->from('quotation q');
      $this->db->join('vendor_quotation vq','vq.quotation_id=q.quotation_id');
      // $this->db->join('vendor_quotation_details vqd','vqd.vendor_quote_id=vq.vendor_quote_id and ');
      $this->db->join('suppliers s','s.id=vq.supplier_id');
      $where = array(
            'q.approval_status' => 'approved',
            'q.delete_status' => '0',
            'q.quotation_status' => '1',
            'vq.delete_status' => 0
      );

      if( $vendor_quote_id != null ){
         $where['vq.vendor_quote_id'] = $vendor_quote_id;
      }
      $this->db->where($where);
      $this->db->group_by('q.quotation_id');
      return $this->db->get()->result_array();
   }

   public function getVendorQuotations($quotation_id = 0){
      $select = 'q.*,vq.delivery_days,vq.transport_cost,vq.grand_wholesale_price,vq.grand_retail_price';
      $select .= ',s.name as supplier,s.email,w.name as warehouse,vqd.vendor_quote_id';
      $this->db->select($select)
         ->from('quotation q')
         ->join('vendor_quotation vq', 'vq.quotation_id=q.quotation_id')
         ->join('vendor_quotation_details vqd', 'vqd.vendor_quote_id=vq.vendor_quote_id')
         ->join('suppliers s','s.id=vqd.supplier_id')
         ->join('warehouse w','w.id=q.warehouse_id')
         ->where(array(
            'q.approval_status' => 'approved',
            'q.delete_status' => '0',
            'q.quotation_status' => '1',
            'vq.delete_status' => 0,
            'q.quotation_id' => $quotation_id
         ))->group_by('vqd.vendor_quote_id');
      return $this->db->get()->result_array();
   }
}
?>