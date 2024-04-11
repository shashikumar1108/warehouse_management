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
                <li class="breadcrumb-item"><a href="<?=base_url('vendor/confirmed_delivery_order')?>"><span>Vendor Delivery Note</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Add Delivery Note</span></li>
              </ol>
            </nav>
          </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <div class="card">
                <div class="card-body">
                  
                  <form method="post" onsubmit="return validateForm();" action="<?php echo base_url('vendor/create_delivery_note'); ?>">
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

                    <div class="row">
                      <div class="form-group col-md-12 col-lg-12">
                        <h5>Approved Products</h5><hr>
                      </div>
                    </div>
                    <?php foreach($approved_products as $row) {?>
                    <div class="row">
                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" value="<?php echo $row['product_name']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label for="name" class="col-form-label">Brand:</label>
                        <?php $brand = $this->db->select('name')->from('brand')->where('id',$row['brand_id'])->get()->row_array(); ?>
                        <input type="text" class="form-control" value="<?php echo $brand['name']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Quantity</label>
                        <input type="text" class="form-control" value="<?php echo $row['quantity']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Approved Quantity</label>
                        <input type="text" class="form-control" value="<?php echo $row['total_qty']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Free Qty</label>
                        <input type="text" class="form-control" value="<?php echo $row['free_quantity']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Wholesale Price</label>
                        <input type="text" class="form-control" value="<?php echo $row['total_wholesale_price']?>" disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Total Price:</label>
                        <input type="text" class="form-control" value="<?php echo $row['total_retail_price']?>" disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label for="name" class="col-form-label">Delivery Date:</label>
                        <input type="date" class="form-control" name="delivery_date[]" id="delivery_date" required>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label for="name" class="col-form-label">Batch Number:</label>
                        <input type="text" class="form-control" name="batch_number[]" autocomplete="off" required>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label for="name" class="col-form-label">Manufacture Date:</label>
                        <input type="date" class="form-control" name="mfg_date[]" id="mfg_date" required>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label for="name" class="col-form-label">Expiry Date:</label>
                        <input type="date" class="form-control" name="expiry_date[]" id="expiry_date" required>
                      </div>
                      <div class="form-group col-md-12 col-lg-12"><hr></div>
                    </div>
                    <?php } ?>

                    <div class="row mt-4">
                      <div class="form-group col-md-12 col-lg-12">
                        <h5>Rejected Products</h5><hr>
                      </div>
                    </div>

                    <?php if( count($rejected_products) ){ foreach($rejected_products as $row) {?>
                    <div class="row">
                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" value="<?php echo $row['product_name']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label for="name" class="col-form-label">Brand:</label>
                        <?php $brand = $this->db->select('name')->from('brand')->where('id',$row['brand_id'])->get()->row_array(); ?>
                        <input type="text" class="form-control" value="<?php echo $brand['name']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Quantity</label>
                        <input type="text" class="form-control" value="<?php echo $row['quantity']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Free Qty</label>
                        <input type="text" class="form-control" value="<?php echo $row['free_quantity']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Wholesale Price</label>
                        <input type="text" class="form-control" value="<?php echo $row['total_wholesale_price']?>" disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Total Price:</label>
                        <input type="text" class="form-control" value="<?php echo $row['total_retail_price']?>" disabled>
                      </div>
                      <div class="form-group col-md-12 col-lg-12"><hr></div>
                    </div>
                    <?php }
                    }else{
                      ?>
                      <div class="row">
                        <div class="form-group col-md-12 col-lg-12">
                          <h6>No products found !!!</h6>
                          <hr>
                        </div>
                      </div>
                      <?php
                    }
                    ?>
                    <br>
                    <button type="submit" class="btn btn-primary">Confirm</button>
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
  <script>
    function validateForm(){
      if( confirm('Are you sure want to proceed') ){
        return true;
      }
      return false;
    }
  </script>
</body>

</html>