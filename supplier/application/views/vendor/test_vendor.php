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
    <style type="text/css">
      td, th {
        padding: 5px !important;
      }
    </style>
      
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="template-demo">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-custom bg-inverse-primary">
                <li class="breadcrumb-item"><a href='<?php echo base_url('vendor/new_quotation_list')?>'>Vendor Quote</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>New Quotation Proposal</span></li>
              </ol>
            </nav>
          </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <div class="card">
                <div class="card-body">
                  
                  <form method="post" action="<?php echo base_url('vendor/add_quotation_proposal'); ?>">
                    <div class="row">
                      <input type="hidden" name="quotation_id" value="<?php echo $quotation['quotation_id']; ?>">
                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Ref Number:</label>
                        <input type="text" class="form-control" name="ref_number" value="<?php echo $quotation['ref_number']; ?>" readonly>
                      </div>

                      <!-- <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Approval Status:</label><br>
                        <input type="text" class="form-control" name="approval_status" value="<?php echo $quotation['approval_status']; ?>" readonly>
                      </div> -->

                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Warehouse:</label><br>
                        <input type="text" class="form-control" name="warehouse" value="<?php echo $quotation['warehouse_name']; ?>" readonly>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <?php $brand = $this->db->select('name')->from('brand')->where('id',$quotation['brand_id'])->get()->row_array(); 
                        $brand_name = $brand['name'];
                        ?>
                        <label class="col-form-label">Brand:</label><br>
                        <input type="text" class="form-control" name="sub_categories_two" value="<?php echo $brand_name; ?>" readonly>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label for="address" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" readonly><?php echo $quotation['description']?></textarea>
                      </div>

                      

                      <div class="form-group col-md-12 col-lg-12">
                        <table class="table table-bordered" id="tableID" style="width: 100%">
                          <?php $product_length = count($quotation_products);?>
                          <?php if($product_length>=1) {?>
                            <tr>
                              <td style="width: 20%">
                                <label>Product Name</label>
                              </td>
                              <td style="width: 15%">
                                <label>Category</label>
                              </td>
                              <td style="width: 15%">
                                <label>Sub Category One</label>
                              </td>
                              <td style="width: 10%">
                                <label>Sub Category Two</label>
                              </td>
                              <td style="width: 10%">
                                <label>Quantity</label>
                              </td>
                              <td style="width: 10%">
                                <label>Free Quantity</label>
                              </td>
                              <td style="width: 20%">
                                <label>Select Supplier</label>
                              </td>
                            </tr>
                          <?php } ?>
                          <?php foreach($quotation_products as $row) {?>
                            <tr>
                              <td><input type="text" class="form-control" value="<?php echo $row['product_name']?>" readonly></td>
                              <td><input type="text" class="form-control" value="<?php echo $quotation['category_name']?>" readonly></td>
                              <td><input type="text" class="form-control" value="<?php echo $quotation['sub_categories_one_name']?>" readonly></td>
                              <td><input type="text" class="form-control" value="<?php echo $quotation['sub_categories_two_name']?>" readonly></td>
                              <td><input type="text" class="form-control" value="<?php echo $row['quantity']?>" readonly></td>
                              <td><input type="text" class="form-control" name="free_quantity" autocomplete="off"></td>
                              <td>
                                <select class="form-control js-example-basic-single w-100%" style="width:100%" name="supplier_id" required >
                                  <?php $supplier = $this->db->select('id,name')->from('suppliers')->get()->result_array()?>
                                    <option value="">-- Select Supplier --</option>
                                    <?php
                                    foreach($supplier as $row){ ?>
                                      <option value="<?php echo $row['id'] ?>" ><?php echo $row['name'] ?></option>
                                    <?php } ?>
                                </select>
                              </td>
                            </tr>

                          <?php } ?>
                        </table>
                      </div>

                      <?php foreach($quotation_products as $row) {?>
                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Product Name Price</label>
                        <input type="text" class="form-control" name="product_name" value="<?php echo $row['product_name']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Category</label>
                        <input type="text" class="form-control" value="<?php echo $quotation['category_name']?>" disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Sub Category One</label>
                        <input type="text" class="form-control" value="<?php echo $quotation['sub_categories_one_name']?>" disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Sub Category Two</label>
                        <input type="text" class="form-control" value="<?php echo $quotation['sub_categories_two_name']?>" disabled>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">Quantity</label>
                        <input type="text" class="form-control" name="quantity" id="quantity" value="<?php echo $row['quantity']?>" disabled="">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">Free Qty</label>
                        <input type="text" class="form-control" name="free_quantity" autocomplete="off">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Select Supplier</label>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="supplier_id" required >
                          <?php $supplier = $this->db->select('id,name')->from('suppliers')->get()->result_array()?>
                            <option value="">-- Select Supplier --</option>
                            <?php
                            foreach($supplier as $row){ ?>
                              <option value="<?php echo $row['id'] ?>" ><?php echo $row['name'] ?></option>
                            <?php } ?>
                        </select>
                      <?php } ?>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Wholesale Price</label>
                        <input type="text" class="form-control" name="wholesale_price" id="wholesale_price" onkeyup="calulate_wholesale()" autocomplete="off" required="">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">CGST %:</label>
                        <input type="text" onchange="calulate_wholesale()" class="form-control" name="w_cgst" id="w_cgst" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">CGST Tax:</label>
                        <input type="text" class="form-control" name="w_cgst_tax" id="w_cgst_tax" readonly>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">SGST %:</label>
                        <input type="text" onchange="calulate_wholesale()" class="form-control" name="w_sgst" id="w_sgst" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">SGST Tax:</label>
                        <input type="text" class="form-control" name="w_sgst_tax" id="w_sgst_tax" readonly>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">IGST %:</label>
                        <input type="text" onchange="calulate_wholesale()" class="form-control" name="w_igst" id="w_igst" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">IGST Tax:</label>
                        <input type="text" class="form-control" name="w_igst_tax" id="w_igst_tax" readonly="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Tax type:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="w_tax_type" id="w_tax_type" required onchange="calulate_wholesale()">
                            <option value="0" selected>Exclusive</option> 
                            <option value="1">Inclusive</option>                            
                        </select>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Total WH Price:</label>
                        <input type="text" onchange="calulate_wholesale()" class="form-control" name="total_wholesale_price" id="total_wholesale_price" readonly="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Retail Price:</label>
                        <input type="text" class="form-control" name="retail_price" id="retail_price" onkeyup="calulate_retail()"  required="" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">CGST %:</label>
                        <input type="text" onchange="calulate_retail()" class="form-control" name="r_cgst" id="r_cgst" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">CGST Tax:</label>
                        <input type="text" class="form-control" name="r_cgst_tax" id="r_cgst_tax" readonly>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">SGST %:</label>
                        <input type="text" onchange="calulate_retail()" class="form-control" name="r_sgst" id="r_sgst" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">SGST Tax:</label>
                        <input type="text" class="form-control" name="r_sgst_tax" id="r_sgst_tax" readonly>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">IGST %:</label>
                        <input type="text" onchange="calulate_retail()" class="form-control" name="r_igst" id="r_igst" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">IGST Tax:</label>
                        <input type="text" class="form-control" name="r_igst_tax" id="r_igst_tax"  readonly="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Tax type:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="r_tax_type" id="r_tax_type" required onchange="calulate_retail()">
                            <option value="0" selected>Exclusive</option> 
                            <option value="1">Inclusive</option>                            
                        </select>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Total Retail Price:</label>
                        <input type="text" onchange="calulate_retail()" class="form-control" name="total_retail_price" id="total_retail_price" readonly="">
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Expiry Date:</label>
                        <input type="date" class="form-control" name="expiry_date" required="">
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Delivery Date:</label>
                        <input type="date" class="form-control" name="delivery_date" required="">
                      </div>

                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>

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


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">

  function calulate_wholesale(){
    let wholesale_price = parseInt($('#wholesale_price').val());
    let total_wh_price = 0;
    let total_tax = 0;
    let total = 0;
    let quantity = $('#quantity').val();

    let cgst = parseInt($('#w_cgst').val());
    let sgst = parseInt($('#w_sgst').val());
    let igst = parseInt($('#w_igst').val());

    if(isNaN(wholesale_price)){
      wholesale_price = 0;
    }

    if(isNaN(cgst))
    { 
      cgst = 0;
      cgst_tax = 0;
    }
    if(isNaN(sgst))
    {
      sgst = 0;
      sgst_tax = 0;
    }
    if(isNaN(igst))
    {
      igst = 0;
      igst_tax = 0;
    }

    let tax_type = parseInt($('#w_tax_type').val());

    if(wholesale_price > 0){
      cgst_tax = (wholesale_price/100)*(cgst);
      sgst_tax = (wholesale_price/100)*(sgst);
      igst_tax = (wholesale_price/100)*(igst);

      $('#w_cgst').val(cgst);
      $('#w_sgst').val(sgst);
      $('#w_igst').val(igst);
      $('#w_cgst_tax').val(cgst_tax);
      $('#w_sgst_tax').val(sgst_tax);
      $('#w_igst_tax').val(igst_tax);
    }

    if(tax_type == 1){
      total_tax = parseFloat(cgst_tax + sgst_tax + igst_tax);
    }

    if(wholesale_price > 0){
        total_wh_price = parseFloat(wholesale_price * quantity + total_tax);
    }

    $('#total_wholesale_price').val(total_wh_price);
  }

  function calulate_retail(){
    let retail_price = parseInt($('#retail_price').val());

    let total_rp_price = 0;
    let total_tax = 0;
    let total = 0;
    let quantity = $('#quantity').val();

    let cgst = parseInt($('#r_cgst').val());
    let sgst = parseInt($('#r_sgst').val());
    let igst = parseInt($('#r_igst').val());

    if(isNaN(retail_price)){
      retail_price = 0;
    }

    if(isNaN(cgst))
    { 
      cgst = 0;
      cgst_tax = 0;
    }
    if(isNaN(sgst))
    {
      sgst = 0;
      sgst_tax = 0;
    }
    if(isNaN(igst))
    {
      igst = 0;
      igst_tax = 0;
    }

    let tax_type = parseInt($('#r_tax_type').val());

    if(retail_price > 0){
      cgst_tax = (retail_price/100)*(cgst);
      sgst_tax = (retail_price/100)*(sgst);
      igst_tax = (retail_price/100)*(igst);

      $('#r_cgst').val(cgst);
      $('#r_sgst').val(sgst);
      $('#r_igst').val(igst);
      $('#r_cgst_tax').val(cgst_tax);
      $('#r_sgst_tax').val(sgst_tax);
      $('#r_igst_tax').val(igst_tax);
    }

    if(tax_type == 1){
      total_tax = parseFloat(cgst_tax + sgst_tax + igst_tax);
    }

    if(retail_price > 0){
        total_rp_price = parseFloat(retail_price * quantity + total_tax);
    }

    // console.log(retail_price);
    // console.log(total_rp_price);

    $('#total_retail_price').val(total_rp_price);
  }


</script>
                
                
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
  