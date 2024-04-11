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
                <li class="breadcrumb-item active" aria-current="page"><span>Edit Request For Quotation</span></li>
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
                      <div class="form-group col-md-3 col-lg-3">
                        <label for="name" class="col-form-label">Ref Number:</label>
                        <input type="text" class="form-control" name="ref_number" value="<?php echo $quotation['ref_number']; ?>" readonly>
                      </div>

                      <!-- <div class="form-group col-md-3 col-lg-3">
                        <label for="name" class="col-form-label">Approval Status:</label><br>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="approval_status">
                          <option value="">-- Select Approval Status --</option>
                          <option value="Approved" <?php if($quotation['approval_status'] == "Approved") {echo "selected";}?>>Approved</option>
                          <option value="UnApproved" <?php if($quotation['approval_status'] == "UnApproved") {echo "selected";}?>>UnApproved</option>
                        </select>
                      </div> -->

                      <div class="form-group col-md-3 col-lg-3">
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

                      <div class="form-group col-md-3 col-lg-3">
                        <label for="address" class="col-form-label">Description:</label>
                        <textarea class="form-control" name="description" required><?php echo $quotation['description']?></textarea>
                      </div>

                      <div class="table-responsive">
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
                          <?php $i=1; foreach($quotation_product as $row) {?>

                            <tr id="rows-added-<?php echo $i; ?>" class="product-row">
                              <input type="hidden" name="qp_id[]" value="<?php echo $row['qp_id']; ?>">
                              <td>
                                <select class="form-control js-example-basic-single w-100%" style="width:100%" name="product_id[]" id="product_id<?php echo $i;?>" required="">
                                  <option value="">-- Select--</option>
                                  <?php $product = $this->db->select('id,name')->from('products')->get()->result(); ?>
                                  <?php 
                                    foreach($product as $p){ ?>
                                      <option value="<?php echo $p->id ?>" <?php if($p->id == $row['product_id']) {echo "selected";}?>><?php echo $p->name ?></option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td>
                                <select class="form-control js-example-basic-single w-100%" style="width:100%" name="category_id[]" id="category_id<?php echo $i; ?>" onchange="fetchSubCategoryOne(<?php echo $i; ?>)" required>
                                  <option value="">-- Select--</option>
                                  <?php $category = $this->db->select('*')->from('category')->get()->result(); ?>
                                  <?php 
                                    foreach($category as $c){ ?>
                                        <option value="<?php echo $c->id ?>" <?php if($c->id == $row['category_id']) {echo "selected";}?>><?php echo $c->name ?></option>
                                  <?php } ?>                               
                                </select>                         
                              </td>
                              <td>
                                <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_one_id[]" id="sub_category_one_id<?php echo $i ?>" onchange="fetchSubCategorytwo(<?php echo $i; ?>)">
                                  <option value="">-- Select --</option>
                                  <?php $ones = $this->db->select('*')->from('sub_categories_one')->where('category_id',$row['category_id'])->get()->result(); ?>
                                  <?php 
                                    foreach($ones as $o){ ?>
                                        <option value="<?php echo $o->id ?>" <?php if($o->id==$row['sub_category_one_id']){echo "selected";} ?>><?php echo $o->name ?></option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td>
                                <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_two_id[]" id="sub_category_two_id<?php echo $i ?>">
                                  <option value="">-- Select--</option>
                                  <?php $twos = $this->db->select('*')->from('sub_categories_two')->where(array('category_id' => $row['category_id'],'sub_category_one_id' => $row['sub_category_one_id']))->get()->result(); ?>
                                  <?php 
                                      foreach($twos as $t){ ?>
                                          <option value="<?php echo $t->id ?>" <?php if($t->id==$row['sub_category_two_id']){echo "selected";} ?>><?php echo $t->name ?></option>
                                  <?php } ?>
                                </select>
                              </td>
                              <td>
                                <input type="text" class="form-control" name="quantity[]" id="quantity<?php echo $i;?>" value="<?php echo $row['quantity']?>" autocomplete="off" required>
                              </td>
                              <?php if($i <= 1) {?>
                              <td>
                                <button type="button" class="btn btn-info btn-sm icon-btn ml-2 mb-2" onclick="addRow()">
                                  <i class="mdi mdi-plus"></i>
                                </button>
                              </td>
                              <?php } else { ?>
                              <td>
                                <button data-repeater-delete="" onclick="removeThis(<?php echo $i?>)" type="button" class="btn btn-danger btn-sm icon-btn">
                                  <i class="mdi mdi-delete"></i>
                                </button>
                              </td>
                              <?php } ?>
                            </tr>
                          <?php $i++;} ?>
                        </table>
                      </div>
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

  var rowsarray=[];

  var product_length = $('.product-row').length;

  for(let i=1;i<=product_length;i++){
    rowsarray.push(i);
  }

  function addRow(){
    var rows = Math.max.apply(Math,rowsarray) + 1;

    $('#tableID').append('<tr id="rows-added-'+rows+'" class="product-row"><td><select class="form-control js-example-basic-single w-100%" style="width:100%" name="product_id[]" id="product_id'+rows+'" required><option value="">-- Select--</option><?php foreach($product as $p){ ?><option value="<?php echo $p->id?>"><?php echo $p->name ?></option><?php } ?></select></td><td><select class="form-control js-example-basic-single w-100%" style="width:100%" name="category_id[]" id="category_id'+rows+'" onchange="fetchSubCategoryOne('+rows+');" required=""><option value="">-- Select--</option><?php foreach($category as $c){ ?><option value="<?php echo $c->id ?>"><?php echo $c->name ?></option><?php } ?></select></td><td><select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_one_id[]" id="sub_category_one_id'+rows+'" onchange="fetchSubCategorytwo('+rows+');" ><option value="">-- Select--</option></select></td><td><select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_two_id[]" id="sub_category_two_id'+rows+'" ><option value="">-- Select--</option></select></td><td><input type="text" class="form-control" name="quantity[]" id="quantity'+rows+'" autocomplete="off" required></td><td><button data-repeater-delete="" onclick="removeThis('+rows+')" type="button" class="btn btn-danger btn-sm icon-btn"><i class="mdi mdi-delete"></i></button></td></tr>');
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
    let output2 = ''
    let category_id = $('#category_id'+row).val();

    $.ajax({
      url: '<?=base_url("category/getSubCategoryOne")?>',
      type: 'GET',
      data: {'category_id' : category_id },
      cache: false,
      success : function(result){
          var res = JSON.parse(result);
          // console.log(res.data);
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
          // console.log(res.data);
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
  