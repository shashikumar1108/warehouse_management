<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="<?php echo asset_url(); ?>chromaTemplate/vendors/icheck/skins/all.css">
<?php $this->load->view('template/header.php'); ?>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php $this->load->view('template/dash_h_n1.php'); ?>
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
                <li class="breadcrumb-item" ><a href='#'>Orders</a></li>
                <li class="breadcrumb-item active"><a href="<?=base_url('vendor/new_quotation_list')?>"><span>Vendor Quote</span></a></li>
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
                      <input type="hidden" name="supplier" id="supplier" value="<?php echo $supplier_details[0]['supplier_id']; ?>">
                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Ref Number:</label>
                        <input type="text" class="form-control" name="ref_number" value="<?php echo $quotation['ref_number']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Warehouse:</label><br>
                        <?php $warehouse = $this->db->select('w.name')->from('warehouse w')
                        ->where(array('w.id' => $quotation['warehouse_id']))->get()->row_array(); ?>
                        <input type="text" class="form-control" name="warehouse" value="<?php echo $warehouse['name']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label for="address" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" disabled><?php echo $quotation['description']?></textarea>
                      </div>
                    </div>

                    <?php $i=1; foreach($quotation_products as $row) {?>
                      <input type="hidden" name="quotation_product_id[]" value="<?php echo $row['qp_id'];?>">

                    <div class="groove row">

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" value="<?php echo $row['product_name']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Category</label>
                        <input type="text" class="form-control" value="<?php echo $row['category_name']?>" disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Sub Category One</label>
                        <?php $sub1 = $this->db->select('*')->from('sub_categories_one')->where(array('id' => $row['sub_category_one_id']))->get()->row_array(); ?>
                        <input type="text" class="form-control" value="<?php echo $sub1['name']?>" disabled>

                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Sub Category Two</label>
                        <?php $sub2 = $this->db->select('*')->from('sub_categories_two')->where(array('id' => $row['sub_category_two_id']))->get()->row_array(); ?>
                        <input type="text" class="form-control" value="<?php echo $sub2['name']?>" disabled>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">Quantity</label>
                        <input type="text" class="form-control" name="quantity" id="quantity<?php echo $i;?>" value="<?php echo $row['quantity']?>" disabled="">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">Free Qty</label>
                        <input type="text" class="form-control" name="free_quantity[]" id="free_quantity<?php echo $i;?>" autocomplete="off">
                        <input type="hidden" name="total_qty[]" id="total_qty<?php echo $i;?>">
                      </div>

                      <div class="form-group">
                        <label for="name" class="col-form-label">Brand:</label>
                        <div class="input-group" style=" display: table !important; border-collapse: separate !important;">
                          <select class="form-control js-example-basic-single w-100% brand" style="width:100%" name="brand_id[]" required="">
                            <option value="">-- Select Brand --</option>
                            <?php $brands = $this->db->select('*')->from('brand')->get()->result_array(); ?>
                            <?php 
                                foreach($brands as $b){ ?>
                                    <option value="<?php echo $b['id'] ?>" ><?php echo $b['name'] ?></option>
                            <?php } ?>                               
                          </select>
                          <div class="input-group-append bg-primary border-primary" title="" data-toggle="tooltip" data-placement="top" style="padding: 0px 10px 0px 10px;">
                            <a data-toggle="modal" data-target="#addBrand" href="">
                            <i class="mdi mdi-plus text-white" style="font-size: 11px;"></i> </a>                         
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Select Supplier</label>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="supplier_id[]" required >
                          <?php $supplier = $this->db->select('id,name')->from('suppliers')->get()->result_array(); ?>
                            <!-- <option value="">-- Select Supplier --</option> -->
                            <?php
                            foreach($supplier as $s){ 
                              $isSelected = '';
                              if( $s['id'] == $supplier_details[0]['supplier_id'] ){
                                $isSelected = 'selected';
                                ?>
                                <option <?=$isSelected?> value="<?php echo $s['id'] ?>" ><?php echo $s['name']; ?></option>
                                <?php
                              }
                              ?>
                              <!-- <option <?=$isSelected?> value="<?php echo $s['id'] ?>" ><?php echo $s['name']; ?></option> -->
                            <?php } ?>
                        </select>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Wholesale Price</label>
                        <input type="text" class="form-control" name="wholesale_price[]" id="wholesale_price<?php echo $i;?>" onkeyup="calulate_wholesale(<?php echo $i;?>)" autocomplete="off" required="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Tax type:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="w_tax_type[]" id="w_tax_type<?php echo $i;?>" required onchange="calulate_wholesale(<?php echo $i;?>)">
                            <option value="0" selected>Exclusive</option> 
                            <option value="1">Inclusive</option>                            
                        </select>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">CGST %:</label>
                        <input type="text" onkeyup="calulate_wholesale(<?php echo $i;?>)" class="form-control" name="w_cgst[]" id="w_cgst<?php echo $i;?>" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">SGST %:</label>
                        <input type="text" onkeyup="calulate_wholesale(<?php echo $i;?>)" class="form-control" name="w_sgst[]" id="w_sgst<?php echo $i;?>" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">IGST %:</label>
                        <input type="text" onkeyup="calulate_wholesale(<?php echo $i;?>)" class="form-control" name="w_igst[]" id="w_igst<?php echo $i;?>" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">TotalTax:</label>
                        <input type="text" class="form-control" name="w_tax_amount[]" id="w_tax_amount<?php echo $i;?>" readonly="">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">WH Amt</label>
                        <input type="text" class="form-control" name="w_total_amount[]" id="w_total_amount<?php echo $i;?>" autocomplete="off" readonly>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">Total Price:</label>
                        <input type="text" class="form-control net_wholesale_price" name="total_wholesale_price[]" id="total_wholesale_price<?php echo $i;?>" readonly="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Retail Price:</label>
                        <input type="text" class="form-control r_total_amount" name="retail_price[]" id="retail_price<?php echo $i;?>" onkeyup="calulate_retail(<?php echo $i;?>)"  required="" autocomplete="off">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Tax type:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="r_tax_type[]" id="r_tax_type<?php echo $i;?>" required onchange="calulate_retail(<?php echo $i;?>)">
                            <option value="0" selected>Exclusive</option> 
                            <option value="1">Inclusive</option>                            
                        </select>
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">CGST %:</label>
                        <input type="text" onkeyup="calulate_retail(<?php echo $i;?>)" class="form-control" name="r_cgst[]" id="r_cgst<?php echo $i;?>" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">SGST %:</label>
                        <input type="text" onkeyup="calulate_retail(<?php echo $i;?>)" class="form-control" name="r_sgst[]" id="r_sgst<?php echo $i;?>" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">IGST %:</label>
                        <input type="text" onkeyup="calulate_retail(<?php echo $i;?>)" class="form-control" name="r_igst[]" id="r_igst<?php echo $i;?>" autocomplete="off">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">TotalTax:</label>
                        <input type="text" class="form-control" name="r_tax_amount[]" id="r_tax_amount<?php echo $i;?>" readonly="">
                      </div>

                      <div class="form-group col-md-1 col-lg-1">
                        <label class="col-form-label">Retail Amt</label>
                        <input type="text" class="form-control" name="r_total_amount[]" id="r_total_amount<?php echo $i;?>" autocomplete="off" readonly>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Total Price:</label>
                        <input type="text" class="form-control net_retail_amount" name="total_retail_price[]" id="total_retail_price<?php echo $i;?>" readonly="">
                      </div>
                    </div>
                    <?php $i++; } ?>
                    <div class="row">

                      <div class="form-group col-md-3 col-lg-3">
                        <label for="address" class="col-form-label">Conditions:</label>
                        <textarea class="form-control" name="conditions" required=""></textarea>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Delivery Days</label>
                        <input type="number" class="form-control" name="delivery_days" required="" autocomplete="off">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Transport Cost:</label>
                        <input type="text" class="form-control" name="transport_cost" id="transport_cost" required="" onkeyup="calulate_wholesale(1)" autocomplete="off">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Grand WH Price:</label>
                        <input type="text" class="form-control" name="grand_wholesale_price" id="grand_wholesale_price" readonly="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Grand Retail Price:</label>
                        <input type="text" class="form-control" name="grand_retail_price" id="grand_retail_price" readonly="">
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

    <!-- Modal Start -->
    <div class="modal fade" id="addBrand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel-4">New Brand</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" id="brandForm">
              <div class="form-group">
                <label for="name" class="col-form-label">Name:</label>
                <input type="text" class="form-control" name="name" id="name" autocomplete="off" placeholder="Enter Brand Name" required>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Add Brand</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
            </form>
        </div>
      </div>
    </div>
    <!-- Modal End -->
  </div>

  <style type="text/css">

    .groove {border-style: groove;}

    .modal .modal-dialog .modal-content .modal-body {
      padding: 5px 26px !important;
    }

    .modal .modal-dialog .modal-content .modal-header {
      padding: 15px 26px;
    }

    .input-group-prepend, .asColorPicker-trigger, .input-group-append {
      display: table-cell !important;
  }
  </style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">

  $(document).on("submit","form#brandForm",function(event){

    event.preventDefault();

    var form = $(this);
    let output="";
    let brand=[];

    // alert(form.serialize());

    $.ajax({

      url:"<?php echo base_url('vendor/addBrand'); ?>",
      type:form.attr('method'),
      data:form.serialize(),
      success:function(response){
        response = JSON.parse(response);
        if(response.status == "success"){
          brand = response.brand;

          output= '<option value="">Select</option>';
          $(brand).each(function(){
             output = output + '<option value="'+this.id+'">'+this.name+'</option>';
          });
          
          $('.brand').html(output);
          $(".brand option:last").prop("selected", "selected");
          $('#addBrand').modal('hide');
          $("#brandForm").trigger('reset');

        }
      }
    });

  });

  function calulate_wholesale(row){

    let wholesale_price = parseInt($('#wholesale_price'+row).val());
    let w_total_amount = 0;
    let total_wh_price = 0;
    let quantity = $('#quantity'+row).val();
    let transport_cost = $('#transport_cost').val();
    let grand_wh_price = 0;
    let tax_amount =0;
    let cgst_tax = 0;
    let sgst_tax = 0;
    let totalQty = 0;
    let freeQty = $('#free_quantity'+row).val();

    let cgst = parseInt($('#w_cgst'+row).val());
    let sgst = parseInt($('#w_sgst'+row).val());
    let igst = parseInt($('#w_igst'+row).val());

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

    if(isNaN(transport_cost))
    {
      transport_cost = 0;
    }

    let tax_type = parseInt($('#w_tax_type'+row).val());

    if(wholesale_price > 0){
      total_wh_price = w_total_amount = wholesale_price * parseInt(quantity);
    }

    if(tax_type == 0){        // exclusive

      if(cgst > 0 && sgst > 0){

        cgst_tax = (w_total_amount/100)*(cgst);
        sgst_tax = (w_total_amount/100)*(sgst);

        tax_amount = parseInt(cgst_tax + sgst_tax);
        total_wh_price = parseInt(w_total_amount + tax_amount);

      }else if(igst > 0){   
        igst_tax = (w_total_amount/100)*(igst);

        tax_amount = parseInt(igst_tax);
        total_wh_price = parseInt(w_total_amount + tax_amount);
      }
    }else if(tax_type == 1){      //inclusive

      if(cgst > 0 && sgst > 0){

        // Inclusive tax formula 
        // GST Tax Amount = Original Cost – (Original Cost * (100 / (100 + GST% ) ) )
        // Net Price = Original Cost – GST Tax Amount

        // tax_amount = w_total_amount - parseInt(w_total_amount*(100/(100+cgst+sgst)));
        // total_wh_price = parseInt(w_total_amount - tax_amount);

        total_wh_price = parseInt(w_total_amount);
        tax_amount = w_total_amount - parseInt(w_total_amount*(100/(100+cgst+sgst)));
        w_total_amount = parseInt(w_total_amount - tax_amount);

      }else if(igst > 0){   

        // tax_amount = w_total_amount - parseInt(w_total_amount*(100/(100+igst)));
        // total_wh_price = parseInt(w_total_amount - tax_amount);

        total_wh_price = parseInt(w_total_amount);
        tax_amount = w_total_amount - parseInt(w_total_amount*(100/(100+igst)));
        w_total_amount = parseInt(w_total_amount - tax_amount);

      }
    }

    if(wholesale_price > 0){
      $('#w_cgst'+row).val(cgst);
      $('#w_sgst'+row).val(sgst);
      $('#w_igst'+row).val(igst);
      $('#w_tax_amount'+row).val(tax_amount);
    }else{
      $('#w_cgst_tax'+row).val('');
      $('#w_sgst_tax'+row).val('');
      $('#w_igst_tax'+row).val('');
      $('#w_tax_amount'+row).val('');
    }

    $('#w_total_amount'+row).val(w_total_amount);

    totalQty = parseInt(quantity) + parseInt(freeQty);
    $('#total_qty'+row).val(totalQty);
    
    $('#total_wholesale_price'+row).val(total_wh_price);

    $('.net_wholesale_price').each(function(){
       if($(this).val() > 0){
          grand_wh_price = parseInt(grand_wh_price) + parseInt($(this).val());
       }
    });

    if(transport_cost > 0){
      grand_wh_price = parseInt(grand_wh_price) + parseInt(transport_cost);
    }

    // $('#grand_wholesale_price').val('');
    $('#grand_wholesale_price').val(grand_wh_price);

  }

  function calulate_retail(row){
    let retail_price = parseInt($('#retail_price'+row).val());

    let total_rp_price = 0;
    let total_tax = 0;
    let quantity = $('#quantity'+row).val();
    let grand_rt_price = 0;
    let tax_amount =0;
    let cgst_tax = 0;
    let sgst_tax = 0;
    let r_total_amount = 0;

    let cgst = parseInt($('#r_cgst'+row).val());
    let sgst = parseInt($('#r_sgst'+row).val());
    let igst = parseInt($('#r_igst'+row).val());

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

    let tax_type = parseInt($('#r_tax_type'+row).val());

    if(retail_price > 0){
      total_rp_price = r_total_amount = retail_price * parseInt(quantity);
    }

    if(tax_type == 0){        // exclusive

      if(cgst > 0 && sgst > 0){

        cgst_tax = (r_total_amount/100)*(cgst);
        sgst_tax = (r_total_amount/100)*(sgst);

        tax_amount = parseInt(cgst_tax + sgst_tax);
        total_rp_price = parseInt(r_total_amount + tax_amount);

      }else if(igst > 0){   
        igst_tax = (r_total_amount/100)*(igst);

        tax_amount = parseInt(igst_tax);
        total_rp_price = parseInt(r_total_amount + tax_amount);
      }
    }else if(tax_type == 1){      //inclusive

      if(cgst > 0 && sgst > 0){

        // Inclusive tax formula 
        // GST Tax Amount = Original Cost – (Original Cost * (100 / (100 + GST% ) ) )
        // Net Price = Original Cost – GST Tax Amount

        // tax_amount = r_total_amount - parseInt(r_total_amount*(100/(100+cgst+sgst)));
        // total_rp_price = parseInt(r_total_amount - tax_amount);

        total_rp_price = parseInt(r_total_amount);
        tax_amount = r_total_amount - parseInt(r_total_amount*(100/(100+cgst+sgst)));
        r_total_amount = parseInt(r_total_amount - tax_amount);

      }else if(igst > 0){   
        // tax_amount = r_total_amount - parseInt(r_total_amount*(100/(100+igst)));
        // total_rp_price = parseInt(r_total_amount - tax_amount);

        total_rp_price = parseInt(r_total_amount);
        tax_amount = r_total_amount - parseInt(r_total_amount*(100/(100+igst)));
        r_total_amount = parseInt(r_total_amount - tax_amount);
      }
    }

    if(retail_price > 0){
      $('#r_cgst'+row).val(cgst);
      $('#r_sgst'+row).val(sgst);
      $('#r_igst'+row).val(igst);
      $('#r_tax_amount'+row).val(tax_amount);
    }else{
      $('#r_cgst_tax'+row).val('');
      $('#r_sgst_tax'+row).val('');
      $('#r_igst_tax'+row).val('');
      $('#r_tax_amount'+row).val(tax_amount);
    }

    $('#r_total_amount'+row).val(r_total_amount);

    $('#total_retail_price'+row).val(total_rp_price);

    $('.net_retail_amount').each(function(){
      if($(this).val() > 0){
        grand_rt_price = parseInt(grand_rt_price) + parseInt($(this).val());
      }
    });

    $('#grand_retail_price').val(grand_rt_price);
  }


</script>
                
                
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
</body>

</html>