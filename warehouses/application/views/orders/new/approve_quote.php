<?php
//echo '<pre>';print_r($quotation);
?>
<div class="row">  
    <div class="form-group col-md-3 col-lg-3">
        <label for="name" class="col-form-label">Ref Number:</label>
        <input type="text" class="form-control" name="ref_number" value="RFQ_WHNO_006" readonly="">
    </div>

    <div class="form-group col-md-3 col-lg-3">
        <label for="name" class="col-form-label">Warehouse:</label><br>
        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="warehouse_id">
            <?php $warehouse = $this->db->select('id,name')->from('warehouse')->where('delete_status',0)->get()->result_array(); ?>
            <?php 
                foreach($warehouse as $w){ ?>
                    <?php if($quotation['warehouse_id'] == $w['id']) {
                        ?>
                        <option value="<?php echo $w['id'] ?>" <?php if($quotation['warehouse_id'] == $w['id']) {echo "selected";}?>><?php echo $w['name'] ?></option>
                        <?php
                    }
                    ?>
            <?php } ?>
        </select>
    </div>

    <div class="form-group col-md-3 col-lg-3">
        <label for="address" class="col-form-label">Description:</label>
        <textarea class="form-control" name="description" required readonly><?php echo $quotation['description']?></textarea>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="tableID" style="width: 100%">
            <tbody>
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
                </tr>
            
                <?php $i=1; foreach($quotation_product as $row) {?>

                    <tr id="rows-added-<?php echo $i; ?>" class="product-row">
                    <input type="hidden" name="qp_id[]" value="<?php echo $row['qp_id']; ?>">
                    <td>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="product_id[]" id="product_id<?php echo $i;?>" required="">
                        <?php $product = $this->db->select('id,name')->from('products')->get()->result(); ?>
                        <?php 
                            foreach($product as $p){ ?>
                                <?php if($p->id == $row['product_id']){
                                   ?>
                                    <option value="<?php echo $p->id ?>" <?php if($p->id == $row['product_id']) {echo "selected";}?>><?php echo $p->name ?></option>
                                   <?php 
                                }?>
                        <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="category_id[]" id="category_id<?php echo $i; ?>" onchange="fetchSubCategoryOne(<?php echo $i; ?>)" required>
                        <?php $category = $this->db->select('*')->from('category')->get()->result(); ?>
                        <?php 
                            foreach($category as $c){ ?>
                                <?php if($c->id == $row['category_id']){
                                    ?>
                                    <option value="<?php echo $c->id ?>" <?php if($c->id == $row['category_id']) {echo "selected";}?>><?php echo $c->name ?></option>
                                    <?php
                                }?>                                
                        <?php } ?>                               
                        </select>                         
                    </td>
                    <td>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_one_id[]" id="sub_category_one_id<?php echo $i ?>" onchange="fetchSubCategorytwo(<?php echo $i; ?>)">
                        <?php $ones = $this->db->select('*')->from('sub_categories_one')->where('category_id',$row['category_id'])->get()->result(); ?>
                        <?php 
                            foreach($ones as $o){ ?>
                                <?php if($o->id==$row['sub_category_one_id']){
                                    ?>
                                    <option value="<?php echo $o->id ?>" <?php if($o->id==$row['sub_category_one_id']){echo "selected";} ?>><?php echo $o->name ?></option>
                                    <?php
                                }?>
                        <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control js-example-basic-single w-100%" style="width:100%" name="sub_category_two_id[]" id="sub_category_two_id<?php echo $i ?>">
                        <?php $twos = $this->db->select('*')->from('sub_categories_two')->where(array('category_id' => $row['category_id'],'sub_category_one_id' => $row['sub_category_one_id']))->get()->result(); ?>
                        <?php 
                            foreach($twos as $t){ ?>
                                <?php if($t->id==$row['sub_category_two_id']){
                                    ?>
                                    <option value="<?php echo $t->id ?>" <?php if($t->id==$row['sub_category_two_id']){echo "selected";} ?>><?php echo $t->name ?></option>
                                    <?php
                                }
                                ?>
                        <?php } ?>
                        </select>
                    </td>
                    <td>
                        <input readonly type="text" class="form-control" name="quantity[]" id="quantity<?php echo $i;?>" value="<?php echo $row['quantity']?>" autocomplete="off" required>
                    </td>
                    </tr>
                <?php $i++;} ?>
            </tbody>
        </table>
    </div>
</div>