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
 
            

              <span class="card-title">Create Order</span>
              <span>
                </span> <br><br><br>
              <div class="row">
              <form method="post" action="<?php echo base_url('ShopOrders/add'); ?>">                        
                       
                        <?php
                        
                        $user_id = $this->session->userdata['id'];
                        $shop_id = $this->db->select('s.id')
                              ->from('shops s')
                              ->join('user_shop_relationship us', 'us.shop_id = s.id')
                              ->join('users u', 'u.id = us.user_id')
                              ->where('u.id', $user_id)                  
                              ->get()
                              ->result_array();

                        /* print_r($shop_id);
                        exit(); */      

                        $products = $this->db->select('p.*')
                                    ->from('products p')
                                    ->join('product_shop_relationship ps', 'ps.product_id = p.id')
                                    ->where('ps.shop_id', $shop_id[0]['id'])
                                    ->get()
                                    ->result_array(); 
                                   
                                    /* print_r($products);
                                    exit(); */
                        ?>

                        <input type="hidden" name="user_id" value="<?php echo $user_id?>" />
                        <input type="hidden" name="shop_id" value="<?php echo $shop_id[0]['id']?>" />


                        <!-- <div class="icheck-square">
                        <?php foreach($products as $p){ ?>                          
                            <input tabindex="<?php echo $p['id'] ?>" class="form-inline" type="checkbox" id="square-radio-<?php echo $p['id'] ?>" name="product_id[]" value="<?php echo $p['id'] ?>">
                            <label style="margin-right:25px" for="square-radio-<?php echo $p['id'] ?>"><?php echo $p['name'] ?></label>                          
                        <?php } ?>                        
                        </div> -->

                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>Product Name</th><th>Enter Quantity</th>
                              </tr>
                            </thead>
                            <?php foreach($products as $p){ ?> 
                              <input type="hidden" min=0 value="<?php echo $p['id'] ?>" name="product_id[]" />
                              <tr>                                
                                <td><?php echo $p['name'] ?></td>
                                <td><input type="number" class="form-control" min=0 value="0" name="quantity[]" /></td>
                              </tr>  
                            <?php } ?>
                          </table>



                         <br><br>                                
                             
                                                                                                                                                                                                                         
                        </div>
                        
                          <button type="submit" class="btn btn-success">Create</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        
                        </form>
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


  
  