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
             
              echo "<b style='color:".$color."'>".$this->session->flashdata('message')."</b>";
              echo "<br><br>";  
            
            }
              
              ?>
 
            

              <span class="card-title">Shop Payments</span>
              <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_cash" data-whatever="@getbootstrap">Cash </button>
                  <button type="button" class="btn btn-warning" style="float:right; margin-right:20px" data-toggle="modal" data-target="#add_cheque" data-whatever="@getbootstrap">Cheque </button>
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>                                                
                        <th>Shop</th>
                        <th>Amount</th> 
                        <th>Payment method</th> 
                        <th>Bank</th>
                        <th>Cheque #</th>                                               
                        <th>Description</th>                                              
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;                    
                        foreach($data as $d){ $i++;    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
<!--                                 <label class="badge badge-danger"><a href="<?php echo base_url(); ?>bank/banks/delete?id=<?php echo $d['id'] ?>">Delete</a></label>
 -->                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_<?php echo $d['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                                                
                                <td><?php echo $d['shop_name'] ?></td>
                                <td><?php echo $d['amount'] ?></td>
                                <td><?php echo $d['payment_method'] == 1 ? 'Cash' : 'Cheque' ?></td>                                 
                                <td><?php echo $d['bank_name'] ?></td>                                
                                <td><?php echo $d['cheque_number'] ?></td>                                
                                <td><?php echo $d['description'] ?></td>                                                                                                                 
                            </tr>

                  <div class="modal fade" id="edit_<?php echo $d['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" style="top:-11vh" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Update</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('ShopPayments/edit'); ?>">
                        <input type="hidden" name="id" value="<?php echo $d['id'] ?>" />
                       
                        <div class="form-group">
                              <label for="name" class="col-form-label">Amount:</label>
                              <input type="text" class="form-control" name="amount" id="amount" value="<?php echo $d['amount'] ?>" required>
                            </div>                            

                            <div class="form-group">
                              <label for="address" class="col-form-label">Description:</label>
                              <textarea class="form-control" name="description" id="description" required><?php echo $d['description'] ?></textarea>
                            </div>     
                                                         
                             
                                                                                                                                                                                                                         
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Update</button>
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




                <div class="modal fade" id="add_cash" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" style="top:-6vh" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Cash</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('ShopPayments/add'); ?>">                                                       
                          <input type="hidden" value="1" class="form-control" name="payment_method" id="payment_method" required>
                            
                          <!-- <?php $danks = $this->db->select('*')
                            ->from('banks')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">Banks:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="bank" id="bank" required>
                              <option value="">Select Bank</option>
                              <?php foreach($danks as $d){ ?>
                                <option value="<?php echo $d['id']?>" ><?php echo $d['name'] ?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div> -->


                          <?php $shops = $this->db->select('*')
                            ->from('shops')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">Shops:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="shop_id" id="shop_id" required>
                              <option value="">Select Shop</option>
                              <?php foreach($shops as $s){ ?>
                                <option value="<?php echo $s['id']?>" ><?php echo $s['name'] ?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-form-label">Amount:</label>
                              <input type="text" class="form-control" name="amount" id="amount" required>
                            </div>
                            <!-- <div class="form-group">
                              <label for="name" class="col-form-label">Cheque#:</label>
                              <input type="text" class="form-control" name="cheque_number" id="cheque_number" required>
                            </div> -->
                           
                             

                            <div class="form-group">
                              <label for="address" class="col-form-label">Description:</label>
                              <textarea class="form-control" name="description" id="description" required></textarea>
                            </div>
                                                                                                                                                                                                                        
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>


                  <div class="modal fade" id="add_cheque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" style="top:-6vh" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Cheque</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('ShopPayments/add'); ?>">                                                       
                          <input type="hidden" value="2" class="form-control" name="payment_method" id="payment_method" required>
                            
                          <?php $banks = $this->db->select('*')
                            ->from('banks')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">Banks:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="bank_id" id="bank_id" required>
                              <option value="">Select Bank</option>
                              <?php foreach($banks as $d){ ?>
                                <option value="<?php echo $d['id']?>" ><?php echo $d['name'] ?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div>


                          <?php $shops = $this->db->select('*')
                            ->from('shops')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">Shops:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="shop_id" id="shop_id" required>
                              <option value="">Select Shop</option>
                              <?php foreach($shops as $s){ ?>
                                <option value="<?php echo $s['id']?>" ><?php echo $s['name'] ?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-form-label">Amount:</label>
                              <input type="text" class="form-control" name="amount" id="amount" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Cheque#:</label>
                              <input type="text" class="form-control" name="cheque_number" id="cheque_number" required>
                            </div>
                           
                             

                            <div class="form-group">
                              <label for="address" class="col-form-label">Description:</label>
                              <textarea class="form-control" name="description" id="description" required></textarea>
                            </div>
                                                                                                                                                                                                                        
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add</button>
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


  
  