<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url(); ?>chromaTemplate/vendors/icheck/skins/all.css">
<?php $this->load->view('template/header.php'); ?>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php $this->load->view('template/dash_h_n1.php'); ?>
      
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="template-demo">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-custom bg-inverse-primary">
                <li class="breadcrumb-item" ><a href='#'>Profile</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Manage Profile</span></li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-12 table-responsive">

            <?php if($this->session->flashdata('status') == 'success' || $this->session->flashdata('status') == 'fail') {
                
                if($this->session->flashdata('status') == 'success'){
                    $color='green';
                }else{                    
                    $color='red';
                }
             
              echo "<b style='color:".$color."'>".$this->session->flashdata('message')."</b>";
              echo "<br><br>";  
            }?>
 
              <div class="card">
                <div class="card-body">
                    <form method="post" action="#" onsubmit="return validateForm();">
                        <?php
                        // echo '<pre>';print_r($user);echo '</pre>';
                        ?>
                        <div class="row">
                          <div class="form-group col-sm-6 col-md-6">
                            <label for="name" class="col-form-label">User Name:</label>
                            <input type="text" class="form-control" minlength="2" maxlength="50" name="username" id="username" value="<?=$user[0]['username']?>" required="">
                          </div>
                        </div>
                        <div class="row">

                          <div class="form-group col-sm-6 col-md-6">
                            <label for="name" class="col-form-label">First Name:</label>
                            <input type="text" class="form-control" minlength="2" maxlength="50" name="first_name" id="first_name" value="<?=$user[0]['first_name']?>" required="">
                          </div>
                          <div class="form-group col-sm-6 col-md-6">
                            <label for="name" class="col-form-label">Last Name :</label>
                            <input type="text" class="form-control" minlength="2" maxlength="50" name="last_name" id="last_name" value="<?=$user[0]['last_name']?>" required="">
                          </div>

                          <div class="form-group col-sm-6 col-md-6">
                            <label for="name" class="col-form-label">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" required="" value="<?=$user[0]['email']?>">
                          </div>

                          <div class="form-group col-sm-6 col-md-6">
                            <label for="name" class="col-form-label">Mobile:</label>
                            <input type="text" class="form-control" pattern="[789][0-9]{9}" name="mobile" id="mobile" required="" value="<?=$user[0]['mobile']?>">
                          </div>

                          <div class="form-group col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                            <a href="<?=base_url()?>" class="btn btn-info" data-dismiss="modal">Cancel</a>
                          </div>
                        </div>                       
                    </form>
                </div>
              </div>

              <div class="card">
                <div class="card-body">
                    <form method="post" action="#" onsubmit="return validateProfilePic();">
                        <div class="row">
                          <div class="form-group col-sm-6 col-md-6">
                            <label for="name" class="col-form-label">Profile Picture:</label>
                            <input type="file" class="form-control" onchange="readURL(this);" accept=".jpg,.png" name="profile_pic" id="profile_pic" value="" required="">
                            <?php
                            if( $this->session->userdata('profile_pic') == '' ){
                              ?>
                              <img id="blah" src="#" alt="Your Profile Picture" style="width:200px;height:200px;" />
                              <?php
                            }else {
                              ?>
                              <img id="blah" src="<?=base_url().$this->session->userdata('profile_pic')?>" alt="Your Profile Picture" style="width:200px;height:200px;" />
                              <?php
                            }
                            ?>
                            
                          </div>

                          <div class="form-group col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-success">Save</button>
                            <a href="<?=base_url()?>" class="btn btn-info" data-dismiss="modal">Cancel</a>
                          </div>
                        </div>                       
                    </form>
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
                

  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?php echo asset_url(); ?>chromaTemplate//vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/off-canvas.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/hoverable-collapse.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/misc.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/settings.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php echo asset_url(); ?>chromaTemplate//js/data-table.js"></script>
  <!-- End custom js for this page-->
  <script src="<?php echo asset_url(); ?>chromaTemplate/js/select2.js"></script>
  <script src="<?php echo asset_url(); ?>chromaTemplate/js/iCheck.js"></script>
    <script>
    function validateForm(){
        var username = $.trim($('#username').val());
        if( username == '' ){
          alert('Enter username');
          return false;
        }

        var first_name = $.trim($('#first_name').val());
        if( first_name == '' ){
          alert('Enter first name');
          return false;
        }
        
        var last_name = $.trim($('#last_name').val());
        if( last_name == '' ){
          alert('Enter last name');
          return false;
        }

        var email = $.trim($('#email').val());
        if( email == '' ){
          alert('Enter email');
          return false;
        }

        var mobile = $.trim($('#mobile').val());
        if( mobile == '' ){
          alert('Enter mobile');
          return false;
        }

        var payload = {
          username : username,
          first_name : first_name,
          last_name : last_name,
          email : email,
          mobile : mobile,
        };

        $.ajax({
            url: '<?=base_url("auth/update_profile")?>',
            type: 'POST',
            data: payload,
            cache: false,
            dataType: 'json',
            success : function(result){
              // console.log(result);
              if( result.status == true ){
                alert(result.message);
                window.location.href = "<?=base_url()?>";
              }else{
                alert(result.message);
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
              alert('Something went wrong!!!')
            }
        });
        return false;
    }

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          $('#blah').attr('src', e.target.result).width(200).height(200);
        };
        let size = (input.files[0].size/1024) / 1024;
        // console.log("File Size : ",input.files[0]);
        // console.log("Size : ",size);
        if( size > 2 ){
          alert("Please select image within 2MB");
          $('#profile_pic').val(null);
        }else{ 
          reader.readAsDataURL(input.files[0]);
        }
        
      }
    }

    function validateProfilePic(){
        var profile_pic = $.trim($('#profile_pic').val());
        if( profile_pic == '' ){
          alert('Select Profile Pic');
          return false;
        }

        var file_data = $('#profile_pic').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        // console.log(form_data);
        $.ajax({
          url: '<?=base_url("auth/update_profile_pic")?>',
          type: 'POST',
          data: form_data,
          processData: false,  // tell jQuery not to process the data
          contentType: false,
          dataType: 'json',
          success : function(result){
            // console.log(result);
            if( result.status == true ){
              alert(result.message);
              window.location.href = "<?=base_url('auth/profile')?>";
            }else{
              alert(result.message);
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            alert('Something went wrong!!!')
          }
        });
        return false;
    }

    </script>
</body>

</html>


  
  