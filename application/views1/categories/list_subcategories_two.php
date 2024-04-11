<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url(); ?>chromaTemplate/vendors/icheck/skins/all.css">
<?php $this->load->view('template/header.php'); ?>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?php $this->load->view('template/dash_h_n.php'); ?>
      
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">

            <?php if($this->session->flashdata('status') == 'success' 
            || $this->session->flashdata('status') == 'fail') {
                
                if($this->session->flashdata('status') == 'success'){
                    $tolor='green';
                }else{                    
                    $tolor='red';
                }
             
              echo "<b style='color:".$tolor."'>".$this->session->flashdata('message')."</b>";
              echo "<br><br>";  
            
            }
              
              ?>
 
            

              <span class="card-title">Sub Categories Two</span>
              <span>
                  <button type="button" class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#add_sub_category_two" data-whatever="@getbootstrap">Add Sub Category Two</button>
                </span> <br><br><br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>Sl #</th>                        
                        <th>Actions</th>
                        <th>Name</th> 
                        <th>Parent Category</th> 
                        <th>Sub Category One</th>                                             
                      </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;                    
                        foreach($listSubCategoryTwo as $t){ $i++;    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td>
                                <label class="badge badge-danger"><a href="<?php echo base_url(); ?>category/deleteSubCategoryTwo?id=<?php echo $t['id'] ?>">Delete</a></label>
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_sub_category_one_<?php echo $t['id']; ?>" data-whatever="@getbootstrap">Edit</button>                                                                
                                <td><?php echo $t['name'] ?></td>
                                <td><?php echo $t['parent_category'] ?></td>
                                <td><?php echo $t['sub_parent_one_name'] ?></td>                                                                                                                 
                            </tr>

                  <div class="modal fade" id="edit_sub_category_one_<?php echo $t['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">Update Sub Category One</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="<?php echo base_url('category/editSubCategoryTwo'); ?>">
                            <input type="hidden" name="id" id="id" value="<?php echo $t['id']; ?>" />
                            
                            <?php $categories = $this->db->select('*')
                            ->from('category')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">Category:</label><br>
                              <select onchange="updateSubCategoryList(this.value, <?php echo $i; ?>)" class="form-control js-example-basic-single w-100%" style="width:100%" name="category_id" id="edit_category_id" required>
                              <option value="">Select Category</option>
                              <?php foreach($categories as $c){ ?>
                                <option value="<?php echo $c['id']?>" <?php if($c['id']==$t['category_id']){echo "selected";} ?>><?php echo $c['name']?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div>

                            <div class="form-group">
                            <label for="name" class="col-form-label">Sub Category One:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_one_id" id="edit_sub_category_one_id<?php echo $i ?>" required>
                              <option value="">Select Sub Category One</option>                             
                                <?php $sub_categories_one = $this->db->select('*')
                                ->from('sub_categories_one')
                                ->where('delete_status',0)
                               // ->where('id!=',$t['sub_parent_one_id'])
                                ->where('category_id',$t['category_id'])
                                ->get()->result_array(); ?>
                                
                                <?php foreach($sub_categories_one as $sco){ ?>
                                <option value="<?php echo $sco['id']?>" <?php if($sco['id']==$t['sub_parent_one_id']){echo "selected";} ?>><?php echo $sco['name']?></option>
                                <?php } ?>                                                                                                                                                
                              </select>
                            </div>
                            
                            <div class="form-group">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" value="<?php echo $t['name']; ?>"" required>
                            </div>
                                                                          
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Update Sub Category One</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>

                    <?php } ?>

                
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




                <div class="modal fade" id="add_sub_category_two" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-4">New Sub Category Two</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="<?php echo base_url('category/addSubCategoryTwo'); ?>">
                            <?php $categories = $this->db->select('*')
                            ->from('category')
                            ->where('delete_status',0)
                            ->get()->result_array(); ?>
                            
                            <div class="form-group">
                            <label for="name" class="col-form-label">Category:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="category_id" id="category_id" required>
                              <option value="">Select Category</option>
                              <?php foreach($categories as $c){ ?>
                                <option value="<?php echo $c['id']?>"><?php echo $c['name']?></option>
                              <?php } ?>                                                                                                                                                  
                              </select>
                            </div>

                            <div class="form-group">
                            <label for="name" class="col-form-label">Sub Category One:</label><br>
                              <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_one_id" id="sub_category_one_id" required>
                              <option value="">Select Sub Category One</option>
                                                                                                                                                                                
                              </select>
                            </div>


                            <div class="form-group">
                              <label for="name" class="col-form-label">Name:</label>
                              <input type="text" class="form-control" name="name" id="name" required>
                            </div>                                                                                                                                                                   
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Add Sub Category Two</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                

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


$('#category_id').change(function() { //alert(1);
    let cat_id = $('#category_id').val();
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
                                $("#sub_category_one_id").html(output);

                          }
                       });
});

function updateSubCategoryList(cat_id, modal_no){
    //alert("#edit_sub_category_one_id"+modal_no);return;
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

                          }
                       });
}

</script>


  
  