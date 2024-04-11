<!DOCTYPE html>
<html lang="en">

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

            <?php if($this->session->flashdata('warehouseAdded_status') == 'success' || $this->session->flashdata('warehouseAdded_status') == 'fail') {
                
                if($this->session->flashdata('warehouseAdded_status') == 'success'){
                    $color='green';
                }else{                    
                    $color='red';
                }
             // echo "hi";
              echo "<b style='color:".$color."'>".$this->session->flashdata('warehouseAdded_message')."</b>";
              echo "<br><br>";  
            
            }
              
              ?>

        <?php if($this->session->flashdata('warehouseDeleted_status') == 'success' || $this->session->flashdata('warehouseDeleted_status') == 'fail') {
                
                if($this->session->flashdata('warehouseDeleted_status') == 'success'){
                    $color='green';
                }else{                    
                    $color='red';
                }
             // echo "hi";
              echo "<b style='color:".$color."'>".$this->session->flashdata('warehouseDeleted_message')."</b>";
              echo "<br><br>";  
            
            }
              
              ?>
         <?php if($this->session->flashdata('warehouseUpdated_status') == 'success' || $this->session->flashdata('warehouseUpdated_status') == 'fail') {
                
                if($this->session->flashdata('warehouseUpdated_status') == 'success'){
                    $color='green';
                }else{                    
                    $color='red';
                }
             // echo "hi";
              echo "<b style='color:".$color."'>".$this->session->flashdata('warehouseUpdated_message')."</b>";
              echo "<br><br>";  
            
            }
              
              ?>      
            

              <span class="card-title">Warehouses</span>
              <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_warehouse" data-whatever="@getbootstrap">Add Warehouse</button>
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>
                        <th>Name</th>
                        <th>Location</th>                        
                        <th>State Code</th>
                        <th>GST</th>
                        <th>PAN</th>
                        <th>Address</th>                        
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;
                        foreach($warehouses as $w){ $i++; ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td style="display:none">
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>warehouse/delete?id=<?php echo $w['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_warehouse_<?php echo $w['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                
                                <label class="badge badge-success"><a href="<?php echo base_url(); ?>warehouse/users?id=<?php echo $w['id'] ?>">Users</a></label>
                                <label class="badge badge-warning"><a href="<?php echo base_url(); ?>warehouse/shops?id=<?php echo $w['id'] ?>">Shops</a></label>
                                <label class="badge badge-primary"><a style="color:white" href="<?php echo base_url(); ?>warehouse/racks?id=<?php echo $w['id'] ?>">Racks</a></label>                                
                                <label class="badge badge-danger"><a style="color:white" href="<?php echo base_url(); ?>warehouse/products?id=<?php echo $w['id'] ?>">Products</a></label>
                              
                        </td>
                        <td>      
                          <div class="dropdown">
                          <button class="btn btn-primary icon-btn dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-settings"></i>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1" style="border:2px solid dodgerblue; text-align:center;" >
                          <a style="text-align:center" href="<?php echo base_url(); ?>warehouse/delete?id=<?php echo $w['id'] ?>">Delete</a>
                          <div class="dropdown-divider"></div>  
                          <a href="" data-toggle="modal" data-target="#edit_warehouse_<?php echo $w['id']; ?>" data-whatever="@getbootstrap">Edit</a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo base_url(); ?>warehouse/users?id=<?php echo $w['id'] ?>">Users</a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo base_url(); ?>warehouse/shops?id=<?php echo $w['id'] ?>">Shops</a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo base_url(); ?>warehouse/racks?id=<?php echo $w['id'] ?>">Racks</a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo base_url(); ?>warehouse/products?id=<?php echo $w['id'] ?>">Products</a>
                          </div>
                        </div>
                              
                              </td>
                                <td><?php echo $w['name'] ?></td>
                                <td><?php echo $w['location'] ?></td>
                                <td><?php echo $w['state_code'] ?></td>
                                <td><?php echo $w['gst'] ?></td>
                                <td><?php echo $w['pan'] ?></td>
                                <td><?php echo $w['address'] ?></td>                                                       
                            </tr>
                    <?php } ?>

                      
                      
                        
                      
                      <!-- <tr>
                        <td>10</td>
                        <td>2003/12/26</td>
                        <td>Tom</td>
                        <td>Germany</td>
                        <td>$1100</td>
                        <td>$2300</td>
                        <td>
                          <label class="badge badge-danger">Pending</label>
                        </td>
                        <td>
                          <button class="btn btn-outline-primary">View</button>
                        </td>
                      </tr> -->
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
    <!-- page-body-wrapper ends -->
  </div>




                <div class="modal fade" id="add_warehouse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">New warehouse</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('warehouse/addWarehouse'); ?>">
                            <div class="form-group">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Location:</label>
                              <input type="text" class="form-control" name="location" id="location" required>
                            </div>
                            <!-- <div class="form-group">
                              <label for="name" class="col-form-label">State Code:</label>
                              <input type="text" pattern="[0-9]{2}"class="form-control" name="state_code" id="state_code" required>
                            </div> -->
                            <?php $state_codes = $this->db->select('*')
                            ->from('state_code')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">State Code:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="state_code" id="state_code" required>
                              <option value="">Select State Code</option>
                              <?php foreach($state_codes as $sc){ ?>
                                <option value="<?php echo $sc['state_code']?>" ><?php echo $sc['state_code'].' - '.$sc['state_name']?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">GST Number:</label>
                              <input type="text" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}[A-Z]{1}[0-9]{1}"class="form-control" name="gst" id="gst" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Pan Number:</label>
                              <input type="text" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}"class="form-control" name="pan" id="pan" required>
                            </div>
                            <div class="form-group">
                              <label for="address" class="col-form-label">Address:</label>
                              <textarea class="form-control" name="address" id="address" required></textarea>
                            </div>                          
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add Warehouse</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php 
                foreach($warehouses as $w){ ?>            
                  <div class="modal fade" id="edit_warehouse_<?php echo $w['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Update warehouse</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('warehouse/editWarehouse'); ?>">
                          <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $w['id']; ?>" required>
                              
                          <div class="form-group">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" value="<?php echo $w['name']; ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Location:</label>
                              <input type="text" class="form-control" name="location" id="location" value="<?php echo $w['location']; ?>" required>
                            </div>
                            <!-- <div class="form-group">
                              <label for="name" class="col-form-label">State Code:</label>
                              <input type="text" pattern="[0-9]{2}"class="form-control" name="state_code" id="state_code" value="<?php echo $w['state_code']; ?>" required>
                            </div> -->
                            <?php $state_codes = $this->db->select('*')
                            ->from('state_code')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">State Code:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="state_code" id="state_code" required>
                              <option value="">Select State Code</option>
                              <?php foreach($state_codes as $sc){ ?>
                                <option value="<?php echo $sc['state_code']?>" <?php if($sc['state_code']==$w['state_code']){echo "selected";} ?>><?php echo $sc['state_code'].' - '.$sc['state_name']?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">GST Number:</label>
                              <input type="text" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}[A-Z]{1}[0-9]{1}"class="form-control" name="gst" id="gst" value="<?php echo $w['gst']; ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Pan Number:</label>
                              <input type="text" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}"class="form-control" name="pan" id="pan" value="<?php echo $w['pan']; ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="address" class="col-form-label">Address:</label>
                              <textarea class="form-control" name="address" id="address" required><?php echo $w['address']; ?></textarea>
                            </div>                          
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Update Warehouse</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php } ?>  









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
</body>

</html>