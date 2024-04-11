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
                  
                  <form method="post" action="<?php echo base_url('orders/update_quotation'); ?>">
                    <input type="hidden" name="quotation_id" value="<?php echo $quotation['quotation_id']; ?>">
                    <div class="row">
                      <div class="form-group col-md-4 col-lg-4">
                        <label for="name" class="col-form-label">Ref Number:</label>
                        <input type="text" class="form-control" name="ref_number" value="<?php echo $quotation['ref_number']; ?>" readonly>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                        <label for="name" class="col-form-label">Approval Status:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="approval_status">
                          <option value="">-- Select Approval Status --</option>
                          <option value="Approved" <?php if($quotation['approval_status'] == "Approved") {echo "selected";}?>>Approved</option>
                          <option value="UnApproved" <?php if($quotation['approval_status'] == "UnApproved") {echo "selected";}?>>UnApproved</option>
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                        <label for="name" class="col-form-label">Warehouse:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="warehouse_id">
                          <option value="">-- Select Warehouse --</option>
                          <?php $warehouse = $this->db->select('id,name')->from('warehouse')->get()->result_array(); ?>
                          <?php 
                              foreach($warehouse as $w){ ?>
                                  <option value="<?php echo $w['id'] ?>" <?php if($quotation['warehouse_id'] == $w['id']) {echo "selected";}?>><?php echo $w['name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                        <label for="name" class="col-form-label">Product:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="product_id" id="new_product_list">
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
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="category_id" id="edit_category" required onchange="updateSubCategoryoneList(this.value, <?php echo $i; ?>)">
                          <option value="">-- Select Category --</option>
                          <?php $category = $this->db->select('*')->from('category')->get()->result_array(); ?>
                          <?php 
                              foreach($category as $c){ ?>
                                  <option value="<?php echo $c['id'] ?>" <?php if($c['id'] == $quotation['category_id']) {echo "selected";}?>><?php echo $c['name'] ?></option>
                          <?php } ?>                               
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                      <label for="name" class="col-form-label">Sub Category One:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_one_id" id="edit_sub_category_one_id<?php echo $i ?>" required onchange="updateSubCategorytwoList(this.value, <?php echo $i; ?>)">
                          <option value="">-- Select Sub Category One --</option>
                          <?php $ones = $this->db->select('*')->from('sub_categories_one')->where('category_id',$quotation['category_id'])->get()->result_array(); ?>
                          <?php 
                            foreach($ones as $o){ ?>
                                <option value="<?php echo $o['id'] ?>" <?php if($o['id']==$quotation['sub_category_one_id']){echo "selected";} ?>><?php echo $o['name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                      <label for="name" class="col-form-label">Sub Category Two:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_two_id" id="edit_sub_category_two_id<?php echo $i ?>" required>
                          <option value="">-- Select Sub Category Two --</option>
                          <?php $twos = $this->db->select('*')->from('sub_categories_two')->where(array('category_id' => $quotation['category_id'],'sub_category_one_id' => $quotation['sub_category_one_id']))->get()->result_array(); ?>
                          <?php 
                              foreach($twos as $t){ ?>
                                  <option value="<?php echo $t['id'] ?>" <?php if($t['id']==$quotation['sub_category_two_id']){echo "selected";} ?>><?php echo $t['name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                        <label for="name" class="col-form-label">Brand:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="brand_id" required>
                          <option value="">-- Select Brand --</option>
                          <?php $brands = $this->db->select('*')->from('brand')->get()->result_array(); ?>
                          <?php 
                              foreach($brands as $b){ ?>
                                  <option value="<?php echo $b['id'] ?>" <?php if($b['id']==$quotation['brand_id']){echo "selected";} ?>><?php echo $b['name'] ?></option>
                          <?php } ?>                               
                        </select>
                      </div>

                      <div class="form-group col-md-4 col-lg-4">
                        <label for="address" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" required><?php echo $quotation['description']?></textarea>
                      </div>
        
                    </div>

                    <div class="table-responsive">
                      <table class="table table-bordered" id="tableID" style="width: 50%">
                        <?php $product_length = count($quotation_product)?>
                        <?php if($product_length>=1) {?>
                          <tr id="rows-edit-product-label">
                            <td width="50%">
                              <label>Product Name</label>
                            </td>
                            <td width="25%">
                              <label>Quantity</label>
                            </td>
                            <td width="25%">
                              <label>Action</label>
                            </td>
                          </tr>
                        <?php } ?>
                        <?php $i=0; foreach($quotation_product as $row) {?>
                          <tr id="rows-adding-<?php echo $i+1?>" class="edit-product-row">
                            <input type="hidden" name="qp_id[]" value="<?php echo $row['qp_id']; ?>">
                            <td><label><?php echo $row['product_name']?></label></td>
                            <input type="hidden" name="product_id[]" value="<?php echo $row['product_id']?>" id="edit_product_name<?php echo $i+1?>">
                            <td width="25%"><input type="text" class="form-control" name="quantity[]" value="<?php echo $row['quantity']?>" required></td>
                            <td>
                              <button data-repeater-delete="" onclick="removeThis(<?php echo $i+1?>)" type="button" class="btn btn-danger btn-sm icon-btn"><i class="mdi mdi-delete"></i></button>
                            </td>
                          </tr>
                        <?php $i++;} ?>
                      </table>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Update</button>

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

  var products = "<?php echo $product_ids; ?>";
  var product_list = products.split(",");

  var rowsarray = [0];
  var product_label_length = product_list.length;

  $(document).ready(function(){

    $('#new_product_list').change(function() {

    var product_id = this.value;
    var product_name = $("#new_product_list  option:selected").text();

    // does not exist
    if(jQuery.inArray(product_id, product_list) === -1){
      product_list.push(product_id);
      product_label_length = product_list.length
      addRow(product_id,product_name);
    }else{
      alert('Product already added');
    }

    });
  });


  function addRow(product_id,product_name){
    var rows = Math.max.apply(Math,rowsarray) + 1;

    if(product_label_length==1){
      addLabel();
    }

    $('#tableID').append('<tr id="rows-adding-'+rows+'" class="edit-product-row"><td width="50%"><label>'+product_name+'</label></td><input type="hidden" name="product_id[]" id="edit_product_name'+rows+'" value='+product_id+'><td width="25%"><input type="text" class="form-control" name="quantity[]" autocomplete="off" required></td><td width="50%"><button data-repeater-delete="" onclick="removeThis('+rows+')" type="button" class="btn btn-danger btn-sm icon-btn"><i class="mdi mdi-delete"></i></button></td></tr>');
    rowsarray.push(rows);
  }

  function removeThis(rows){
    
    var pId = $('#edit_product_name'+rows).val();

    $('#rows-adding-'+rows).remove();
    rowsarray.splice($.inArray(rows,rowsarray),1);

    product_label_length = product_list.length;

    if(product_label_length==1){
      removeLabel();
    }

    product_list.splice($.inArray(pId,product_list),1);
  }

  function addLabel(){
    $('#tableID').append('<tr id="rows-edit-product-label"><td style=width:"50%";font-weight:bold;><label>Product Name</label></td><td style=width:"25%";font-weight:bold;><label>Quantity</label></td><td style=width:"25%";font-weight:bold;><label class="for-action">Action</label></td></tr>');
  }

  function removeLabel(){
    $('#rows-edit-product-label').remove();
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
  