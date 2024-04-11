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
 
            

              <span class="card-title">Drivers</span>
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
                        <th>Contact</th>
                        <th>License</th>
                        <th>Image</th>
                        <th>Date</th>
                        <th>Reference</th>
                        <th>Address</th>                                               
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;                    
                        foreach($data as $d){ $i++;    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>supply/driver/delete?id=<?php echo $d['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_<?php echo $d['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                                                
                                <td><?php echo $d['name'] ?></td>
                                <td><?php echo $d['contact_number'] ?></td>
                                <td><?php echo $d['license_number'] ?></td>
                                <td><img src="<?php echo base_url(); ?>assets/images/<?php echo $d['image'] ?>" alt="<?php echo $d['name'] ?>"></td>
                                <td><?php echo $d['date'] ?></td>
                                <td><?php echo $d['reference'] ?></td>
                                <td><?php echo $d['address'] ?></td>                                                                                                                 
                            </tr>

                  <div class="modal fade" id="edit_<?php echo $d['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                  <div class="modal-dialog modal-lg" style="width:80%; left:8vw; top:-5vh" role="document">
                      <div class="modal-content" style="border:5px solid dodgerblue">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" id="edit" action="<?php echo base_url('supply/driver/edit'); ?>" enctype="multipart/form-data">
                            <div class="row">
                            <input type="hidden" value="<?php echo $d['id'] ?>" name="id" id="id<?php echo $d['id']; ?>">
                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name<?php echo $d['id']; ?>" value="<?php echo $d['name'] ?>" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Contact:</label>
                              <input type="number" class="form-control" name="contact_number" id="contact_number<?php echo $d['id']; ?>" value="<?php echo $d['contact_number'] ?>" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Licence number:</label>
                              <input type="text" class="form-control" name="license_number" id="license_number<?php echo $d['id']; ?>" value="<?php echo $d['license_number'] ?>" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Reference:</label>
                              <input type="text" class="form-control" name="reference" id="reference<?php echo $d['id']; ?>" value="<?php echo $d['reference'] ?>" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Date:</label>
                              <input type="date" class="form-control" name="date" id="date<?php echo $d['id']; ?>" value="<?php echo $d['date'] ?>" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Image:</label>
                              <input type="file" class="form-control" name="image" id="image<?php echo $d['id']; ?>">
                            </div>

                            <div class="form-group col-md-12 col-lg-12">
                              <label for="name" class="col-form-label">Address:</label>
                              <textarea class="form-control" name="address" id="address<?php echo $d['id']; ?>" cols="30" rows="5" required><?php echo $d['address'] ?></textarea>
                            </div>


                            </div>                                                                                  
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Edit</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
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




  <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="width:80%; left:8vw; top:-5vh" role="document">
                      <div class="modal-content" style="border:5px solid dodgerblue">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" id="add" action="<?php echo base_url('supply/driver/add'); ?>" enctype="multipart/form-data">
                            <div class="row">

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Contact:</label>
                              <input type="number" class="form-control" name="contact_number" id="contact_number" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Licence number:</label>
                              <input type="text" class="form-control" name="license_number" id="license_number" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Reference:</label>
                              <input type="text" class="form-control" name="reference" id="reference" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Date:</label>
                              <input type="date" class="form-control" name="date" id="date" required>
                            </div>

                            <div class="form-group col-md-6 col-lg-6">
                              <label for="name" class="col-form-label">Image:</label>
                              <input type="file" class="form-control" name="image" id="image" required>
                            </div>

                            <div class="form-group col-md-12 col-lg-12">
                              <label for="name" class="col-form-label">Address:</label>
                              <textarea class="form-control" name="address" id="address" cols="30" rows="5" required></textarea>
                            </div>


                            </div>                                                                                  
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <!-- Modal Ends -->

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


  
  