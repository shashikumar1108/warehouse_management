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

      $this->db->select('q.*,vq.vendor_quote_id');
      $this->db->from('quotation q');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->where(array('q.approval_status' => 'approved','q.delete_status' => '0','vq.proposal_status' => $proposal_status));
      return $this->db->get()->result_array();
   }


   public function get_single_vendor_quotation_details($quotation_id,$proposal_status){

      $this->db->select('q.*,vq.*,w.name as warehouse_name');
      $this->db->from('quotation q');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->join('warehouse w','w.id=q.warehouse_id');
      $this->db->where(array('q.quotation_id' => $quotation_id,'vq.proposal_status' => $proposal_status));
      return $this->db->get()->row_array();
   }

   public function get_vendor_proposed_price_details($quotation_id,$proposal_status){

     //  $this->db->select('qp.*,p.name as product_name');
     //  $this->db->from('quotation_products qp');
     //  $this->db->join('products p','qp.product_id=p.id');
     //  $this->db->where('qp.quotation_id',$quotation_id);
     //  $product_details = $this->db->get()->result_array();

     //  $this->db->distinct();
     //  $this->db->select('vq.vendor_quote_id,vqd.brand_id,vqd.total_wholesale_price,vqd.total_retail_price,vqd.supplier_id,vqd.free_quantity');
     //  $this->db->from('vendor_quotation vq');
     //  $this->db->join('vendor_quotation_details vqd','vq.vendor_quote_id=vqd.vendor_quote_id');
     //  $this->db->where(array('vq.quotation_id' => $quotation_id,'vq.proposal_status' => $proposal_status));
     //  $price_details = $this->db->get()->result_array();

     //  $i=0;
     //  for($i=0;$i<count($price_details);$i++){
     //     $price_details[$i]['product_id'] = $product_details[$i]['product_id'];
     //     $price_details[$i]['category_id'] = $product_details[$i]['category_id'];
     //     $price_details[$i]['sub_category_one_id'] = $product_details[$i]['sub_category_one_id'];
     //     $price_details[$i]['sub_category_two_id'] = $product_details[$i]['sub_category_two_id'];
     //     $price_details[$i]['quantity'] = $product_details[$i]['quantity'];
     //     $price_details[$i]['product_name'] = $product_details[$i]['product_name'];
     //  }

     // return $price_details;

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

   public function create_delivery_note_details($temp_data,$vendor_quote_id){

      for($i=0;$i<count($temp_data["delivery_date"]); $i++){
        $batch[] = array(
            'delivery_date' => $temp_data['delivery_date'][$i],
            'batch_number' => $temp_data['batch_number'][$i],
            'mfg_date' => $temp_data['mfg_date'][$i],
            'expiry_date' => $temp_data['expiry_date'][$i],
            'vendor_quote_id' => $temp_data['vendor_quote_id'][$i]);
      }

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

   // public function confirmTableData($payload = array()){
   //    $order_column = array("q.id","q.id","q.ref_number","w.name","s.name","vq.delivery_days","vq.transport_cost","vq.grand_wholesale_price","vq.grand_retail_price","q.id");
   //    $result = array('data'=>array(),'total'=>0);
   //    $start = 0;
   //    $limit = 10;
   //    if( isset($payload['start']) ){
   //        $start = (int)$payload['start'];
   //    }

   //    if( isset($payload['length']) ){
   //        $limit = (int)$payload['length'];
   //    }

   //    $select = 'q.*,vq.delivery_days,vq.transport_cost,vq.grand_wholesale_price,vq.grand_retail_price';
   //    $select .= ',s.name as supplier,s.email,w.name as warehouse';
   //    $this->db->select($select)
   //       ->from('quotation q')
   //       ->join('vendor_quotation vq', 'vq.quotation_id=q.quotation_id')
   //       ->join('vendor_quotation_details vqd', 'vqd.vendor_quote_id=vq.vendor_quote_id')
   //       ->join('suppliers s','s.id=vqd.supplier_id')
   //       ->join('warehouse w','w.id=q.warehouse_id')
   //       ->where(array(
   //          'q.approval_status' => 'approved',
   //          'q.delete_status' => '0',
   //          'q.quotation_status' => '1',
   //          'vq.delete_status' => 0
   //       ))->group_by('q.quotation_id');

   //    if( isset($payload['search']['value']) ){
   //        $this->db->like('q.ref_number', trim($payload['search']['value']));
   //    }
      
   //    if( isset($payload['order'][0]['column']) && $payload['order'][0]['column'] == 0 ){
   //        $this->db->order_by('q.quotation_id', 'desc');
   //    }else if( isset($payload['order'][0]['column']) && $payload['order'][0]['column'] > 0 ){
   //        $this->db->order_by($order_column[$payload['order'][0]['column']], $payload['order'][0]['dir']);
   //    }
      
   //    $result['data'] = $this->db->limit($limit,$start)->get()->result_array();
      
   //    $this->db->select('q.quotation_id')
   //       ->from('quotation q')
   //       ->join('vendor_quotation vq', 'vq.quotation_id=q.quotation_id')
   //       ->join('vendor_quotation_details vqd', 'vqd.vendor_quote_id=vq.vendor_quote_id')
   //       ->join('suppliers s','s.id=vqd.supplier_id')
   //       ->where(array(
   //          'q.approval_status' => 'approved',
   //          'q.delete_status' => '0',
   //          'q.quotation_status' => '1',
   //          'vq.delete_status' => 0
   //       ));

   //    if( isset($payload['search']['value']) ){
   //       $this->db->like('q.ref_number', trim($payload['search']['value']));
   //    }

   //    $result['total'] = $this->db->get()->num_rows();
   //    return $result;
   // }

   public function confirmTableData($payload = array()){
      $order_column = array("q.quotation_id","q.quotation_id","q.ref_number","w.name","q.quotation_id");
      $result = array('data'=>array(),'total'=>0);
      $start = 0;
      $limit = 10;
      if( isset($payload['start']) ){
          $start = (int)$payload['start'];
      }

      if( isset($payload['length']) ){
          $limit = (int)$payload['length'];
      }

      $select = 'q.*,count(vq.quotation_id) as quotations,w.name as warehouse';
      $this->db->select($select)
         ->from('quotation q')
         ->join('vendor_quotation vq', 'vq.quotation_id=q.quotation_id')
         ->join('warehouse w','w.id=q.warehouse_id')
         ->where(array(
            'q.approval_status' => 'approved',
            'q.delete_status' => '0',
            'q.quotation_status' => '1',
            'vq.delete_status' => 0
         ))->group_by('q.quotation_id');

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
         ->join('vendor_quotation vq', 'vq.quotation_id=q.quotation_id')
         ->join('warehouse w','w.id=q.warehouse_id')
         ->where(array(
            'q.approval_status' => 'approved',
            'q.delete_status' => '0',
            'q.quotation_status' => '1',
            'vq.delete_status' => 0
         ))->group_by('q.quotation_id');

      if( isset($payload['search']['value']) ){
         $this->db->like('q.ref_number', trim($payload['search']['value']));
      }

      $result['total'] = $this->db->get()->num_rows();
      return $result;
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