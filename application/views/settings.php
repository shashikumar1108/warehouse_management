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
 
            
            

              <span class="card-title">Update</span>
              <!-- <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_batch" data-whatever="@getbootstrap">Add Batch</button>
                </span> --> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  
                    

                        <form enctype="multipart/form-data" method="post" action="<?php echo base_url('settings/edit'); ?>">
                            <div class="row">
                            <input type="hidden" name="id" value="<?php echo '1' ?>" />

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name"  value="<?php echo $data[0]['name'] ?>" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Mobile:</label>
                              <input type="number" class="form-control" name="mobile" id="mobile" min="0" value="<?php echo $data[0]['mobile'] ?>" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Email:</label>
                              <input type="email" class="form-control" name="email" id="email" min="0" value="<?php echo $data[0]['email'] ?>" required>
                            </div>
                            

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Currency:</label>
                              <input type="text" class="form-control" name="currency" id="currency" min="0" value="<?php echo $data[0]['currency'] ?>" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Address:</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="5"><?php echo $data[0]['address'] ?></textarea>                                                        
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Description:</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="5"><?php echo $data[0]['description'] ?></textarea>                                                        
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">logo:</label>
                              <img width=150 height=150 alt="logo" src="<?php echo base_url(); ?>assets/images/<?php echo $data[0]['logo'] ?>" alt="">
                              <input type="file" class="form-control" name="logo" id="logo" >
                            </div>

       
                            </div>                                                                                  
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Update</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                        </form>
                      











                   
                     
                    
                
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


  