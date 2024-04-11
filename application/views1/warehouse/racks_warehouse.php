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
            

              <span class="card-title">Racks</span>
              <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_rack" data-whatever="@getbootstrap">Add Rack</button>
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>                        
                        <th>Rack number</th>                        
                        <th>Description</th>                        
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;
                        foreach($racks as $r){ $i++; ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>warehouse/deleteRack?id=<?php echo $r['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_rack_<?php echo $r['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                
                                </td>                                
                                <td><?php echo $r['rack_number'] ?></td>                                                                
                                <td><?php echo $r['description'] ?></td>                                                       
                            </tr>



                  <div class="modal fade" id="edit_rack_<?php echo $r['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Edit Rack</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('warehouse/editRack'); ?>">
                          <input type="hidden" name="id" value="<?php echo $r['id'] ?>" />
                          <input type="hidden" name="warehouse_id" value="<?php echo $warehouse_id ?>" />
                            <div class="form-group">
                              <label for="name" class="col-form-label">Rack Number:</label>
                              <input type="text" class="form-control" name="rack_number" id="rack_number" value="<?php echo $r['rack_number'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="address" class="col-form-label">Description:</label>
                              <textarea class="form-control" name="description" id="description"  required><?php echo $r['description'] ?></textarea>
                            </div>
                                                                                 
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Edit Rack</button>
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




                <div class="modal fade" id="add_rack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">New Rack</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('warehouse/addRack'); ?>">
                          <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                            <div class="form-group">
                              <label for="name" class="col-form-label">Rack Number:</label>
                              <input type="text" class="form-control" name="rack_number" id="rack_number" required>
                            </div>
                            <div class="form-group">
                              <label for="address" class="col-form-label">Description:</label>
                              <textarea class="form-control" name="description" id="description" required></textarea>
                            </div>
                                                                                 
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add Rack</button>
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