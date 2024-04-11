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

              <span class="card-title">Suppliers</span>
              <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_supplier" data-whatever="@getbootstrap">Add Supplier</button>
                                
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>                        
                        <th>PAN</th>
                        <th>GST</th>
                        <th>State Code</th>
                        <th>Description</th>
                        <th>Address</th>                        
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;                    
                        foreach($suppliers as $s){ $i++;                         
                        
                         /*  $assigned_wareshouse = $this->db->select('w.name')
                          ->from('warehouse w')
                          ->join('shop_warehouse_relationship swr', 'swr.warehouse_id=w.id')
                          ->where('swr.id', $s['id'])
                          ->get()->result_array(); */
                        
                        ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td style="display:none">
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>suppliers/delete?id=<?php echo $s['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_supplier_<?php echo $s['id']; ?>" data-whatever="@getbootstrap">Edit</button>
                                <label class="badge badge-success"><a href="<?php echo base_url(); ?>suppliers/users?id=<?php echo $s['id'] ?>">Users</a></label>
                                <button class="btn btn-outline-success" data-toggle="modal" data-target="#assign_warehouse_<?php echo $s['id']; ?>" data-whatever="@getbootstrap">Assign</button>
                                <?php if($this->session->userdata['usertype'] == 1 && $s['active_status'] == 0){ ?>
                                  <label class="badge badge-warning"><a href="<?php echo base_url(); ?>suppliers/activateSupplier?id=<?php echo $s['id'] ?>">Activate</a></label>
                                <?php } ?>
                                <label class="badge badge-danger"><a style="color:white" href="<?php echo base_url(); ?>suppliers/products?id=<?php echo $s['id'] ?>">Products</a></label>
                  
                                </td>
                                <td>
                                <div class="dropdown">
                          <button class="btn btn-primary icon-btn dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-settings"></i>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1" style="border:2px solid dodgerblue; text-align:center;" >
                          <a style="text-align:center" href="<?php echo base_url(); ?>suppliers/delete?id=<?php echo $s['id'] ?>">Delete</a>
                          <div class="dropdown-divider"></div>  
                          <a href="" data-toggle="modal" data-target="#edit_supplier_<?php echo $s['id']; ?>" data-whatever="@getbootstrap">Edit</a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo base_url(); ?>suppliers/users?id=<?php echo $s['id'] ?>">Users</a>
                            <div class="dropdown-divider"></div>  
                          <a href="" data-toggle="modal" data-target="#assign_warehouse_<?php echo $s['id']; ?>" data-whatever="@getbootstrap">Assign</a>
                            <?php if($this->session->userdata['usertype'] == 1 && $s['active_status'] == 0){ ?>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo base_url(); ?>suppliers/activateSupplier?id=<?php echo $s['id'] ?>">Activate</a>
                            <?php } ?>                            
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo base_url(); ?>suppliers/products?id=<?php echo $s['id'] ?>">Products</a>
                          </div>
                        </div>
                                </td>
                                <td><?php echo $s['name'] ?></td>
                                <!-- <td><?php //echo empty($assigned_wareshouse) ? 'Not Assigned' : $assigned_wareshouse[0]['name'] ?></td>
                                 -->
                                <td><?php echo $s['phone'] ?></td>
                                <td><?php echo $s['email'] ?></td>
                                <td><?php echo $s['pan'] ?></td>
                                <td><?php echo $s['gst'] ?></td>
                                <td><?php echo $s['state_code'] ?></td>
                                <td><?php echo $s['description'] ?></td>
                                <td><?php echo $s['address'] ?></td>                                                       
                            </tr>

                  <div class="modal fade" id="edit_supplier_<?php echo $s['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Update Supplier</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('suppliers/editSupplier'); ?>">
                            <input type="hidden" name="id" id="id" value="<?php echo $s['id']; ?>" />
                            <div class="form-group">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" value="<?php echo $s['name']; ?>"" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Phone:</label>
                              <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $s['phone']; ?>"" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Email:</label>
                              <input type="email" class="form-control" name="email" id="email" value="<?php echo $s['email']; ?>"" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">PAN Number:</label>
                              <input type="text" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" class="form-control" name="pan" id="pan" value="<?php echo $s['gst']; ?>"" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">GST Number:</label>
                              <input type="text" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}[A-Z]{1}[0-9]{1}" class="form-control" name="gst" id="gst" value="<?php echo $s['gst']; ?>"" required>
                            </div> 
                            <!-- <div class="form-group">
                              <label for="name" class="col-form-label">State Code:</label>
                              <input type="text" pattern="[0-9]{2}"class="form-control" name="state_code" id="state_code" value="<?php echo $s['state_code']; ?>"" required>
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
                                <option value="<?php echo $sc['state_code']?>" <?php if($sc['state_code']==$s['state_code']){echo "selected";} ?>><?php echo $sc['state_code'].' - '.$sc['state_name']?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div>                                                      
                            <div class="form-group">
                              <label for="address" class="col-form-label">Description:</label>
                              <textarea class="form-control" name="description" id="description" required> <?php echo $s['description']; ?></textarea>
                            </div>
                            <div class="form-group">
                              <label for="address" class="col-form-label">Address:</label>
                              <textarea class="form-control" name="address" id="address" required> <?php echo $s['address']; ?></textarea>
                            </div>
                                                                                  
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Update Supplier</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>


                  <div class="modal fade" id="assign_warehouse_<?php echo $s['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Assign Warehouse</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('suppliers/assignSupplierWarehouse'); ?>">
                            <input type="hidden" name="id" id="id" value="<?php echo $s['id']; ?>" />                            
                            
                            <div class="form-group">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" value="<?php echo $s['name']; ?>" readonly required>
                            </div>



                            <?php $warehouses = $this->db->select('*')
                            ->from('warehouse')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">Warehouse:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="warehouse_id" id="warehouse_id" required>
                              <option value="">Select Warehouse</option>
                              <?php foreach($warehouses as $w){ ?>
                                <option value="<?php echo $w['id']?>" ><?php echo $w['name']?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div>

  
                                                          
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Assign Warehouse</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>                                









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




                <div class="modal fade" id="add_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">New Supplier</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('suppliers/addSupplier'); ?>">
                            <div class="form-group">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Phone:</label>
                              <input type="text" class="form-control" name="phone" id="phone" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Email:</label>
                              <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">PAN Number:</label>
                              <input type="text" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}"class="form-control" name="pan" id="pan" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">GST Number:</label>
                              <input type="text" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}[A-Z]{1}[0-9]{1}"class="form-control" name="gst" id="gst" required>
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
                              <label for="address" class="col-form-label">Description:</label>
                              <textarea class="form-control" name="description" id="description" required></textarea>
                            </div>
                            <div class="form-group">
                              <label for="address" class="col-form-label">Address:</label>
                              <textarea class="form-control" name="address" id="address" required></textarea>
                            </div>                                                       
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add Supplier</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                      </div>
                    </div>
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


  
  