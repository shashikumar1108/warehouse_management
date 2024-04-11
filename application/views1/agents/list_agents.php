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

            <?php if($this->session->flashdata('status') == 'success' || $this->session->flashdata('status') == 'fail') {
                
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

       
            
            <?php 
            
            $warehouses = $this->db->select('id, name')->from('warehouse')->where('delete_status',0)->get()->result_array();

            ?>

              <span class="card-title">Agents</span>
              <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_agent" data-whatever="@getbootstrap">Add Agent</button>
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>
                        <th>User Name</th>
                        <th>Email</th>                        
                        <th>Mobile</th>
                        <th>State Code</th>
                        <th>GST</th>
                        <th>Full Name</th>                        
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;
                        foreach($agents as $a){ $i++; ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>agents/delete?id=<?php echo $a['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_agent_<?php echo $a['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                
                                <button class="btn btn-outline-success" data-toggle="modal" data-target="#assign_user_<?php echo $a['id']; ?>" data-whatever="@getbootstrap">Assign</button>                                                                
                                </td>
                                <td><?php echo $a['username'] ?></td>
                                <td><?php echo $a['email'] ?></td>
                                <td><?php echo $a['mobile'] ?></td>
                                <td><?php echo $a['state_code'] ?></td>
                                <td><?php echo $a['gst'] ?></td>
                                <td><?php echo $a['first_name'].' '.$a['last_name'] ?></td>                                                       
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




                <div class="modal fade" id="add_agent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">New Agent</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('agents/addAgent'); ?>">                            
                            <div class="form-group">
                              <label for="name" class="col-form-label">Email:</label>
                              <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Mobile:</label>
                              <input type="text" class="form-control" pattern="[789][0-9]{9}" name="mobile" id="mobile" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Commision Percentage:</label>
                              <input type="number" class="form-control" name="commision" id="commision" required>
                            </div>
                                                          
                            <?php $state_codes = $this->db->select('*')
                            ->from('state_code')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">State Code:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="state_code" id="state_code" required>
                              <option value="">Select State Code</option>
                              <?php foreach($state_codes as $sc){ ?>
                                <option value="<?php echo $sc['state_code']?>" ><?php echo $sc['state_code'].' - '.$sc['state_name']?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div> 

                            <div class="form-group">
                              <label for="name" class="col-form-label">GST Number:</label>
                              <input type="text" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}[A-Z]{1}[0-9]{1}" class="form-control" name="gst" id="gst"  required>
                            </div>     
                                                                                  
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add Agent</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php 
                foreach($agents as $a){ ?>            
                  <div class="modal fade" id="edit_agent_<?php echo $a['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Update Agent</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('agents/editAgent'); ?>">
                            <input type="hidden" name="id" id="id" value="<?php echo $a['id']; ?>" />
                            <div class="form-group">
                              <label for="name" class="col-form-label">Email:</label>
                              <input type="email" class="form-control" name="email" id="email" value="<?php echo $a['email'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Mobile:</label>
                              <input type="text" class="form-control" pattern="[789][0-9]{9}" name="mobile" id="mobile" value="<?php echo $a['mobile'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label for="name" class="col-form-label">Commision Percentage:</label>
                              <input type="number" class="form-control" name="commision" id="commision" value="<?php echo $a['commision'] ?>" required>
                            </div>
                                                          
                            <?php $state_codes = $this->db->select('*')
                            ->from('state_code')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">State Code:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="state_code" id="state_code" required>
                              <option value="">Select State Code</option>
                              <?php foreach($state_codes as $sc){ ?>
                                <option value="<?php echo $sc['state_code']?>" <?php if($sc['state_code']==$a['state_code']){echo "selected";} ?>><?php echo $sc['state_code'].' - '.$sc['state_name']?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div> 

                            <div class="form-group">
                              <label for="name" class="col-form-label">GST Number:</label>
                              <input type="text" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}[A-Z]{1}[0-9]{1}" class="form-control" name="gst" id="gst" value="<?php echo $a['gst'] ?>" required>
                            </div>     
                                                                                  
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add Agent</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>


                  <div class="modal fade" id="assign_user_<?php echo $a['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Assign User</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('users/assignUserWarehouse'); ?>">
                            <input type="hidden" name="id" id="id" value="<?php echo $a['id']; ?>" />
                            <input type="hidden" name="usertype" id="usertype" value="<?php echo $a['usertype']; ?>" />
                            
                            <div class="form-group">
                              <label for="name" class="col-form-label">User Name:</label>
                              <input type="text" class="form-control" name="full_name" id="first_name" value="<?php echo $a['first_name'].' '.$a['last_name']; ?>" readonly required>
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


  
  