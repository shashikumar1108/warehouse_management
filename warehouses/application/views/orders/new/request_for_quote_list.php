<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="<?php echo asset_url(); ?>chromaTemplate/vendors/icheck/skins/all.css">
<?php $this->load->view('template/header.php'); ?>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php $this->load->view('template/dash_h_n1.php'); ?>
      
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

          <div class="template-demo">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-custom bg-inverse-primary">
                <li class="breadcrumb-item"><a href="#">Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Quotations</span></li>
              </ol>
            </nav>
          </div>

          <div class="card">
            <div class="card-body">

            <?php if($this->session->flashdata('status') == 'success' || $this->session->flashdata('status') == 'fail') {
                
                if($this->session->flashdata('status') == 'success'){
                    $color='green';
                }else{                    
                    $color='red';
                }
             
              echo "<b style='color:".$color."'>".$this->session->flashdata('message')."</b>";
              echo "<br><br>";  
            }?>
 
              <!-- <span class="card-title">Orders</span> -->
              <!-- <span>
                <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_rfq" data-whatever="@getbootstrap">Add Request For Quotation</button>
              </span> <br><br><br> -->
              <!-- <span> -->
                <a href="<?php echo base_url('orders/add_request_for_quote')?>" style="float:right" class="btn btn-warning">Add Request For Quotation</a>
              </span> <br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="table-listing" class="table" style="width:100%;">
                    <thead>
                      <tr>
                        <th>Sl #</th>                                                
                        <th>Reference No</th>
                        <th>Status</th>                                               
                        <th>Action</th>                                           
                      </tr>
                    </thead>
                    <tbody>
                      <?php /* $i=1; foreach($quotation_list as $row) {
                        $warehouse = $this->db->select('w.name')->from('warehouse w')
                        ->where(array('w.id' => $row['warehouse_id']))->get()->row_array();
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['ref_number']; ?></td>                                
                            <td><?php echo $row['approval_status']; ?></td>
                            <td><?php echo $warehouse['name']; ?></td>
                            <td>
                              <a href="<?= asset_url()?>orders/edit_request_for_quote/<?php echo $row['quotation_id']?>">Edit</a>
                              <label class="badge badge-danger"><a href="<?php echo asset_url(); ?>orders/delete_quotation?id=<?php echo $row['quotation_id'] ?>" onclick="return confirm('Are you sure to delete?')">Delete</a></label>
                              
                            </td>                                                                
                        </tr>
                      <?php $i++;} */ ?>
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
  <script>
    var datatable;
    $(document).ready(function(){
        initializeTable();
    })

    function initializeTable(){

      datatable = $('#table-listing').DataTable({
          "processing": true,
          "serverSide": true,
          "responsive": true,
          "paging": true,
          "ordering": true,
          "scrollX": true,
          "lengthChange": true,
          "ajax": {
              "url": "<?=base_url()?>orders/getQuoteTableList",
              "type": "post",
          },
          // "aLengthMenu": [
          //     [5, 10, 15],
          //     [5, 10, 15],
          // ],
          "columnDefs": [
              { "orderable": false, "targets": [0, 3] },
              { "orderable": true, "targets": [1, 2] }
          ],
          "pageLength": 10,
          "lengthMenu": [10, 20, 50],
          // "iDisplayLength": 5,
          // "language": {
          //     search: ""
          // }
      });
    }
  </script>
</body>

</html>


  
  