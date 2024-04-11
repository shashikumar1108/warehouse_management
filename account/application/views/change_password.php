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
                <li class="breadcrumb-item active" aria-current="page"><span>Change Password</span></li>
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
                        // echo '<pre>';print_r($user);
                        ?>
                        <input type="hidden" name="id" id="id" value="<?=$user[0]['id']?>">
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-6">
                                <label for="name" class="col-form-label">New Password:</label>
                                <input type="text" class="form-control" minlength="8" maxlength="10" name="n_password" id="n_password" value="" required="">
                            </div>
                            <div class="form-group col-sm-6 col-md-6">
                                <label for="name" class="col-form-label">Confirm New Password :</label>
                                <input type="text" class="form-control" minlength="8" maxlength="10" name="c_password" id="c_password" value="" required="">
                            </div>

                            <div class="form-group col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-success">Change Password</button>
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
        var npassword = $.trim($('#n_password').val());
        if( npassword == '' ){
            alert('Enter new password');
            return false;
        }

        var cpassword = $.trim($('#c_password').val());
        if( cpassword == '' ){
            alert('Enter confirm password');
            return false;
        }

        if( npassword != cpassword ){
            alert('Password mismatch !!! ');
            return false;
        }

        var payload = {
            npassword : npassword,
            cpassword : cpassword,
        };

        $.ajax({
            url: '<?=base_url("auth/update_password")?>',
            type: 'POST',
            data: payload,
            cache: false,
            dataType: 'json',
            success : function(result){
                // console.log(result);
                if( result.status == true ){
                    alert(result.message);
                    window.location.href = "<?=base_url('auth/logout')?>";
                }else{
                    alert(result.message);
                }
                // var res = JSON.parse(result);
                // console.log(res.data);
                // output = output + '<option value="">Select Sub Category Two</option>';
                // $(res.data).each(function(){
                //     output = output + "<option value="+this.id+">"+this.name+"</option>";
                // });
                
                // $("#add_sub_category_two").html(output);
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


  
  