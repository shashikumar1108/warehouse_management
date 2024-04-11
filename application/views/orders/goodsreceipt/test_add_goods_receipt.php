<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url(); ?>chromaTemplate/vendors/icheck/skins/all.css">
<?php $this->load->view('template/header.php'); ?>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php 
    if($this->session->userdata['usertype'] == 1){  
      $this->load->view('template/dash_h_n.php');
    }else{  
      $this->load->view('template/dash_h_n1.php');
    }         
    ?>
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
                <li class="breadcrumb-item"><a href="<?php echo base_url('orders/confirmed_goods_receipt_list')?>">Confirm Goods Reciept Note</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Add Goods Receipt Note</span></li>
              </ol>
            </nav>
          </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <div class="card">
                <div class="card-body">
                  
                  <form method="post" action="<?php echo base_url('vendor/create_delivery_note'); ?>">
                    <div class="row">
                      <input type="hidden" name="vendor_quote_id" value="<?php echo $vendor_quotation['vendor_quote_id']; ?>">
                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Ref Number:</label>
                        <input type="text" class="form-control" name="ref_number" value="<?php echo $vendor_quotation['ref_number']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Vendor Name:</label><br>
                        <input type="text" class="form-control" name="warehouse" value="<?php echo $vendor_quotation['warehouse_name']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Warehouse:</label><br>
                        <input type="text" class="form-control" name="warehouse" value="<?php echo $vendor_quotation['warehouse_name']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label for="address" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" disabled><?php echo $vendor_quotation['description']?></textarea>
                      </div>
                    </div>

                    <div class="form-group col-md-12 col-lg-12" style="padding-left: 0px !important;padding-right: 0px !important;">
                      <table class="table table-bordered" id="view-product-table" style="width: 100%">
                        <tr>
                          <td style="width: 10%">
                            <label>Product Name</label>
                          </td>
                          <td style="width: 10%">
                            <label>Category</label>
                          </td>
                          <!-- <td style="width: 20%">
                            <label>Sub Category one</label>
                          </td>
                          <td style="width: 20%">
                            <label>Sub category two</label>
                          </td> -->
                          <td style="width: 10%">
                            <label>Brand</label>
                          </td>
                          <td style="width: 5%">
                            <label>Quantity</label>
                          </td>
                          <td style="width: 5%">
                            <label>Free Qty</label>
                          </td>
                          <td style="width: 5%">
                            <label>WH Price</label>
                          </td>
                          <td style="width: 5%">
                            <label>Tax Type</label>
                          </td>
                          <td style="width: 5%">
                            <label>Total Price</label>
                          </td>
                          <td style="width: 5%">
                            <label>Retail Price</label>
                          </td>
                          <td style="width: 5%">
                            <label>Tax Type</label>
                          </td>
                          <td style="width: 5%">
                            <label>Total Price</label>
                          </td>
                        </tr>
                        <?php foreach($quotation_price_details as $row) {?>
                        <tr>
                          <td>
                            <input type="text" class="form-control" value="<?php echo $row['product_name']?>" disabled="">
                          </td>
                          <td>
                            <?php $category = $this->db->select('*')->from('category')->get()->result_array(); ?>
                            <?php foreach($category as $c){ 
                              if($row['category_id'] == $c['id']) { $category_name =  $c['name']; }
                            }?>
                            <input type="text" class="form-control" value="<?php echo $category_name; ?>" disabled>
                          <!-- <td>
                            <?php $ones = $this->db->select('*')->from('sub_categories_one')->where('category_id',$row['category_id'])->get()->result_array(); ?>
                            <?php foreach($ones as $o){ 
                              if($row['sub_category_one_id'] == $o['id']) { $sub_category_one_name =  $o['name']; }
                            }?>
                            <input type="text" class="form-control" value="<?php echo $sub_category_one_name; ?>" disabled>
                          </td>
                          <td>
                            <?php $twos = $this->db->select('*')->from('sub_categories_two')->where(array('category_id' => $row['category_id'],'sub_category_one_id' => $row['sub_category_one_id']))->get()->result_array(); ?>
                            <?php foreach($twos as $t){ 
                              if($row['sub_category_two_id'] == $t['id']) { $sub_category_two_name =  $t['name']; }
                            }?>
                            <input type="text" class="form-control" value="<?php echo $sub_category_two_name; ?>" disabled>
                          </td> -->
                          <td>
                            <?php $brands = $this->db->select('*')->from('brand')->get()->result_array(); ?>
                            <?php foreach($brands as $b){ 
                              if($row['brand_id'] == $b['id']) { $brand_name =  $b['name']; }
                            } ?>
                            <input type="text" class="form-control" value="<?php echo $brand_name; ?>" disabled>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo $row['quantity']?>" disabled>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo $row['free_quantity']?>" disabled>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo $row['wholesale_price']?>" disabled>
                          </td>
                          <td>
                            <?php if($row['w_tax_type'] == '0') { $tax_type = "Exclusive";} else{$tax_type = "Inclusive";}?>
                            <input type="text" class="form-control" value="<?php echo $tax_type ?>" disabled>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo $row['total_wholesale_price']?>" disabled>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo $row['retail_price']?>" disabled>
                          </td>
                          <td>
                            <?php if($row['r_tax_type'] == '0') { $tax_type = "Exclusive";} else{$tax_type = "Inclusive";}?>
                            <input type="text" class="form-control" value="<?php echo $tax_type ?>" disabled>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo $row['total_retail_price']?>" disabled>
                          </td>
                        </tr>
                        <?php } ?>
                      </table>
                    </div>

                    
                    <div class="row">
                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Delivery Days:</label><br>
                        <input type="text" class="form-control" name="warehouse" value="<?php echo $vendor_quotation['delivery_days']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Transport Cost:</label>
                        <input type="text" class="form-control" name="transport_cost" value="<?php echo $vendor_quotation['grand_wholesale_price']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Grand WH Price:</label>
                        <input type="text" class="form-control" name="grand_wholesale_price" value="<?php echo $vendor_quotation['grand_wholesale_price']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Grand Retail Price:</label>
                        <input type="text" class="form-control" name="grand_retail_price" value="<?php echo $vendor_quotation['grand_retail_price']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label for="name" class="col-form-label">Breakage/Return Qty:</label>
                        <input type="text" class="form-control" name="breakage_qty" id="breakage_qty" required>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label for="name" class="col-form-label">Reduce Amount:</label>
                        <input type="text" class="form-control" name="reduced_amount" autocomplete="off" required>
                      </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-primary">Cancel</button>

                  </form>
                    
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

  <style type="text/css">

    .modal .modal-dialog .modal-content .modal-body {
      padding: 5px 26px !important;
    }

    .modal .modal-dialog .modal-content .modal-header {
      padding: 15px 26px;
    }
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