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
                <li class="breadcrumb-item"><a href="#">Orders</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url('orders/request_for_quote')?>"><span>Quotations</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Add Quotations</span></li>
              </ol>
            </nav>
          </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <div class="card">
                <div class="card-body">
                  
                  <form method="post" action="<?php echo base_url('orders/add_new_quotation'); ?>">
                    <div class="row">
                      <div class="form-group col-md-3 col-lg-3">
                        <label for="name" class="col-form-label">Ref Number:</label>
                        <input type="text" class="form-control" name="ref_number" value="<?php echo $new_ref_no; ?>" readonly>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label for="name" class="col-form-label">Warehouse:</label><br>
                        <select disabled class="form-control js-example-basic-single w-100%" style="width:100%" name="warehouse_id" required="">
                          <option value="">-- Select Warehouse --</option>
                          <?php $warehouse = $this->db->select('id,name')->from('warehouse')->where('delete_status',0)->get()->result_array(); ?>
                          <?php 
                              foreach($warehouse as $w){ ?>
                                  <option <?php if($w['id'] == $warehouse_id ){ echo "selected"; }  ?> value="<?php echo $w['id'] ?>"><?php echo $w['name'] ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group col-md-3 col-lg-3">
                        <label for="address" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" required=""></textarea>
                      </div>

                      <div class="form-group col-md-12 col-lg-12">
                        <table class="table table-bordered" id="tableID" style="width: 100%">
                          <tr>
                            <td style="width: 20%">
                              <label>Product Name</label>
                            </td>
                            <td style="width: 20%">
                              <label>Category</label>
                            </td>
                            <td style="width: 20%">
                              <label>Sub Category One</label>
                            </td>
                            <td style="width: 20%">
                              <label>Sub Category Two</label>
                            </td>
                            <td style="width: 5%">
                              <label>Quantity</label>
                            </td>
                            <td style="width: 5%">
                              <label>Action</label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="product_id[]" id="product_id0" required="">
                                <option value="">-- Select--</option>
                                <?php $product = $this->db->select('id,name')->from('products')->get()->result(); ?>
                                <?php 
                                    foreach($product as $p){ ?>
                                        <option value="<?php echo $p->id ?>"><?php echo $p->name ?></option>
                                <?php } ?>
                              </select>
                            </td>
                            <td>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="category_id[]" id="category_id0" required onchange="fetchSubCategoryOne(0);" required="">
                                <option value="">-- Select--</option>
                                <?php $category = $this->db->select('*')->from('category')->get()->result(); ?>
                                <?php 
                                    foreach($category as $c){ ?>
                                        <option value="<?php echo $c->id ?>"><?php echo $c->name ?></option>
                                <?php } ?>                               
                              </select>
                            </td>
                            <td>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_one_id[]" id="sub_category_one_id0" onchange="fetchSubCategorytwo(0);" >
                                <option value="">-- Select--</option>
                              </select>
                            </td>
                            <td>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_two_id[]" id="sub_category_two_id0" >
                                <option value="">-- Select--</option>
                              </select>
                            </td>
                            <td>
                              <input type="text" class="form-control" name="quantity[]" id="quantity0" autocomplete="off" required>
                            </td>
                            <td>
                              <button type="button" class="btn btn-info btn-sm icon-btn ml-2 mb-2" onclick="addRow()">
                                <i class="mdi mdi-plus"></i>
                              </button>
                            </td>
                          </tr>

                        </table>
                      </div>
                    </div>

                    <!-- <div class="table-responsive">
                      <table class="table table-bordered" id="tableID" style="width: 50%;">
                      </table>
                    </div> -->

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

  var rowsarray = [0];
  
  function addRow(){
    var rows = Math.max.apply(Math,rowsarray) + 1;

    $('#tableID').append('<tr id="rows-added-'+rows+'" class="product-row"><td><select class="form-control js-example-basic-single w-100%" style="width:100%" name="product_id[]" id="product_id'+rows+'" required><option value="">-- Select--</option><?php foreach($product as $p){ ?><option value="<?php echo $p->id?>"><?php echo $p->name ?></option><?php } ?></select></td><td><select class="form-control js-example-basic-single w-100%" style="width:100%" name="category_id[]" id="category_id'+rows+'" required onchange="fetchSubCategoryOne('+rows+');" ><option value="">-- Select--</option><?php foreach($category as $c){ ?><option value="<?php echo $c->id ?>"><?php echo $c->name ?></option><?php } ?></select></td><td><select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_one_id[]" id="sub_category_one_id'+rows+'" onchange="fetchSubCategorytwo('+rows+');" ><option value="">-- Select--</option></select></td><td><select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_two_id[]" id="sub_category_two_id'+rows+'" ><option value="">-- Select--</option></select></td><td><input type="text" class="form-control" name="quantity[]" id="quantity'+rows+'" autocomplete="off" required></td><td><button data-repeater-delete="" onclick="removeThis('+rows+')" type="button" class="btn btn-danger btn-sm icon-btn"><i class="mdi mdi-delete"></i></button></td></tr>');
    rowsarray.push(rows);

    $(".js-example-basic-single").select2();
  }

  function removeThis(rows){

    $('#rows-added-'+rows).remove();
    rowsarray.splice($.inArray(rows,rowsarray),1);

  }


</script>

<script type="text/javascript">

  function fetchSubCategoryOne(row){
  
    let output='';
    let output2 = '';
    let category_id = $('#category_id'+row).val();

    $.ajax({
      url: '<?=base_url("category/getSubCategoryOne")?>',
      type: 'GET',
      data: {'category_id' : category_id },
      cache: false,
      success : function(result){
          var res = JSON.parse(result);
          console.log(res.data);
          output = output + '<option value="">-- Select--</option>';
          $(res.data).each(function(){
            output = output + "<option value="+this.id+">"+this.name+"</option>";
          });
          $("#sub_category_one_id"+row).html(output);

          output2 = output2 + '<option value="">-- Select--</option>';
          $("#sub_category_two_id"+row).html(output2);

      }
    });
  }

  function fetchSubCategorytwo(row){
  
    let output='';
    var category_id = $('#category_id'+row).val();
    var sub_category_one_id = $('#sub_category_one_id'+row).val();

    $.ajax({
      url: '<?=base_url("category/getSubCategorytwo")?>',
      type: 'GET',
      data: {'category_id' : category_id,'sub_category_one_id' : sub_category_one_id },
      cache: false,
      success : function(result){
          var res = JSON.parse(result);
          console.log(res.data);
          output = output + '<option value="">-- Select--</option>';
          $(res.data).each(function(){
              output = output + "<option value="+this.id+">"+this.name+"</option>";
          });
          
          $("#sub_category_two_id"+row).html(output);
      }
    });

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