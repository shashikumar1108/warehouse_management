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
 
            

              <span class="card-title">Shop Orders</span>
              <span>
                  <!-- <a href="<?php echo base_url('ShopOrders/create') ?>" type="button" class="btn btn-warning" style="float:right">Create Order </a> -->
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>    
                        <th>Order ID</th>                                            
                        <th>Shop</th>
                        <th>User</th> 
                        <th>Date and Time</th>   
                        <th>Status</th>                                                                                            
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;                    
                        foreach($data as $d){ $i++;    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
<!--                                 <label class="badge badge-danger"><a href="<?php echo base_url(); ?>bank/banks/delete?id=<?php echo $d['id'] ?>">Delete</a></label>
 -->                            <a href="<?php echo base_url('WarehouseOrders/viewOrderDetails/').$d['id'] ?>" class="btn btn-outline-danger">Details</a>                                                                
                                <td><?php echo $d['order_id'] ?></td>
                                <td><?php echo $d['shop_name'][0]['name'] ?></td>
                                <td><?php echo $d['user_name'][0]['first_name'] ?></td>
                                <td><?php echo $d['date'] ?></td>
                                <?php 
                                  if($d['status'] == 0){ ?>
                                    <td style="color:red">Pending</td>
                                  <?php }elseif($d['status'] == 1){ ?>
                                    <td style="color:dodgerblue">In - Process</td>
                                  <?php }else{ ?>
                                    <td style="color:green">Completed</td>
                                  <?php }                                
                                ?>                                                                                                                                                                                                                                               
                            </tr>

                  

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


  
  