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
                <li class="breadcrumb-item"><a href="#">Orders</a></li>
                <li class="breadcrumb-item"><a href="#">Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Goods Receipt Notes</span></li>
              </ol>
            </nav>
          </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <div class="card">
                <div class="card-body">
                  
                  <!-- <form method="post" action="<?php echo base_url('orders/create_goods_delivery_note'); ?>"> -->
                    <input type="hidden" name="quotation_id" value="<?php echo $vendor_quotation['quotation_id']?>">
                    <input type="hidden" name="vendor_quote_id" value="<?php echo $vendor_quotation['vendor_quote_id']?>">
                    <div class="row">
                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Ref Number:</label>
                        <input type="text" class="form-control" name="ref_number" value="<?php echo $vendor_quotation['ref_number']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Vendor Name:</label><br>
                        <?php $supplier = $this->db->select('s.name')->from('suppliers s')
                        ->where(array('s.id' => $quotation_price_details[0]['supplier_id']))->get()->row_array(); ?>
                        <input type="text" class="form-control" name="supplier" value="<?php echo $supplier['name']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label class="col-form-label">Warehouse:</label><br>
                        <?php $warehouse = $this->db->select('w.name')->from('warehouse w')
                        ->where(array('w.id' => $vendor_quotation['warehouse_id']))->get()->row_array(); ?>
                        <input type="text" class="form-control" name="warehouse" value="<?php echo $warehouse['name']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label for="address" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" disabled><?php echo $vendor_quotation['description']?></textarea>
                      </div>
                    </div>

                    <div class="form-group col-md-12 col-lg-12" style="padding-left: 0px !important;padding-right: 0px !important;">
                      <table class="table table-bordered" id="view-product-table" style="width: 100%">
                        <tr>
                          <td style="width: 10%">
                            <label>Product Name</label>
                          </td>
                          <td style="width: 10%">
                            <label>Category</label>
                          </td>
                          <td style="width: 10%">
                            <label>Brand</label>
                          </td>
                          <td style="width: 5%">
                            <label>Quantity</label>
                          </td>
                          <td style="width: 5%">
                            <label>WH Price</label>
                          </td>
                          <td style="width: 5%">
                            <label>Tax Type</label>
                          </td>
                          <td style="width: 5%">
                            <label>Total Price</label>
                          </td>
                          <td style="width: 5%">
                            <label>Breakage Qty</label>
                          </td>
                          <td style="width: 5%">
                            <label>Reduced Amt</label>
                          </td>
                          <td style="width: 5%">
                            <label>Total Amt</label>
                          </td>
                        </tr>
                        <?php $i=1; foreach($quotation_price_details as $row) {?>
                        <tr>
                          <input type="hidden" id="w_cgst<?php echo $i;?>" value="<?php echo $row['w_cgst']; ?>" disabled>
                          <input type="hidden" id="w_sgst<?php echo $i;?>" value="<?php echo $row['w_sgst']; ?>" disabled>
                          <input type="hidden" id="w_igst<?php echo $i;?>" value="<?php echo $row['w_igst']; ?>" disabled>
                          
                          <input type="hidden" id="r_cgst<?php echo $i;?>" value="<?php echo $row['r_cgst']; ?>" disabled>
                          <input type="hidden" id="r_sgst<?php echo $i;?>" value="<?php echo $row['r_sgst']; ?>" disabled>
                          <input type="hidden" id="r_igst<?php echo $i;?>" value="<?php echo $row['r_igst']; ?>" disabled>
                          <input type="hidden" value="<?php echo $row['retail_price']?>" id="retail_price<?php echo $i;?>" disabled>
                          <input type="hidden" value="<?php if($row['r_tax_type'] == '0') { echo "Exclusive";} else{ echo "Inclusive";} ?>" id="r_tax_type<?php echo $i; ?>" disabled>
                          <input type="hidden" value="<?php echo $row['total_retail_price']?>" id="total_retail_price<?php echo $i;?>" disabled>
                          <input type="hidden" name="reduced_rp_amount[]" id="reduced_rp_amount<?php echo $i;?>" readonly>

                          <input type="hidden" class="net_total_rp_amount" name="total_rp_amount[]" value="<?php echo $row['total_wholesale_price']?>" id="total_rp_amount<?php echo $i;?>" readonly>

                          <input type="hidden" id="free_quantity<?php echo $i;?>" value="<?php echo $row['free_quantity']; ?>" readonly>
                          <input type="hidden" name="total_qty[]" id="total_qty<?php echo $i;?>" value="<?php echo $row['total_qty']; ?>">
                          <input type="hidden" name="vqd_id[]" value="<?php echo $row['vqd_id']?>">
                          <td>
                            <input type="text" class="form-control" value="<?php echo $row['product_name']?>" disabled>
                          </td>
                          <td>
                            <?php $category = $this->db->select('*')->from('category')->get()->result_array(); ?>
                            <?php foreach($category as $c){ 
                              if($row['category_id'] == $c['id']) { $category_name =  $c['name']; }
                            }?>
                            <input type="text" class="form-control" value="<?php echo $category_name; ?>" disabled>
                          <td>
                            <?php $brands = $this->db->select('*')->from('brand')->get()->result_array(); ?>
                            <?php foreach($brands as $b){ 
                              if($row['brand_id'] == $b['id']) { $brand_name =  $b['name']; }
                            } ?>
                            <input type="text" class="form-control" value="<?php echo $brand_name; ?>" disabled>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo $row['quantity']?>" id="quantity<?php echo $i; ?>" disabled>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo $row['wholesale_price']?>" id="wholesale_price<?php echo $i;?>" disabled>
                          </td>
                          <td>
                            <?php if($row['w_tax_type'] == '0') { $tax_type = "Exclusive";} else{$tax_type = "Inclusive";}?>
                            <input type="text" class="form-control" value="<?php echo $tax_type ?>" id="w_tax_type<?php echo $i; ?>" disabled>
                          </td>
                          <td>
                            <input type="text" class="form-control" value="<?php echo $row['total_wholesale_price']?>" id="total_wholesale_price<?php echo $i;?>" disabled>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="breakage_qty[]" id="breakageQty<?php echo $i;?>" required onkeyup="calTotalAmt(<?php echo $i; ?>)" autocomplete="off" value="<?php echo $row['breakage_qty']; ?>">
                          </td>
                          <td>
                            <input type="text" class="form-control" name="reduced_wh_amount[]" id="reduced_wh_amount<?php echo $i;?>" readonly>
                          </td>
                          <td>
                            <input type="text" class="form-control net_total_wh_amount" name="total_wh_amount[]" value="<?php echo $row['total_wholesale_price']?>" id="total_wh_amount<?php echo $i;?>" readonly>
                          </td>
                        </tr>
                        <?php $i++; } ?>
                      </table>
                    </div>

                    
                    <div class="row">
                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Delivery Days:</label><br>
                        <input type="text" class="form-control" name="warehouse" value="<?php echo $vendor_quotation['delivery_days']; ?>" disabled>
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Transport Cost:</label>
                        <input type="text" class="form-control" name="transport_cost" id="transport_cost" value="<?php echo $vendor_quotation['transport_cost']?>" disabled="">
                      </div>

                      <div class="form-group col-md-2 col-lg-2">
                        <label class="col-form-label">Grand WH Price:</label>
                        <input type="hidden" id="temp_gwh_price" value="<?php echo $vendor_quotation['grand_wholesale_price']?>" disabled="">
                        <input type="text" class="form-control" name="grand_wholesale_price" value="<?php echo $vendor_quotation['grand_wholesale_price']?>" id="grand_wholesale_price" readonly="">

                        <input type="hidden" id="temp_grp_price" value="<?php echo $vendor_quotation['grand_retail_price']?>" disabled="">
                          <input type="hidden" name="grand_retail_price" value="<?php echo $vendor_quotation['grand_retail_price']?>" id="grand_retail_price" readonly="">
                      </div>
                     
                    </div>

                    <!-- <br>
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-primary">Cancel</button>

                  </form> -->
                    
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

  <style type="text/css">

    .modal .modal-dialog .modal-content .modal-body {
      padding: 5px 26px !important;
    }

    .modal .modal-dialog .modal-content .modal-header {
      padding: 15px 26px;
    }
  </style>

  <script type="text/javascript">
    
    function calTotalAmt(row){

      let breakageQty = parseInt($('#breakageQty'+row).val());
      let quantity= parseInt($('#quantity'+row).val());
      let free_quantity= parseInt($('#free_quantity'+row).val());
      let totalQty = 0;
      let wholesale_price = parseInt($('#wholesale_price'+row).val());
      let transport_cost = parseInt($('#transport_cost').val());
      let cgst = parseInt($('#w_cgst'+row).val());
      let sgst = parseInt($('#w_sgst'+row).val());
      let igst = parseInt($('#w_igst'+row).val());
      let tax_type = $('#w_tax_type'+row).val();
      let total_wholesale_price = parseInt($('#total_wholesale_price'+row).val());
      let total_wh_amount = parseInt($('#total_wh_amount'+row).val());
      let grand_wh_price = 0;
      let total_wh_price = 0;
      let w_total_amount = 0;
      let temp_gwh_price = $('#temp_gwh_price').val();


      let retail_price = parseInt($('#retail_price'+row).val());
      let r_cgst = parseInt($('#r_cgst'+row).val());
      let r_sgst = parseInt($('#r_sgst'+row).val());
      let r_igst = parseInt($('#r_igst'+row).val());
      let r_tax_type = $('#r_tax_type'+row).val();
      let total_retail_price = parseInt($('#total_retail_price'+row).val());
      let total_rp_amount = parseInt($('#total_rp_amount'+row).val());
      let grand_rp_price = 0;
      let total_rp_price = 0;
      let r_total_amount = 0;
      let temp_grp_price = $('#temp_grp_price').val();
      let r_cgst_tax=0;
      let r_sgst_tax=0;
      let r_igst_tax=0;
      let r_tax_amount=0;

      
      if(breakageQty > quantity){

        $('#breakageQty'+row).val('');
        totalQty = parseInt(quantity + free_quantity);
        $('#total_qty'+row).val(totalQty);
        $('#reduced_wh_amount'+row).val('0');
        $('#total_wh_amount'+row).val(total_wholesale_price);
        $('#grand_wholesale_price').val(temp_gwh_price);

        $('#reduced_rp_amount'+row).val('0');
        $('#total_rp_amount'+row).val(total_retail_price);
        $('#grand_retail_price').val(temp_grp_price);

        alert('Breakage quantity should be less than or equal to quantity');

      }else{

        if(breakageQty > 0){

          total_wh_price = w_total_amount = wholesale_price * parseInt(breakageQty);
          totalQty = parseInt(quantity + free_quantity - breakageQty);

          total_rp_price = r_total_amount = retail_price * parseInt(breakageQty);

          if(tax_type == "Exclusive"){        // exclusive

            if(cgst > 0 && sgst > 0){

              cgst_tax = (w_total_amount/100)*(cgst);
              sgst_tax = (w_total_amount/100)*(sgst);

              tax_amount = parseInt(cgst_tax + sgst_tax);
              total_wh_price = parseInt(w_total_amount + tax_amount);

              r_cgst_tax = (r_total_amount/100)*(r_cgst);
              r_sgst_tax = (r_total_amount/100)*(r_sgst);

              r_tax_amount = parseInt(r_cgst_tax + r_sgst_tax);
              // console.log(r_tax_amount);

              total_rp_price = parseInt(r_total_amount + r_tax_amount);
              // console.log(total_rp_price);

            }else if(igst > 0){   
              igst_tax = (w_total_amount/100)*(igst);

              tax_amount = parseInt(igst_tax);
              total_wh_price = parseInt(w_total_amount + tax_amount);

              r_igst_tax = (r_total_amount/100)*(r_igst);

              r_tax_amount = parseInt(r_igst_tax);
              total_rp_price = parseInt(r_total_amount + r_tax_amount);
            }
          }else if(tax_type == "Inclusive"){      //inclusive

            if(cgst > 0 && sgst > 0){

              // Inclusive tax formula 
              // GST Tax Amount = Original Cost – (Original Cost * (100 / (100 + GST% ) ) )
              // Net Price = Original Cost – GST Tax Amount

              tax_amount = w_total_amount - parseInt(w_total_amount*(100/(100+cgst+sgst)));
              total_wh_price = parseInt(w_total_amount - tax_amount);

              r_tax_amount = r_total_amount - parseInt(r_total_amount*(100/(100+r_cgst+r_sgst)));
              total_rp_price = parseInt(r_total_amount - r_tax_amount);

            }else if(igst > 0){   
              tax_amount = w_total_amount - parseInt(w_total_amount*(100/(100+igst)));
              total_wh_price = parseInt(w_total_amount - tax_amount);

              r_tax_amount = r_total_amount - parseInt(r_total_amount*(100/(100+r_igst)));
              total_rp_price = parseInt(r_total_amount - r_tax_amount);
            }
          }

          $('#reduced_wh_amount'+row).val(total_wh_price);

          total_wh_amount = parseInt(total_wholesale_price - total_wh_price);

          $('#total_wh_amount'+row).val(total_wh_amount);

          $('.net_total_wh_amount').each(function(){
             if($(this).val() > 0){
                grand_wh_price = parseInt(grand_wh_price) + parseInt($(this).val());
             }
          });

          $('#total_qty'+row).val(totalQty);

          grand_wh_price = parseInt(grand_wh_price + transport_cost);
          $('#grand_wholesale_price').val(grand_wh_price);

          // retailprice
          $('#reduced_rp_amount'+row).val(total_rp_price);

          total_rp_amount = parseInt(total_retail_price - total_rp_price);

          $('#total_rp_amount'+row).val(total_rp_amount);

          $('.net_total_rp_amount').each(function(){
             if($(this).val() > 0){
                grand_rp_price = parseInt(grand_rp_price) + parseInt($(this).val());
             }
          });

          grand_rp_price = parseInt(grand_rp_price + transport_cost);
          $('#grand_retail_price').val(grand_rp_price);
          // retailprice

        }else{

          $('#reduced_wh_amount'+row).val('0');
          $('#total_wh_amount'+row).val(total_wholesale_price);


          $('#reduced_rp_amount'+row).val('0');
          $('#total_rp_amount'+row).val(total_retail_price);
        }


      }
    }
  </script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                
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