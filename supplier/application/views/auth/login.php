<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('template/header'); ?>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper auth p-0 theme-two">
        <div class="row d-flex align-items-stretch">
          <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
            <div class="slide-content bg-1">
            </div>
          </div>
          <div class="col-12 col-md-8 h-100 bg-white" >
            <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">              
            <div class="nav-get-started">
                <p>Don't have an account?</p>
                <a class="btn get-started-btn" href="<?php echo base_url('auth/registration'); ?>" style="border:2px solid dodgerblue">GET STARTED</a>
              </div>
              <form action="<?php echo base_url('auth/verifyLogin'); ?>" method="post" >
                <h3 class="mr-auto">Hello! let's get started</h3>
                <p class="mb-5 mr-auto">Enter your details below.</p>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
                    </div>
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="mdi mdi-lock-outline"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                  </div>
                </div>
                <div class="form-group" style="">
                  <button class="btn btn-primary submit-btn">SIGN IN</button>
                  <?php if(isset($invalid_credentials)){ ?>
                  <span style="float:right; font-weight:bold; color:red">Invalid Credentials</span>
                  <?php } ?>
                </div>               
                <div class="wrapper mt-5 text-gray">
                  <p class="footer-text">Copyright © 2020 PinknBloos. All rights reserved.</p>
                  <ul class="auth-footer text-gray">
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                  </ul>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  
</body>
  <?php $this->load->view('template/footer.php'); ?>
</html>