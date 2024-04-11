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

              <span class="card-title">Batches</span>
              <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_batch" data-whatever="@getbootstrap">Add Batch</button>
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>
                        <th>Name</th>
                        <th>Supplier</th>
                        <th>Quantity</th>
                        <th>Brand</th>
                        <th>Category</th>                        
                        <th>Batch ID</th>
                        <th>Product Code</th> 
                        <th>Wholesale price</th>
                        <th>Retail price per product</th>
                        <th>CGST</th>
                        <th>SGST</th>
                        <th>IGST</th>
                        <th>CGST value</th>
                        <th>SGST value</th>
                        <th>ISGT value</th>
                        <th>Total tax</th>
                        <th>Tax type</th>
                        <th>Total</th>
                        <th>Expiry date</th>                                                                   
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;                    
                        foreach($batches as $b){ $i++;                         
                        
                        ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>products/deleteBatch?id=<?php echo $b['id'] ?>">Delete</a></label>
                                <!-- <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_batch_<?php echo $b['id']; ?>" data-whatever="@getbootstrap">Edit</button> -->
                                <label class="badge badge-warning"><a href="<?php echo base_url(); ?>products/editBatchView?id=<?php echo $b['id'] ?>">Edit</a></label>
                                <!-- <label class="badge badge-success"><a href="<?php echo base_url(); ?>products/batches?id=<?php echo $b['id'] ?>">Batches</a></label>
                                 --></td>
                                <td><?php echo $b['product_name'] ?></td>
                                <td><?php echo $b['supplier_name'][0]['name'] ?></td>
                                <td><?php echo $b['quantity'] ?></td>
                                <td><?php echo $b['brand_name'] ?></td>
                                <td><?php echo $b['category_name'] ?></td>
                                <td><?php echo $b['batch_id'] ?></td>
                                <td><?php echo $b['product_code'] ?></td> 
                                <td><?php echo $b['wholesale_price'] ?></td>
                                <td><?php echo $b['retail_price_per_product'] ?></td>
                                <td><?php echo $b['cgst'] ?></td>                                                                                                                                                    
                                <td><?php echo $b['sgst'] ?></td>
                                <td><?php echo $b['igst'] ?></td>
                                <td><?php echo $b['cgst_tax'] ?></td>
                                <td><?php echo $b['sgst_tax'] ?></td>
                                <td><?php echo $b['igst_tax'] ?></td>
                                <td><?php echo $b['total_tax'] ?></td>
                                <td><?php echo $b['tax_type'] ?></td>
                                <td><?php echo $b['total'] ?></td>
                                <td><?php echo $b['expiry_date'] ?></td>
                            </tr>

                <!-- <div class="modal fade" id="edit_batch_<?php echo $b['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="width:70%; left:9vw" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Edit Batch</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('products/editBatch'); ?>">
                            <div class="row">
                            <input type="hidden" name="id" value="<?php echo $b['id'] ?>" />
                                <input type="hidden" name="product_id" value="<?php echo $b['product_id'] ?>" />
                            <?php $product_name = $this->db->select('name')->from('products')->where('id', $b['product_id'])->get()->result_array(); ?>           
                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" readonly="false" value="<?php echo $product_name[0]['name'] ?>" required>
                            </div>

                            <?php $brand_name = $this->db->select('b.id, b.name')->from('brand b')->join('products p', 'p.brand = b.id')->where('p.id', $b['product_id'])->get()->result_array(); ?>           
                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Brand:</label>
                              <input type="text" class="form-control" name="brand" id="brand" readonly="false" value="<?php echo $brand_name[0]['name'] ?>" required>
                            </div>

                            <?php $category_name = $this->db->select('c.id,c.name')->from('category c')->join('products p', 'p.category = c.id')->where('p.id', $b['product_id'])->get()->result_array(); ?>           
                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Category:</label>
                              <input type="text" class="form-control" name="category" id="category" readonly="false" value="<?php echo $category_name[0]['name'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Batch ID:</label>
                              <input type="text" class="form-control" name="batch_id" id="batch_id" value="<?php echo $b['batch_id'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Product Code:</label>
                              <input type="text" class="form-control" name="product_code" id="product_code" value="<?php echo $b['product_code'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Wholesale Price:</label>
                              <input type="number" class="form-control" name="wholesale_price" id="wholesale_price" min="0" value="<?php echo $b['wholesale_price'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Retail price per product:</label>
                              <input type="number" class="form-control" name="retail_price_per_product" id="retail_price_per_product" min="0" value="<?php echo $b['retail_price_per_product'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                            <label for="name" class="col-form-label">Tax type:</label><br>
                              <select onchange="updateValues()" class="form-control js-example-basic-single w-100%" style="width:100%" name="tax_type" id="tax_type" value="<?php echo $b['expiry_date'] ?>" required>                                                                
                                <option value="0" selected>Exclusive</option> 
                                <option value="1">Inclusive</option>                            
                              </select>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Expiry Date:</label>
                              <input type="date" class="form-control" name="expiry_date" id="expiry_date" value="<?php echo $b['expiry_date'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">CGST:</label>
                              <input type="number" onchange="updateValues()" class="form-control" min="0" max="9" name="cgst" id="cgst" value="<?php echo $b['cgst'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">SGST:</label>
                              <input type="number" onchange="updateValues()" class="form-control" min="0" max="9" name="sgst" id="sgst" value="<?php echo $b['sgst'] ?>" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">IGST:</label>
                              <input type="number" onchange="updateValues()" class="form-control" name="igst" id="igst" value="<?php echo $b['igst'] ?>"  required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">CGST Tax:</label>
                              <input type="number" class="form-control" name="cgst_tax" id="cgst_tax" value="<?php echo $b['cgst_tax'] ?>" readonly required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">SGST Tax:</label>
                              <input type="number" class="form-control" name="sgst_tax" id="sgst_tax" value="<?php echo $b['sgst_tax'] ?>" readonly required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">IGST Tax:</label>
                              <input type="number" class="form-control" min="0" max="18" name="igst_tax" id="igst_tax" value="<?php echo $b['igst_tax'] ?>" readonly required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Total Tax:</label>
                              <input type="number" class="form-control" name="total_tax" id="total_tax" min="0" value="<?php echo $b['total_tax'] ?>" readonly required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Total:</label>
                              <input type="number" class="form-control" name="total" id="total" min="0" value="<?php echo $b['total'] ?>" readonly required>
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
 -->










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
    <!-- page-body-wrapper ends --><!-- Modal starts -->
                  
                  <div class="modal fade" id="add_batch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="width:80%; left:8vw; top:-5vh" role="document">
                      <div class="modal-content" style="border:5px solid dodgerblue">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add Batch</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('products/addBatch'); ?>">
                            <div class="row">
                                <input type="hidden" name="product_id" value="<?php echo $product_id ?>" />
                            <?php $product_name = $this->db->select('name')->from('products')->where('id', $product_id)->get()->result_array(); ?>           
                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" readonly="false" value="<?php echo $product_name[0]['name'] ?>" required>
                            </div>

                            <?php $brand_name = $this->db->select('b.id, b.name')->from('brand b')->join('products p', 'p.brand = b.id')->where('p.id', $product_id)->get()->result_array(); ?>           
                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Brand:</label>
                              <input type="text" class="form-control" name="brand" id="brand" readonly="false" value="<?php echo $brand_name[0]['name'] ?>" required>
                            </div>

                            <?php $category_name = $this->db->select('c.id,c.name')->from('category c')->join('products p', 'p.category = c.id')->where('p.id', $product_id)->get()->result_array(); ?>           
                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Category:</label>
                              <input type="text" class="form-control" name="category" id="category" readonly="false" value="<?php echo $category_name[0]['name'] ?>" required>
                            </div>

                            <?php
                            $suppliers = $this->db->select('u.id, s.name')
                                        ->from('users u')
                                        ->join('user_supplier_relationship us', 'us.user_id = u.id')
                                        ->join('suppliers s', 's.id = us.supplier_id')
                                        ->where('u.usertype',5)
                                        ->get()
                                        ->result_array();
                            
                            
                                     //   print_r($suppliers);
                           // exit();            
                            
                            ?>

                            <div class="form-group col-md-4 col-lg-4">
                            <label for="name" class="col-form-label">Supplier:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="supplier_id" id="supplier_id" required>
                              <option value="">Select Supplier</option>
                              <?php foreach($suppliers as $s){ ?>
                                <option value="<?php echo $s['id']?>" ><?php echo $s['name'] ?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div>


                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Batch ID:</label>
                              <input type="text" class="form-control" name="batch_id" id="batch_id" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Product Code:</label>
                              <input type="text" class="form-control" name="product_code" id="product_code" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Wholesale Price:</label>
                              <input type="number" class="form-control" name="wholesale_price" id="wholesale_price" min="0" value="0" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Retail price per product:</label>
                              <input type="number" class="form-control" name="retail_price_per_product" id="retail_price_per_product" min="0" value="0" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                            <label for="name" class="col-form-label">Tax type:</label><br>
                              <select onchange="updateValues()" class="form-control js-example-basic-single w-100%" style="width:100%" name="tax_type" id="tax_type" required>                                                                
                                <option value="0" selected>Exclusive</option> 
                                <option value="1">Inclusive</option>                            
                              </select>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Expiry Date:</label>
                              <input type="date" class="form-control" name="expiry_date" id="expiry_date"  required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Quantity:</label>
                              <input type="number" class="form-control" name="quantity" id="quantity" min="0" value="0" required>
                            </div>
                            
                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">CGST:</label>
                              <input type="number" onchange="updateValues()" class="form-control" min="0" max="9" name="cgst" id="cgst" value="0" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">SGST:</label>
                              <input type="number" onchange="updateValues()" class="form-control" min="0" max="9" name="sgst" id="sgst" value="0" required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">IGST:</label>
                              <input type="number" onchange="updateValues()" class="form-control" name="igst" id="igst" value="0"  required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">CGST Tax:</label>
                              <input type="number" class="form-control" name="cgst_tax" id="cgst_tax" value="0" readonly required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">SGST Tax:</label>
                              <input type="number" class="form-control" name="sgst_tax" id="sgst_tax" value="0" readonly required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">IGST Tax:</label>
                              <input type="number" class="form-control" min="0" max="18" name="igst_tax" id="igst_tax" value="0" readonly required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Total Tax:</label>
                              <input type="number" class="form-control" name="total_tax" id="total_tax" min="0" value="0" readonly required>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                              <label for="name" class="col-form-label">Total:</label>
                              <input type="number" class="form-control" name="total" id="total" min="0" value="0" readonly required>
                            </div>


                            </div>                                                                                  
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add Batch</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                        
                      </div>
                    </div>
                  </div>
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
  