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
          <div class="template-demo">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-custom bg-inverse-primary">
                <li class="breadcrumb-item active" aria-current="page"><a href='<?php echo base_url('vendor/new_quotation_list')?>'>Vendor Quote</a></li>
                <li class="breadcrumb-item"><span>New Quotation</span></li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-12 table-responsive">

            <?php if($this->session->flashdata('status') == 'success' || $this->session->flashdata('status') == 'fail') {
                
                if($this->session->flashdata('status') == 'success'){
                    $color='green';
                }else{                    
                    $color='red';
                }
             
              echo "<b style='color:".$color."'>".$this->session->flashdata('message')."</b>";
              echo "<br><br>";  
            }?>
 
              <div class="card">
                <div class="card-body">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                                                
                        <th>Reference No</th>
                        <th>Warehouse</th>                                                  
                        <th>Action</th>                                           
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=1; foreach($order_quotation_list as $row) {
                        $warehouse = $this->db->select('w.name')->from('warehouse w')
                        ->where(array('w.id' => $row['warehouse_id']))->get()->row_array();
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['ref_number']; ?></td>                                
                            <td><?php echo $warehouse['name']; ?></td>
                            <td>
                              <a href="<?= base_url()?>vendor/new_proposal/<?php echo $row['quotation_id']?>" class="btn btn-warning">Apply</a>
                            </td>                                                                
                        </tr>
                      <?php $i++;} ?>
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
    <!-- page-body-wrapper ends -->
  </div>

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


  
  