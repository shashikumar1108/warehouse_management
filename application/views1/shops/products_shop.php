<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url(); ?>chromaTemplate/vendors/icheck/skins/all.css">
<?php $this->load->view('template/header.php'); ?>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php $this->load->view('template/dash_h_n.php'); ?>
      
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">

            <?php if($this->session->flashdata('status') == 'success' 
            || $this->session->flashdata('status') == 'fail') {
                
                if($this->session->flashdata('status') == 'success'){
                    $color='green';
                }else{                    
                    $color='red';
                }
             // echo "hi";
              echo "<b style='color:".$color."'>".$this->session->flashdata('message')."</b>";
              echo "<br><br>";  
            
            }
              
              ?>
 
            
            <?php 
            
            $warehouses = $this->db->select('id, name')->from('warehouse')->where('delete_status',0)->get()->result_array();

            ?>

              <span class="card-title">Shop Products</span>
              <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_product" data-whatever="@getbootstrap">Add Product</button>
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Category</th>                        
                        <th>Sub Category One</th>
                        <th>Sub Category Two</th>
                        <!-- <th>Supplier</th> -->                       
                        <th>Description</th>
                                            
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;                    
                        foreach($products as $p){ $i++;                         
                        
                        ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>shops/deleteProduct?id=<?php echo $p['id'] ?>&&shop_id=<?php echo $shop_id?>">Delete</a></label>
                                <!-- <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_product_<?php //echo $p['id']; ?>" data-whatever="@getbootstrap">Edit</button>
                                <label class="badge badge-success"><a href="<?php //echo base_url(); ?>products/batches?id=<?php //echo $p['id'] ?>">Batches</a></label>
                                 --></td>
                                <td><?php echo $p['product_name'] ?></td>                                
                                <td><?php echo $p['brand_name'] ?></td>
                                <td><?php echo $p['category_name'] ?></td>
                                <td><?php echo $p['sub_category_one_name'] ?></td>
                                <td><?php echo $p['sub_category_two_name'] ?></td>                                
                                <!-- <td><?php //echo $p['first_name'].' '.$p['last_name'] ?></td> -->
                                <td><?php echo $p['description'] ?></td>                                                                                     
                            </tr>


                    <?php } ?>

                     
                    </tbody>
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
    <!-- page-body-wrapper ends --><!-- Modal starts -->
                  
                  <div class="modal fade" id="add_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" style="width:70%; left:9vw;" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('shops/addProduct'); ?>">
                           <input type="hidden" name="shop_id" value="<?php echo $shop_id; ?>" />
                            <div class="row">
                            <div class="form-group col-md-12 col-lg-12">
                            <label for="name" class="col-form-label">Products:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="products[]" id="products" multiple="multiple" required>
                                <option value="">-- Select Product --</option>
                                <?php $products = $this->db->select('*')->from('products')->get()->result_array(); ?>
                                <?php 
                                    foreach($products as $p){ ?>
                                        <option value="<?php echo $p['id'] ?>"><?php echo $p['name'] ?></option>
                                <?php } ?>                               
                              </select>
                            </div>
                                                       
                            </div>  <br><br><br><br><br><br><br><br>                                                                                
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add Product</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>  
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <!-- Modal Ends -->
  </div>




                
                

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


  
  