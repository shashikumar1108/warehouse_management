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
             
             
             
            <?php if($this->session->flashdata('assign_status') == 'success' || 
              $this->session->flashdata('assign_status') == 'fail') {
                
                if($this->session->flashdata('assign_status') == 'success'){
                    $color='green';
                }else{                    
                    $color='red';
                }
             // echo "hi";
              echo "<b style='color:".$color."'>".$this->session->flashdata('assign_message')."</b>";
              echo "<br><br>";  
            
            }
              
              ?> 
            
            <?php 
            
            $warehouses = $this->db->select('id, name')->from('warehouse')->where('delete_status',0)->get()->result_array();
            $shops = $this->db->select('id, name')->from('shops')->where('delete_status',0)->get()->result_array();
            $departments = $this->db->select('id, name')->from('department')->where('delete_status',0)->get()->result_array();

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
                        <th>User Type</th>
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
                                <td style="display:none;">
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>users/delete?id=<?php echo $u['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_user_<?php echo $u['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                
                              <?php if($u['usertype'] == 2 || $u['usertype'] == 3 || $u['usertype'] == 4 || $u['usertype'] == 7 || $u['usertype'] == 8) { ?>  
                                <button class="btn btn-outline-success" data-toggle="modal" data-target="#assign_user_<?php echo $u['id']; ?>" data-whatever="@getbootstrap">Assign</button>                                                                
                              <?php } ?>
                              </td>
                              <td>
                              <div class="dropdown">
                          <button class="btn btn-primary icon-btn dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-settings"></i>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1" style="border:2px solid dodgerblue; text-align:center;" >
                          <a href="<?php echo base_url(); ?>users/delete?id=<?php echo $u['id'] ?>">Delete</a>
                          <div class="dropdown-divider"></div>  
                          <a href="" data-toggle="modal" data-target="#edit_user_<?php echo $u['id']; ?>" data-whatever="@getbootstrap">Edit</a>
                            
                          
                          <?php if($u['usertype'] != 1 && $u['usertype'] != 5 && $u['usertype'] != 6) { ?>  
                            <div class="dropdown-divider"></div>    
                            <a href="" data-toggle="modal" data-target="#assign_user_<?php echo $u['id']; ?>" data-whatever="@getbootstrap">Assign</a>                                                                
                              <?php } ?>
                          
                          
                         </div>
                        </div>
                                </td>
                                
                                <?php if($u['usertype'] == 1){ ?>
                                  <td style="color:#0a003a"><b>Super - Admin</b></td>
                                <?php }elseif($u['usertype'] == 2){ ?>
                                  <td style="color:green">WH - Admin</td>
                                  <?php }elseif($u['usertype'] == 3){ ?>
                                    <td style="color:red">WH - Accountant</td>
                                  <?php }elseif($u['usertype'] == 4){ ?>
                                    <td style="color:purple">WH - Sales</td>
                                  <?php }elseif($u['usertype'] == 5){ ?>
                                    <td style="color:green">Supplier - User</td>
                                  <?php }elseif($u['usertype'] == 6){ ?>
                                    <td style="color:orange">Agent</td>
                                  <?php }elseif($u['usertype'] == 7){ ?>
                                    <td style="color:#ec5e77">Shop - Admin</td> 
                                  <?php }elseif($u['usertype'] == 8){ ?>    
                                  <td style="color:#0d0d9e">Department - User</td> 
                                <?php } ?>
                                

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
                                <option value="7">Shop - Admin</option> 
                                <option value="8">Department - User</option> 

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
                        <form method="post" action="<?php echo base_url('users/editUser'); ?>">
                            <input type="hidden" name="id" id="id" value="<?php echo $u['id']; ?>" />
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
                        <?php if($u['usertype'] == 2 || $u['usertype'] == 3 || $u['usertype'] == 4) { // Warehouse ?> 
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
                        <?php }elseif($u['usertype'] == 7){ // Shop ?>
                          <form method="post" action="<?php echo base_url('users/assignUserShop'); ?>">
                            <input type="hidden" name="id" id="id" value="<?php echo $u['id']; ?>" />
                            <input type="hidden" name="usertype" id="usertype" value="<?php echo $u['usertype']; ?>" />
                            
                            <div class="form-group">
                              <label for="name" class="col-form-label">User Name:</label>
                              <input type="text" class="form-control" name="full_name" id="first_name" value="<?php echo $u['first_name'].' '.$u['last_name']; ?>" readonly required>
                            </div>
                            <div class="form-group">
                            <label for="name" class="col-form-label">Select Shop:</label>
                            </div>

                            <div class="icheck-square">
                        <?php foreach($shops as $s){ ?>                          
                            <input tabindex="<?php echo $s['id'] ?>" type="radio" id="square-radio-<?php echo $s['id'] ?>" name="shop_id" value="<?php echo $s['id'] ?>">
                            <label for="square-radio-<?php echo $s['id'] ?>"><?php echo $s['name'] ?></label>                          
                        <?php } ?>
                        </div>
                                                          
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Assign User</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                        <?php }else{ // Department ?>
                         <form method="post" action="<?php echo base_url('users/assignUserDepartment'); ?>">
                            <input type="hidden" name="id" id="id" value="<?php echo $u['id']; ?>" />
                            <input type="hidden" name="usertype" id="usertype" value="<?php echo $u['usertype']; ?>" />
                            
                            <div class="form-group">
                              <label for="name" class="col-form-label">User Name:</label>
                              <input type="text" class="form-control" name="full_name" id="first_name" value="<?php echo $u['first_name'].' '.$u['last_name']; ?>" readonly required>
                            </div>
                            <div class="form-group">
                            <label for="name" class="col-form-label">Select Department:</label>
                            </div>

                            <div class="icheck-square">
                        <?php foreach($departments as $d){ ?>                          
                            <input tabindex="<?php echo $d['id'] ?>" type="radio" id="square-radio-<?php echo $d['id'] ?>" name="department_id" value="<?php echo $d['id'] ?>">
                            <label for="square-radio-<?php echo $d['id'] ?>"><?php echo $d['name'] ?></label>                          
                        <?php } ?>
                        </div>
                                                          
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Assign User</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                        <?php } ?>
                        
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


  
  