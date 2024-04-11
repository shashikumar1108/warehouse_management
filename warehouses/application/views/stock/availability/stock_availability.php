<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="<?php echo asset_url(); ?>chromaTemplate/vendors/icheck/skins/all.css">
<?php $this->load->view('template/header.php'); ?>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php 
      $this->load->view('template/dash_h_n1.php');
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
                <li class="breadcrumb-item"><a href="#">Stock</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Stock Availability</span></li>
              </ol>
            </nav>
          </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <div class="card">
                <div class="card-body">
                  
                  <div class="form-group col-md-12 col-lg-12" style="padding-left: 0px !important;padding-right: 0px !important;">
                    <table class="table table-bordered" id="view-product-table" style="width: 100%">
                      <tr>
                        <td style="width: 10%">
                          <label>Ref Number</label>
                        </td>
                        <td style="width: 5%">
                          <label>Total Qty</label>
                        </td>
                        <td style="width: 5%">
                          <label>Product Name</label>
                        </td>
                        <td style="width: 5%">
                          <label>Category</label>
                        </td>
                        <td style="width: 5%">
                          <label>Brand</label>
                        </td>
                        <td style="width: 5%">
                          <label>Total Price</label>
                        </td>
                        <td style="width: 5%">
                          <label>Warehouse</label>
                        </td>
                        <td style="width: 5%">
                          <label>Stock Placement</label>
                        </td>
                        <td style="width: 5%">
                          <label>Action</label>
                        </td>
                      </tr>
                      <?php $i=1;foreach($stock_list as $row) {?>
                      <tr>
                        <td>
                          <input type="text" class="form-control" value="<?php echo $row['ref_number']?>" disabled>
                        </td>
                        <td>
                          <input type="text" class="form-control" value="<?php echo $row['total_qty']?>" disabled>
                        </td>
                        <td>
                          <input type="text" class="form-control" value="<?php echo $row['product_name']?>" disabled>
                        </td>
                        <td>
                          <?php $category = $this->db->select('*')->from('category')->get()->result_array(); ?>
                          <?php foreach($category as $c){ 
                            if($row['category_id'] == $c['id']) { $category_name =  $c['name']; }
                          }?>
                          <input type="text" class="form-control" value="<?php echo $category_name; ?>" disabled>
                        <td>
                          <?php $brands = $this->db->select('*')->from('brand')->get()->result_array(); ?>
                          <?php foreach($brands as $b){ 
                            if($row['brand_id'] == $b['id']) { $brand_name =  $b['name']; }
                          } ?>
                          <input type="text" class="form-control" value="<?php echo $brand_name; ?>" disabled>
                        </td>
                        <td>
                          <input type="text" class="form-control" value="<?php echo $row['total_wh_amount']?>" disabled>
                        </td>
                        <td>
                          <?php $warehouse = $this->db->select('w.name')->from('warehouse w')
                                  ->where(array('w.id' => $row['warehouse_id']))->get()->row_array(); ?>
                            <input type="text" class="form-control" name="warehouse" value="<?php echo $warehouse['name']; ?>" disabled>
                        </td>
                        <td>
                          <input type="text" class="form-control" value="<?php echo $row['rack_number'] . " " . $row['rack_description']; ?>" disabled>
                        </td>
                        <td>
                          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#view_product<?php echo $i;?>">View</button>
                        </td>
                      </tr>

                      <!-- Modal Start -->
                      <div class="modal fade" id="view_product<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" style="width:70%; left:9vw" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                
                                <div class="form-group col-md-3 col-lg-3">
                                  <label class="col-form-label">Ref Number:</label>
                                  <input type="text" class="form-control" name="ref_number" value="<?php echo $row['ref_number']; ?>" disabled>
                                </div>

                                <div class="form-group col-md-3 col-lg-3">
                                  <label class="col-form-label">Warehouse:</label><br>
                                  <?php $warehouse = $this->db->select('w.name')->from('warehouse w')
                                  ->where(array('w.id' => $row['warehouse_id']))->get()->row_array(); ?>
                                  <input type="text" class="form-control" name="warehouse" value="<?php echo $warehouse['name']; ?>" disabled>
                                </div>

                                <div class="form-group col-md-3 col-lg-3">
                                  <label class="col-form-label">Supplier Name</label>
                                  <?php $supplier = $this->db->select('id,name')->from('suppliers')->get()->result_array(); ?>
                                  <?php 
                                    foreach($supplier as $s){ 
                                      if($row['supplier_id'] == $s['id']) { $supplier_name =  $b['name']; }?>
                                  <?php } ?>
                                  <input type="text" class="form-control" name="supplier_name" value="<?php echo $supplier_name; ?>"  disabled>
                                </div>

                                <div class="form-group col-md-3 col-lg-3">
                                  <label for="name" class="col-form-label">Brand:</label>
                                  <?php $brands = $this->db->select('*')->from('brand')->get()->result_array(); ?>
                                  <?php foreach($brands as $b){ 
                                        if($row['brand_id'] == $b['id']) { $brand_name =  $b['name']; }?>
                                  <?php } ?>
                                  <input type="text" class="form-control" name="brand_name" value="<?php echo $brand_name; ?>"  disabled>
                                </div>

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
                                  <input type="text" class="form-control" name="quantity" value="<?php echo $row['free_quantity']?>" disabled="">
                                </div>

                                <div class="form-group col-md-2 col-lg-2">
                                  <label class="col-form-label">Breakage Qty</label>
                                  <input type="text" class="form-control" name="quantity" value="<?php echo $row['breakage_qty']?>" disabled="">
                                </div>

                                <div class="form-group col-md-2 col-lg-2">
                                  <label class="col-form-label"> Total Qty</label>
                                  <input type="text" class="form-control" name="quantity" value="<?php echo $row['total_qty']?>" disabled="">
                                </div>

                                <div class="form-group col-md-2 col-lg-2">
                                  <label class="col-form-label">Wholesale Price</label>
                                  <input type="text" class="form-control" name="wholesale_price" value="<?php echo $row['wholesale_price']?>" disabled>
                                </div>

                                <div class="form-group col-md-2 col-lg-2">
                                  <label class="col-form-label">Total Price:</label>
                                  <input type="text" class="form-control" name="total_wholesale_price" value="<?php echo $row['total_wholesale_price']?>" disabled="">
                                </div>

                                <div class="form-group col-md-2 col-lg-2">
                                  <label class="col-form-label">Retail Price:</label>
                                  <input type="text" class="form-control r_total_amount" name="retail_price" value="<?php echo $row['retail_price']?>" disabled="">
                                </div>

                                <div class="form-group col-md-2 col-lg-2">
                                  <label class="col-form-label">Total Price:</label>
                                  <input type="text" class="form-control" name="total_retail_price[]" value="<?php echo $row['total_retail_price']?>" disabled="">
                                </div>
                              </div>

                              </div>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                      <!-- Modal Ends -->
                      
                      <?php $i++;} ?>
                    </table>
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
  <script src="<?php echo asset_url(); ?>chromaTemplate//vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/off-canvas.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/hoverable-collapse.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/misc.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/settings.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/data-table.js"></script>
  <!-- End custom js for this page-->
  <script src="<?php echo asset_url(); ?>chromaTemplate/js/select2.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate/js/iCheck.js"></script>
</body>

</html>