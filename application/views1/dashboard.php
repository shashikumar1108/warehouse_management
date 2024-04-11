<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('template/header.php'); ?>

<body>
  <div class="container-scroller" >
    <!-- partial:partials/_navbar.html -->
    <?php $this->load->view('template/dash_h_n.php'); ?>
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
                        <h5>Total Warehouse</h5>                        
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
                        <p class="text-muted"><?php echo $total_warehouses; ?></p>
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
                        <h5>Total Suppliers</h5>                        
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
                        <p class="text-muted"><?php echo $total_suppliers; ?></p>
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
                        <h5>Total Shops</h5>                        
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
                        <p class="text-muted"><?php echo $total_shops; ?></p>
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
                        <h5>Total Products</h5>                        
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
                        <p class="text-muted"><?php echo $total_products; ?></p>
                      </div>                     
                    </div>
                  </div>
                </div>
              </div>

            </br>

              <div class="row">  
                <div class="col-12 col-sm-6 col-md-3">
                  <div class="card" style="border:2px solid dodgerblue; border-radius:3%">
                    <div class=""> <br>
                      <div class="justify-content-between pb-2" style="text-align:center;">                       
                        <i class="icon-docs"></i>
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center;">
                        <h5>Total Brands</h5>                        
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
                        <p class="text-muted"><?php echo $total_brands; ?></p>
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
                        <h5>Total Categories</h5>                        
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
                        <p class="text-muted"><?php echo $total_categories; ?></p>
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
                        <h5>Total Agents</h5>                        
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
                        <p class="text-muted"><?php echo $total_agents; ?></p>
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
                        <h5>Total Supplier Users</h5>                        
                      </div>
                      <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
                        <p class="text-muted"><?php echo $total_supplier_users; ?></p>
                      </div>                     
                    </div>
                  </div>
                </div>                                                
              </div>

              </br>

<div class="row">  
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card" style="border:2px solid dodgerblue; border-radius:3%">
      <div class=""> <br>
        <div class="justify-content-between pb-2" style="text-align:center;">                       
          <i class="icon-docs"></i>
        </div>
        <div class="justify-content-between pb-2" style="text-align:center;">
          <h5>Total State Codes</h5>                        
        </div>
        <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
          <p class="text-muted"><?php echo $total_state_codes; ?></p>
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
          <h5>Total Accounts</h5>                        
        </div>
        <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
          <p class="text-muted"><?php echo $total_accountants; ?></p>
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
          <h5>Total Sales Manager</h5>                        
        </div>
        <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
          <p class="text-muted"><?php echo $total_sales_managers; ?></p>
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
          <h5>Total Pending Orders</h5>                        
        </div>
        <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
          <p class="text-muted">105</p>
        </div>                     
      </div>
    </div>
  </div>
                                                 
</div>

<br />
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card" style="border:2px solid dodgerblue; border-radius:3%">
      <div class=""> <br>
        <div class="justify-content-between pb-2" style="text-align:center;">                       
          <i class="icon-docs"></i>
        </div>
        <div class="justify-content-between pb-2" style="text-align:center;">
          <h5>Total Batches</h5>                        
        </div>
        <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
          <p class="text-muted"><?php echo $total_batches; ?></p>
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
          <h5>Total Business</h5>                        
        </div>
        <div class="justify-content-between pb-2" style="text-align:center; font-weight:bold">                        
          <p class="text-muted">INR: 21,49,70,497</p>
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