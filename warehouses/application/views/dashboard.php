<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('template/header.php'); ?>

<body>
  <div class="container-scroller" >
    <!-- partial:partials/_navbar.html -->
    <?php 
    $this->load->view('template/dash_h_n.php');
    ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row mb-4">
            <div class="col-12 d-flex align-items-center justify-content-between">
              <h4 class="page-title">Dashboard</h4>
              <div class="d-flex align-items-center">
                <div class="wrapper mr-4 d-none d-sm-block">
                  <!-- <p class="mb-0">Summary for
                    <b class="mb-0">September 2017</b>
                  </p> -->
                </div>
                <div class="wrapper">
                  <!-- <a href="<?php echo base_url(); ?>chromaTemplate/#" class="btn btn-link btn-sm font-weight-bold">
                    <i class="icon-share-alt"></i>Export CSV</a> -->
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 card-statistics">
              <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                  <div class="card" style="border:2px solid dodgerblue; border-radius:3%">
                    <div class=""> <br>
                      <div class="justify-content-between pb-2" style="text-align:center;">                       
                        <i class="icon-docs"></i>
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center;">
                        <h5>Pending Quotations</h5>                        
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
                        <p class="text-muted"><?php echo $pending_quotation; ?></p>
                      </div>                     
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                  <div class="card" style="border:2px solid dodgerblue; border-radius:3%">
                    <div class=""> <br>
                      <div class="justify-content-between pb-2" style="text-align:center;">                       
                        <i class="icon-docs"></i>
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center;">
                        <h5>Approved Quotations</h5>                        
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
                        <p class="text-muted"><?php echo $approved_quotation; ?></p>
                      </div>                     
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                  <div class="card" style="border:2px solid dodgerblue; border-radius:3%">
                    <div class=""> <br>
                      <div class="justify-content-between pb-2" style="text-align:center;">                       
                        <i class="icon-docs"></i>
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center;">
                        <h5>Confirmed Quotations</h5>                        
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
                        <p class="text-muted"><?php echo $confirmed_quotation; ?></p>
                      </div>                     
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                  <div class="card" style="border:2px solid dodgerblue; border-radius:3%">
                    <div class=""> <br>
                      <div class="justify-content-between pb-2" style="text-align:center;">                       
                        <i class="icon-docs"></i>
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center;">
                        <h5>Track Shipments</h5>                        
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
                        <p class="text-muted"><?php echo $shipments; ?></p>
                      </div>                     
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php $this->load->view('template/dash_f.php'); ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

</body>
    <?php $this->load->view('template/footer.php'); ?>
</html>