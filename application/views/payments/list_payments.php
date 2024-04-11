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
 
            

              <span class="card-title">Payments</span>
              <span>
                  <button style="display:none" type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_brand" data-whatever="@getbootstrap">Add Brand</button>
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Payment Entity</th>
                        <th>Entity Name</th>
                        <th>Invoice ID</th>
                        <th>Amount</th>
                        <th>Payment Type</th>  
                        <th>Date</th>                                             
                      </tr>
                    </thead>
                    <tbody>

                   
                            <tr>
                                <td>1</td>                                
                                 <td style="color:dodgerblue">Warehouse</td>
                                 <td>SLN</td>
                                 <td>W/21/001</td> 
                                 <td>25000</td> 
                                 <td>Online</td> 
                                 <td>01-03-2020</td>                                                                                                                
                            </tr>
                            <tr>
                                <td>2</td>                                
                                 <td style="color:green">Supplier</td>
                                 <td>TGR Goods</td>
                                 <td>S/25/002</td> 
                                 <td>130500</td> 
                                 <td>Cheque</td>   
                                 <td>05-03-2020</td>                                                                                                              
                            </tr>
                            <tr>
                                <td>3</td>                                
                                 <td style="color:green">Supplier</td>
                                 <td>PNB Industry</td>
                                 <td>S/14/001</td> 
                                 <td>95000</td> 
                                 <td>DD</td>      
                                 <td>21-03-2020</td>                                                                                                           
                            </tr>
                            <tr>
                                <td>4</td>                                
                                 <td style="color:dodgerblue">Warehouse</td>
                                 <td>Saptha Enterprises</td>
                                 <td>W/28/125</td> 
                                 <td>47000</td> 
                                 <td>Online</td>  
                                 <td>07-04-2020</td>                                                                                                               
                            </tr>
                            <tr>
                                <td>5</td>                                
                                 <td style="color:dodgerblue">Warehouse</td>
                                 <td>SVR & sons</td>
                                 <td>W/21/146</td> 
                                 <td>63000</td> 
                                 <td>DD</td> 
                                 <td>14-04-2020</td>                                                                                                                
                            </tr>
                            <tr>
                                <td>6</td>                                
                                 <td style="color:green">Supplier</td>
                                 <td>Fortune</td>
                                 <td>S/21/001</td> 
                                 <td>35000</td> 
                                 <td>Cash</td>   
                                 <td>28-04-2020</td>                                                                                                              
                            </tr>


                  
                 

                
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




                <div class="modal fade" id="add_brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">New Brand</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('brand/addBrand'); ?>">
                            <div class="form-group">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" required>
                            </div>                                                                                                                                                                   
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add Brand</button>
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


  
  