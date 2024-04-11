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
      
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="template-demo">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-custom bg-inverse-primary">
                <li class='breadcrumb-item'><a href='<?php echo base_url('orders/request_for_quote')?>'>Confirm Quotation</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>New Confirm Quotation List</span></span></li>
              </ol>
            </nav>
          </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <div class="card">
                <div class="card-body">

                  <div class="row">
                    <input type="hidden" name="quotation_id" value="<?php echo $quotation['quotation_id']; ?>">
                    <div class="form-group col-md-3 col-lg-3">
                      <label class="col-form-label">Ref Number:</label>
                      <input type="text" class="form-control" name="ref_number" value="<?php echo $quotation['ref_number']; ?>" disabled>
                    </div>

                    <div class="form-group col-md-3 col-lg-3">
                      <br>
                      <span>
                        <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#view_product" data-whatever="@getbootstrap">Click To View Quotation Products</button>
                      </span>
                    </div>

                    <div class="table-responsive">
                      <table class="table table-bordered" id="vendor-table" style="width: 100%">
                        <thead>
                          <tr>
                            <td width="20%">
                              <label>Vendor Name</label>
                            </td>
                            <td width="20%">
                              <label>Delivery Days</label>
                            </td>
                            <td width="20%">
                              <label>Total Price</label>
                            </td>
                            <td width="20%">
                              <label>Approve/Reject</label>
                            </td>
                            <td width="20%">
                              <label>View</label>
                            </td>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach($vendor_quotation as $row) {
                          ?>
                          <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo $row['delivery_days']; ?></td>                                
                              <td><?php echo $row['grand_wholesale_price']; ?></td>
                              <td>
                                <a href="<?= base_url()?>orders/confirm_vendor_quotation/<?php echo $row['vendor_quote_id']?>">Approve</a>
                              </td>                                   
                              <td>
                                <a href="<?= base_url()?>orders/quotation_proposal_details/<?php echo $row['vendor_quote_id']?>" class="btn btn-warning" target="_blank">View Quotation Details</a>
                              </td>                                                                
                          </tr>
                        <?php $i++;} ?>
                        </tbody>
                        
                      </table>
                    </div>

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

      <!-- Modal Start -->
      <div class="modal fade" id="view_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:70%; left:9vw" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="post" action="<?php echo base_url('products/addProduct'); ?>">
                <div class="row">

                    <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Ref Number:</label>
                        <input type="text" class="form-control" name="ref_number" value="<?php echo $quotation['ref_number']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Warehouse:</label><br>
                        <?php $warehouse = $this->db->select('w.name')->from('warehouse w')
                        ->where(array('w.id' => $quotation['warehouse_id']))->get()->row_array(); ?>
                        <input type="text" class="form-control" name="warehouse" value="<?php echo $warehouse['name']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label for="address" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" disabled><?php echo $quotation['description']?></textarea>
                      </div>
                    </div>

                    <div class="form-group col-md-12 col-lg-12">
                      <table class="table table-bordered" id="view-product-table" style="width: 100%">
                        <tr>
                          <td style="width: 20%">
                            <label>Product Name</label>
                          </td>
                          <td style="width: 20%">
                            <label>Category</label>
                          </td>
                          <td style="width: 20%">
                            <label>Sub Category One</label>
                          </td>
                          <td style="width: 20%">
                            <label>Sub Category Two</label>
                          </td>
                          <td style="width: 5%">
                            <label>Quantity</label>
                          </td>
                        </tr>
                        <?php foreach($quotation_products as $row) {?>
                        <tr>
                          <td>
                            <input type="text" class="form-control" name="product_name" value="<?php echo $row['product_name']?>" disabled="">
                          </td>
                          <td>
                            <?php $category = $this->db->select('*')->from('category')->where('id',$row['category_id'])->get()->row_array(); ?>
                            <input type="text" class="form-control" value="<?php echo $category['name'] ?>" disabled>
                          </td>
                          <td>
                            <?php $sub1 = $this->db->select('*')->from('sub_categories_one')->where(array('id' => $row['sub_category_one_id']))->get()->row_array(); ?>
                            <input type="text" class="form-control" value="<?php echo $sub1['name']?>" disabled>
                          </td>
                          <td>
                            <?php $sub2 = $this->db->select('*')->from('sub_categories_two')->where(array('id' => $row['sub_category_two_id']))->get()->row_array(); ?>
                            <input type="text" class="form-control" value="<?php echo $sub2['name']?>" disabled>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="quantity" value="<?php echo $row['quantity']?>" disabled>
                          </td> 
                        </tr>
                        <?php } ?>
                      </table>
                    </div>
                
                </div>                                                                                  
            </div>
            <!-- <div class="modal-footer">
              <button type="submit" class="btn btn-success">Add Product</button>
              <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div> -->
            </div>
            
          </div>
        </div>
      </div>
      <!-- Modal Ends -->
  </div>

    <style type="text/css">

      #view-product-table td, th {
        border: 1px solid #1d1a1a !important;
        text-align: center;
        padding: 5px !important;
      }

      #vendor-table td, th {
        border: 1px solid #1d1a1a !important;
        text-align: center;
        padding: 12px !important;
      }
      .modal .modal-dialog .modal-content .modal-body {
        padding: 5px 26px !important;
      }

      .modal .modal-dialog .modal-content .modal-header {
        padding: 15px 26px;
      }
    </style>


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


  
  