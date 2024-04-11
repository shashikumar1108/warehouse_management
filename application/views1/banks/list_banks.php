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
             
              echo "<b style='color:".$color."'>".$this->session->flashdata('message')."</b>";
              echo "<br><br>";  
            
            }
              
              ?>
 
            

              <span class="card-title">Banks</span>
              <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_bank" data-whatever="@getbootstrap">Add Bank</button>
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Branch Code</th>
                        <th>Account Title</th>
                        <th>Account Number</th>
                        <th>Account Type</th>                                               
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;                    
                        foreach($banks as $b){ $i++;    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>bank/banks/delete?id=<?php echo $b['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_bank_<?php echo $b['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                                                
                                <td><?php echo $b['name'] ?></td>
                                <td><?php echo $b['branch'] ?></td>
                                <td><?php echo $b['branch_code'] ?></td>
                                <td><?php echo $b['account_title'] ?></td>
                                <td><?php echo $b['account_number'] ?></td>
                                <td><?php echo $b['account_type'] ?></td>                                                                                                                 
                            </tr>

                  <div class="modal fade" id="edit_bank_<?php echo $b['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" style="top:-11vh" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Update Bank</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('bank/banks/editBank'); ?>">
                        <input type="hidden" name="id" value="<?php echo $b['id'] ?>" />
                        <div class="form-group">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" value="<?php echo $b['name']?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Branch:</label>
                              <input type="text" class="form-control" name="branch" id="branch" value="<?php echo $b['branch']?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Branch Code:</label>
                              <input type="text" class="form-control" name="branch_code" id="branch_code" value="<?php echo $b['branch_code']?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Account Title:</label>
                              <input type="text" class="form-control" name="account_title" id="account_title" value="<?php echo $b['account_title']?>" required>
                            </div>
                            <div class="form-group">
                            <label for="name" class="col-form-label">Account Type:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="account_type" id="account_type" required>
                              <option value="">Select Account Type</option>
                              <option value="Savings" <?php if($b['account_type'] == 'Savings') { echo "selected"; }  ?>>Savings Account</option>
                              <option value="Current" <?php if($b['account_type'] == 'Current') { echo "selected"; }  ?>>Current Account</option>
                              </select>
                            </div> 
                            <div class="form-group">
                              <label for="name" class="col-form-label">Account Number:</label>
                              <input type="text" class="form-control" name="account_number" id="account_number" value="<?php echo $b['account_number']?>" required>
                            </div> 
                            <div class="form-group">
                              <label for="name" class="col-form-label">Current Balance:</label>
                              <input type="text" class="form-control" name="current_balance" id="current_balance" value="<?php echo $b['current_balance']?>" required>
                            </div>                                                                                                                                                                                             
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Update Bank</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
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
    <!-- page-body-wrapper ends -->
  </div>




                <div class="modal fade" id="add_bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" style="top:-11vh" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">New Bank</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('bank/banks/addBank'); ?>">
                            <div class="form-group">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Branch:</label>
                              <input type="text" class="form-control" name="branch" id="branch" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Branch Code:</label>
                              <input type="text" class="form-control" name="branch_code" id="branch_code" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Account Title:</label>
                              <input type="text" class="form-control" name="account_title" id="account_title" required>
                            </div>
                            <div class="form-group">
                            <label for="name" class="col-form-label">Account Type:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="account_type" id="account_type" required>
                              <option value="">Select Account Type</option>
                              <option value="Savings">Savings Account</option>
                              <option value="Current">Current Account</option>
                              </select>
                            </div> 
                            <div class="form-group">
                              <label for="name" class="col-form-label">Account Number:</label>
                              <input type="text" class="form-control" name="account_number" id="account_number" required>
                            </div>  
                            <div class="form-group">
                              <label for="name" class="col-form-label">Current Balance:</label>
                              <input type="text" class="form-control" name="current_balance" id="current_balance" required>
                            </div>                                                                                                                                                                                             
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add Bank</button>
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


  
  