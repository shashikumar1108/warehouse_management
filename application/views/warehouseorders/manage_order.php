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
 
            

              <span class="card-title">Order Details</span>
              <span>
                </span> <br><br><br>
              <div class="row">
                <table class="table table-bordered ">
                    <tr>
                        <td>ORDER ID</td><th><?php echo $data[0]['order_id'] ?></th>
                    </tr>
                    <tr>
                        <td>USER NAME</td><th><?php echo $data[0]['user_name'][0]['first_name'] ?></th>
                    </tr>
                    <tr>
                        <td>SHOP NAME</td><th><?php echo $data[0]['shop_name'][0]['name'] ?></th>
                    </tr>
                    <tr>
                        <td>DATE</td><th><?php echo $data[0]['date'] ?></th>
                    </tr>
                    <tr>
                        <td>DATE</td><th><?php echo $data[0]['order_id'] ?></th>
                    </tr>
                    <tr>
                        <td>PRODUCTS</td>
                        <th>
                        <?php 
                            foreach($data[0]['products'] as $k=>$p){    ?>
                              <button class="btn btn-primary"><?php echo $p['name'].' - '.$data[0]['quantities'][$k] ?></button> <br><br>
              <?php    }
                        ?>
                        </th>                       
                    </tr>                    
                </table>

                 
                 <?php 
                 
                 /* $warehouse_id = $this->db->select('warehouse_id')
                                ->from('user_warehouse_relationship')
                                ->where('user_id', $this->session->userdata['id'])
                                ->get()
                                ->result_array(); */
                 
                 echo "<pre>";
                 //echo $warehouse_id[0]['warehouse_id'];

                 $db2 = $this->load->database('database2', TRUE);
                 ?>
                <form action="<?php echo base_url('WarehouseOrders/assignToShop') ?>" method="POST">
                <input type="hidden" name="warehouse_id" value="<?php echo $warehouse_id ?>">
                <input type="hidden" name="shop_order_id" value="<?php echo $shop_order_id ?>">
                <input type="hidden" name="shop_id" value="<?php echo $shop_id ?>">
                 <table class="table table-bordered">
                 <tr>
                        <th>Product Name</th>
                        <th>Batch ID</th>
                        <th>Product Code</th>
                        <th>Available Quantity</th>
                        <th>Assign Quantity</th>
                      </tr>
                
                 <?php              
                 foreach($data[0]['products'] as $k=>$p){
                  $batches = $db2->select('*')->from('warehouse_batches')->where(array('product_id'=>$p['id'], 'warehouse_id'=>$warehouse_id))->get()->result_array();
                    foreach($batches as $b){ ?>
                      <!-- print_r($b); -->
                      <input type="hidden" name="product_id[]" value="<?php echo $p['id'] ?>">
                      <input type="hidden" name="batch_id[]" value="<?php echo $b['batch_id'] ?>">
                      <tr>
                        <td><?php echo $p['name']; ?></td>
                        <td><?php echo $b['batch_id']; ?></td>
                        <td><?php echo $b['product_code']; ?></td>
                        <td><?php echo $b['quantity']; ?></td>
                        <td><input class="form-control" type="number" name="quantity[]" value="0" min="0" max="<?php echo $b['quantity']?>"></td>
                      </tr>

                   <?php }

                 }

                 ?>
                 
                 
                 </table>
                 <input class="btn btn-success" style="float:right" type="submit" value="Assign">
                 </form>

                 
                 


                <table>
                

                
                </table>             


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

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "input" ).checkboxradio();
  } );
  </script>



</body>

</html>


  
  