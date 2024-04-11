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
 
            

              <span class="card-title">Vehicles</span>
              <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add" data-whatever="@getbootstrap">Add</button>
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>
                        <th>Name</th>
                        <th>Vehicle #</th>
                        <th>Vehicle ID</th>
                        <th>Chase #</th>
                        <th>Engine #</th>
                        <th>Date</th>                                               
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;                    
                        foreach($data as $d){ $i++;    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>supply/vehicle/delete?id=<?php echo $d['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_<?php echo $d['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                                                
                                <td><?php echo $d['name'] ?></td>
                                <td><?php echo $d['vehicle_number'] ?></td>
                                <td><?php echo $d['vehicle_id'] ?></td>
                                <td><?php echo $d['chase_number'] ?></td>
                                <td><?php echo $d['engine_number'] ?></td>
                                <td><?php echo $d['date'] ?></td>                                                                                                                 
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
                        <form method="post" action="<?php echo base_url('supply/vehicle/edit'); ?>">
                        <input type="hidden" name="id" value="<?php echo $d['id'] ?>" />
                        <div class="form-group">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" value="<?php echo $d['name'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Vehicle number:</label>
                              <input type="text" class="form-control" name="vehicle_number" id="vehicle_number" value="<?php echo $d['vehicle_number'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Vehicle ID:</label>
                              <input type="text" class="form-control" name="vehicle_id" id="vehicle_id" value="<?php echo $d['vehicle_id'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Chase:</label>
                              <input type="text" class="form-control" name="chase_number" id="chase_number" value="<?php echo $d['chase_number'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Engine:</label>
                              <input type="text" class="form-control" name="engine_number" id="engine_number" value="<?php echo $d['engine_number'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Date:</label>
                              <input type="date" class="form-control" name="date" id="date" value="<?php echo $d['date'] ?>" required>
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




                <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" style="top:-11vh" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">New</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('supply/vehicle/add'); ?>">
                            <div class="form-group">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Vehicle number:</label>
                              <input type="text" class="form-control" name="vehicle_number" id="vehicle_number" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Vehicle ID:</label>
                              <input type="text" class="form-control" name="vehicle_id" id="vehicle_id" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Chase:</label>
                              <input type="text" class="form-control" name="chase_number" id="chase_number" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Engine:</label>
                              <input type="text" class="form-control" name="engine_number" id="engine_number" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Date:</label>
                              <input type="date" class="form-control" name="date" id="date" required>
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


  
  