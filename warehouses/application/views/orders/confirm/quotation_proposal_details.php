<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url(); ?>chromaTemplate/vendors/icheck/skins/all.css">
<?php $this->load->view('template/header.php'); ?>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php $this->load->view('template/dash_h_n1.php'); ?>
    <style type="text/css">
      td, th {
        padding: 5px !important;
      }
    </style>
    
      
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="template-demo">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-custom bg-inverse-primary">
                <li class="breadcrumb-item"><a href="#">Orders</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url('orders/new_confirm_quotation_list')?>">Vendor Quotation</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Vendor Quotation Details</span></li>
              </ol>
            </nav>
          </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <div class="card">
                <div class="card-body">
                  
                    <div class="row">
                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Ref Number:</label>
                        <input type="text" class="form-control" name="ref_number" value="<?php echo $quotation['ref_number']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Warehouse:</label><br>
                        <input type="text" class="form-control" name="warehouse" value="<?php echo $quotation['warehouse_name']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label for="address" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" disabled><?php echo $quotation['description']?></textarea>
                      </div>
                    </div>

                    <?php $i=1; foreach($quotation_price_details as $row) {?>

                    <div class="groove row">

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" value="<?php echo $row['product_name']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Category</label>
                        <?php $category = $this->db->select('*')->from('category')->where('id',$row['category_id'])->get()->row_array(); ?>
                        <input type="text" class="form-control" value="<?php echo $category['name'] ?>" disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Sub Category One</label>
                        <?php $sub1 = $this->db->select('*')->from('sub_categories_one')->where(array('id' => $row['sub_category_one_id']))->get()->row_array(); ?>
                        <input type="text" class="form-control" value="<?php echo $sub1['name']?>" disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Sub Category Two</label>
                        <?php $sub2 = $this->db->select('*')->from('sub_categories_two')->where(array('id' => $row['sub_category_two_id']))->get()->row_array(); ?>
                        <input type="text" class="form-control" value="<?php echo $sub2['name']?>" disabled>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">Quantity</label>
                        <input type="text" class="form-control" name="quantity" value="<?php echo $row['quantity']?>" disabled="">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">Free Qty</label>
                        <input type="text" class="form-control" name="free_quantity" value="<?php echo $row['free_quantity']?>"  disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label for="name" class="col-form-label">Brand:</label>
                        <?php $brands = $this->db->select('*')->from('brand')->get()->result_array(); ?>
                        <?php foreach($brands as $b){ 
                              if($row['brand_id'] == $b['id']) { $brand_name =  $b['name']; }?>
                        <?php } ?>
                        <input type="text" class="form-control" name="brand_name" value="<?php echo $brand_name; ?>"  disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Select Supplier</label>
                        <?php $supplier = $this->db->select('id,name')->from('suppliers')->get()->result_array(); ?>
                        <?php 
                          foreach($supplier as $s){ 
                            if($row['supplier_id'] == $s['id']) { $supplier_name =  $b['name']; }?>
                        <?php } ?>
                        <input type="text" class="form-control" name="supplier_name" value="<?php echo $supplier_name; ?>"  disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Wholesale Price</label>
                        <input type="text" class="form-control" name="wholesale_price" value="<?php echo $row['wholesale_price']?>" disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Tax type:</label><br>
                        <?php if($row['w_tax_type'] == "0") {$w_tax_type = "Exclusive";} else{$w_tax_type = "Inclusive";}?>
                        <input type="text" class="form-control" name="w_tax_type" value="<?php echo $w_tax_type; ?>"  disabled>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">CGST %:</label>
                        <input type="text"  class="form-control" name="w_cgst" value="<?php echo $row['w_cgst']?>" disabled>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">SGST %:</label>
                        <input type="text"  class="form-control" name="w_sgst" value="<?php echo $row['w_sgst']?>" disabled>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">IGST %:</label>
                        <input type="text"  class="form-control" name="w_igst" value="<?php echo $row['w_igst']?>" disabled>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">TotalTax:</label>
                        <input type="text" class="form-control" name="w_tax_amount" value="<?php echo $row['w_tax_amount']?>" disabled="">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">WH Amt</label>
                        <input type="text" class="form-control" name="w_total_amount" value="<?php echo $row['w_total_amount']?>" disabled>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">Total Price:</label>
                        <input type="text" class="form-control" name="total_wholesale_price" value="<?php echo $row['total_wholesale_price']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Retail Price:</label>
                        <input type="text" class="form-control r_total_amount" name="retail_price" value="<?php echo $row['retail_price']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Tax type:</label><br>
                        <?php if($row['r_tax_type'] == "0") {$r_tax_type = "Exclusive";} else{$r_tax_type = "Inclusive";}?>
                        <input type="text" class="form-control" name="r_tax_type" value="<?php echo $r_tax_type; ?>"  disabled>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">CGST %:</label>
                        <input type="text" class="form-control" name="r_cgst[]" value="<?php echo $row['r_cgst']?>" disabled="">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">SGST %:</label>
                        <input type="text"  class="form-control" name="r_sgst[]" value="<?php echo $row['r_sgst']?>" disabled="">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">IGST %:</label>
                        <input type="text" class="form-control" name="r_igst[]" value="<?php echo $row['r_igst']?>" disabled="">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">TotalTax:</label>
                        <input type="text" class="form-control" name="r_tax_amount[]" value="<?php echo $row['r_tax_amount']?>" disabled="">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">Retail Amt</label>
                        <input type="text" class="form-control" name="r_total_amount"  value="<?php echo $row['r_total_amount']?>" disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Total Price:</label>
                        <input type="text" class="form-control" name="total_retail_price[]" value="<?php echo $row['total_retail_price']?>" disabled="">
                      </div>
                    </div>
                    <?php $i++; } ?>
                    <div class="row">

                      <div class="form-group col-md-3 col-lg-3">
                        <label for="address" class="col-form-label">Conditions:</label>
                        <textarea class="form-control" name="conditions" disabled=""><?php echo $vendor_quotation['conditions']?></textarea>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Delivery Days</label>
                        <input type="number" class="form-control" name="delivery_days" disabled="" value="<?php echo $vendor_quotation['delivery_days']?>">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Transport Cost:</label>
                        <input type="text" class="form-control" name="transport_cost" value="<?php echo $vendor_quotation['transport_cost']?>" disabled="" >
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Grand WH Price:</label>
                        <input type="text" class="form-control" name="grand_wholesale_price" value="<?php echo $vendor_quotation['grand_wholesale_price']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Grand Retail Price:</label>
                        <input type="text" class="form-control" name="grand_retail_price" value="<?php echo $vendor_quotation['grand_retail_price']?>" disabled="">
                      </div>

                    </div>

                </div>
              </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <style>
    .groove {border-style: groove;}
  </style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?php echo base_url(); ?>chromaTemplate//vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo base_url(); ?>chromaTemplate//vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo base_url(); ?>chromaTemplate//js/off-canvas.js"></script>
  <script src="<?php echo base_url(); ?>chromaTemplate//js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url(); ?>chromaTemplate//js/misc.js"></script>
  <script src="<?php echo base_url(); ?>chromaTemplate//js/settings.js"></script>
  <script src="<?php echo base_url(); ?>chromaTemplate//js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php echo base_url(); ?>chromaTemplate//js/data-table.js"></script>
  <!-- End custom js for this page-->
  <script src="<?php echo base_url(); ?>chromaTemplate/js/select2.js"></script>
  <script src="<?php echo base_url(); ?>chromaTemplate/js/iCheck.js"></script>
</body>

</html>