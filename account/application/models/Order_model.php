<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {
	
	public function _consruct(){
		parent::_construct();
   }
   
   public function getWarehouseSuppliers($warehouse_id = null)
   {
      if( $warehouse_id != null ){
         $suppilers = $this->db->select('group_concat(s.email) as mail')->from('suppliers s')
                                ->join('supplier_warehouse_relationship sw','sw.supplier_id=s.id','inner')
                                ->where('sw.warehouse_id',$warehouse_id)
                                ->where('s.delete_status',0)->get()->result();
         return $suppilers;
      }else{
         return array();
      }
   }
   	// START NEW QUOTATION 
      public function add_new_quotation_details($temp_data,$temp_product){
   		$this->db->insert('quotation',$temp_data);
         $row1 = $this->db->affected_rows();
         $quotation_id = $this->db->insert_id();

         for($i=0;$i<count($temp_product["product_id"]); $i++){
            $batch[] = array('product_id' => $temp_product['product_id'][$i],
               'category_id' => $temp_product['category_id'][$i],
               'sub_category_one_id' => $temp_product['sub_category_one_id'][$i],
               'sub_category_two_id' => $temp_product['sub_category_two_id'][$i],
               'quantity' => $temp_product['quantity'][$i],
               'quotation_id' => $quotation_id);
         }

         $this->db->insert_batch('quotation_products',$batch);
         $row2 = $this->db->affected_rows();

   		if($row1 > 0 && $row2 >0){
   			return true;
   		}else{
   			return false;
   		}
   	}

      public function edit_quotation_details($quotation_id){
         return $this->db->select('*')->from('quotation')->where('quotation_id',$quotation_id)->get()->row_array();
      }

      public function get_quotation_product_details($quotation_id){
         $this->db->distinct();
         $this->db->select('qp.*,p.name as product_name,c.name as category_name,sc1.name as s1name,sc2.name as s2name');
         $this->db->from('quotation_products qp');
         $this->db->join('products p','qp.product_id=p.id');
         $this->db->join('category c','qp.category_id=c.id');
         $this->db->join('sub_categories_one sc1','qp.sub_category_one_id=sc1.id');
         $this->db->join('sub_categories_two sc2','qp.sub_category_two_id=sc2.id');
         $this->db->where('qp.quotation_id',$quotation_id);
         return $this->db->get()->result_array();
      }

      public function get_current_quotation_product_ids($quotation_id){
         return $this->db->select('qp_id')->from('quotation_products')->where('quotation_id',$quotation_id)->get()->result_array();
      }

   	public function update_quotation_details($temp_data,$quotation_id,$temp_product,$drop_qp_ids){
   		$this->db->where('quotation_id',$quotation_id)->update('quotation',$temp_data);
         $quotation_row = $this->db->affected_rows();

         for($i=0;$i<count($temp_product["product_id"]); $i++){
            $qp_exists = $this->db->select('qp_id')->from('quotation_products')->where('qp_id',$temp_product['qp_id'][$i])->get()->row();
            if(!empty($qp_exists)){
               $update_batch[] = array('qp_id' =>$qp_exists->qp_id,
                  'product_id' => $temp_product['product_id'][$i],
                  'category_id' => $temp_product['category_id'][$i],
                  'sub_category_one_id' => $temp_product['sub_category_one_id'][$i],
                  'sub_category_two_id' => $temp_product['sub_category_two_id'][$i],
                  'quantity' => $temp_product['quantity'][$i],
                  'quotation_id' => $quotation_id);
            }else{
               $insert_batch[] = array(
                  'product_id' => $temp_product['product_id'][$i],
                  'category_id' => $temp_product['category_id'][$i],
                  'sub_category_one_id' => $temp_product['sub_category_one_id'][$i],
                  'sub_category_two_id' => $temp_product['sub_category_two_id'][$i],
                  'quantity' => $temp_product['quantity'][$i],
                  'quotation_id' => $quotation_id);
            }
         }

         $insert_row=0;
         if(!empty($insert_batch)){
            $this->db->insert_batch('quotation_products',$insert_batch);
            $insert_row = $this->db->affected_rows();
         } 

         $update_row=0;
         if(!empty($update_batch)){
            $this->db->update_batch('quotation_products',$update_batch,'qp_id');
            $update_row = $this->db->affected_rows();
         }

         $delete_row=0;
         if(!empty($drop_qp_ids)){
            $this->db->where_in('qp_id',$drop_qp_ids)->where('quotation_id',$quotation_id)->delete('quotation_products');
            $delete_row = $this->db->affected_rows();
         }

   		if($quotation_row>0 || $insert_row>0 || $update_row>0 || $delete_row>0){
   			return true;
   		}else{
   			return false;
   		}
   	}

   	public function delete_quotation_details($temp_data,$quotation_id){
   		$this->db->where('quotation_id',$quotation_id)->update('quotation',$temp_data);
   		$row = $this->db->affected_rows();
   		if($row > 0){
   			return true;
   		}else{
   			return false;
   		}
   	}
      // END NEW QUOTATION 

      // START CONFIRM QUOTATION

      public function get_quotation_proposal_details($quotation_id){

         $this->db->select('q.*,w.name as warehouse_name');
         $this->db->from('quotation q');
         $this->db->join('warehouse w','w.id=q.warehouse_id');
         $this->db->where(array('q.approval_status' => 'approved','q.delete_status' => '0','q.quotation_id' => $quotation_id));
         return $this->db->get()->row_array();
      }

      public function get_vendor_quotation($quotation_id, $vendor_quote_id = 0){

         $where = array(
            'vq.quotation_id'=>$quotation_id,
         );
         if( $vendor_quote_id > 0 ){
            $where['vq.vendor_quote_id'] = $vendor_quote_id;
         }
         return $this->db->select('vq.*,s.name as supplier')
            ->from('vendor_quotation vq')
            ->join('suppliers s','s.id=vq.supplier_id','left')
            ->where($where)
            ->get()->result_array();
      }

      public function get_requested_vendor_details($quotation_id){
         return $this->db->select('*')->from('vendor_quotation')->where('quotation_id',$quotation_id)->get()->row_array();
      }

      public function get_quotation_product_price($vendor_quote_id = 0,$quotation_id = 0,$qproduct_id = 0){

         $select = 'q.quotation_id,q.ref_number,q.description,qp.*,p.name as product_name,vqd.*,w.name as warehouse_name';
         $select .= ',pc.name as category, psc1.name as sub_cat_one';
         $select .= ',psc2.name as sub_cat_two,b.name as brand';
         $select .= ',s.name as supplier_name,s.phone as supplier_phone,s.email as supplier_email';
         $this->db->select($select);
         $this->db->from('quotation q');
         $this->db->join('quotation_products qp','q.quotation_id=qp.quotation_id');
         $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
         $this->db->join('vendor_quotation_details vqd','qp.qp_id=vqd.quotation_product_id and vqd.vendor_quote_id = vq.vendor_quote_id');
         $this->db->join('products p','qp.product_id=p.id');
         $this->db->join('category pc','pc.id=p.category');
         $this->db->join('sub_categories_one psc1','psc1.id=qp.sub_category_one_id');
         $this->db->join('sub_categories_two psc2','psc2.id=qp.sub_category_two_id');
         $this->db->join('brand b','b.id=p.brand');
         $this->db->join('warehouse w','q.warehouse_id=w.id');
         $this->db->join('suppliers s','s.id=vq.supplier_id');
         if( $vendor_quote_id != 0 ){
            $this->db->where(array('vq.vendor_quote_id' => $vendor_quote_id));
         }

         if( $quotation_id != 0 && $qproduct_id != 0 ){
            $this->db->where(array('qp.quotation_id'=>$quotation_id,'qp.qp_id'=>$qproduct_id));
         }
         
         return $this->db->get()->result_array();
      }

      public function checkQuotationVendorItem($quotation_id = 0,$vendor_quote_id = 0,$qproduct_id = 0,$product_id = 0,$supplier_id = 0,$vqd_id = 0){

         $select = 'vqd.*';
         $this->db->select($select);
         $this->db->from('quotation q');
         $this->db->join('quotation_products qp','q.quotation_id=qp.quotation_id');
         $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
         $this->db->join('vendor_quotation_details vqd','qp.qp_id=vqd.quotation_product_id and vqd.vendor_quote_id = vq.vendor_quote_id');
         $this->db->join('products p','qp.product_id=p.id');
         $this->db->join('category pc','pc.id=p.category');
         $this->db->join('sub_categories_one psc1','psc1.id=qp.sub_category_one_id');
         $this->db->join('sub_categories_two psc2','psc2.id=qp.sub_category_two_id');
         $this->db->join('brand b','b.id=p.brand');
         $this->db->join('warehouse w','q.warehouse_id=w.id');
         $this->db->join('suppliers s','s.id=vq.supplier_id');

         $this->db->where(
            array(
               'q.delete_status' => 0,
               'q.quotation_status' => 1,
               'q.quotation_id' => $quotation_id,
               'qp.qp_id' => $qproduct_id,
               'qp.product_id' => $product_id,
               'vq.supplier_id' => $supplier_id,
               'vq.vendor_quote_id' => $vendor_quote_id,
               'vqd.vqd_id' => $vqd_id,
            )
         );         
         return $this->db->get()->result_array();
      }

      public function update_proposal_details($vendor_quote_id,$quotation_id){

         $this->db->set('proposal_status','2')->where('vendor_quote_id',$vendor_quote_id)->update('vendor_quotation');
         $row1 = $this->db->affected_rows();

         $this->db->set('quotation_status','2')->where('quotation_id',$quotation_id)->update('quotation');
         $row2 = $this->db->affected_rows();

         if($row1 > 0 && $row2 > 0){
            return true;
         }else{
            return false;
         }
      }
      // END CONFIRM QUOTATION


      // CONFIRM GOODS RECEIPT NOTE

      public function get_order_quotation_table_list($payload = array(), $proposal_status = 4){

         $order_column = array("q.quotation_id","q.ref_number","w.name","s.name","q.quotation_id");
         $result = array('data'=>array(),'total'=>0);
         $start = 0;
         $limit = 10;
         if( isset($payload['start']) ){
            $start = (int)$payload['start'];
         }

         if( isset($payload['length']) ){
            $limit = (int)$payload['length'];
         }

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

      public function get_order_quotation_details($proposal_status){

         $this->db->select('q.*,w.name as warehouse_name,vq.vendor_quote_id');
         $this->db->from('quotation q');
         $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
         $this->db->join('warehouse w','w.id=q.warehouse_id');
         $this->db->where(array('q.approval_status' => 'approved','q.delete_status' => '0','vq.proposal_status' => $proposal_status));
         return $this->db->get()->result_array();
      }

      public function get_single_order_quotation_details($quotation_id,$proposal_status){

         $this->db->select('q.*,vq.*,i.paid_amount,vts.lorry_number,vts.lorry_details');
         $this->db->from('quotation q');
         $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
         $this->db->join('invoice i','q.quotation_id=i.quotation_id');
         $this->db->join('vendor_track_shipment vts','vts.vendor_quote_id=vq.vendor_quote_id','left');
         $this->db->where(array('q.quotation_id' => $quotation_id,'vq.proposal_status' => $proposal_status));
         // $this->db->where(array('q.quotation_id' => $quotation_id));
         return $this->db->get()->row_array();
      }

      public function get_order_price_details($quotation_id,$proposal_status){

         $this->db->select('q.quotation_id,q.ref_number,q.description,qp.*,p.name as product_name,
            vq.vendor_quote_id,vqd.*');
         $this->db->from('quotation q');
         $this->db->join('quotation_products qp','q.quotation_id=qp.quotation_id');
         $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
         $this->db->join('vendor_quotation_details vqd','qp.qp_id=vqd.quotation_product_id');
         $this->db->join('products p','qp.product_id=p.id');
         $this->db->where(array('q.quotation_id' => $quotation_id,'vq.proposal_status' => $proposal_status));
         // $this->db->where(array('q.quotation_id' => $quotation_id));
         return $this->db->get()->result_array();
      }

      public function update_vendor_quotation_details($temp_data,$temp_product,$vendor_quote_id,$quotation_id,$quotation_data){

         $this->db->set($quotation_data)->where('quotation_id',$quotation_id)->update('quotation');
         $row1 = $this->db->affected_rows();

         $this->db->set($temp_data)->where('vendor_quote_id',$vendor_quote_id)->update('vendor_quotation');
         $row2 = $this->db->affected_rows();

         for($i=0;$i<count($temp_product["vqd_id"]); $i++){
            
            $update_batch[] = array(
            'vqd_id' => $temp_product['vqd_id'][$i],
            'total_qty' => $temp_product['total_qty'][$i],
            'breakage_qty' => $temp_product['breakage_qty'][$i],
            'reduced_wh_amount' => $temp_product['reduced_wh_amount'][$i],
            'total_wh_amount' => $temp_product['total_wh_amount'][$i],
            'reduced_rp_amount' => $temp_product['reduced_rp_amount'][$i],
            'total_rp_amount' => $temp_product['total_rp_amount'][$i]);
         }

         $this->db->update_batch('vendor_quotation_details',$update_batch,'vqd_id');
         $row3 = $this->db->affected_rows();

         if($row1 > 0 && $row2 > 0 && $row3 > 0){
            return true;
         }else{
            return false;
         }
      }

      // CONFIRM GOODS RECEIPT NOTE

      // Track Shipment
      public function create_track_shipment_details($temp_data,$temp_product,$vendor_quote_id){

         $this->db->set($temp_data)->where('vendor_quote_id',$vendor_quote_id)->update('vendor_quotation');
         $row1 = $this->db->affected_rows();

         $this->db->insert('vendor_track_shipment',$temp_product);
         $row2 = $this->db->affected_rows();

         if($row1 > 0 && $row2 > 0){
            return true;
         }else{
            return false;
         }
      }

      // Track Shipment
	
}
?>