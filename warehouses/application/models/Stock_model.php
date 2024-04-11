<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_model extends CI_Model {
	
	public function _consruct(){
		parent::_construct();
   }

   public function get_stock_position_price_details($quotation_status,$stock_status,$warehouse_id){

      $this->db->select('q.*,qp.*,p.name as product_name,qp.*,vqad.*');
      $this->db->from('quotation q');
      $this->db->join('quotation_products qp','q.quotation_id=qp.quotation_id');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->join('vendor_quotation_details vqd','qp.qp_id=vqd.quotation_product_id and vq.vendor_quote_id = vqd.vendor_quote_id');
      $this->db->join('vendor_quotation_approved_details vqad','qp.qp_id=vqad.quotation_product_id and vq.vendor_quote_id = vqad.vendor_quote_id');
      $this->db->join('products p','qp.product_id=p.id');
      $this->db->join('warehouse w','w.id = q.warehouse_id');
      $this->db->where(array('q.quotation_status' => $quotation_status,'vqad.stock_status' => $stock_status,'q.warehouse_id'=>$warehouse_id));
      return $this->db->get()->result_array();
   }
   
   public function create_stock_position_details($temp_data,$temp_product,$vendor_quotation_details_id,$warehouse_id){

      $this->db->set($temp_data)->where('vqad_id',$vendor_quotation_details_id)->update('vendor_quotation_approved_details');
      $row1 = $this->db->affected_rows();

      $this->db->insert('stock_position',$temp_product);
      $row2 = $this->db->affected_rows();

      if($row1 > 0 && $row2 > 0){
         return true;
      }else{
         return false;
      }

   }

   public function get_stock_availability_price_details($quotation_status,$stock_status,$warehouse_id){
      $this->db->distinct();
      $this->db->select('q.*,qp.*,p.name as product_name,qp.*,vqad.*,w.name as warehouse_name,r.rack_number,r.description as rack_description');
      $this->db->from('quotation q');
      $this->db->join('quotation_products qp','q.quotation_id=qp.quotation_id');
      $this->db->join('vendor_quotation vq','q.quotation_id=vq.quotation_id');
      $this->db->join('vendor_quotation_details vqd','qp.qp_id=vqd.quotation_product_id and vq.vendor_quote_id = vqd.vendor_quote_id');
      $this->db->join('vendor_quotation_approved_details vqad','qp.qp_id=vqad.quotation_product_id and vq.vendor_quote_id = vqad.vendor_quote_id');
      $this->db->join('products p','qp.product_id=p.id');
      $this->db->join('warehouse w','q.warehouse_id=w.id');
      $this->db->join('stock_position sp','vqad.vqad_id =sp.vendor_quotation_details_id');
      $this->db->join('racks r','sp.rack_id=r.id');
      $this->db->where(array('q.quotation_status' => $quotation_status,'vqad.stock_status' => $stock_status,'q.warehouse_id'=>$warehouse_id));
      return $this->db->get()->result_array();
   }

   public function create_stock_transfer_details($temp_data,$temp_quotation,$vendor_quotation_details_id,$quotation_id,$warehouse_id){

      $this->db->set($temp_data)->where('vqad_id',$vendor_quotation_details_id)->update('vendor_quotation_approved_details');
      $row1 = $this->db->affected_rows();

      $this->db->set($temp_quotation)->where('quotation_id',$quotation_id)->update('quotation');
      $row2 = $this->db->affected_rows();

      $this->db->insert('stock_position',$temp_product);
      $row2 = $this->db->affected_rows();

      $this->db->where(array('id'=>$id,'user_type'=>3))->delete('users');

      if($row1 > 0 && $row2 > 0){
         return true;
      }else{
         return false;
      }

   }

}
?>