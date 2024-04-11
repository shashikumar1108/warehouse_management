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
          <div class="row profile-page">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  

            <?php if($this->session->flashdata('profile_update_status') == 'success' || $this->session->flashdata('profile_update_status') == 'fail') {
                
                if($this->session->flashdata('profile_update_status') == 'success'){
                    $color='green';
                }else{                    
                    $color='red';
                }
             // echo "hi";
              echo "<b style='color:".$color."'>".$this->session->flashdata('profile_update_message')."</b>";
              }?>

                  <div class="profile-body pt-0 pt-sm-4">
                    <ul class="nav tab-switch " role="tablist ">
                      <li class="nav-item ">
                        <a class="nav-link active " id="user-profile-info-tab " data-toggle="pill " href="#user-profile-info
                        " role="tab " aria-controls="user-profile-info " aria-selected="true ">Profile</a>
                      </li>
                      <li class="nav-item " style="display:none;">
                        <a class="nav-link " id="user-profile-activity-tab " data-toggle="pill " href="#user-profile-activity
                        " role="tab " aria-controls="user-profile-activity " aria-selected="false ">Activity</a>
                      </li>
                    </ul>
                    <div class="row ">
                      <div class="col-12 col-md-9">
                        <div class="tab-content tab-body " id="profile-log-switch ">
                          <div class="tab-pane fade show active pr-3 " id="user-profile-info " role="tabpanel
                        " aria-labelledby="user-profile-info-tab ">
                           
                           
                            
              <div class="card" style="border:1px solid dodgerblue">
                <div class="card-body">
                  <!-- <h4 class="card-title">Basic form</h4>
                  <p class="card-description">
                    Basic form elements
                  </p> -->
                  <form class="forms-sample" method="post" action="<?php echo base_url('auth/updateProfile'); ?>">
                    <div class="form-group">
                      <label for="exampleInputName1">First Name</label>
                      <input type="text" class="form-control" name="first_name" id="" placeholder="First Name" value="<?php echo $profile[0]['first_name']; ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Last Name</label>
                      <input type="text" class="form-control" name="last_name" id="" placeholder="Last Name" value="<?php echo $profile[0]['last_name']; ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Email address</label>
                      <input type="email" class="form-control" name="email" id="" placeholder="Email" value="<?php echo $profile[0]['email']; ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Mobile Number</label>
                      <input type="text" class="form-control" name="mobile" id="" pattern="[789][0-9]{9}" placeholder="Mobile number" value="<?php echo $profile[0]['mobile']; ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Password <span>(Enter only if you want to change password)</span></label>                      
                      <input type="password" class="form-control" name="password" id="" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Confirm Password <span>(Enter only if you want to change password)</span></label>
                      <input type="password" class="form-control" name="c_password" id="" placeholder="Confirm Password">
                    </div>
                    <!--<div class="form-group">
                      <label>File upload</label>
                      <input type="file" name="img[]" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                    </div> -->
                    <!-- <div class="form-group">
                      <label for="exampleInputCity1">City</label>
                      <input type="text" class="form-control" id="exampleInputCity1" placeholder="Location">
                    </div> -->
                    <!-- <div class="form-group">
                      <label for="exampleTextarea1">Textarea</label>
                      <textarea class="form-control" id="exampleTextarea1" rows="2"></textarea>
                    </div> -->
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
                            
                         
                          
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <?php $this->load->view('template/dash_f.php'); ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  
  <!-- End custom js for this page-->
</body>
<?php $this->load->view('template/footer.php'); ?>
</html>