<!DOCTYPE html>
<html lang="en">

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

            <?php if($this->session->flashdata('userAdded_status') == 'success' || $this->session->flashdata('userAdded_status') == 'fail') {
                
                if($this->session->flashdata('userAdded_status') == 'success'){
                    $color='green';
                }else{                    
                    $color='red';
                }
             // echo "hi";
              echo "<b style='color:".$color."'>".$this->session->flashdata('userAdded_message')."</b>";
              echo "<br><br>";  
            
            }
              
              ?>

        <?php if($this->session->flashdata('userDeleted_status') == 'success' || $this->session->flashdata('userDeleted_status') == 'fail') {
                
                if($this->session->flashdata('userDeleted_status') == 'success'){
                    $color='green';
                }else{                    
                    $color='red';
                }
             // echo "hi";
              echo "<b style='color:".$color."'>".$this->session->flashdata('userDeleted_message')."</b>";
              echo "<br><br>";  
            
            }
              
              ?>
         <?php if($this->session->flashdata('userUpdated_status') == 'success' || $this->session->flashdata('userUpdated_status') == 'fail') {
                
                if($this->session->flashdata('userUpdated_status') == 'success'){
                    $color='green';
                }else{                    
                    $color='red';
                }
             // echo "hi";
              echo "<b style='color:".$color."'>".$this->session->flashdata('userUpdated_message')."</b>";
              echo "<br><br>";  
            
            }
              
              ?>      
            

              <span class="card-title">Assigned Users</span>
              <!-- <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_user" data-whatever="@getbootstrap">Assign User</button>
                </span> --> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <!-- <th>Actions</th> -->
                        <th>Designation</th>
                        <th>User Name</th>
                        <th>Email</th>                        
                        <th>Mobile</th>
                        <th>Full Name</th>                        
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;
                        foreach($warehouse_admin as $admin){ $i++; ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <!-- <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>users/delete?id=<?php echo $u['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_user_<?php echo $u['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                
                                </td> -->
                                <td style="color: green; font-weight:bold">Admin</td>
                                <td><?php echo $admin['username'] ?></td>                                
                                <td><?php echo $admin['email'] ?></td>
                                <td><?php echo $admin['mobile'] ?></td>
                                <td><?php echo $admin['first_name'].' '.$admin['last_name'] ?></td>                                                       
                            </tr>
                    <?php } ?>

                    <?php //$i = 0;
                        foreach($warehouse_accountant as $accountant){ $i++; ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <!-- <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>users/delete?id=<?php echo $u['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_user_<?php echo $u['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                
                                </td> -->
                                <td style="color: red; font-weight:bold">Accountant</td>
                                <td><?php echo $accountant['username'] ?></td>                                
                                <td><?php echo $accountant['email'] ?></td>
                                <td><?php echo $accountant['mobile'] ?></td>
                                <td><?php echo $accountant['first_name'].' '.$accountant['last_name'] ?></td>                                                       
                            </tr>
                    <?php } ?>

                    <?php //$i = 0;
                        foreach($warehouse_sales as $sales){ $i++; ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <!-- <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>users/delete?id=<?php echo $u['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_user_<?php echo $u['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                
                                </td> -->
                                <td style="color: purple; font-weight:bold">Sales</td>
                                <td><?php echo $sales['username'] ?></td>                                
                                <td><?php echo $sales['email'] ?></td>
                                <td><?php echo $sales['mobile'] ?></td>
                                <td><?php echo $sales['first_name'].' '.$sales['last_name'] ?></td>                                                       
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
                          <form method="post" action="<?php echo base_url('users/addUser'); ?>">
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
                            <div class="form-group">
                            <label for="name" class="col-form-label">Usertype:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="usertype" id="usertype" required>
                              <option value="">User Type</option>
                                <option value="2">WH - Admin</option>
                                <option value="3">WH - Accountant</option>
                                <option value="4">WH - Sales</option>                                
                              </select>
                            </div>                                                      
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add User</button>
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
</body>

</html>