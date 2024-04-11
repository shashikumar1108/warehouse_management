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
            
          //  $warehouses = $this->db->select('id, name')->from('warehouse')->where('delete_status',0)->get()->result_array();

            ?>

              <span class="card-title">Users</span>
              <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_user" data-whatever="@getbootstrap">Add User</button>
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>
                        <th>User Name</th>
                        <th>Email</th>                        
                        <th>Mobile</th>
                        <th>Full Name</th>                        
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;
                        foreach($users as $u){ $i++; ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>suppliers/deleteUser?id=<?php echo $u['id'] ?>&&supplier_id=<?php echo $supplier_id; ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_user_<?php echo $u['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                
                                </td>
                                <td><?php echo $u['username'] ?></td>
                                <td><?php echo $u['email'] ?></td>
                                <td><?php echo $u['mobile'] ?></td>
                                <td><?php echo $u['first_name'].' '.$u['last_name'] ?></td>                                                       
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




                <div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">New User</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('suppliers/addUser'); ?>">
                            <input type="hidden" name="supplier_id" value="<?php echo $supplier_id; ?>"/>
                            <div class="form-group">
                              <label for="name" class="col-form-label">First Name:</label>
                              <input type="text" class="form-control" name="first_name" id="first_name" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Last Name:</label>
                              <input type="text" class="form-control" name="last_name" id="last_name" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Email:</label>
                              <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Mobile:</label>
                              <input type="text" class="form-control" pattern="[789][0-9]{9}" name="mobile" id="mobile" required>
                            </div>
                            <!-- <div class="form-group">
                            <label for="name" class="col-form-label">Usertype:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="usertype" id="usertype" required>
                              <option value="">User Type</option>
                                <option value="2">WH - Admin</option>
                                <option value="3">WH - Accountant</option>
                                <option value="4">WH - Sales</option>                                
                              </select>
                            </div> -->                                                      
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add User</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php 
                foreach($users as $u){ ?>            
                  <div class="modal fade" id="edit_user_<?php echo $u['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Update User</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('suppliers/editUser'); ?>">
                            <input type="hidden" name="id" id="id" value="<?php echo $u['id']; ?>" />
                            <input type="hidden" name="supplier_id" value="<?php echo $supplier_id; ?>"/>
                            
                            <div class="form-group">
                              <label for="name" class="col-form-label">First Name:</label>
                              <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $u['first_name']; ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Last Name:</label>
                              <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $u['last_name']; ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Email:</label>
                              <input type="email" class="form-control" name="email" id="email" value="<?php echo $u['email']; ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Mobile:</label>
                              <input type="text" class="form-control" pattern="[789][0-9]{9}" name="mobile" id="mobile" value="<?php echo $u['mobile']; ?>" required>
                            </div>
                            <!-- <div class="form-group">
                            <label for="name" class="col-form-label">Usertype:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="usertype" id="usertype" required>
                              <option value="">User Type</option>
                                <option value="2">WH - Admin</option>
                                <option value="3">WH - Accountant</option>
                                <option value="4">WH - Sales</option>                                
                              </select>
                            </div> -->                                                      
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Update User</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>


                  <div class="modal fade" id="assign_user_<?php echo $u['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Assign User</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('users/assignUserWarehouse'); ?>">
                            <input type="hidden" name="id" id="id" value="<?php echo $u['id']; ?>" />
                            <input type="hidden" name="usertype" id="usertype" value="<?php echo $u['usertype']; ?>" />
                            
                            <div class="form-group">
                              <label for="name" class="col-form-label">User Name:</label>
                              <input type="text" class="form-control" name="full_name" id="first_name" value="<?php echo $u['first_name'].' '.$u['last_name']; ?>" readonly required>
                            </div>
                            <div class="form-group">
                            <label for="name" class="col-form-label">Select Warehouse:</label>
                            </div>

                            <div class="icheck-square">
                        <?php foreach($warehouses as $w){ ?>                          
                            <input tabindex="<?php echo $w['id'] ?>" type="radio" id="square-radio-<?php echo $w['id'] ?>" name="warehouse_id" value="<?php echo $w['id'] ?>">
                            <label for="square-radio-<?php echo $w['id'] ?>"><?php echo $w['name'] ?></label>                          
                        <?php } ?>
                        </div>
                                                          
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Assign User</button>
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
  <script src="<?php echo base_url(); ?>chromaTemplate/js/select2.js"></script>
  <script src="<?php echo base_url(); ?>chromaTemplate/js/iCheck.js"></script>
</body>

</html>


  
  