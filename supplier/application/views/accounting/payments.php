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
                <li class="breadcrumb-item"><a href="#">Accounting</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Payments</span></li>
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
                  <table id="table-listing" class="table" style="width:100%;">
                    <thead>
                      <tr>
                        <th>Sl #</th>                                                
                        <th>Reference No</th>
                        <th>Warehouse</th>
                        <th>Paid Amount</th>
                        <th>Pending Amount</th>                                                  
                        <th>Total Amount</th>
                        <th>Status</th>                                           
                      </tr>
                    </thead>
                    <tbody></tbody>
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
              "url": "<?=base_url()?>accounting/getPaymentTableList",
              "type": "post",
          },
          // "aLengthMenu": [
          //     [5, 10, 15],
          //     [5, 10, 15],
          // ],
          "columnDefs": [
              { "orderable": false, "targets": [0] },
              { "orderable": true, "targets": [1, 2, 3, 4, 5, 6] }
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