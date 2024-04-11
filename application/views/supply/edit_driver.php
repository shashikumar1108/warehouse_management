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
             // echo "hi";
              echo "<b style='color:".$color."'>".$this->session->flashdata('message')."</b>";
              echo "<br><br>";  
            
            }
              
              ?>
 
            
            <?php 
            
            $warehouses = $this->db->select('id, name')->from('warehouse')->where('delete_status',0)->get()->result_array();

            ?>

              <span class="card-title">Edit Batch</span>
              <!-- <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_batch" data-whatever="@getbootstrap">Add Batch</button>
                </span> --> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  
                    

                        <form method="post" action="<?php echo base_url('products/editBatch'); ?>">
                            <div class="row">
                            <input type="hidden" name="id" value="<?php echo $batch_id ?>" />
                                <input type="hidden" name="product_id" value="<?php echo $product_id ?>" />
                            <?php $product_name = $this->db->select('name')->from('products')->where('id', $product_id)->get()->result_array(); ?>           
                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" readonly="false" value="<?php echo $product_name[0]['name'] ?>" required>
                            </div>

                            <?php $batchrand_name = $this->db->select('b.id, b.name')->from('brand b')->join('products p', 'p.brand = b.id')->where('p.id', $product_id)->get()->result_array(); ?>           
                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Brand:</label>
                              <input type="text" class="form-control" name="brand" id="brand" readonly="false" value="<?php echo $batchrand_name[0]['name'] ?>" required>
                            </div>

                            <?php $category_name = $this->db->select('c.id,c.name')->from('category c')->join('products p', 'p.category = c.id')->where('p.id', $product_id)->get()->result_array(); ?>           
                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Category:</label>
                              <input type="text" class="form-control" name="category" id="category" readonly="false" value="<?php echo $category_name[0]['name'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Batch ID:</label>
                              <input type="text" class="form-control" name="batch_id" id="batch_id" value="<?php echo $batch[0]['batch_id'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Product Code:</label>
                              <input type="text" class="form-control" name="product_code" id="product_code" value="<?php echo $batch[0]['product_code'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Wholesale Price:</label>
                              <input type="number" class="form-control" name="wholesale_price" id="wholesale_price" min="0" value="<?php echo $batch[0]['wholesale_price'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Retail price per product:</label>
                              <input type="number" class="form-control" name="retail_price_per_product" id="retail_price_per_product" min="0" value="<?php echo $batch[0]['retail_price_per_product'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                            <label for="name" class="col-form-label">Tax type:</label><br>
                              <select onchange="updateValues()" class="form-control js-example-basic-single w-100%" style="width:100%" name="tax_type" id="tax_type" value="<?php echo $batch[0]['expiry_date'] ?>" required>                                                                
                                <option value="0" selected>Exclusive</option> 
                                <option value="1">Inclusive</option>                            
                              </select>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Expiry Date:</label>
                              <input type="date" class="form-control" name="expiry_date" id="expiry_date" value="<?php echo $batch[0]['expiry_date'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">CGST:</label>
                              <input type="number" onchange="updateValues()" class="form-control" min="0" max="9" name="cgst" id="cgst" value="<?php echo $batch[0]['cgst'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">SGST:</label>
                              <input type="number" onchange="updateValues()" class="form-control" min="0" max="9" name="sgst" id="sgst" value="<?php echo $batch[0]['sgst'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">IGST:</label>
                              <input type="number" onchange="updateValues()" class="form-control" name="igst" id="igst" value="<?php echo $batch[0]['igst'] ?>"  required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">CGST Tax:</label>
                              <input type="number" class="form-control" name="cgst_tax" id="cgst_tax" value="<?php echo $batch[0]['cgst_tax'] ?>" readonly required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">SGST Tax:</label>
                              <input type="number" class="form-control" name="sgst_tax" id="sgst_tax" value="<?php echo $batch[0]['sgst_tax'] ?>" readonly required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">IGST Tax:</label>
                              <input type="number" class="form-control" min="0" max="18" name="igst_tax" id="igst_tax" value="<?php echo $batch[0]['igst_tax'] ?>" readonly required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Total Tax:</label>
                              <input type="number" class="form-control" name="total_tax" id="total_tax" min="0" value="<?php echo $batch[0]['total_tax'] ?>" readonly required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Total:</label>
                              <input type="number" class="form-control" name="total" id="total" min="0" value="<?php echo $batch[0]['total'] ?>" readonly required>
                            </div>


                            </div>                                                                                  
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Update Batch</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </div>
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
    <!-- page-body-wrapper ends --><!-- Modal starts -->
                  
                  
                  <!-- Modal Ends -->
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


  <script>
    $('#wholesale_price').on('keyup', function(){   
         
      let wholesale_price = parseInt($('#wholesale_price').val());
      let total_tax = 0;
      let total = 0;

      let cgst = parseInt($('#cgst').val());
      let sgst = parseInt($('#sgst').val());
      let igst = parseInt($('#igst').val());

      let tax_type = parseInt($('#tax_type').val());

      if(tax_type == 0){        
        cgst_tax = (wholesale_price/100)*(cgst);
        sgst_tax = (wholesale_price/100)*(sgst);
        igst_tax = (wholesale_price/100)*(igst);
        total_tax = parseInt(cgst_tax + sgst_tax + igst_tax);      
        total = parseInt(wholesale_price) + parseInt(total_tax);
      }else{
        cgst_tax = (wholesale_price/(100+(cgst+sgst+igst)))*(cgst); 
        sgst_tax = (wholesale_price/(100+(cgst+sgst+igst)))*(sgst); 
        igst_tax = (wholesale_price/(100+(cgst+sgst+igst)))*(igst); 
        total_tax = parseInt(cgst_tax + sgst_tax + igst_tax);      
        total = parseInt(wholesale_price);
      }
      
      $('#cgst_tax').val(cgst_tax);
      $('#sgst_tax').val(sgst_tax);
      $('#igst_tax').val(igst_tax);

      $('#total_tax').val(total_tax);
      $('#total').val(total);
    })


    function updateValues() { //alert($('#tax_type').val());
      let wholesale_price = parseInt($('#wholesale_price').val());
      let total_tax = 0;
      let total = 0;

      let cgst = parseInt($('#cgst').val());
      let sgst = parseInt($('#sgst').val());
      let igst = parseInt($('#igst').val());

      let tax_type = parseInt($('#tax_type').val());

      if(tax_type == 0){        
        cgst_tax = (wholesale_price/100)*(cgst);
        sgst_tax = (wholesale_price/100)*(sgst);
        igst_tax = (wholesale_price/100)*(igst);
        total_tax = parseInt(cgst_tax + sgst_tax + igst_tax);      
        total = parseInt(wholesale_price) + parseInt(total_tax);
      }else{
        cgst_tax = (wholesale_price/(100+(cgst+sgst+igst)))*(cgst); 
        sgst_tax = (wholesale_price/(100+(cgst+sgst+igst)))*(sgst); 
        igst_tax = (wholesale_price/(100+(cgst+sgst+igst)))*(igst); 
        total_tax = parseInt(cgst_tax + sgst_tax + igst_tax);      
        total = parseInt(wholesale_price);
      }
      
      $('#cgst_tax').val(cgst_tax);
      $('#sgst_tax').val(sgst_tax);
      $('#igst_tax').val(igst_tax);

      $('#total_tax').val(total_tax);
      $('#total').val(total);
    }


  </script>
  