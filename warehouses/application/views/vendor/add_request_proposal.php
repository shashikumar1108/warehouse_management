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
        border: 1px solid #1d1a1a !important;
        text-align: center;
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
                <li class="breadcrumb-item"><a href='<?php echo base_url('orders/request_for_quote')?>'>Request For Quotation</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Add Request For Quotation</span></li>
              </ol>
            </nav>
          </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <div class="card">
                <div class="card-body">
                  
                  <form method="post" action="<?php echo base_url('orders/add_new_quotation'); ?>">
                    <div class="row">
                      <div class="form-group col-md-4 col-lg-4">
                        <label for="name" class="col-form-label">Ref Number:</label>
                        <input type="text" class="form-control" name="ref_number" value="<?php echo $new_ref_no; ?>" readonly>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                        <label for="name" class="col-form-label">Approval Status:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="approval_status" required="">
                          <option value="">-- Select Approval Status --</option>
                          <option value="Approved">Approved</option>
                          <option value="UnApproved">UnApproved</option>
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                        <label for="name" class="col-form-label">Warehouse:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="warehouse_id" required="">
                          <option value="">-- Select Warehouse --</option>
                          <?php $warehouse = $this->db->select('id,name')->from('warehouse')->get()->result_array(); ?>
                          <?php 
                              foreach($warehouse as $w){ ?>
                                  <option value="<?php echo $w['id'] ?>"><?php echo $w['name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                        <label for="name" class="col-form-label">Product:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="product_name" id="new_product_list" required="">
                          <option value="">-- Select Product --</option>
                          <?php $product = $this->db->select('id,name')->from('products')->get()->result_array(); ?>
                          <?php 
                              foreach($product as $p){ ?>
                                  <option value="<?php echo $p['id'] ?>"><?php echo $p['name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                        <label for="name" class="col-form-label">Category:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="category_id" id="add_category" required onchange="fetchSubCategoryOne(this.value);" required="">
                          <option value="">-- Select Category --</option>
                          <?php $category = $this->db->select('*')->from('category')->get()->result_array(); ?>
                          <?php 
                              foreach($category as $c){ ?>
                                  <option value="<?php echo $c['id'] ?>"><?php echo $c['name'] ?></option>
                          <?php } ?>                               
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                      <label for="name" class="col-form-label">Sub Category One:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_one_id" id="add_sub_category_one" required onchange="fetchSubCategorytwo(this.value);" required="">
                          <option value="">-- Select Sub Category One --</option>
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                      <label for="name" class="col-form-label">Sub Category Two:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_two_id" id="add_sub_category_two" required="">
                          <option value="">-- Select Sub Category Two --</option>
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                        <label for="name" class="col-form-label">Brand:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="brand_id" required="">
                          <option value="">-- Select Brand --</option>
                          <?php $brands = $this->db->select('*')->from('brand')->get()->result_array(); ?>
                          <?php 
                              foreach($brands as $b){ ?>
                                  <option value="<?php echo $b['id'] ?>" ><?php echo $b['name'] ?></option>
                          <?php } ?>                               
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                        <label for="name" class="col-form-label">Quantity:</label>
                        <input type="text" class="form-control" name="quantity" required="">
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                        <label for="address" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" required=""></textarea>
                      </div>
        
                    </div>

                    <div class="table-responsive">
                      <table class="table table-bordered" id="tableID" style="width: 50%;">
                      </table>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Save</button>

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

  var product_list = [];

  $(document).ready(function(){

    $('#new_product_list').change(function() {

    var product_id = this.value;
    var product_name = $("#new_product_list  option:selected").text();

    // does not exist
    if(jQuery.inArray(product_id, product_list) === -1){
      product_list.push(product_id);
      addRow(product_id,product_name);
    }else{
      alert('Product already added');
    }

    // console.log(product_list);

    });
  });


  var rowsarray = [0];
  
  function addRow(product_id,product_name){
    var rows = Math.max.apply(Math,rowsarray) + 1;

    if(rowsarray.length==1){
      addLabel();
    }

    $('#tableID').append('<tr id="rows-adding-'+rows+'" class="add-product-row"><td width="50%"><label>'+product_name+'</label></td><input type="hidden" name="product_id[]" id="add_product_name'+rows+'" value='+product_id+'><td width="50%"><button data-repeater-delete="" onclick="removeThis('+rows+')" type="button" class="btn btn-danger btn-sm icon-btn"><i class="mdi mdi-delete"></i></button></td></tr>');
    rowsarray.push(rows);
  }

  function removeThis(rows){
    var pId = $('#add_product_name'+rows).val();

    $('#rows-adding-'+rows).remove();
    rowsarray.splice($.inArray(rows,rowsarray),1);

    product_list.splice($.inArray(pId,product_list),1);
    if(rowsarray.length==1){
      removeLabel();
    }
  }

  function addLabel(){
    $('#tableID').append('<tr id="rows-add-product-label"><td style=width:"50%";font-weight:bold;><label>Product Name</label></td><td style=width:"50%";font-weight:bold;><label class="for-action">Action</label></td></tr>');
  }

  function removeLabel(){
    $('#rows-add-product-label').remove();
  }

</script>

<script type="text/javascript">

  function fetchSubCategoryOne(category_id){
  
    let output='';

    $.ajax({
      url: '<?=base_url("category/getSubCategoryOne")?>',
      type: 'GET',
      data: {'category_id' : category_id },
      cache: false,
      success : function(result){
          var res = JSON.parse(result);
          // console.log(res.data);
          output = output + '<option value="">Select Sub Category One</option>';
          $(res.data).each(function(){
                output = output + "<option value="+this.id+">"+this.name+"</option>";
            });
            $("#add_sub_category_one").html(output);

      }
    });
  }

  function fetchSubCategorytwo(sub_category_one_id){
  
    let output='';
    var category_id = $('#add_category').val();

    $.ajax({
      url: '<?=base_url("category/getSubCategorytwo")?>',
      type: 'GET',
      data: {'category_id' : category_id,'sub_category_one_id' : sub_category_one_id },
      cache: false,
      success : function(result){
          var res = JSON.parse(result);
          console.log(res.data);
          output = output + '<option value="">Select Sub Category Two</option>';
          $(res.data).each(function(){
              output = output + "<option value="+this.id+">"+this.name+"</option>";
          });
          
          $("#add_sub_category_two").html(output);
      }
    });

  }

  function updateSubCategoryoneList(cat_id, modal_no){
    
    let output = '';
    $.ajax({
      url: '<?=base_url("category/getSubCategoryOne")?>',
      type: 'GET',
      data: {'category_id' : cat_id },
      cache: false,
      success : function(result){
          var res = JSON.parse(result);
          console.log(res.data);
          output = output + '<option value="">Select Sub Category One</option>';
          $(res.data).each(function(){
                output = output + "<option value="+this.id+">"+this.name+"</option>";
          });
          $("#edit_sub_category_one_id"+modal_no).html(output);
          var output1 = output1 + '<option value="">Select Sub Category Two</option>';
          $("#edit_sub_category_two_id"+modal_no).html(output1);

      }
   });
  }

  function updateSubCategorytwoList(sub_category_one_id, modal_no){
    
    let output = '';
    var category_id = $('#edit_category').val();
    $.ajax({
      url: '<?=base_url("category/getSubCategorytwo")?>',
      type: 'GET',
      data: {'category_id': category_id,'sub_category_one_id' : sub_category_one_id },
      cache: false,
      success : function(result){
          var res = JSON.parse(result);
          console.log(res.data);
          output = output + '<option value="">Select Sub Category Two</option>';
          $(res.data).each(function(){
              output = output + "<option value="+this.id+">"+this.name+"</option>";
          });
            $("#edit_sub_category_two_id"+modal_no).html(output);
      }
   });
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
  