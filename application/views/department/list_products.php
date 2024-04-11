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

              <span class="card-title">Products</span>
              <span>
                  <!-- <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_product" data-whatever="@getbootstrap">Add Product</button>
                 --></span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <!-- <th>Actions</th> -->
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Brand</th>
                        <th>Category</th>                        
                        <th>Sub Category One</th>
                        <th>Sub Category Two</th>
                        <th>Supplier</th>                       
                        <th>Description</th>
                                            
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;                    
                        foreach($products as $p){ $i++;                         
                        
                        ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <!-- <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>products/delete?id=<?php echo $p['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_product_<?php echo $p['id']; ?>" data-whatever="@getbootstrap">Edit</button>
                                <label class="badge badge-success"><a href="<?php echo base_url(); ?>products/batches?id=<?php echo $p['id'] ?>">Batches</a></label>
                                <?php 
                                $usertype = $this->session->userdata['usertype'];
                                if($usertype == 1 || $usertype == 2 || $usertype == 3 || $usertype == 4){ ?>
                                <button class="btn btn-outline-danger" data-toggle="modal" data-target="#assign_product_<?php echo $p['id']; ?>" data-whatever="@getbootstrap">Assign</button>
                                <?php } ?>
                                </td> -->
                                <td><?php echo $p['name'] ?></td>   
                                <td><?php echo $p['quantity'] ?></td>
                                <td><?php echo $p['brand_name'] ?></td>
                                <td><?php echo $p['category_name'] ?></td>
                                <td><?php echo $p['sub_category_one_name'] ?></td>
                                <td><?php echo $p['sub_category_two_name'] ?></td>                                
                                <td><?php echo $p['first_name'].' '.$p['last_name'] ?></td>
                                <td><?php echo $p['description'] ?></td>                                                                                     
                            </tr>

                <div class="modal fade" id="edit_product_<?php echo $p['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="width:70%; left:9vw" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('products/editProduct'); ?>">
                            <input type="hidden" name="id" value="<?php echo $p['id'] ?>" />    
                        <div class="row">
                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" value="<?php echo $p['name'] ?>" required>
                            </div>
                            
                            <div class="form-group col-md-6 col-lg-6">
                            <label for="name" class="col-form-label">Brand:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="brand" id="brand" required>
                                <option value="">-- Select Brand --</option>
                                <?php $brands = $this->db->select('*')->from('brand')->get()->result_array(); ?>
                                <?php 
                                    foreach($brands as $b){ ?>
                                        <option value="<?php echo $b['id'] ?>" <?php if($b['id']==$p['brand']){echo "selected";} ?>><?php echo $b['name'] ?></option>
                                <?php } ?>                               
                              </select>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                            <label for="name" class="col-form-label">Category:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="category" id="category" required>
                                <option value="">-- Select Category --</option>
                                <?php $category = $this->db->select('*')->from('category')->get()->result_array(); ?>
                                <?php 
                                    foreach($category as $c){ ?>
                                        <option value="<?php echo $c['id'] ?>" <?php if($c['id']==$p['category']){echo "selected";} ?>><?php echo $c['name'] ?></option>
                                <?php } ?>                               
                              </select>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                            <label for="name" class="col-form-label">Sub Category One:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_one" id="sub_category_one" required>
                                <option value="">-- Select Sub Category One --</option>
                                <?php $ones = $this->db->select('*')->from('sub_categories_one')->get()->result_array(); ?>
                                <?php 
                                    foreach($ones as $o){ ?>
                                        <option value="<?php echo $o['id'] ?>" <?php if($o['id']==$p['sub_category_one']){echo "selected";} ?>><?php echo $o['name'] ?></option>
                                <?php } ?>                               
                              </select>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                            <label for="name" class="col-form-label">Sub Category Two:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_two" id="sub_category_two" required>
                                <option value="">-- Select Sub Category Two --</option>
                                <?php $twos = $this->db->select('*')->from('sub_categories_two')->get()->result_array(); ?>
                                <?php 
                                    foreach($twos as $t){ ?>
                                        <option value="<?php echo $t['id'] ?>" <?php if($t['id']==$p['sub_category_two']){echo "selected";} ?>><?php echo $t['name'] ?></option>
                                <?php } ?>                               
                              </select>
                            </div>
                                                                                   
                            <div class="form-group col-md-6 col-lg-6">
                              <label for="address" class="col-form-label">Description:</label>
                              <textarea class="form-control" name="description" id="description" required><?php echo $p['description'] ?></textarea>
                            </div> 
                            </div>                                                                                  
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add Product</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                                    </form>
                        
                      </div>
                    </div>
                  </div>


                <div class="modal fade" id="assign_product_<?php echo $p['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md"  style="height:500px"  role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Assign Product</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('products/assignProduct'); ?>">
                            <input type="hidden" name="id" value="<?php echo $p['id'] ?>" />    
                        <div class="row"  style="height:200px">
                            
                            <div class="form-group col-md-12 col-lg-12">
                            <label for="name" class="col-form-label">Department:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="department_id" id="department_id" required>
                                <option value="">-- Select Department --</option>
                                <?php $departments = $this->db->select('*')->from('department')->where('delete_status',0)->get()->result_array(); ?>
                                <?php 
                                    foreach($departments as $d){ ?>
                                        <option value="<?php echo $d['id'] ?>"><?php echo $d['name'] ?></option>
                                <?php } ?>                               
                              </select>
                            </div>
                                                                                                           
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Assign Product</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                                    </form>
                        
                      </div>
                    </div>
                  </div>









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
                    <div class="modal-dialog modal-lg" style="width:70%; left:9vw" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('products/addProduct'); ?>">
                            <div class="row">

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            
                            <div class="form-group col-md-6 col-lg-6">
                            <label for="name" class="col-form-label">Brand:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="brand" id="brand" required>
                                <option value="">-- Select Brand --</option>
                                <?php $brands = $this->db->select('*')->from('brand')->get()->result_array(); ?>
                                <?php 
                                    foreach($brands as $b){ ?>
                                        <option value="<?php echo $b['id'] ?>"><?php echo $b['name'] ?></option>
                                <?php } ?>                               
                              </select>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                            <label for="name" class="col-form-label">Category:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="category" id="category" required>
                                <option value="">-- Select Category --</option>
                                <?php $category = $this->db->select('*')->from('category')->get()->result_array(); ?>
                                <?php 
                                    foreach($category as $c){ ?>
                                        <option value="<?php echo $c['id'] ?>"><?php echo $c['name'] ?></option>
                                <?php } ?>                               
                              </select>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                            <label for="name" class="col-form-label">Sub Category One:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_one" id="sub_category_one" required>
                                <option value="">-- Select Sub Category One --</option>
                                <?php $ones = $this->db->select('*')->from('sub_categories_one')->get()->result_array(); ?>
                                <?php 
                                    foreach($ones as $o){ ?>
                                        <option value="<?php echo $o['id'] ?>"><?php echo $o['name'] ?></option>
                                <?php } ?>                               
                              </select>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                            <label for="name" class="col-form-label">Sub Category Two:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_two" id="sub_category_two" required>
                                <option value="">-- Select Sub Category Two --</option>
                                <?php $twos = $this->db->select('*')->from('sub_categories_two')->get()->result_array(); ?>
                                <?php 
                                    foreach($twos as $t){ ?>
                                        <option value="<?php echo $t['id'] ?>"><?php echo $t['name'] ?></option>
                                <?php } ?>                               
                              </select>
                            </div>
                                                                                   
                            <div class="form-group col-md-6 col-lg-6">
                              <label for="address" class="col-form-label">Description:</label>
                              <textarea class="form-control" name="description" id="description" required></textarea>
                            </div> 
                            </div>                                                                                  
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


  
  