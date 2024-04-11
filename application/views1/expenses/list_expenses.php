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
 
            

              <span class="card-title">Expenses</span>
              <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_expense" data-whatever="@getbootstrap">Add Expense</button>
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>
                        <th>Expense Category</th> 
                        <th>Amount</th>
                        <th>Notes</th>                                              
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;                    
                        foreach($expenses as $b){ $i++;    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>expense/delete?id=<?php echo $b['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_expense_<?php echo $b['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                                                
                                <td><?php echo $b['expense_category'] ?></td> 
                                <td><?php echo $b['amount'] ?></td>
                                <td><?php echo $b['notes'] ?></td>                                                                                                                
                            </tr>

                  <div class="modal fade" id="edit_expense_<?php echo $b['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Update Expense</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('expense/editExpense'); ?>">
                            <input type="hidden" name="id" id="id" value="<?php echo $b['id']; ?>" />
                            <?php $categories = $this->db->select('*')
                            ->from('expense_category')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">Expense Category:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="category_id" id="category_id" required>
                              <option value="">Select Expense Category</option>
                              <?php foreach($categories as $c){ ?>
                                <option value="<?php echo $c['id']?>" <?php if($b['category_id'] == $c['id']){echo "selected";} ?>><?php echo $c['name'] ?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="name" class="col-form-label">Amount:</label>
                              <input type="number" class="form-control" name="amount" id="amount" value="<?php  echo $b['amount']; ?>" required>
                            </div>

                            <div class="form-group">
                              <label for="address" class="col-form-label">Notes:</label>
                              <textarea class="form-control" name="notes" id="notes" required><?php  echo $b['notes']; ?></textarea>
                            </div>
                                                                          
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Update Expense</button>
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




                <div class="modal fade" id="add_expense" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">New Expense</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('expense/addExpense'); ?>">
                          <?php $categories = $this->db->select('*')
                            ->from('expense_category')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">Expense Category:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="category_id" id="category_id" required>
                              <option value="">Select Expense Category</option>
                              <?php foreach($categories as $c){ ?>
                                <option value="<?php echo $c['id']?>" ><?php echo $c['name'] ?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="name" class="col-form-label">Amount:</label>
                              <input type="number" class="form-control" name="amount" id="amount" required>
                            </div>

                            <div class="form-group">
                              <label for="address" class="col-form-label">Notes:</label>
                              <textarea class="form-control" name="notes" id="notes" required></textarea>
                            </div>


                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add Expense</button>
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


  
  